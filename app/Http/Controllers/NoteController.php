<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Folder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = Folder::with('teacher')->get(); // Remove ->paginate()

        // Get all notes for the current page's folders
        $folderIds = $folders->pluck('id');
        $notes = Note::with('teacher')
            ->whereIn('folder_id', $folderIds)
            ->get();

        return view('dashboard', compact('folders', 'notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //teacher must pick a folder first
        $folders = Folder::where('user_id', auth()->id())->get();
        return view('notes.create', compact('folders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|exists:folders,id',
            'title' => 'required|string|max:255',
            'course_code' => 'required|string|max:20',
            'description' => 'required|string|max:500',
            'category' => 'nullable|string|max:50',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,png,jpg,jpeg,gif,zip,rar,txt|max:10240',
        ]);

        $file = $request->file('file');
        $filePath = $file->store('notes', 'public');

        Note::create([
            'user_id' => Auth::id(),
            'folder_id' => $request->folder_id,
            'title' => $request->title,
            'course_code' => $request->course_code,
            'description' => $request->description,
            'category' => $request->category,
            'file_path' => $filePath,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Note uploaded inside folder.');
    }

    //----------download function----------

    public function download(Note $note)
    {
        $filePath = storage_path('app/public/' . $note->file_path);
        return response()->download($filePath, $note->file_name);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
       if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($note->file_path)) {
            Storage::disk('public')->delete($note->file_path);
        }

        $note->delete();
        return redirect()->route('dashboard')->with('success', 'Note deleted successfully!');
    }
}
