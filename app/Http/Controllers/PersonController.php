<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Role;
use App\Models\Unit;
use App\Models\UnitPeople;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $limit;
        $search = $request->query('search');
        $sortBy = 'people.per_id';
        $sortType = $request->input('sortType', 'asc');

        // Base query
        $personQuery = Person::join('users', 'people.id', '=', 'users.person_id')
            ->select('users.username', 'users.password', 'people.*');

        if ($search) {
            $personQuery->whereBlind('person', 'person_index', $search)
                ->orWhereBlind('per_phone', 'per_phone_index', $search)
                ->orWhere('per_id', 'like', '%' . $search . '%')
                ->orWhere('people.per_num', 'like', '%' . $search . '%');
        }

        $totalCount = $personQuery->count();

        // Get paginated data
        $persons = $personQuery
            ->orderBy($sortBy, $sortType)
            ->skip($offset)
            ->take($limit)
            ->get();

        // Buat paginator manual
        $personData = new \Illuminate\Pagination\LengthAwarePaginator(
            $persons,
            $totalCount,
            $limit,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $unit = Unit::where('active', 'Y')->get();
        $role = Role::where('active', 'Y')->get();

        return Inertia::render('Person/Index', [
            'person' => $personData,
            'unit' => $unit->toArray(),
            'role' => $role->toArray(),
        ]);
    }



    // make function getJsonPersonById to get user data by id where the pergroup is 'MAHASISWA' along with its unit which using unit_people table as reference
    public function getJsonPersonById($id)
    {
        // get all required data to be parsed by array
        // $person = Person::
        //     join('users', 'people.id', '=', 'users.person_id')
        //     ->join('unit_people', 'people.id', '=', 'unit_people.person_id')
        //     ->join('units', 'unit_people.unit_id', '=', 'units.id')
        //     ->join('units as unit_parents', 'units.unit_parent', '=', 'unit_parents.id')
        //     ->where('users.username', $id)
        //     ->where('people.per_group', 'MAHASISWA')
        //     ->select('*')
        //     ->select('users.username', 'users.password', 'people.*', 'units.unit', 'unit_parents.unit as unit_parent_name', 'unit_people.start_date',)
        //     ->first();

        $person = Person::
            // join('users', 'people.id', '=', 'users.person_id')
            leftjoin('unit_people', 'person_id', '=', 'unit_people.person_id')
            ->leftjoin('units', 'unit_people.unit_id', '=', 'units.id')
            // ->leftjoin('units as unit_parents', 'units.unit_parent', '=', 'unit_parents.id')
            ->where('per_num', $id)
            ->where('per_group', 'MAHASISWA')
            ->select('people.*')
            ->first();
        if ($person === null) {
            return response()->json([
                'code' => 404,
                // 'message' => 'NIM tidak ditemukan',
                'data' => $person,
            ]);
        }
        // change the unit name using helper toTitle
        $person->unit = toTitle($person->unit);
        $person->unit_parent_name = toTitle($person->unit_parent_name);
        return response()->json([
            'code' => 200,
            'message' => 'NIM ditemukan',
            'data' => $person,
        ]);
    }

    public function searchStudent(Request $request)
    {
        $search = $request->input('search', '');

        if (empty($search)) {
            return response()->json([
                'code' => 200,
                'data' => [],
            ]);
        }

        // Cari mahasiswa berdasarkan NIM atau nama
        $students = Person::query()
            ->leftJoin('unit_people', 'people.id', '=', 'unit_people.person_id')
            ->leftJoin('units', 'unit_people.unit_id', '=', 'units.id')
            ->where('per_group', 'MAHASISWA')
            ->where(function ($query) use ($search) {
                $query->where('per_num', 'like', "%{$search}%")
                    ->orWhere('per_id', 'like', "%{$search}%")
                    ->orWhereBlind('person', 'person_index', $search);
            })
            ->select('people.*')
            ->limit(10)
            ->get();


        return response()->json([
            'code' => 200,
            'message' => 'Data Mahasiswa ditemukan',
            'data' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $major = Unit::where('units.unit', 'like', 'S1%')->get();

        return Inertia::render('Person/Create', [
            'major' => $major
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'person' => 'required',
            'per_num' => 'required',
            'per_id' => 'required',
            'per_phone' => 'required',
            'per_email' => 'required',
            'per_group' => 'required',
            'active' => 'required',
        ]);

        // set the model class to assign the input data
        $people = new Person([
            'person' => $request->input('person'),
            'per_num' => $request->input('per_num'),
            'per_id' => $request->input('per_id'),
            'per_phone' => $request->input('per_phone'),
            'per_email' => $request->input('per_email'),
            'per_group' => $request->input('per_group')['id'],
            'per_major' => $request->input('per_major')['name'] ?? '',
            'per_years' => $request->input('per_years') ?? '',
            'per_faculty' =>  $request->input('per_group')['id'] === 'MAHASISWA' ? 'Direktorat Kampus Surabaya' : '',
            'active' => $request->input('active'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // $lastId = Person::where('per_num', $request->input('per_num'))->where('active', 'Y')->first();
        // check if input were successful
        if ($people->save() !== true) {
            return redirect()->route('person.index')->with('err', 'Input data failed');
        }

        // get id from last inputed data
        $lastId = Person::where('per_num', $request->input('per_num'))->where('per_id', $request->input('per_id'))->first();

        // set the model class to assign the input data
        $user = new User([
            'username' => $request->input('per_id'),
            'password' => Hash::make($request->input('per_num')),
            'person_id' => $lastId->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $user->save();
        // return it to view with true message
        return redirect()->route('person.index')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        // render the view along with the data
        return Inertia::render('Person/Show', [
            'person' => $person,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Person $person, Controller $ctrl)
    {
        // get all required people to be parsed by array
        // $person = Person::where('people.id', $person->id)
        //     ->join('users', 'people.id', '=', 'users.person_id')
        //     ->select('users.username', 'users.password', 'people.*')
        //     ->get();
        // get all required data to be parsed by array

        $person = Person::query()
            ->join('users', 'people.id', '=', 'users.person_id')
            ->leftJoin('unit_people', 'people.id', '=', 'unit_people.person_id')
            ->leftJoin('units', 'units.id', '=', 'unit_people.unit_id')
            ->where('people.active', 'Y')
            ->where('people.id', $person->id)
            ->select(
                'people.*',
                'users.username',
                'users.password',
                'units.id as unit_id',
                'units.unit as unit_name',
                'unit_people.position as unit_position'
            )
            ->first();

        $unit = Unit::where('active', 'Y')->get();
        $role = Role::where('active', 'Y')->get();
        $major = Unit::where('units.unit', 'like', 'S1%')->get();

        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Person/Edit', [
            'person' => $ctrl->toObject($person),
            'major' => $major,
            'unit' => $ctrl->toObject($unit),
            'role' => $ctrl->toObject($role),
            'person' => $person->toArray(),
            'unit' => $unit->toArray(),
            'role' => $role->toArray(),
        ]);
    }

    public function update(UpdatePersonRequest $request, Person $person, Controller $ctrl)
    {
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $person->update($request->all());

        // Handle password
        $password = $request->input('password') === ''
            ? $request->input('oldpassword')
            : Hash::make($request->input('password'));

        // Update user
        User::where('person_id', $person->id)->update([
            'username' => $request->input('per_num'),
            'password' => $password,
            'updated_at' => now(),
        ]);

        // Update UnitPeople jika group PEGAWAI
        if ($request->input('per_group') === 'PEGAWAI') {
            UnitPeople::updateOrCreate(
                ['person_id' => $person->id],
                [
                    'unit_id' => $request->input('per_unit.id'),
                    'position' => $request->input('unit_position.name'),
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->route('person.index')->with('msg', 'Data successfully updated.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $person->delete();
        User::where('person_id', $person->id)->delete();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // $user->where('person_id', $person->id)->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('person.index')->with('msg', 'Data succesfully removed');
    }
}
