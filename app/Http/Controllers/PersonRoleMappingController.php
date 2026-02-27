<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonRoleMappingRequest;
use App\Http\Requests\UpdatePersonRoleMappingRequest;
use App\Models\PersonRoleMapping;
use App\Models\Role;
use App\Models\Person;
use App\Models\User;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonRoleMappingController extends Controller
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
        $sortBy = 'per_id';
        $sortType = $request->input('sortType', 'asc');

        $personQuery = Person::with(['roles'])
            ->when($search, function ($q) use ($search) {
                $q->where('person', 'person_index', strtolower($search))
                    ->orWhere('per_phone', 'per_phone_index', $search)
                    ->orWhere('per_id', 'like', '%' . $search . '%')
                    ->orWhere('per_num', 'like', '%' . $search . '%');
            })
            ->join('person_role_mappings', 'person_role_mappings.person_id', '=', 'people.id')
            ->join('roles', 'roles.id', '=', 'person_role_mappings.role_id')
            ->select(
                'people.*',
                'person_role_mappings.id as mapping_id',
                'roles.id as role_id',
                'roles.role as role_name'
            );

        $totalCount = $personQuery->count();

        $privileges = $personQuery
            ->orderBy($sortBy, $sortType)
            ->skip($offset)
            ->take($limit)
            ->get();

        $privilegeData = new \Illuminate\Pagination\LengthAwarePaginator(
            $privileges,
            $totalCount,
            $limit,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $modul = Page::where('active', 'Y')->get();
        $roles = Role::where('active', 'Y')->get();

        return Inertia::render('Privilege/Index', [
            'privilege' => $privilegeData,
            'roles' => $roles->toArray(),
            'modul' => $modul->toArray(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get all required data to be parsed by array
        $roles = Role::where('active', 'Y')->get();
        $users = User::select('users.*', 'people.person', 'people.per_num', 'people.per_group')
            ->where('active', 'Y')
            ->join('people', 'users.person_id', '=', 'people.id')
            ->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Privilege/Person/Create', [
            'roles' => $roles->toArray(),
            'users' => $users->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRoleMappingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonRoleMapping $personRoleMapping)
    {
        //
        return Inertia::render('Privilege/Person/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $person = Person::with('roles')->find($id);

        if (!$person) {
            abort(404, 'Person not found');
        }

        $roles = Role::select('id', 'role')
            ->where('active', 'Y')
            ->get()
            ->map(function ($row) {
                $row->name = $row->role;
                unset($row->role);
                return $row;
            });


        return Inertia::render(
            'Privilege/Person/Edit',
            [
                'data' => $person->toArray(),
                'roles' => $roles->toArray()
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRoleMappingRequest $request, $id)
    {
        $person = PersonRoleMapping::where('person_id', $id)->firstOrFail();

        $person->update([
            'role_id' => $request->role['id'],
            'updatedby' => $person->person_id
        ]);

        return redirect()->route('privilege')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonRoleMapping $personRoleMapping)
    {
        //
    }
}
