<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Person;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\ServiceAdditional;
use App\Models\ServiceCategory;
use App\Models\ServiceMapping;
use App\Models\ServiceTagMapping;
use App\Models\ServiceTag;
use App\Models\Ticket;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::select(
            DB::raw(
                'DISTINCT services.*,
                time_categories.id as time_id, time_categories.category as times,
                order_categories.id as order_id, order_categories.category as orders,
                service_additionals.id as additional_id, service_additionals.description, service_additionals.requirement, service_additionals.duration,
                people.id as person_id, people.person,
                units.id as unit_id, units.unit,
                GROUP_CONCAT(DISTINCT service_tags.name) as tags'
            )
        )
            ->join('service_mappings', 'service_mappings.service_id', '=', 'services.id')
            ->leftJoin('service_additionals', 'service_mappings.service_additional_id', '=', 'service_additionals.id')
            ->leftJoin('service_categories as time_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'), '=', 'time_categories.id')
            ->leftJoin('service_categories as order_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'), '=', 'order_categories.id')
            ->leftJoin('people', 'service_mappings.person_id', '=', 'people.id')
            ->leftJoin('units', 'service_mappings.unit_id', '=', 'units.id')
            ->leftJoin('service_tag_mappings', 'service_tag_mappings.service_id', '=', 'services.id')
            ->leftJoin('service_tags', 'service_tags.id', '=', 'service_tag_mappings.service_tag_id')
            ->groupBy('services.id')
            ->get();

        foreach ($services as $service) {
            $service->tags = $service->tags ? explode(',', $service->tags) : [];
        }

        return Inertia::render('Service/Index', [
            'service' => $services->toArray(),
        ]);
    }


    public function list($limit = 3)
    {
        // 1. Ambil daftar service aktif beserta unitnya menggunakan join
        $activeMappings = DB::table('service_mappings as sm')
            ->join('services as s', 'sm.service_id', '=', 's.id')
            ->join('units as u', 'sm.unit_id', '=', 'u.id')
            ->where('s.active', 'Y')
            ->select(
                'sm.service_id',
                'sm.unit_id',
                's.service as service_name',
                'u.unit as unit_name'
            )
            ->get();

        if ($activeMappings->isEmpty()) {
            return response()->json([]);
        }

        // Buat array service_id untuk filter MongoDB
        $activeServiceIds = $activeMappings->pluck('service_id')->toArray();

        // 2. Aggregation MongoDB untuk menghitung jumlah tiket per service
        $pipeline = [
            ['$match' => ['purpose.service.id' => ['$in' => $activeServiceIds]]],
            ['$group' => [
                '_id'   => '$purpose.service.id',
                'total' => ['$sum' => 1],
            ]],
            ['$sort'  => ['total' => -1]],
            ['$limit' => $limit],
        ];

        $ticketStats = Ticket::raw(function ($collection) use ($pipeline) {
            return $collection->aggregate($pipeline);
        });

        // 3. Keyed array untuk memudahkan lookup
        $mappings = $activeMappings->keyBy('service_id');

        // 4. Gabungkan hasil agregasi dengan detail service & unit
        $result = collect($ticketStats)->map(function ($stat) use ($mappings) {
            $mapping = $mappings[$stat->_id] ?? null;

            return [
                'id'           => $mapping->service_id,
                'service_name' => $mapping->service_name,
                'unit_name'    => $mapping->unit_name,
                'total_ticket' => $stat->total,
            ];
        })->values();

        return response()->json($result);
    }


    public function searchByName(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $limit = $request->get('limit', 10);

        if (empty($query) || strlen($query) < 2) {
            return response()->json([
                'code' => 400,
                'message' => 'Query minimal 2 karakter',
                'data' => []
            ]);
        }

        try {
            $services = Service::select([
                'services.id',
                'services.service',
                'units.unit as unit_name',
                DB::raw('GROUP_CONCAT(DISTINCT service_tags.name) as tags')
            ])
                ->join('service_mappings', 'service_mappings.service_id', '=', 'services.id')
                ->leftJoin('units', 'service_mappings.unit_id', '=', 'units.id')
                ->leftJoin('service_tag_mappings', 'service_tag_mappings.service_id', '=', 'services.id')
                ->leftJoin('service_tags', 'service_tags.id', '=', 'service_tag_mappings.service_tag_id')
                ->where('services.active', 'Y')
                ->where(function ($q) use ($query) {
                    $q->where('services.service', 'LIKE', "%{$query}%")
                        ->orWhere('units.unit', 'LIKE', "%{$query}%")
                        ->orWhere('service_tags.name', 'LIKE', "%{$query}%");
                })
                ->groupBy('services.id', 'services.service', 'units.unit')
                ->orderBy('services.service', 'asc')
                ->limit($limit)
                ->get();

            $results = $services->map(function ($service) {
                return [
                    'id'   => $service->id,
                    'name' => $service->service,
                    'unit' => $service->unit_name,
                    'tags' => $service->tags ? explode(',', $service->tags) : [],
                ];
            });

            return response()->json([
                'code' => 200,
                'message' => 'Pencarian berhasil',
                'data' => $results,
                'total' => $results->count(),
                'query' => $query
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 500,
                'message' => 'Terjadi kesalahan saat pencarian',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }


    public function getJsonServiceById($id)
    {
        // dd($id)
        // get all required data to be parsed by array
        // $service = Service::select(
        //     DB::raw(
        //         'DISTINCT services.*,
        //         time_categories.id as time_id, time_categories.category as times,
        //         order_categories.id as order_id, order_categories.category as orders,
        //         service_additionals.id as additional_id, service_additionals.description, service_additionals.requirement, service_additionals.duration,
        //         units.id as unit_id, units.unit,
        //         people.id as recipient_id, people.person as recipient, people.per_phone as recipient_phone, people.per_email as recipient_email,
        //         supervisor.id as supervisor_id, supervisor.person as supervisor'
        //     )
        // )
        //     ->join('service_mappings', 'service_mappings.service_id', '=', 'services.id')
        //     ->leftjoin('service_additionals', 'service_mappings.service_additional_id', '=', 'service_additionals.id')
        //     ->leftjoin('service_categories as time_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'), '=', 'time_categories.id')
        //     ->leftjoin('service_categories as order_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'), '=', 'order_categories.id')
        //     ->leftjoin('people', 'service_mappings.person_id', '=', 'people.id')
        //     ->leftjoin('units', 'service_mappings.unit_id', '=', 'units.id')
        //     ->leftjoin('unit_people as supervisors', 'units.id', '=', 'supervisors.unit_id', DB::raw('where supervisors.position like "KEPALA BAGIAN%" or where supervisors.position like "KEPALA URUSAN%"'))
        //     ->leftjoin('people as supervisor', 'supervisor.id', '=', 'supervisors.person_id')
        //     // ->where('services.active', 'Y')
        //     ->where('services.id', $id)
        //     ->groupby('services.id')
        //     ->first();

        $service = ServiceMapping::with([
            'service' => fn($q) => $q->selectRaw('id, service AS service_name'),
            'person'  => fn($q) => $q->select('id', 'person', 'per_phone', 'per_email'),
            'unit'    => fn($q) => $q->selectRaw('id, unit AS unit_name'),
            'unit.supervisor',
        ])
            ->select(
                'service_mappings.*',
                'time_categories.id as time_id',
                'time_categories.category as times',
                'order_categories.id as order_id',
                'order_categories.category as orders',
            )
            ->join('services', 'service_mappings.service_id', '=', 'services.id')
            ->leftJoin('people', 'service_mappings.person_id', '=', 'people.id')
            ->leftJoin(
                'service_categories as time_categories',
                DB::raw('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'),
                '=',
                'time_categories.id'
            )
            ->leftJoin(
                'service_categories as order_categories',
                DB::raw('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'),
                '=',
                'order_categories.id'
            )
            ->where('service_mappings.service_id', $id)
            ->first();

        $unit = $service->unit;
        $recipient = $service->person;
        $supervisor = $service->unit->supervisor;

        $response = [
            'id' => $service->service_id,
            'service' => $service->service->service_name,
            'active' => $service->service->active,
            'inactive_reason' => $service->service->inactive_reason,
            'external_app' => $service->service->external_app,
            'createdby' => $service->service->createdby,
            'updatedby' => $service->service->updatedby,
            'created_at' => $service->service->created_at,
            'updated_at' => $service->service->updated_at,

            'time_id' => $service->time_id,
            'times'   => $service->times,
            'order_id' => $service->order_id,
            'orders'   => $service->orders,

            'additional_id' => $service->service_additional_id,
            'description' => $service->serviceAdditional->description ?? null,
            'requirement' => $service->serviceAdditional->requirement ?? null,
            'duration' => $service->serviceAdditional->duration ?? null,

            'unit_id' => $unit->id,
            'unit' => $unit->unit_name,

            'recipient_id' => $recipient->id,
            'recipient' => $recipient->person,
            'recipient_phone' => $recipient->per_phone,
            'recipient_email' => $recipient->per_email,

            'supervisor_id' => $supervisor->id ?? null,
            'supervisor' => $supervisor->person ?? null,
        ];


        if ($service === null) {
            return response()->json([
                'code' => 404,
                'message' => 'Data layanan tidak ditemukan',
                'data' => $service,
            ]);
        }

        // change unit name using helper toTitle
        $service->unit = toTitle($service->unit);
        return response()->json([
            'code' => 200,
            'message' => 'Data Layanan ditemukan',
            'data' => $response,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get people where per_group is not 'MAHASISWA'
        // $people = Person::where('active', 'Y')->where('per_group', '!=', 'MAHASISWA')->get();
        $people = Person::with('roles')
            ->where('active', 'Y')
            ->whereHas('roles', function ($query) {
                $query->where('role', '!=', 'Pengguna');
            })
            // ->where('per_group', '!=', 'MAHASISWA')
            ->get();
        $units = Unit::where('active', 'Y')->get();
        $time_categories = ServiceCategory::where('active', 'Y')->where('type', 'time')->get();
        $order_categories = ServiceCategory::where('active', 'Y')->where('type', 'order')->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Service/Create', [
            'people' => $people->toArray(),
            'unit' => $units->toArray(),
            'time' => $time_categories->toArray(),
            'order' => $order_categories->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'service' => 'required',
            'description' => 'required',
            'requirement' => 'required',
            'duration' => 'required',
            'active' => 'required',
        ]);
        $service = new Service([
            'service' => $request->input('service'),
            'active' => $request->input('active'),
            'inactive_reason' => $request->input('active') == 'N' ? $request->input('inactive_reason') : null,
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $request->input('createdby'),
        ]);
        if ($service->save() !== true) {
            return redirect()->route('service.index')->with('err', 'Input data failed');
        }
        // get id from last inputed data
        $serviceId = Service::where('service', $request->input('service'))->first();
        // set the model class to assign the input data
        $serviceAdditionals = new ServiceAdditional([
            'description' => $request->input('description'),
            'requirement' => $request->input('requirement'),
            'duration' => $request->input('duration'),
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $request->input('createdby'),
        ]);
        if ($serviceAdditionals->save() !== true) {
            return redirect()->route('service.index')->with('err', 'Input data failed');
        }
        $serviceAdditionalId = ServiceAdditional::where('description', $request->input('description'))->first();

        // set the model class to assign the input data
        $serviceMappings = new ServiceMapping([
            'service_id' => $serviceId->id,
            'unit_id' => $request->input('unit')['id'],
            'service_category_id' => $request->input('time')['id'] . '+' . $request->input('order')['id'],
            'service_additional_id' => $serviceAdditionalId->id,
            'person_id' => $request->input('person')['id'],
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $request->input('createdby'),
        ]);

        if ($request->has('tags') && is_array($request->input('tags'))) {
            $service = Service::findOrFail($serviceId->id);

            $tagIds = [];
            foreach ($request->input('tags') as $tagName) {
                $tag = ServiceTag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $service->tags()->syncWithoutDetaching($tagIds);
        }

        $serviceMappings->save();
        return redirect()->route('service.index')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return Inertia::render('Service/Show', [
            'service' => $service,
        ]);
    }

    public function edit(Service $service)
    {
        $serviceMapping = ServiceMapping::with('service.tags', 'person', 'unit')
            ->select(
                'service_mappings.*',
                'service_additionals.description as additional_description',
                'service_additionals.requirement as additional_requirement',
                'service_additionals.duration as additional_duration',
                'people.id as person_id',
                'people.person',
                'time_categories.id as time_id',
                'time_categories.category as times',
                'order_categories.id as order_id',
                'order_categories.category as orders'
            )
            ->join('services', 'service_mappings.service_id', '=', 'services.id')
            ->leftJoin('service_additionals', 'service_mappings.service_additional_id', '=', 'service_additionals.id')
            ->leftjoin('service_categories as time_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'), '=', 'time_categories.id')
            ->leftjoin('service_categories as order_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'), '=', 'order_categories.id')
            ->leftJoin('people', 'service_mappings.person_id', '=', 'people.id')
            ->where('service_mappings.service_id', $service->id)
            ->first();

        $people = Person::with('roles')
            ->where('active', 'Y')
            ->whereHas('roles', function ($query) {
                $query->where('role', '!=', 'Pengguna');
            })
            // ->where('per_group', '!=', 'MAHASISWA')
            ->get();
        $units = Unit::where('active', 'Y')->get();
        $time_categories = ServiceCategory::where('active', 'Y')->where('type', 'time')->get();
        $order_categories = ServiceCategory::where('active', 'Y')->where('type', 'order')->get();

        return Inertia::render('Service/Edit', [
            'data' => $serviceMapping,
            'people' => $people->toArray(),
            'unit' => $units->toArray(),
            'time' => $time_categories->toArray(),
            'order' => $order_categories->toArray(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service, Controller $ctrl)
    {
        $request->validate([
            'service' => 'required',
            'description' => 'required',
            'requirement' => 'required',
            'duration' => 'required',
            'active' => 'required',
        ]);

        $additionalRequest = [
            'description' => $request->input('description'),
            'requirement' => $request->input('requirement'),
            'duration' => $request->input('duration'),
            'updated_at' => now(),
            'updatedby' => $request->input('updatedby'),
        ];

        if ($request->input('service_additional_id') === null) {
            $serviceAdditional = new ServiceAdditional($additionalRequest);
            $serviceAdditional->save();

            $request['service_additional_id'] = $serviceAdditional->id;
        } else {
            ServiceAdditional::where('id', $request->input('service_additional_id'))
                ->update($additionalRequest);
        }

        $service->update($request->all());

        $mappingRequest = [
            'unit_id' => $request->input('unit')['id'],
            'person_id' => $request->input('person')['id'],
            'service_additional_id' => $request->input('service_additional_id'),
            'service_category_id' => $request->input('time')['id'] . '+' . $request->input('order')['id'],
            'updated_at' => now(),
            'updatedby' => $request->input('updatedby'),
        ];

        ServiceMapping::where('service_id', $service->id)->update($mappingRequest);

        if ($request->has('tags') && is_array($request->input('tags'))) {
            $tagIds = [];
            foreach ($request->input('tags') as $tagName) {
                $tag = ServiceTag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $service->tags()->sync($tagIds);
        }

        return redirect()->route('service.index')->with('msg', 'Data succesfully changed');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $service->delete();
        $ids = ServiceMapping::where('service_id', $service->id)->first();
        ServiceAdditional::where('id', $ids->service_additional_id)->delete();
        ServiceMapping::where('service_id', $service->id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('service.index')->with('msg', 'Data succesfully removed');
    }
}
