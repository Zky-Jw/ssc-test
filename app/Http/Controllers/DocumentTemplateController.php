<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentTemplateRequest;
use App\Http\Requests\UpdateDocumentTemplateRequest;
use App\Models\DocumentTemplate;
use App\Models\UnitPeople;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DocumentTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all required data to be parsed by array
        $templates = DocumentTemplate::where('active', 'Y')
            ->get();
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('DocumentTemplate/Index', [
            'template' => $templates->toArray(),
        ]);
    }

    /**
     * Get ajax data in basic format
     */
    public function getJsonTemplateById($id)
    {
        // get all required data to be parsed by array
        $template = DocumentTemplate::where('id', $id)
            ->where('active', 'Y')
            ->first();
        if ($template === null) {
            return response()->json([
                'code' => 404,
                'message' => 'Data template tidak ditemukan',
                'data' => $template,
            ]);
        }
        return response()->json([
            'code' => 200,
            'message' => 'Data service ditemukan',
            'data' => $template,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // get unit_people and join it with people where unit_people.position not like 'MAHASISWA'
        // $people = UnitPeople::join('people', 'unit_people.person_id', '=', 'people.id')
        //     ->where('unit_people.position', 'not like', 'MAHASISWA')
        //     ->select('people.id', 'people.person as name')
        //     ->get();

        $people = UnitPeople::with([
            'person' => fn($q) => $q->select('id', 'person', 'per_phone')
        ])
            ->where('unit_people.position', 'not like', 'MAHASISWA')
            ->get();

        $people = $people->map(function ($item) {
            return [
                'id'   => $item->person->id,
                'name' => $item->person->person,
            ];
        });

        // dd($people->toArray());
        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('DocumentTemplate/Create', [
            'people' => $people->toArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentTemplateRequest $request)
    {
        // validate the request data needed for insert
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'approval' => 'required',
            'active' => 'required',
        ]);
        $request['content'] = json_encode($request->input('content'));
        $request['required_field'] = json_encode($request->input('required_field'));
        $request['approval'] = json_encode($request->input('approval'));
        // dd($request->all());
        // set the model class to assign the input data
        $template = new DocumentTemplate([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'required_field' => $request->input('required_field'),
            'approval' => $request->input('approval'),
            'active' => $request->input('active'),
            'created_at' => date('Y-m-d H:i:s'),
            'createdby' => $request->input('createdby'),
        ]);
        $template->save();
        // return it to view with true message
        return redirect()->route('document-template.index')->with('msg', 'Data succesfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentTemplate $template)
    {
        // render the view along with the data
        return Inertia::render('DocumentTemplate/Show', [
            'template' => $template,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentTemplate $template, Controller $ctrl)
    {
        $template = DocumentTemplate::find(Request::segment(3));
        $people = UnitPeople::with([
            'person' => fn($q) => $q->select('id', 'person', 'per_phone')
        ])
            ->where('unit_people.position', 'not like', 'MAHASISWA')
            ->get();

        $people = $people->map(function ($item) {
            return [
                'id'   => $item->person->id,
                'name' => $item->person->person,
            ];
        });

        // dd($people);


        // parse it to array while passing it to inertia to be rendered to view
        return Inertia::render('DocumentTemplate/Edit', [
            'template' => $template,
            'people' => $people->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentTemplateRequest $request, DocumentTemplate $template, Controller $ctrl)
    {
        $request['content'] = json_encode($request->input('content'));
        $request['required_field'] = json_encode($request->input('required_field'));
        $request['approval'] = json_encode($request->input('approval'));
        $request['active'] = $ctrl->toDbActive($request->input('active'));
        $template = DocumentTemplate::find(Request::segment(3));
        $template->update($request->all());
        // return it to view with true message
        return redirect()->route('document-template.index')->with('msg', 'Data succesfully changed');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentTemplate $template)
    {
        $template = DocumentTemplate::find(Request::segment(3));
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $template->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return redirect()->route('document-template.index')->with('msg', 'Data succesfully removed');
    }
}
