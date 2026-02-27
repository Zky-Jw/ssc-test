<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all()->toArray();
        return array_reverse($data);
        // return array_reverse();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User([
            'username' => $request->input('per_num'),
            'password' => Hash::make($request->input('per_num')),
            'person_id' => $lastId->id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $inputedUser = $user->save();
        echo json_encode($inputedUser);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $person->delete();
        return response()->json(['status' => 200, 'msg' => 'The user successfully deleted']);
    }
}
