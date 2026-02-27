<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceMappingRequest;
use App\Http\Requests\UpdateServiceMappingRequest;
use App\Models\Person;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceMapping;
use App\Models\Unit;
use App\Models\UnitPeople;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Request;

class ServiceMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipients = ServiceMapping::with([
            'person'
        ])
        ->select(
            'service_mappings.id',
            'service_mappings.person_id',
            'services.service',
            'services.active',
            'time_categories.category as times',
            'order_categories.category as orders',
            'units.unit'
        )
        ->join('services', 'service_mappings.service_id', '=', 'services.id')
        ->leftJoin('service_categories as time_categories', DB::raw('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'), '=', 'time_categories.id')
        ->leftJoin('service_categories as order_categories', DB::raw('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'), '=', 'order_categories.id')
        ->leftJoin('units', 'service_mappings.unit_id', '=', 'units.id')
        ->get();

        return Inertia::render('Recipient/Index', [
            'recipient' => $recipients->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // parse it to array while passing it to inertia to be rendered to view

        $time_categories = ServiceCategory::where('active', 'Y')->where('type', 'time')->get();
        $order_categories = ServiceCategory::where('active', 'Y')->where('type', 'order')->get();
        $people = Person::where('active', 'Y')->get();
        $units = Unit::where('active', 'Y')->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Recipient/Create', [
            'people' => $people->toArray(),
            'units' => $units->toArray(),
            'time' => $time_categories->toArray(),
            'order' => $order_categories->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceMappingRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'service' => 'required',
            'active' => 'required',
        ]);
        // set the model class to assign the input data
        $recipient = new ServiceMapping([
            'service_id' => $request->input('service_id'),
            'unit_id' => $request->input('unit_id'),
            'service_category_id' => $request->input('category_id'),
            'service_additional_id' => $request->input('service_additional_id'),
            'person_id' => $request->input('person_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $request->input('createdby'),
            'active' => $request->input('active'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $recipient->save();
        // return it to view with true message
        return redirect()->route('recipient')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceMapping $recipient)
    {
        // render the view along with the data
        return Inertia::render('Recipient/Show', [
            'recipient' => $recipient,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceMapping $recipient)
    {

        $service = ServiceMapping::with([
            'service' => fn($q) => $q->selectRaw('id, service AS service_name'),
            'person' => fn($q) => $q->select('id', 'person', 'per_phone'),
            'unit'    => fn($q) => $q->selectRaw('id, unit AS unit_name')
        ])
        ->select(
            'service_mappings.*',
            'time_categories.id as time_id',
            'time_categories.category as times',
            'order_categories.id as order_id',
            'order_categories.category as orders'
        )
        ->join('services', 'service_mappings.service_id', '=', 'services.id')
        ->leftjoin('service_categories as time_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'), '=', 'time_categories.id')
        ->leftjoin('service_categories as order_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'), '=', 'order_categories.id')
        ->leftJoin('people', 'service_mappings.person_id', '=', 'people.id')
        ->where('service_mappings.id', Request::segment(3))
        ->groupby('services.id')
        ->first();

        // $service = Service::select(
        //     DB::raw(
        //         'DISTINCT services.service, services.id as service_id, services.active, service_mappings.id as id,
        //         time_categories.id as time_id, time_categories.category as times,
        //         order_categories.id as order_id, order_categories.category as orders,
        //         people.id as person_id, people.person,
        //         units.id as unit_id, units.unit'
        //     )
        // )
        //     ->join('service_mappings', 'service_mappings.service_id', '=', 'services.id')
        //     ->leftjoin('service_categories as time_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", 1)'), '=', 'time_categories.id')
        //     ->leftjoin('service_categories as order_categories', DB::RAW('SUBSTRING_INDEX(service_mappings.service_category_id, "+", -1)'), '=', 'order_categories.id')
        //     ->leftjoin('people', 'service_mappings.person_id', '=', 'people.id')
        //     ->leftjoin('units', 'service_mappings.unit_id', '=', 'units.id')
        //     // ->where('services.active', 'Y')
        //     ->where('service_mappings.id', Request::segment(3))
        //     ->groupby('services.id')
        //     ->first();

        $service = $service->toArray();
        $recipient = UnitPeople::with(['person' => fn($q) => $q->select('id', 'person', 'per_phone')])
                                ->where('unit_id', $service['unit_id'])->get()
                                ->map(fn($item) => $item->person);
        $unit = Unit::all();

        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Recipient/Edit', [
            'service' => $service,
            'units' => $unit->toArray(),
            'recipients' => $recipient->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceMappingRequest $request, ServiceMapping $recipient, Controller $ctrl)
    {
        // validate the request recipient needed for update
        // validate the request data needed for update
        $request->validate([
            'service_id' => 'required',
            'updatedby' => 'required',
        ]);
        $request['updated_at'] = date('Y-m-d H:i:s');
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $request['person_id'] = $request->input('recipient')['id'];
        $request['unit_id'] = $request->input('unit')['id'];
        unset($request['service'], $request['recipient'], $request['unit']);

        $recipient = ServiceMapping::find(Request::segment(3));
        $recipient->update($request->all());
        // return it to view with true message
        return redirect()->route('recipient')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceMapping $recipient)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $recipient->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('recipient')->with('msg', 'Data succesfully removed');
    }
}
