<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RedirectAuthenticatedUsersController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = userrole($user->person_id);
        if (in_array(106, $roles)) {
            return redirect()->route('dashboard');
        } elseif (in_array(105, $roles)) {
            return redirect()->route('dashboard');
        } elseif (in_array(104, $roles)) {
            return redirect()->route('dashboard');
        } elseif (in_array(103, $roles)) {
            return redirect()->route('dashboard');
        } elseif (in_array(102, $roles)) {
            return redirect()->route('dashboard');
        } elseif (in_array(101, $roles)) {
            return redirect()->route('landing-page');
        } else {
            return auth()->logout();
        }
    }

    public function home(){
        return Inertia::render('Index');
    }
}
