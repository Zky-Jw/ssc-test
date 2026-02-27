<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\Person;
use App\Models\Ticket;
use App\Models\TicketProgress;
use App\Models\UnitPeople;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $document = Document::all();
        return Inertia::render('Document/Index', [
            'document' => $document->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     */
    public function generate()
    {
        $template = DocumentTemplate::where('active', 'Y')->get();
        $people = UnitPeople::join('people', 'unit_people.person_id', '=', 'people.id')
            ->where('unit_people.position', 'not like', 'MAHASISWA')
            ->select('people.id', 'people.person as name')
            ->get();
        $id = Request::segment(4);
        $ticket = Ticket::find($id);
        return Inertia::render('Document/Create',
            [
                'template' => $template->toArray(),
                'ticket' => $ticket->toArray(),
                'people' => $people->toArray(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'ticketNumber' => 'required',
            'template' => 'required',
            'approval' => 'required',
            'content.*.value' => 'required',
            'enclosure.*.value' => 'required',
        ]);
        if(!$validated){
            return redirect()->route('document.index')->with('error', 'All field must me filled.');
        }
        foreach ($request->approval as $key => $value) {
            $id = $request['approval'][$key]['name']['id'];
            $person = UnitPeople::join('people', 'unit_people.person_id', '=', 'people.id')
                ->join('units', 'unit_people.unit_id', '=', 'units.id')
                ->where('unit_people.person_id', $id)
                ->select('people.id', 'people.person as name', 'people.per_num', 'unit_people.position', 'units.unit as unit')
                ->first();
            $approval[$key] = [
                'id' => $request['approval'][$key]['name']['id'],
                'name' => $request['approval'][$key]['name']['name'],
                'position' => $person->position !== 'TPA' ? toTitle($person->position) : $person->position . ' ' . toTitle($person->unit),
                'employeeid' => $person->per_num,
                'approved' => '',
            ];
        }
        $enclosure = $request->enclosure;
        // if one of name contain word "Tanggal" then change current value to date format
        foreach ($enclosure as $key => $value) {
            if (strpos($value['name'], 'Tanggal') !== false) {
                $enclosure[$key]['value'] = date('Y-m-d H:i:s', strtotime($value['value']));
            }
        }
        // dd($enclosure, $request->all());
        try {
            $document = Document::create([
                'ticketNumber' => $request->ticketNumber,
                'template' => $request->template,
                'approval' => $approval,
                'content' => $request->content,
                'enclosure' => $request->enclosure,
                'active' => 'Y',
                'created' => [
                    'at' => date('Y-m-d H:i:s'),
                    'by' => [
                        'id' => auth()->user()->id,
                        'name' => userdata('person'),
                    ],
                ],
            ]);
            
            $ticket = Ticket::where('ticketNumber', (int) $request->ticketNumber)->first();
            $templateName = $request->template['name'];
            $ticketProgress = TicketProgress::create([
                'ticketId' => $ticket->id,
                'head' => 'document-generated',
                'content' => "Surat $templateName telah dibuat, surat dibuat untuk tiket #$ticket->ticketNumber",
                'attachment' => '',
                'by' => [
                    'name' => userdata('person'),
                    'id' => userdata('userid'),
                ],
                'timestamp' => date('Y-m-d H:i:s'),
            ]);
            return redirect()->route('document.index')->with('success', 'document generated successfully.');
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->route('document.index')->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document = Document::with('ticket')->find($document->id);
        $ticket = Ticket::where('ticketNumber', (int) $document->ticketNumber)->first();
        return Inertia::render('Document/Show', [
            'document' => $document->toArray(),
            'ticket' => $ticket->toArray(),
        ]);
    }

    /**
     * Update the approved field in the document data
     */
    public function approve(UpdateDocumentRequest $request, Document $document)
    {
        $pid = $request->approvedby['id'];
        $person = UnitPeople::join('people', 'unit_people.person_id', '=', 'people.id')
            ->join('units', 'unit_people.unit_id', '=', 'units.id')
            ->where('unit_people.person_id', $pid)
            ->select('people.id', 'people.person as name', 'people.per_num as empid', 'unit_people.position', 'units.unit as unit')
            ->first();
        // check if the person is exist
        if ($person) {
            $document = Document::find(Request::segment(4));
            $documentData = $document->toArray();
            $approval = $documentData['approval'];

            $index = array_search($pid, array_column($documentData['approval'], 'id'));
            $newData = [
                'id' => $person->id,
                'name' => $person->name,
                'position' => $person->position !== 'TPA' ? toTitle($person->position) : $person->position . ' ' . toTitle($person->unit),
                'employeeid' => $person->empid,
                'approved' => [
                    'time' => date('Y-m-d H:i:s'),
                    'token' => randomString(33),
                ],
            ];
            // replace the indexed approval array with the new data
            $approval[$index] = $newData;
            $document->update(['approval' => $approval]);
            // dd(route('document.show', $document->id));
            return redirect()->route('document.show', $document->id)->with('success', 'document has been approved.');
        } else {
            return redirect()->route('document.show', $document->id)->with('error', 'document failed to approve.');
        }
    }

    /**
     * Show the print preview of the document.
     */
    public function print(Document $document)
    {
        $id = Request::segment(4);
        $document = Document::find($id);
        if (!$document) {
            $document = Ticket::find($id);
            $document = Document::where('ticketNumber', (int) $document->ticketNumber)->first();
        }
        // dd(Request::segment(4), $document->toArray());
        $document = Document::with('ticket')->find($document->id);
        $ticket = Ticket::where('ticketNumber', (int) $document->ticketNumber)->first();
        return Inertia::render('Document/Print', [
            'document' => $document->toArray(),
            'ticket' => $ticket->toArray(),
        ]);
    }

    public function creatorCheck(Ticket $ticket, $id, $id2)
    {
        $ticket = Ticket::find($id)->with('document')->first();
        $person = Person::where('per_num', $id2)->first();
        $return = false;
        $data = [];
        if ($ticket && $person) {
            $return = true;
            $data = [
                'return' => $return,
                'ticket' => $ticket->toArray(),
                'person' => $person->toArray(),
                'document' => $ticket->document->toArray(),
            ];
        }
        // render the view with return as the data
        return Inertia::render('Document/CreatorCheck', $data);

    }

    public function approvalCheck(Document $document, $id, $token)
    {
        $document = Document::findOrFail($id);
        $approval = $document->toArray()['approval'];
        $ticket = Ticket::where('ticketNumber', (int) $document->ticketNumber)->first();
        $isTokenValid = false;
        $return = false;
        $data = [];

        // Search the approval array with the token
        $filteredApproval = array_filter($approval, function ($approved) use ($token) {
            return !empty($approved['approved']) && $approved['approved']['token'] == $token;
        });
        $filteredApproval = array_values($filteredApproval); // Reset array keys
        $isTokenValid = !empty($filteredApproval);
        $index = $isTokenValid ? array_search($filteredApproval[0], $approval) : null;

        // Check if the document and the token exist
        // Then print the document ID, the person who approved it, and their position
        if ($document && $isTokenValid) {
            $return = true;
            $data = [
                'return' => $return,
                'ticket' => $ticket->toArray(),
                'document' => $document->toArray(),
                'person' => $approval[$index],
            ];
        }

        return Inertia::render('Document/ApprovalCheck', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        Document::destroy($document->id);

        return redirect()->route('document.index')->with('msg', 'Data succesfully removed');
    }
}
