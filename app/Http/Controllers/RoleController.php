<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\PersonRoleMapping;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all required data to be parsed by array
        $roles = Role::where('active','Y')
            ->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Role/Index', [
            'role' => $roles->toArray(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Role/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'role' => 'required',
            'active' => 'required',
        ]);
        // set the model class to assign the input data
        $role = new Role([
            'role' => $request->input('role'),
            'active' => $request->input('active'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $role->save();
        // return it to view with true message
        return redirect()->route('role.index')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // render the view along with the data
        return Inertia::render('Role/Show', [
            'role' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role, Controller $ctrl)
    {
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Role/Edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role, Controller $ctrl)
    {
        // validate the request role needed for update
        // validate the request data needed for update
        $request->validate([
            'role' => 'required',
            'updatedby' => 'required',
        ]);
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $role->update($request->all());
        // return it to view with true message
        return redirect()->route('role.index')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $role->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('role.index')->with('msg', 'Data succesfully removed');
    }
}
