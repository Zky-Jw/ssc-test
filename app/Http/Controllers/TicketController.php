<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Http\Requests\StoreticketRequest;
use App\Http\Requests\UpdateticketRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\TicketFilterRequest;
use App\Models\Resolution;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceAdditional;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketProgress;
use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\PersonRoleMapping;
use App\Models\Person;
use App\Models\ServiceMapping;
use App\Traits\NotificationMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Http\Client\ConnectionException;

class TicketController extends Controller
{
    use NotificationMessage;
    /**
     * Uploads files and returns an object containing the file names, URLs, and extensions.
     *
     * @param array $files An array of files to be uploaded.
     * @param string $ticketNumber The ticket number associated with the files.
     * @return object An object with properties 'name', 'url', and 'extension' containing the uploaded file details.
     */
    private function uploadFile($files, $ticketNumber)
    {
        $object = [];
        foreach ($files as $file) {
            $fileextension = $file->getClientOriginalExtension();
            $randomstring = \Illuminate\Support\Str::random(10);
            $newfilename = $ticketNumber . '_' . $randomstring . '.' . $fileextension;

            $storage = Storage::disk('public');

            // make try catch to make directory and upload file
            try {
                if (!$storage->exists('file_upload/' . $ticketNumber)) {
                    $storage->makeDirectory('file_upload/' . $ticketNumber);
                }
                $storage->putFileAs('file_upload/' . $ticketNumber, $file, $newfilename);
            } catch (\Throwable $th) {
                return redirect()->route('ticket.index')->with('error', $th);
            }

            $object[] = (object) [
                'name' => $newfilename,
                'url' => 'file_upload/' . $ticketNumber . '/' . $newfilename,
                'extension' => $fileextension,
            ];
        }

        return $object;
    }

