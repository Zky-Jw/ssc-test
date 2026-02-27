<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\UnitPeople;
use App\Models\Unit;
use App\Models\Role;
use Inertia\Inertia;

use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->query('limit', 10);
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $limit;

        $search = $request->query('search');
        $sortBy = 'per_id';
        $sortType = $request->input('sortType', 'asc');

        $peopleQuery = Person::select('people.*', 'units.unit')
            ->join('unit_people', 'unit_people.person_id', '=', 'people.id')
            ->join('units', 'units.id', '=', 'unit_people.unit_id')
            ->where('units.unit', 'like', 'S1%');

        if ($search) {
            $peopleQuery->where(function ($q) use ($search) {
                $q->whereBlind('person', 'person_index', strtolower($search))
                    ->orWhereBlind('per_phone', 'per_phone_index', $search)
                    ->orWhere('per_id', 'like', '%' . $search . '%')
                    ->orWhere('people.per_num', 'like', '%' . $search . '%');
            });
        }


        $totalCount = $peopleQuery->count();

        $people = $peopleQuery
            ->orderBy($sortBy, $sortType)
            ->skip($offset)
            ->take($limit)
            ->get();

        $data = new \Illuminate\Pagination\LengthAwarePaginator(
            $people,
            $totalCount,
            $limit,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return Inertia::render('Lecturer/Index', [
            'data' => $data
        ]);
    }



    public function show(String $id)
    {
        $lecturer = Person::select('people.*', 'units.unit', 'units.id', 'unit_people.position')
            ->join('unit_people', 'unit_people.person_id', '=', 'people.id')
            ->join('units', 'units.id', '=', 'unit_people.unit_id')
            ->where('people.id', $id)
            ->firstOrFail();

        return Inertia::render('Lecturer/Show', [
            'lecturer' => $lecturer
        ]);
    }
}
