<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::query()
            ->where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('note.index', ['notes' => $notes]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('note.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $data = request()->validate([
            'note' => ['required', 'string'],
        ]);

          $note = Note::create([
             'note' => $data['note'],
              'created_by' => Auth::user()->id,
         ]);

         return to_route('note.show', $note)->with('message', 'Note created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $userId = Auth::user()->id;
        $note = Note::findOrFail($id);
        if ($note->created_by != $userId) {
            abort(403);
        }
        return view('note.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $userId = Auth::user()->id;
        $note = Note::findOrFail($id);
        if ($note->created_by != $userId) {
            abort(403);
        }
        return view('note.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'note' => ['required', 'string']
        ]);

        $userId = Auth::user()->id;
        $note = Note::findOrFail($id);
        if ($note->created_by != $userId) {
            abort(403);
        }

        $note->update($data);

        return to_route('note.show', $note)->with('message', 'Note was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $userId = Auth::user()->id;
        $note = Note::findOrFail($id);
        if ($note->created_by != $userId) {
            abort(403);
        }

        $note->delete();
        return to_route('note.index')->with('message', 'Note was deleted');
    }
}
