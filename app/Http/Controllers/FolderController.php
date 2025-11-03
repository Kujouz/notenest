<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Note;

class FolderController extends Controller
{

    public function index()
{
    $folders = Folder::with('teacher')->get();
    $notes = Note::with('teacher')->get();
    return view('dashboard', compact('folders', 'notes'));
}
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'code' => 'required|string|max:20']);

        Folder::create([
            'name' => $request->name,
            'code' => $request->code,
            'user_id' => Auth::id(),
        ]);
        return redirect()->route('dashboard')->with('success', 'Folder created.');
    }

    public function show(Folder $folder)
{
    return view('folders.show', compact('folder'));
}
public function destroy(Folder $folder)
    {
        if ($folder->user_id !== Auth::id()) {
            abort(403, 'You can only delete your own folders.');
        }

        // Delete all notes in this folder first
        $notes = Note::where('folder_id', $folder->id)->get();
        foreach ($notes as $note) {
            if (Storage::disk('public')->exists($note->file_path)) {
                Storage::disk('public')->delete($note->file_path);
            }
        }

        // Delete the notes from database
        Note::where('folder_id', $folder->id)->delete();

        $folder->delete();
        return redirect()->route('dashboard')->with('success', 'Folder deleted successfully!');
    }
}
