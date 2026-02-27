<?php

namespace App\Http\Controllers;

use App\Exports\QuestionExport;
use App\Http\Requests\StoreQuestion;
use App\Models\Question;
use App\Models\Service;
use App\Models\Unit;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $limit  = (int) $request->query('limit', 10);
        $page   = (int) $request->query('page', 1);
        $search = $request->query('search');
        $unitFilter = $request->query('unit');
        $sortBy = $request->input('sortBy', 'questionNumber');
        $sortType = $request->input('sortType', 'asc');

        $query = Question::query();

        if ($unitFilter) {
            $query->where('category.unit.name', $unitFilter);
        }

        if (!empty($search)) {

            $query->where('questionNumber', 'like', '%' . $search . '%')
                ->orwhere('title', 'like', "%{$search}%")
                ->orWhere('category.service.name', 'like', "%{$search}%")
                ->orWhere('category.unit.name', 'like', "%{$search}%");
        }

        $totalCount = $query->count();
        $offset = ($page - 1) * $limit;

        $questions = $query
            ->orderBy($sortBy, $sortType)
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($q) {
                return [
                    'id'         => $q->_id,
                    'questionNumber'  => $q->questionNumber,
                    'title'      => $q->title,
                    'date'      => $q->date,
                    'category'   => $q->category,
                    'created_at' => $q->created_at,
                    'question'   => $q->question,
                    'answer'   => $q->answer,
                ];
            });

        $units = Unit::where('active', 'Y')
            ->pluck('unit')
            ->map(function ($unit) {
                return preg_replace('/\s*-\s*kampus surabaya/i', '', $unit);
            });

        return Inertia::render('Question/Index', [
            'data' => [
                'questions'       => $questions,
                'total'       => $totalCount,
                'per_page'    => $limit,
                'current_page' => $page,
                'last_page'   => ceil($totalCount / $limit),
            ],
            'units' => $units
        ]);
    }


    public function create()
    {
        $services = Service::select('services.*')
            // ->where('services.active', 'Y')
            ->get();

        $units = Unit::where('active', 'Y')->get();


        return Inertia::render('Question/Create', [
            'services' => $services,
            'units' => $units
        ]);
    }

    public function store(StoreQuestion $request)
    {
        $category = [
            "service" => $request->service,
            "unit" => $request->unit
        ];

        $questionNum = Question::orderBy('questionNumber', 'desc')->value('questionNumber');
        $lastQuestionNum = $questionNum ? (int) $questionNum : 0;
        $newQuestionNum = str_pad($lastQuestionNum + 1, 8, '0', STR_PAD_LEFT);

        Question::create([
            "title" => $request->title,
            "date" => $request->date,
            "questionNumber" => $newQuestionNum,
            "category" => $category,
            "question" => $request->question,
            "answer" => $request->answer
        ]);

        return redirect()->route('question.index')
            ->with('success', 'Pertanyaan berhasil dibuat');
    }

    public function edit(Question $question)
    {
        $services = Service::select('services.*')
            // ->where('services.active', 'Y')
            ->get();

        $units = Unit::where('active', 'Y')->get();

        return Inertia::render('Question/Edit', [
            'question' => $question,
            'services' => $services,
            'units' => $units
        ]);
    }

    public function update(StoreQuestion $request, Question $question)
    {

        $category = [
            "service" => $request->service,
            "unit" => $request->unit
        ];

        $question->update([
            "title" => $request->title,
            "date" => $request->date,
            "category" => $category,
            "question" => $request->question,
            "answer" => $request->answer
        ]);

        return redirect()->route('question.index')
            ->with('success', 'Pertanyaan berhasil diperbarui');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('question.index')
            ->with('success', 'Pertanyaan berhasil dihapus');
    }

    public function export(Request $request){
        $unit      = $request->input('unit');
        $sortType = $request->input('sortType', 'asc');
        $sortBy = $request->input('sortBy', 'ticketNumber');

        return Excel::download(new QuestionExport($unit, $sortBy, $sortType), 'question.xlsx');
    }
}
