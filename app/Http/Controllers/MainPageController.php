<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Unit;
use App\Models\Ticket;
use App\Models\Person;
use App\Models\ServiceMapping;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainPageController extends Controller
{
    public function index()
    {
        return Inertia::render('Index');
    }

    public function selfServicePage()
    {
        $data = [];
        $units = Unit::where('active', 'Y')->where('show', 'Y')->get();

        foreach ($units as $i => $unit) {
            $color = json_decode($unit->colors);
            $data[$i] = [
                'id' => $i + 1,
                'title' => $unit->unit,
                'icons' => $unit->icons,
                'icon' => $unit->icon,
                'colorPrimary' => $color[0],
                'colorSecondary' => $color[1],
                'services' => []
            ];

            $services = ServiceMapping::select(
                'service_mappings.*',
                'services.service',
                'services.active',
                'services.external_app',
                'services.inactive_reason',
                'services.id as serviceid',
                'service_categories.category',
                'service_additionals.description',
                'service_additionals.requirement',
                'service_additionals.duration',
                'people.person',
            )
                ->leftJoin('services', 'services.id', '=', 'service_mappings.service_id')
                ->leftJoin('service_categories', 'service_categories.id', '=', 'service_mappings.service_category_id')
                ->leftJoin('service_additionals', 'service_additionals.id', '=', 'service_mappings.service_additional_id')
                ->leftJoin('people', 'people.id', '=', 'service_mappings.person_id')
                ->where('unit_id', $unit->id)
                ->get();

            foreach ($services as $j => $service) {
                $data[$i]['service'][$j]['id'] = $j + 1;
                $data[$i]['service'][$j]['uiid'] = $service->serviceid;
                $data[$i]['service'][$j]['title'] = $service->service;
                $data[$i]['service'][$j]['duration'] = $service->duration . " Hari Kerja";
                $data[$i]['service'][$j]['active'] = $service->active;
                $data[$i]['service'][$j]['external_app'] = $service->external_app;
                $data[$i]['service'][$j]['inactive_reason'] = $service->inactive_reason;
                $data[$i]['service'][$j]['description'] = $service->description;
                $data[$i]['service'][$j]['requirement'] = $service->requirement;
            }
        }

        return Inertia::render('Home/SelfServicePage', [
            'services' => $data
        ]);
    }

    public function detailTicketStatus($id = null)
    {
        if ($id == null) {
            return abort(416);
        }
        $ticket = Ticket::with('progress')->find($id);
        $creatorData = [
            'name' => userdata('person'),
            'photo' => userdata('per_photo'),
            'id' => Auth::user()->person_id,
        ];
        return Inertia::render(
            'Home/DetailTicketStatus',
            [
                'ticket' => $ticket->toArray(),
                'creatorData' => $creatorData,
            ]
        );
    }

    public function about()
    {
        return Inertia::render('Home/About');
    }

    public function generateSurat()
    {
        return Inertia::render('Home/GenerateSurat');
    }

    public function dummyPageTemplate()
    {
        return Inertia::render('Home/DummyPageTemplate');
    }

    public function createTicket($id)
    {
        //get service data by id
        $serviceid = Service::select('services.*')
            ->where('id', $id)
            ->get()->toArray();
        // dd($serviceid[0]['active']);

        if($serviceid[0]['active'] === 'N'){
            return Inertia::render('Error/404');
        }

        //set service id and service name
        $id = ['id' => $serviceid[0]['id'], 'service' => $serviceid[0]['service']];
        //get all services data from services collection in mongo connection
        $services = Service::select('services.*')
            ->where('services.active', 'Y')
            ->get();
        //get all time and order categories
        $time_categories = ServiceCategory::where('active', 'Y')->where('type', 'time')->get();
        $order_categories = ServiceCategory::where('active', 'Y')->where('type', 'order')->get();
        // get users name
        $creatorData = [
            'name' => userdata('person'),
            'nim' => userdata('per_num'),
            'email' => userdata('per_email'),
            'phone' => userdata('per_phone'),
            'major' => userdata('per_major'),
            'faculty' => userdata('per_faculty'),
            'years' => userdata('per_years'),
        ];
        //return data to the view
        return Inertia::render(
            'Home/FormInputPage',
            [
                'serviceid' => $id,
                'services' => $services->toArray(),
                'time' => $time_categories->toArray(),
                'order' => $order_categories->toArray(),
                'creatorData' => $creatorData
            ]
        );
    }

    public function submissionHistory()
    {
        $user = Auth::user();
        $person = Person::with(['roleMapping', 'unitPeople.unit'])
            ->where('id', $user->person_id)
            ->firstOrFail();

        // akses role
        $role = $person->roleMapping;

        // akses unit
        $unit = $person->unitPeople?->unit;

        // Inisialisasi query tiket
        $ticketQuery = Ticket::with('progress')->where('active', 'Y');

        //Menambahkan filter berdasarkan role
        if ($role->role_id == 101) {
            // Untuk role 101, hanya tampilkan tiket yang dibuat oleh user
            $ticketQuery->where('person.creator.name', $person->person);
        } elseif ($role->role_id  == 103 || $role->role_id  == 104) {
            // Untuk role 103 dan 104, hanya tampilkan tiket yang ditujukan ke unit user
            $ticketQuery->where('purpose.unit.name', $unit->unit);
        }

        // Ambil data tiket
        $tickets = $ticketQuery->get();

        $creatorData = [
            'name' => userdata('person'),
            'id' => Auth::user()->person_id,
        ];
        return Inertia::render(
            'Home/SubmissionHistoryPage',
            [
                'ticket' => $tickets,
                'creatorData' => $creatorData
            ]
        );
    }

    public function profileMenu()
    {
        return Inertia::render('Home/ProfileMenu');
    }

    public function cdnFile($type, $ticket, $file)
    {
        $storagePath = 'app/public/file_upload';
        if ($type == 'attachment-ticket') {
            $storagePath = 'app/public/file_upload/' . $ticket;
        } else if ($type ==  'attachment-chat') {
            $storagePath = 'app/public/file_upload/' . $ticket;
        }
        $file = $storagePath . '/' . $file;
        // use function to show the file either it's pdf or image
        return response()->file(storage_path($file));
    }
}
