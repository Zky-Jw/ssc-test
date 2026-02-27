<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Http\Requests\StoreServiceCategoryRequest;
use App\Http\Requests\UpdateServiceCategoryRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all required data to be parsed by array
        $serviceCategories = ServiceCategory::where('active','Y')
            ->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('ServiceCategory/Index', [
            'serviceCategory' => $serviceCategories->toArray(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('ServiceCategory/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceCategoryRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'category' => 'required',
            'type' => 'required',
            'active' => 'required',
        ]);
        // set the model class to assign the input data
        $serviceCategory = new ServiceCategory([
            'category' => $request->input('category'),
            'type' => $request->input('type')['id'],
            'active' => $request->input('active'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $serviceCategory->save();
        // return it to view with true message
        return redirect()->route('category.index')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceCategory $serviceCategory)
    {
        // render the view along with the data
        return Inertia::render('ServiceCategory/Show', [
            'serviceCategory' => $serviceCategory,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceCategory $serviceCategory, Controller $ctrl)
    {
        $serviceCategory = ServiceCategory::find(Request::segment(3));
        // dd($serviceCategory->toArray());
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('ServiceCategory/Edit', [
            'serviceCategory' => $serviceCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceCategoryRequest $request, ServiceCategory $serviceCategory, Controller $ctrl)
    {
        // validate the request data needed for update
        $request->validate([
            'category' => 'required',
            'type' => 'required',
            'active' => 'required',
        ]);
        $serviceCategory = ServiceCategory::find(Request::segment(3));
        $request['type'] = $request->input('type')['id'];
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $serviceCategory->update($request->all());
        // return it to view with true message
        return redirect()->route('category.index')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory = ServiceCategory::find(Request::segment(3));
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $serviceCategory->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('category.index')->with('msg', 'Data succesfully removed');
    }
}