    public function index(TicketFilterRequest $request)
    {
        $statusFiltered = $request->query('status');
        $limit = $request->query('limit', 10);
        $page = $request->query('page', 1);
        $overdue = $request->query('overdue', '');
        $search = $request->query('search');

        $sortBy = $request->input('sortBy', 'ticketNumber');
        $sortType = $request->input('sortType', 'desc');
        $user = Auth::user();

        $person = Person::with(['roleMapping', 'unitPeople.unit'])
            ->where('id', $user->person_id)
            ->firstOrFail();

        $role = $person->roleMapping;
        $unit = $person->unitPeople?->unit;
        $unitList = null;
        $recipient = null;

        $ticketQuery = Ticket::with('progress')->where('active', 'Y');

        if ($overdue !== '') {
            $overdueValue = filter_var($overdue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($overdueValue !== null) {
                $ticketQuery->where('isLate', $overdueValue);
            }
        }

        if ($role->role_id === '106' || $role->role_id === '102' || $role->role_id === '105') {
            $unitFiltered = $request->query('unit');
            $employeeFiltetered = $request->query('petugas');

            if ($unitFiltered) {
                $ticketQuery->where('purpose.unit.name', $unitFiltered);
            }

            $unitList = Unit::where('active', 'Y')
                ->pluck('unit')
                ->map(function ($unit) {
                    return preg_replace('/\s*-\s*kampus surabaya/i', '', $unit);
                });

                $recipient = ServiceMapping::with([
                    'person:id,person,per_phone',
                    'unit:id,unit as unit_name'
                ])
                ->when($unitFiltered !== null, function ($query) use ($unitFiltered) {
                    $query->whereHas('unit', function ($q) use ($unitFiltered) {
                        $q->where('unit', $unitFiltered);
                    });
                })
                ->get()
                ->pluck('person')
                ->unique('id')
                ->values();

            // $recipients = DB::table('service_mappings')
            //     ->join('people', 'service_mappings.person_id', '=', 'people.id')
            //     ->join('units', 'service_mappings.unit_id', '=', 'units.id')
            //     ->when($unitFiltered !== null, function ($query) use ($unitFiltered) {
            //         return $query->where('units.unit', $unitFiltered);
            //     })
            //     ->select('people.*')
            //     ->distinct()
            //     ->get();

            if ($employeeFiltetered) {
                $ticketQuery->where('person.recipient.name', $employeeFiltetered);
            }
        }

        if ($statusFiltered) {
            $ticketQuery->where('status', $statusFiltered);
        } else {
            $ticketQuery->where('status', 'on progress');
        }

        // Menambahkan filter berdasarkan role
        if ($role->role_id == 101) {
            $ticketQuery->where('person.creator.name', $person->person);
        } elseif ($role->role_id == 103 || $role->role_id == 104) {
            $ticketQuery
                ->where('purpose.unit.name', $unit->unit)
                ->where('person.recipient.id', $user->person_id);
        }

        if ($search) {
            $baseQuery = Ticket::where('active', 'Y');

            // Apply all previous filters to base query
            if ($overdue !== '') {
                $overdueValue = filter_var($overdue, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($overdueValue !== '') {
                    $baseQuery->where('isLate', $overdueValue);
                }
            }

            if ($statusFiltered) {
                $baseQuery->where('status', $statusFiltered);
            } else {
                $baseQuery->where('status', 'on progress');
            }

            // Apply role-specific filters
            if ($role->role_id == 101) {
                $baseQuery->where('person.creator.name', $person->person);
            } elseif ($role->role_id == 103 || $role->role_id == 104) {
                $baseQuery->where('purpose.unit.name', $unit->unit)
                         ->where('person.recipient.id', $user->person_id);
            }

            // Apply unit filter if exists
            if (isset($unitFiltered) && $unitFiltered) {
                $baseQuery->where('purpose.unit.name', $unitFiltered);
            }

            // Apply employee filter if exists
            if (isset($employeeFiltetered) && $employeeFiltetered) {
                $baseQuery->where('person.recipient.name', $employeeFiltetered);
            }

            // Apply search filter
            $ticketQuery = $baseQuery->where(function ($q) use ($search) {
                $q->where('ticketNumberStr', 'like', '%' . $search . '%')
                  ->orWhere('person.creator.name', 'like', '%' . $search . '%')
                  ->orWhere('person.recipient.name', 'like', '%' . $search . '%')
                  ->orWhere('purpose.unit.name', 'like', '%' . $search . '%')
                  ->orWhere('purpose.service.name', 'like', '%' . $search . '%');
            });
        }

        $totalCount = $ticketQuery->count();
        $offset = ($page - 1) * $limit;

        $tickets = $ticketQuery
            ->orderBy($sortBy, $sortType)
            ->skip($offset)
            ->take($limit)
            ->get();

        // Create manual pagination object
        $paginatedTickets = new \Illuminate\Pagination\LengthAwarePaginator(
            $tickets,
            $totalCount,
            $limit,
            $page,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );

        // Transform data untuk memastikan kompatibilitas dengan frontend
        $transformedTickets = $tickets->map(function ($ticket) {
            return [
                '_id' => $ticket->_id,
                'ticketNumber' => $ticket->ticketNumber,
                'status' => $ticket->status,
                'isLate' => $ticket->isLate ?? false,
                'dueDate' => $ticket->dueDate,
                'closedDate' => $ticket->updated_at,
                'created' => [
                    'createdat' => $ticket->created_at ?? $ticket->created['createdat'] ?? null
                ],
                'person' => [
                    'creator' => [
                        'name' => $ticket->person['creator']['name'] ?? null
                    ],
                    'recipient' => [
                        'name' => $ticket->person['recipient']['name'] ?? null,
                        'id' => $ticket->person['recipient']['id'] ?? null
                    ]
                ],
                'purpose' => [
                    'service' => [
                        'name' => $ticket->purpose['service']['name'] ?? null
                    ],
                    'unit' => [
                        'name' => $ticket->purpose['unit']['name'] ?? null
                    ]
                ],
                // Include other necessary fields
                'active' => $ticket->active,
                'progress' => $ticket->progress ?? null,
            ];
        });

        // Update paginated data dengan transformed data
        $paginatedTickets->setCollection($transformedTickets);

        return Inertia::render('Ticket/Index', [
            'ticket' => $paginatedTickets,
            'recipient' => $recipient,
            'units' => $role->role_id == 106 || $role->role_id == 102 || $role->role_id == 105 ? $unitList : null
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //get all services data from services collection in mongo connection
        $services = Service::select('services.*')
            // ->where('services.active', 'Y')
            ->get();
        $time_categories = ServiceCategory::where('active', 'Y')->where('type', 'time')->get();
        $order_categories = ServiceCategory::where('active', 'Y')->where('type', 'order')->get();
        //get all unit data from unit collection in mongo connection
        return Inertia::render(
            'Ticket/Create',
            [
                'services' => $services->toArray(),
                'time' => $time_categories->toArray(),
                'order' => $order_categories->toArray(),
            ]
        );
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreticketRequest $request)
    {
        try {
            DB::connection('mongodb')->transaction(function () use ($request) {
                // Data 'created'
                $created = [
                    'createdat' => date('Y-m-d H:i:s'),
                    'createdby' => userdata('person')
                ];

                // Data 'creator'
                $creator = [
                    'name' => $request->creator_name,
                    'id' => $request->creator,
                    'major' => $request->major,
                    'faculty' => $request->faculty,
                    'years' => $request->years,
                    'phone' => $request->creator_phone,
                    'email' => $request->creator_email,
                    'photo' => $request->creator_photo
                ];

                // Data 'recipient'
                $recipient = [
                    'name' => $request->recipient,
                    'id' => $request->recipient_id,
                    'phone' => $request->recipient_phone,
                    'email' => $request->recipient_email,
                ];

                // Data 'supervisor'
                $supervisor = [
                    'name' => $request->supervisor ?? '',
                    'id' => $request->supervisor_id ?? '',
                ];

                $person = compact('creator', 'supervisor', 'recipient');

                // Data 'unit'
                $unit = [
                    'name' => $request->unit,
                    'id' => $request->unit_id,
                ];

                // Data 'service'
                $service = [
                    'name' => $request->service['name'],
                    'id' => $request->service['id'],
                ];

                $purpose = compact('unit', 'service');

                // Data 'time'
                $time = [
                    'name' => $request->time['name'],
                    'id' => $request->time['id'],
                ];

                // Data 'order'
                $order = [
                    'name' => $request->order['name'],
                    'id' => $request->order['id'],
                ];

                $category = compact('time', 'order');
                $ticketNum = Ticket::orderBy('ticketNumber', 'desc')->value('ticketNumber');
                $ticketNum = $ticketNum ? $ticketNum + 1 : 13000001;

                $attachment = [];
                if ($request->hasFile('attachment')) {
                    $attachment[] = $this->uploadFile($request->file('attachment'), $ticketNum);
                }

                // Membuat tiket baru
                $ticket = Ticket::create([
                    'attachment' => $attachment,
                    'created' => $created,
                    'person' => $person,
                    'purpose' => $purpose,
                    'category' => $category,
                    'updated' => [],
                    'rating' => '',
                    'status' => 'on progress',
                    'active' => 'Y',
                    'ticketNumber' => (int) $ticketNum,
                    'ticketNumberStr' => (string) $ticketNum,
                    'content' => $request->content,
                    'isLate' => false
                ]);

                // Menghitung dan menyimpan due date
                $ticket->dueDate = calculate_due_date($ticket);
                $ticket->save();

                // Membuat entri progress tiket: 'created'
                TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'created',
                    'content' => "Tiket " . $ticketNum . " berhasil dibuat oleh " . userdata('person') . " untuk " . $request->creator_name . ", Mohon menunggu sampai tiket diproses.",
                    'attachment' => '',
                    'by' => [
                        'name' => userdata('person'),
                        'id' => userdata('userid'),
                    ],
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                $url = "dashboard/ticket/" . $ticket->id;
                $recipientNumber = $request->recipient_phone;

                /*
                * TEMPLATE NAME
                * helpdesk_ticket_notification_for_unit
                * helpdesk_ticket_notification_for_ssc
                * helpdesk_ticket_notification_for_unit_reminder
                * helpdesk_ticket_notification_for_unit_deadline
                * helpdesk_ticket_notification_for_user
                */

                $servAdd = ServiceAdditional::where('id', $request->service['id'])->first();
                $sla = 3;

                if ($servAdd) {
                    $sla = $servAdd->duration;
                }

                $templateName = "helpdesk_ticket_notification_for_unit";
                $params = ["#" . $ticketNum, $request->service['name'], strip_tags($request->content), date('j M Y', strtotime('+' . $sla . ' days'))];

                if (config('services.wappin.enabled')) {
                    $sendToUnit = $this->sendWhatsapp($url, $recipientNumber, $templateName, $params);

                    if (!$sendToUnit['status']) {
                        throw new \Exception("Gagal mengirim WA ke unit: " . $sendToUnit['message']);
                    }
                }

                if ($request->recipient_id) {
                    TicketProgress::create([
                        'ticketId' => $ticket->id,
                        'head' => 'assigned',
                        'content' => "Tiket " . $ticketNum . " berhasil diberikan kepada " . $request->recipient . ", Tiket akan segera diproses.",
                        'attachment' => '',
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                    TicketProgress::create([
                        'ticketId' => $ticket->id,
                        'head' => 'progress',
                        'content' => "Tiket " . $ticketNum . " sudah mulai dikerjakan, " . $request->recipient . " memulai pengerjaan tiket.",
                        'attachment' => '',
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                }

                // Membuat entri progress tiket: 'content-original'
                TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'content-original',
                    'content' => $request->content,
                    'attachment' => '',
                    'by' => [
                        'name' => userdata('person'),
                        'id' => userdata('userid'),
                    ],
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                // Mengirim notifikasi WhatsApp ke pelanggan
                if (config('services.wappin.enabled')) {
                    $sendToCust = $this->sendWhatsapp($url, $request->creator_phone, 'helpdesk_new_ticket_notification_for_user', ["#" . $ticketNum, $request->service['name'], strip_tags($request->content)]);

                    if (!$sendToCust['status']) {
                        throw new \Exception("Gagal mengirim WA ke mahasiswa: " . $sendToCust['message']);
                    }
                }

                // Membuat entri log tiket: 'Ticket Created'
                TicketLog::create([
                    'ticketId' => $ticket->_id,
                    'action' => 'Ticket Created',
                    'content' => "Ticket created by " . userdata('person') . " on " . date('Y-m-d H:i:s'),
                    'ticketdata' => $ticket->toArray(),
                    'by' => [
                        'name' => userdata('person'),
                        'id' => userdata('userid'),
                    ],
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                if ($request->recipient_id) {
                    TicketLog::create([
                        'ticketId' => $ticket->_id,
                        'action' => 'Ticket Assigned',
                        'content' => "Ticket assigned to " . $request->recipient . " by " . userdata('person') . " on " . date('Y-m-d H:i:s'),
                        'ticketdata' => $ticket->toArray(),
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                    TicketLog::create([
                        'ticketId' => $ticket->_id,
                        'action' => 'Ticket Progress',
                        'content' => "Ticket progress started by " . $request->recipient . " on " . date('Y-m-d H:i:s'),
                        'ticketdata' => $ticket->toArray(),
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                }

                // Memperbarui informasi kontak Person
                // Memperbarui informasi kontak Person
                    if ($request->recipient_id) {
                        $pelaksana = Person::find($request->recipient_id);
                        if ($pelaksana) {
                            $pelaksana->per_phone = $request->recipient_phone;
                            $pelaksana->save();
                        }
                    }
                    if ($request->creator_id) {
                        $pengguna = Person::find($request->creator_id);
                        if ($pengguna) {
                            $pengguna->per_phone = $request->creator_phone;
                            $pengguna->save();
                        }
                    }
            });

            if (userdata('role') == 101) {
                return redirect()->route('submission-history')->with('success', 'Ticket created successfully.');
            }


            return redirect()->route('ticket.index')->with('success', 'Ticket created successfully.');

        } catch (\Throwable $th) {
            // Log error untuk debugging
            Log::error('Gagal membuat tiket: ' . $th->getMessage(), ['exception' => $th]);

            // Redirect dengan pesan error
            if (userdata('role') == 101) {
                return redirect()->route('submission-history')->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
            }

            return redirect()->route('ticket.create')->with('error', 'Terjadi kesalahan saat membuat tiket. Mohon coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ticket $ticket)
    {

        $ticket = Ticket::with('progress')->find($ticket->id);

        $creatorData = [
            'name' => userdata('person'),
            'photo' => userdata('per_photo'),
            'nim' => userdata('per_num'),
            'phone' => userdata('per_phone'),
            'id' => Auth::user()->person_id,
        ];

        return Inertia::render('Ticket/Show', [
            'ticket' => $ticket->toArray(),
            'creatorData' => $creatorData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ticket $ticket)
    {

        $services = Service::select('services.*')
            // ->where('services.active', 'Y')
            ->get();
        $time_categories = ServiceCategory::where('active', 'Y')->where('type', 'time')->get();
        $order_categories = ServiceCategory::where('active', 'Y')->where('type', 'order')->get();
        $people = UnitPeople::join('people', 'unit_people.person_id', '=', 'people.id')
            ->where('unit_people.position', 'not like', 'MAHASISWA')
            ->select('people.id', 'people.person as name', 'people.per_num as num')
            ->get();
        return Inertia::render('Ticket/Edit', [
            'ticket' => $ticket,
            'services' => $services->toArray(),
            'time' => $time_categories->toArray(),
            'order' => $order_categories->toArray(),
            'people' => $people->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateticketRequest $request, ticket $ticket)
    {
        try {
            DB::connection('mongodb')->transaction(function () use ($request, $ticket){
                $updated = [
                    'updatedat' => date('Y-m-d H:i:s'),
                    'updatedby' => userdata('person'),

                ];

                $creator = [
                    'name' => $request->creator_name,
                    'id' => $request->creator,
                    'major' => $request->major,
                    'faculty' => $request->faculty,
                    'years' => $request->years,
                    'phone' => $request->creator_phone,
                    'email' => $request->creator_email,
                ];

                if ($request->recipient_id == null) {
                    $request->recipient_id = $request->recipient['id'];
                    $request->recipient = $request->recipient['name'];
                }

                $recipient = [
                    'name' => $request->recipient,
                    'id' => $request->recipient_id,
                    'phone' => $request->recipient_phone,
                    'email' => $request->recipient_email,
                ];

                $supervisor = [
                    'name' => $request->supervisor ?? '',
                    'id' => $request->supervisor_id ?? '',
                ];

                $person = compact('creator', 'supervisor', 'recipient');

                $unit = [
                    'name' => $request->unit,
                    'id' => $request->unit_id,
                ];

                $service = [
                    'name' => $request->service['name'],
                    'id' => $request->service['id'],
                ];

                $purpose = compact('unit', 'service');

                $time = [
                    'name' => $request->time['name'],
                    'id' => $request->time['id'],
                ];
                $order = [
                    'name' => $request->order['name'],
                    'id' => $request->order['id'],
                ];

                $category = compact('time', 'order');

                $attachment = $request->file_existing ?? [];
                if ($request->hasFile('attachment')) {
                    $attachment[] = $this->uploadFile($request->file('attachment'), (int) $request->ticketNumber);
                }

                if ($ticket->content != $request->content) {
                    TicketProgress::create([
                        'ticketId' => $ticket->id,
                        'head' => 'progress-chat',
                        'content' => 'edited: ' . $request->content,
                        'attachment' => '',
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                }
                $ticket->update([
                    'attachment' => $attachment,
                    'created' => $ticket->created,
                    'person' => $person,
                    'purpose' => $purpose,
                    'category' => $category,
                    'updated' => $updated,
                    'rating' => $ticket->rating,
                    'status' => $ticket->status,
                    'active' => $ticket->active,
                    'ticketNumber' => (int)  $ticket->ticketNumber,
                    'content' => $request->content,
                ]);

                if ($request->recipient_id == null) {
                    TicketProgress::create([
                        'ticketId' => $ticket->id,
                        'head' => 'assigned',
                        'content' => "Tiket " . $ticket->ticketNumber . " berhasil diberikan kepada " . $request->recipient . ", Tiket akan segera diproses.",
                        'attachment' => '',
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                    TicketProgress::create([
                        'ticketId' => $ticket->id,
                        'head' => 'progress',
                        'content' => "Tiket " . $ticket->ticketNumber . " sudah mulai dikerjakan, " . $request->recipient . " memulai pengerjaan tiket.",
                        'attachment' => '',
                        'by' => [
                            'name' => userdata('person'),
                            'id' => userdata('userid'),
                        ],
                        'timestamp' => date('Y-m-d H:i:s'),
                    ]);
                }

               TicketLog::create([
                    'ticketId' => $ticket->_id,
                    'action' => 'Ticket Updated',
                    'content' => "Ticket updated by " . userdata('person') . " on " . date('Y-m-d H:i:s'),
                    'ticketdata' => $ticket->toArray(),
                    'by' => [
                        'name' => userdata('person'),
                        'id' => userdata('userid'),
                    ],
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                //Save nomor pengguna dan operator
                if ($request->recipient_id) {
                    $pelaksana = Person::find($request->recipient_id);
                    if ($pelaksana) {
                        $pelaksana->per_phone = $request->recipient_phone;
                        $pelaksana->save();
                    }
                }
                if ($request->creator) {
                    $pengguna = Person::where('per_num', $request->creator)->first();
                    if ($pengguna) {
                        $pengguna->per_phone = $request->creator_phone;
                        $pengguna->save();
                    }
                }
            });
            // if role is 101 redirect to riwayat-pengajuan
            if (in_array('101', userrole())) {
                return redirect()->route('submission-history')->with('success', 'Ticket created successfully.');
            }

            return redirect()->route('ticket.index')->with('success', 'Ticket updated successfully.');
        } catch (\Throwable $th) {
            // dd($th);
            if (userdata('role') == 101) {
                return redirect()->route('submission-history')->with('error', $th);
            }

            return redirect()->route('ticket.index')->with('error', 'Terjadi kesalahan saat mengupdate tiket');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ticket $ticket)
    {
        //
    }

    /*
    Here goes another function related to ticket
     */
    public function storeProgress(Request $request, ticket $ticket)
    {
        try {
            // Validasi di luar transaction
            if (empty(trim($request->content))) {
                return response()->json([
                    'message' => 'Progress content cannot be empty.',
                ], 400);
            }

            $result = DB::connection('mongodb')->transaction(function () use ($request, $ticket) {
                $attachment = [];
                if ($request->hasFile('attachment')) {
                    $attachment[] = $this->uploadFile($request->file('attachment'), (int) $ticket->ticketNumber);
                }

                $as = 'Admin SSC';
                $recipientNumber = $ticket->person['creator']['phone'];

                if (userdata('person') == $ticket->person['creator']['name']) {
                    $as = 'Creator';
                    $recipientNumber = $ticket->person['recipient']['phone'];
                } elseif (userdata('person') == $ticket->person['recipient']['name']) {
                    $as = 'Recipient';
                } elseif (userdata('person') == $ticket->person['supervisor']['name']) {
                    $as = 'Pengawas Layanan';
                } elseif (in_array(userdata('per_id'), petugasArr())) {
                    $as = 'Petugas SSC';
                }

                $ticketProgress = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => $request->head,
                    'content' => $request->content,
                    'attachment' => $attachment[0] ?? '',
                    'by' => [
                        'name' => userdata('person'),
                        'id' => userdata('userid'),
                        'nim' => userdata('per_num'),
                        'photo' => userdata('per_photo'),
                        'phone' => userdata('per_phone'),
                        'as' => $as,
                    ],
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                if (!$ticketProgress) {
                    throw new \Exception('Progress failed to create.');
                }

                $url = "dashboard/ticket/" . $ticket->id;
                $templateName = "helpdesk_ticket_notification_user_feedback";
                $params = ["#" . $ticket->ticketNumber, $ticket->purpose['service']['name']];

                if (config('services.wappin.enabled')) {
                    $sendToRecipient = $this->sendWhatsapp($url, $recipientNumber, $templateName, $params);

                    if (!$sendToRecipient['status']) {
                        throw new \Exception("Gagal mengirim WA ke unit: " . $sendToRecipient['message']);
                    }
                }

                $ticketLog = TicketLog::create([
                    'ticketId' => $ticket->id,
                    'action' => 'Progress Created',
                    'content' => "Progress created by " . userdata('person') . " on " . date('Y-m-d H:i:s'),
                    'ticketdata' => $ticket->toArray(),
                    'by' => [
                        'name' => userdata('person'),
                        'id' => userdata('userid'),
                        'photo' => userdata('per_photo'),
                    ],
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                if (!$ticketLog) {
                    throw new \Exception('Log failed to create.');
                }

                return [
                    'success' => 'Progress created successfully.',
                    'filename' => $attachment[0] ?? '',
                    'as' => $as,
                ];
            });

            return response()->json($result, 200);

        } catch(\Exception $e) {
            Log::error('Progress creation failed: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat memberikan feedback',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Make a function to close the ticket
    public function closeTicket(Request $request, ticket $ticket)
    {
        try {
            DB::connection('mongodb')->transaction(function () use ($request, $ticket) {
                $by = [
                    'name' => userdata('person'),
                    'id' => userdata('userid'),
                ];

                $isLate = false;

                if ($ticket->dueDate) {
                    $dueDate = Carbon::parse($ticket->dueDate);
                    $now = Carbon::now();
                    $isLate = $now->gt($dueDate);
                }

                $ticket->update([
                    'status' => 'closed',
                    'isLate' => $isLate,
                ]);

                // upload file
                $attachment = [];
                if ($request->hasFile('attachment')) {
                    $attachment[] = $this->uploadFile($request->file('attachment'), (int) $ticket->ticketNumber);
                }

                // input resolution
                $resolution = Resolution::create([
                    'ticketId' => $ticket->id,
                    'resolution' => $request->resolution,
                    'response' => $request->response,
                    'attachment' => $attachment[0] ?? '',
                    'by' => $by,
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                if (!$resolution) {
                    throw new \Exception('Resolution failed to create.');
                }

                // Siapkan content progress dengan informasi keterlambatan
                $lateInfo = '';
                if ($isLate && $ticket->dueDate) {
                    $dueDate = Carbon::parse($ticket->dueDate);
                    $daysLate = Carbon::now()->diffInDays($dueDate);
                    $lateInfo = $daysLate > 0 ? " (Terlambat {$daysLate} hari dari deadline)" : " (Terlambat dari deadline)";
                }

                // input progress
                $ticketProgress = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'closed',
                    'content' => 'Ticket ' . $ticket->ticketNumber . ' ditutup oleh ' . userdata('person') . ', Tiket ditutup dengan keterangan ' . $request->response . $lateInfo,
                    'attachment' => $attachment[0] ?? '',
                    'by' => $by,
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                if (!$ticketProgress) {
                    throw new \Exception('Progress failed to create.');
                }

                $recipientNumber = $ticket->person['creator']['phone'];
                $url = "feedback/" . $ticket->id;
                $templateName = "helpdesk_ticket_closed_notification_for_user";

                $params = ["#" . $ticket->ticketNumber, $ticket->purpose['service']['name'], strip_tags($ticket->content), strip_tags($request->response)];

                if (config('services.wappin.enabled')) {
                    $sendToCust = $this->sendWhatsapp($url, $recipientNumber, $templateName, $params);

                    if (!$sendToCust['status']) {
                        throw new \Exception("Gagal mengirim WA ke mahasiswa: " . $sendToCust['message']);
                    }
                }

                // input log dengan informasi keterlambatan
                $logContent = "Ticket closed by " . userdata('person') . " on " . date('Y-m-d H:i:s');
                if ($isLate && $ticket->dueDate) {
                    $logContent .= " - Closed after deadline ({$ticket->dueDate})";
                }

                $ticketLog = TicketLog::create([
                    'ticketId' => $ticket->id,
                    'action' => 'Ticket Closed',
                    'content' => $logContent,
                    'ticketdata' => $ticket->toArray(),
                    'by' => $by,
                    'timestamp' => date('Y-m-d H:i:s'),
                ]);

                if (!$ticketLog) {
                    throw new \Exception('Log failed to create.');
                }

                // Success message dengan informasi keterlambatan
                $successMessage = 'Close Ticket Successfully';
                if ($isLate && $ticket->dueDate) {
                    $dueDate = Carbon::parse($ticket->dueDate);
                    $daysLate = Carbon::now()->diffInDays($dueDate);
                    $successMessage .= $daysLate > 0 ? " (Ticket closed {$daysLate} days after deadline)" : " (Ticket closed after deadline)";
                }

                // Return success redirect
                return redirect()->back()->with('success', $successMessage);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat melakukan close ticket, silahkan coba lagi');
        }

    }

    public function notifyOperator(ticket $ticket)
    {
        try{
            $operators = Person::where('id', $ticket['person']['recipient']['id'])->first();
            if ($operators) {
                $recipientNumber = $operators['per_phone'];
                $url = "-";
                $templateName = "helpdesk_ticket_notification_for_operator";
                $params = ["#" . $ticket->ticketNumber, $ticket->purpose['service']['name'], strip_tags($ticket->content)];

                if (config('services.wappin.enabled')) {
                    $sendToOperator = $this->sendWhatsapp($url, $recipientNumber, $templateName, $params);

                    if (!$sendToOperator['status']) {
                        throw new \Exception("Gagal mengirim WA ke operator: " . $sendToOperator['message']);
                    }
                }
            }
            return redirect()->back()->with('success', 'Notification Sent');
        }catch(\Exception $e){
            Log::error('Gagal mengirim notifikasi ke operator: ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->back()->with('error', 'Notifikasi tidak terkirim ke operator');
        }
    }

    public function notifyCreator(Ticket $ticket, Request $request)
    {
        try {
            $creator = Person::where('per_num', $ticket['person']['creator']['id'])->first();
            $status = $request->status;

            if ($creator) {
                $recipientNumber = $creator['per_phone'];

                if ($status === 'on progress') {
                    $servAdd = ServiceAdditional::where('id', $request->service['id'])->first();
                    $sla = $servAdd->duration;

                    $templateForUnit = "helpdesk_ticket_notification_for_unit";
                    $sla = 3;
                    $paramsForUnit = ["#" .
                                        $ticket->ticketNumber, $request->service['name'],
                                        strip_tags($request->content),
                                        date('j M Y', strtotime('+' . $sla . ' days'))];
                    $params = [
                        "#" . $ticket->ticketNumber,
                        $request->service['name'] ?? '-',
                        strip_tags($request->content ?? '-')
                    ];
                    $url = "dashboard/ticket/" . $ticket->id;
                    $templateName = "helpdesk_new_ticket_notification_for_user";
                }
                elseif ($status === 'closed') {
                    $ticketProgress = TicketProgress::where('ticketId', $ticket->id)
                        ->where('head', 'closed')
                        ->first();

                    $params = [
                        "#" . $ticket->ticketNumber,
                        $ticket->purpose['service']['name'] ?? '-',
                        strip_tags($ticket->content ?? '-'),
                        strip_tags($ticketProgress->content ?? '-')
                    ];
                    $url = "feedback/" . $ticket->id;
                    $templateName = "helpdesk_ticket_closed_notification_for_user";
                }
                else {
                    throw new \Exception("Status ticket tidak dikenali: " . $status);
                }

                if (config('services.wappin.enabled')) {
                    if($status === 'on progress') $sendToUnit = $this->sendWhatsapp($url, $recipientNumber, $templateForUnit, $paramsForUnit);
                    $sendToUser = $this->sendWhatsapp($url, $recipientNumber, $templateName, $params);

                    if (!$sendToUser['status']) {
                        throw new \Exception("Gagal mengirim WA ke operator: " . $sendToUser['message']);
                    }
                }
            }

            return redirect()->back()->with('success', 'Notification Sent');
        } catch (\Exception $e) {
            Log::error('Gagal mengirim notifikasi ke operator: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Notifikasi tidak terkirim ke operator');
        }
    }


    public function feedbackPage($ticketId)
    {
        $ticket = Ticket::where('status', 'closed')
            ->where('_id', $ticketId)
            ->first();

        if (!$ticket) return Inertia::render('Error/404');

        $user = Auth::user();

        $person = Person::with([
            'roleMapping',
            'unitPeople.unit',
            'serviceMappings.service'
        ])
            ->where('id', $user->person_id)
            ->firstOrFail();

        $role = $person->roleMapping;
        $serviceName = $ticket->purpose['service']['name'];
        $roleId = $role->role_id;
        $creatorName = $ticket->person['creator']['name'];
        $canSubmitFeedback = $person->person === $ticket->person['creator']['name'];

        $hasServiceAccess = $person->serviceMappings
            ->pluck('service.service')
            ->contains($serviceName);

        $allowAccess = false;

        if (in_array($roleId, ['106', '102'])) {
            $allowAccess = true;
        } elseif (in_array($roleId, ['103', '104']) && $hasServiceAccess) {
            $allowAccess = true;
        } elseif ($roleId === '101' && $person->person === $creatorName) {
            $allowAccess = true;
        }

        if (! $allowAccess) {
            return Inertia::render('Error/404');
        }

        return Inertia::render('Ticket/Feedback/Index', [
            'ticket' => $ticket,
            'canSubmit' => $canSubmitFeedback,
        ]);
    }

    public function feedbackSuccess()
    {
        if (!session()->has('after_store_feedback')) abort(403, 'Forbidden');

        return Inertia::render('Ticket/Feedback/Success');
    }


    public function storeFeedback(StoreFeedbackRequest $request, $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $ticket->update([
            'feedback' => [
                'rating' => $request->rating,
                'comment' => $request->comment,
                'submitted_at' => date('Y-m-d H:i:s')
            ]
        ]);

        session()->flash('after_store_feedback', true);

        return redirect('/feedback/success');
    }

    public function export(Request $request){
        $status    = $request->input('status', 'on progress');
        $unit      = $request->input('unit');
        $petugas = $request->input('petugas');
        $sortType = $request->input('sortType', 'asc');
        $sortBy = $request->input('sortBy', 'ticketNumber');

        return Excel::download(new TicketExport($status, $unit, $petugas, $sortBy, $sortType), 'tickets.xlsx');
    }
}