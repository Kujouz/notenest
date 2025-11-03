<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show profile based on user role.
     */
    public function show()
    {
        if (Auth::user()->role === 'teacher') {
            return view('profile.teacher');
        } else {
            return view('profile.student');
        }
    }
}
