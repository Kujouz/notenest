<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class HelpCenterController extends Controller
{
    /**
     * Show help center based on user role.
     */
    public function index()
    {
        if (Auth::user()->role === 'teacher') {
            return view('help.teacher');
        } else {
            return view('help.student');
        }
    }

    /**
     * Handle contact form submission.
     */
    public function contact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        // In a real app, you'd send this to your support email
        // For now, we'll just store it or show success message
        // Mail::to('support@notenest.com')->send(new SupportMessage($request->all()));

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent to the Note-Nest support team!'
        ]);
    }
}
