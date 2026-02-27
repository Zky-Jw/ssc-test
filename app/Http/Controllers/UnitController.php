<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all required data to be parsed by array
        $units = Unit::All();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Unit/Index', [
            'unit' => $units->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get unit data to be parsed by array
        $unit = Unit::where('active', 'Y')
            ->get();
        // get people where per_group is not 'MAHASISWA'
        $people = Person::where('active', 'Y')->where('per_group', '!=', 'MAHASISWA')->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Unit/Create', [
            'units' => $unit->toArray(),
            'people' => $people->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'unit' => 'required',
            'icons' => 'required',
            'active' => 'required',
        ]);
        try {
            // set the model class to assign the input data
            $unit = Unit::create([
                'unit' => $request->input('unit'),
                'icons' => $request->input('icons'),
                'icon' => randomString(8),
                'colors' => json_encode($request->input('colors')),
                'unit_parent' => $request->input('unit_parent')['id'] ?? null,
                'active' => $request->input('active'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            // get the last inserted id
            $lastInsertedId = Unit::latest()->first()->id;
            // dd($lastInsertedId);
            $unitPeople = UnitPeople::create([
                'unit_id' => $lastInsertedId,
                'person_id' => $request->input('supervisor')['id'],
                'position' => 'KEPALA BAGIAN',
                'start_date' => date('Y-m-d'),
                'active' => 'Y',
                'createdby' => userdata('user_id') ?? '999',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('unit.index')->with('error', $th);
        }

        // return it to view with true message
        return redirect()->route('unit.index')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        // render the view along with the data
        return Inertia::render('Unit/Show', [
            'unit' => $unit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit, Controller $ctrl)
    {
        $units = Unit::where('active', 'Y')
            ->get();

        $unitpeople = UnitPeople::with('person')
            ->where('unit_id', $unit->id)
            ->whereIn('position', ['Kepala Bagian', 'Ketua Prodi'])
            ->orderByRaw("CASE
                WHEN position = 'Kepala Bagian' THEN 1
                WHEN position = 'Ketua Prodi' THEN 2
                ELSE 3
            END")
            ->first();

        $unit['supervisor'] = $unitpeople->person ?? null;
        $unitparent = Unit::where('id', $unit->unit_parent)
            ->select('id', 'unit')
            ->first();
        $unit['unit_parent'] = $unitparent ?? null;

        // get people where per_group is not 'MAHASISWA'
        $people = Person::where('active', 'Y')->where('per_group', '!=', 'MAHASISWA')->get();

        return Inertia::render('Unit/Edit', [
            'unit' => $unit,
            'units' => $units->toArray(),
            'people' => $people->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit, Controller $ctrl)
    {
        // validate the request unit needed for update
        // validate the request data needed for update
        $request->validate([
            'unit' => 'required',
            'icons' => 'required',
            'active' => 'required',
            'updatedby' => 'required',
        ]);
        $request['unit_parent'] = $request->input('unit_parent')['id'] ?? null;
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $unit->update($request->all());

        $unitPeople = UnitPeople::where('unit_id', $unit->id)->first();
        if ($unitPeople) {
            $unitPeople->update([
                'person_id' => $request->input('supervisor')['id'],
                'updatedby' => userdata('user_id') ?? '999',
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } else {
            $unitPeople = UnitPeople::create([
                'unit_id' => $unit->id,
                'person_id' => $request->input('supervisor')['id'],
                'position' => 'KEPALA BAGIAN',
                'start_date' => date('Y-m-d'),
                'active' => 'Y',
                'createdby' => userdata('user_id') ?? '999',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        // return it to view with true message
        return redirect()->route('unit.index')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $unit->delete();
        UnitPeople::where('unit_id', $unit->id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('unit.index')->with('msg', 'Data succesfully removed');
    }
}
