<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all required data to be parsed by array
        $moduls = Page::where('active','Y')
            ->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Modul/Index', [
            'modul' => $moduls->toArray(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Modul/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePageRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'modul' => 'required',
            'active' => 'required',
        ]);
        // set the model class to assign the input data
        $modul = new Page([
            'page' => $request->input('modul'),
            'url' => strtolower("/".$request->input('modul')),
            'active' => $request->input('active'),
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $request->input('createdby'),
        ]);
        $modul->save();
        // return it to view with true message
        return redirect()->route('modul')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $modul)
    {
        // render the view along with the data
        return Inertia::render('Modul/Show', [
            'modul' => $modul,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $modul, Controller $ctrl)
    {
        $modul = Page::find(Request::segment(3));
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('Modul/Edit', [
            'modul' => $modul,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePageRequest $request, Page $modul, Controller $ctrl)
    {
        // validate the request data needed for update
        $request->validate([
            'modul' => 'required',
            'url' => 'required',
            'active' => 'required',
        ]);
        $request['page'] = $request->input('modul');
        $modul = Page::find(Request::segment(3));
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $modul->update($request->all());
        // return it to view with true message
        return redirect()->route('modul')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $modul)
    {
        $modul = Page::find(Request::segment(3));
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $modul->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('modul')->with('msg', 'Data succesfully removed');
    }
}
