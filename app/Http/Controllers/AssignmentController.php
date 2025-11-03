<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Show assignment submission form for a specific note.
     */
    public function create(Note $note)
    {
        // Ensure note exists and is accessible
        return view('assignments.create', compact('note'));
    }

    /**
     * Store a newly submitted assignment.
     */
    public function store(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,txt|max:10240',
        ]);

        // Check if student has already submitted for this note
        $existing = Assignment::where('student_id', Auth::id())
            ->where('note_id', $note->id)
            ->first();

        if ($existing) {
            return back()->withErrors(['error' => 'You have already submitted an assignment for this note.']);
        }

        $file = $request->file('file');
        $filePath = $file->store('assignments', 'public');

        Assignment::create([
            'note_id' => $note->id,
            'student_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'status' => 'submitted',
        ]);

        return redirect()->route('dashboard')->with('success', 'Assignment submitted successfully!');
    }

    /**
     * Display all assignments for a teacher's notes.
     */
    public function index()
    {
        $assignments = Assignment::with(['note.folder', 'student'])
            ->whereHas('note', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show specific assignment details for grading.
     */
    public function show(Assignment $assignment)
    {
        // Ensure teacher owns the note this assignment is for
        if ($assignment->note->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to view this assignment.');
        }

        return view('assignments.show', compact('assignment'));
    }

    /**
     * Grade an assignment.
     */
    public function grade(Request $request, Assignment $assignment)
    {
        if ($assignment->note->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'grade' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $assignment->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'status' => 'graded',
        ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment graded successfully!');
    }

    /**
     * Download assignment file.
     */
    public function download(Assignment $assignment)
    {
        if ($assignment->note->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to download this assignment.');
        }

        $filePath = storage_path('app/public/' . $assignment->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->download($filePath, $assignment->file_name);
    }
}
