<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        // Get user counts by role
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalTeachers = User::where('role', 'teacher')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Get all users for the table
        $users = User::all();

        // Pass data to the view
        return view('admin.users', compact(
            'totalUsers',
            'totalStudents',
            'totalTeachers',
            'totalAdmins',
            'users'
        ));
    }

    /**
     * Show all notes for moderation
     */
    public function notes()
    {
        $notes = Note::with('user', 'folder')->latest()->get();
        $folders = Folder::all();
        return view('admin.notes', compact('notes', 'folders'));
    }

    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_code' => 'required|string|max:20',
            'folder_id' => 'required|exists:folders,id',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:20480',
        ]);

        // get uploaded file instance
        $uploadedFile = $request->file('file');

        // safety check (shouldn't be necessary because of validation, but good practice)
        if (!$uploadedFile || !$uploadedFile->isValid()) {
            return back()->withErrors(['file' => 'Uploaded file is invalid.'])->withInput();
        }

        // store file in storage/app/public/notes
        $path = $uploadedFile->store('notes', 'public');

        $path = $request->file('file')->store('notes', 'public');

        Note::create([
            'title' => $validated['title'],
            'course_code' => $request->course_code,
            'folder_id' => $validated['folder_id'],
            'description' => $validated['description'],
            'file_path' => $path,
            'file_name' => $uploadedFile->getClientOriginalName(),
            'file_type' => $uploadedFile->getMimeType(),
            'file_size' => $uploadedFile->getSize(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.notes')->with('success', 'Note uploaded successfully!');
    }

    public function deleteNote($id)
    {
        $note = Note::findOrFail($id);
        if ($note->file_path) {
            Storage::disk('public')->delete($note->file_path);
        }
        $note->delete();

        return back()->with('success', 'Note deleted successfully!');
    }

    public function folders()
    {
        $folders = Folder::with('notes')->get();
        return view('admin.folders', compact('folders'));
    }

    public function storeFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Folder::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Folder created successfully!');
    }

    public function destroyFolder($id)
    {
        $folder = Folder::findOrFail($id);
        $folder->delete();

        return back()->with('success', 'Folder deleted successfully!');
    }
    /**
     * Delete a user
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    public function storeUser(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,teacher,student',
        ]);

        // Create the new user
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Redirect back with success message
        return redirect()
            ->route('admin.users')
            ->with('success', 'User "' . $user->name . '" has been created successfully.');
    }

    public function reports()
    {
    // ✅ 1. Basic counts
    $totalUsers = \App\Models\User::count();
    $totalNotes = \App\Models\Note::count();
    $teacherCount = \App\Models\User::where('role', 'teacher')->count();
    $studentCount = \App\Models\User::where('role', 'student')->count();

    // ✅ 2. Notes by category
    $notesByCategory = \App\Models\Note::select('course_code', \DB::raw('COUNT(*) as total'))
        ->groupBy('course_code')
        ->get();

    // ✅ 3. Notes by folder
    $notesByFolder = \App\Models\Folder::withCount('notes')->get();

    // ✅ 4. Uploads by role (teacher vs student)
    $uploadsByRole = \DB::table('users')
        ->leftJoin('notes', 'users.id', '=', 'notes.user_id')
        ->select('users.role', \DB::raw('COUNT(notes.id) as uploads'))
        ->groupBy('users.role')
        ->get();

    // ✅ 5. Upload activity (notes uploaded per day for last 14 days)
    $activity = \App\Models\Note::select(
            \DB::raw('DATE(created_at) as date'),
            \DB::raw('COUNT(*) as total')
        )
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // ✅ 6. Top uploaders
    $topUploaders = \DB::table('users')
        ->leftJoin('notes', 'users.id', '=', 'notes.user_id')
        ->select('users.name', \DB::raw('COUNT(notes.id) as uploads'))
        ->groupBy('users.id', 'users.name')
        ->orderByDesc('uploads')
        ->limit(5)
        ->get();

    // ✅ 7. Return to Blade view
    return view('admin.reports', compact(
        'totalUsers',
        'totalNotes',
        'teacherCount',
        'studentCount',
        'notesByCategory',
        'notesByFolder',
        'uploadsByRole',
        'activity',
        'topUploaders'
    ));
    }
}
