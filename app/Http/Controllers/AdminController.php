<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_teachers' => User::where('role', 'teacher')->count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_notes' => Note::count(),
            'new_users_this_week' => User::where('created_at', '>=', now()->subWeek())->count(),
            'new_notes_this_month' => Note::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // Get recent activity (you can customize this based on your needs)
        $recentActivity = [
            [
                'icon' => 'fa-user-plus',
                'color' => 'text-success',
                'message' => 'New user registered: ' . User::latest()->first()->name ?? 'John Doe',
                'time' => '2 hours ago'
            ],
            [
                'icon' => 'fa-file-upload',
                'color' => 'text-primary',
                'message' => 'New note uploaded: ' . Note::latest()->first()->title ?? 'Calculus I',
                'time' => '5 hours ago'
            ],
            [
                'icon' => 'fa-check-circle',
                'color' => 'text-info',
                'message' => 'System backup completed',
                'time' => 'Yesterday'
            ]
        ];

        return view('admin.dashboard', compact('stats', 'recentActivity'));
    }

    /**
     * Show all users
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    /**
     * Show all notes for moderation
     */
    public function notes()
    {
        $notes = Note::with('teacher')->latest()->paginate(15);
        return view('admin.notes', compact('notes'));
    }

    /**
     * Approve a note
     */
    public function approveNote(Note $note)
    {
        $note->update(['approved_at' => now()]);
        return redirect()->back()->with('success', 'Note approved successfully!');
    }

    /**
     * Reject/Delete a note
     */
    public function rejectNote(Note $note)
    {
        $note->delete();
        return redirect()->back()->with('success', 'Note rejected and deleted!');
    }

    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()->withErrors('You cannot delete your own admin account.');
        }

        $user->notes()->delete();
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
