<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Unit;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use MongoDB\BSON\UTCDateTime;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $person = Person::with(['roleMapping', 'unitPeople.unit'])
            ->findOrFail($user->person_id);

        $role = $person->roleMapping;
        $unit = $person->unitPeople?->unit;

        return Inertia::render('Dashboard/Index', [
            'ticketSummary'   => $this->getTicketSummary($person, $role, $unit),
            'statistikPerBulan' => $this->getStatistikTiketTahunan($person, $role, $unit),
            'layananTerbanyak'  => $this->getLayananTerbanyak($person, $role, $unit),
            'totalQuestion'     => in_array($role->role_id, ['102', '106'])
                ? Question::count()
                : 0,
        ]);
    }

    private function getTicketSummary($person, $role, $unit): array
    {
        try {
            $roleId = $role->role_id;
            $globalRoles = ['106', '105', '102'];

            $baseQuery = Ticket::where('active', 'Y');

            if (in_array($roleId, ['103', '104'])) {
                $baseQuery = $baseQuery
                    ->where('person.recipient.id', $person->id)
                    ->where('purpose.unit.id', $unit->id);
            } elseif ($roleId === '101') {
                $baseQuery = $baseQuery
                    ->where('person.creator.email', $person->per_email);
            }

            $totalTickets     = (clone $baseQuery)->count();
            $ticketsClosed    = (clone $baseQuery)->where('status', 'closed')->count();
            $ticketsOnProgress = (clone $baseQuery)->where('status', 'on progress')->count();

            $closedOverdue = (clone $baseQuery)
                ->where('status', 'closed')
                ->whereNotNull('dueDate')
                ->where('isLate', true)
                ->count();

            $progressOverdue = (clone $baseQuery)
                ->where('status', 'on progress')
                ->whereNotNull('dueDate')
                ->where('isLate', true)
                ->count();

            return [
                'totalTickets'     => $totalTickets,
                'ticketsClosed'    => $ticketsClosed,
                'ticketsOnProgress'=> $ticketsOnProgress,
                'closedOverdue'    => $closedOverdue,
                'progressOverdue'  => $progressOverdue,
            ];
        } catch (\Throwable $th) {
            report($th);
            return [
                'totalTickets'     => 0,
                'ticketsClosed'    => 0,
                'ticketsOnProgress'=> 0,
                'closedOverdue'    => 0,
                'progressOverdue'  => 0,
            ];
        }
    }

    private function getStatistikTiketTahunan($person, $role, $unit): array
    {
        $roleId = $role->role_id;
        $globalRoles = ['106', '105', '102'];

        $tahun = now()->year;
        $mulai = Carbon::create($tahun, 1, 1, 0, 0, 0, 'UTC');
        $berakhir = $mulai->copy()->addYear();

      // Gunakan pengecekan apakah class UTCDateTime ada atau tidak
$ms = function(Carbon $c) {
    if (class_exists('MongoDB\BSON\UTCDateTime')) {
        return new \MongoDB\BSON\UTCDateTime((int) $c->valueOf());
    }
    return $c->toDateTimeString(); // Fallback jika driver belum jalan
};

        $match = [
            'created_at' => [
                '$gte' => $ms($mulai),
                '$lt'  => $ms($berakhir),
            ],
            'active' => 'Y'
        ];

        if (!in_array($roleId, $globalRoles)) {
            if (in_array($roleId, ['103', '104'])) {
                $match['person.recipient.id'] = $person->id;
                $match['purpose.unit.id']     = $unit->id;
            } elseif ($roleId === '101') {
                $match['person.creator.email'] = $person->per_email;
            }
        }

      $statistik = Ticket::raw(function($col) use ($match) {
    // Pastikan driver benar-benar terbaca di level runtime browser
    if (!class_exists('MongoDB\BSON\UTCDateTime')) {
        return [];
    }

    return $col->aggregate([
        ['$match' => $match],
        [
            '$group' => [
                // HATI-HATI: Jika created_at bukan objek BSON Date,
                // operator $month akan error.
                '_id'   => ['$month' => '$created_at'],
                'total' => ['$sum' => 1],
            ],
        ],
        ['$sort' => ['_id' => 1]],
    ]);
})->collect();

        $data = array_fill(0, 12, 0);

        foreach ($statistik as $doc) {
            $index = (int) $doc->_id - 1;
            $data[$index] = (int) $doc->total;
        }

        return $data;
    }

    public function getStatistikByUnitBulan(Request $request)
    {
        $personId = $request->input('person_id');
        $email    = $request->input('email');
        $roleId   = $request->input('role_id');
        $unitId   = $request->input('unit_id');

        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = now()->year;

        $mulai    = Carbon::create($tahun, $bulan, 1, 0, 0, 0, 'UTC');
        $berakhir = $mulai->copy()->endOfMonth();

        $ms = fn(Carbon $c) => new UTCDateTime((int) $c->valueOf());

        $match = [
            'created_at' => [
                '$gte' => $ms($mulai),
                '$lte' => $ms($berakhir),
            ],
            'active' => 'Y'
        ];

        if ($roleId === '101') {
            $match['person.creator.email'] = $email;
        }

        $units = Unit::pluck('unit')->toArray();

        $statistik = Ticket::raw(fn($col) => $col->aggregate([
            ['$match' => $match],
            [
                '$group' => [
                    '_id'     => '$purpose.unit.name',
                    'total'   => ['$sum' => 1],
                    'unit_id' => ['$first' => '$purpose.unit.id']
                ],
            ],
            ['$sort' => ['total' => -1]]
        ]))->collect();

        $tiketMapping = [];
        foreach ($statistik as $item) {
            $unitName = $item->_id ?? 'Unit Tidak Diketahui';
            $tiketMapping[$unitName] = (int) $item->total;
        }

        $result = [];
        foreach ($units as $unit) {
            $result[] = [
                'unit_name' => $unit,
                'total'     => $tiketMapping[$unit] ?? 0
            ];
        }

        foreach ($tiketMapping as $unitName => $total) {
            if (!in_array($unitName, $units)) {
                $result[] = [
                    'unit_name' => $unitName,
                    'total'     => $total
                ];
            }
        }

        usort($result, fn($a, $b) => $b['total'] <=> $a['total']);

        return response()->json($result);
    }

    public function getLayananTerbanyakByBulan(Request $request)
    {
        $personId = $request->input('person_id');
        $email    = $request->input('email');
        $roleId   = $request->input('role_id');
        $unitId   = $request->input('unit_id');
        $bulan    = (int) $request->input('bulan', now()->month);

        $person = $personId ? Person::find($personId) : null;
        $unit   = $unitId ? Unit::find($unitId) : null;

        $role = (object) ['role_id' => $roleId];

        $layananTerbanyak = $this->getLayananTerbanyak($person, $role, $unit, $bulan);

        return response()->json($layananTerbanyak);
    }

    private function getLayananTerbanyak($person = null, $role = null, $unit = null, $bulan = null): array
    {
        $roleId = $role->role_id ?? null;
        $globalRoles = ['106', '105', '102'];

        $bulan = $bulan ?? now()->month;
        $tahun = now()->year;

        $mulai    = Carbon::create($tahun, $bulan, 1, 0, 0, 0, 'UTC');
        $berakhir = $mulai->copy()->endOfMonth();

        $ms = fn(Carbon $c) => new UTCDateTime((int) $c->valueOf());

        $match = [
            'created_at' => [
                '$gte' => $ms($mulai),
                '$lte' => $ms($berakhir),
            ],
            'active' => 'Y',
        ];

        if ($roleId && !in_array($roleId, $globalRoles)) {
            if (in_array($roleId, ['103', '104']) && $person && $unit) {
                $match['person.recipient.id'] = $person->id;
                $match['purpose.unit.id']     = $unit->id;
            } elseif ($roleId === '101' && $person) {
                $match['person.creator.email'] = $person->per_email;
            }
        }

        $layanan = Ticket::raw(fn($col) => $col->aggregate([
            ['$match' => $match],
            [
                '$group' => [
                    '_id' => [
                        'service_name' => '$purpose.service.name',
                        'unit_name'    => '$purpose.unit.name',
                    ],
                    'id'    => ['$first' => '$purpose.service.id'],
                    'total' => ['$sum' => 1],
                ],
            ],
            ['$sort' => ['total' => -1]],
            ['$limit' => 5],
        ]))->collect();

        // dd($layanan);

        return $layanan->map(fn($item) => [
            'id'           => $item->id ?? null,
            'service_name' => $item['_id']['service_name'] ?? 'Layanan Tidak Diketahui',
            'unit_name'    => $item['id']['unit_name'] ?? '',
            'total'        => (int) $item->total,
        ])->all();
    }
}
