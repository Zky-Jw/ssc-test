<?php

namespace App\Http\Controllers;

use App\Models\ServiceTag;
use Illuminate\Http\Request;


class ServiceTagController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $tags = ServiceTag::orderBy('id', 'desc')->cursorPaginate($perPage);
        return response()->json($tags);
    }
}
