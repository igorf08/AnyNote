<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {

        $id = session('user.id');
        $notes = User::find($id)
                ->notes()
                ->whereNull('deleted_at')
                ->get()
                ->toArray();

        return view('main', ['notes' => $notes]);
    }
    public function newNote()
    {
        return view('new_note');
    }

    public function newNoteSubmit(Request $request) 
    {
        $request->validate(
        [
            'text_title' => 'required|min:3|max:200', 
            'text_note' => 'required|min:3|max:3000'
        ],
        [
            'text_title.required' => 'O título é obrigatório.',
            'text_title.min' => 'O título deve conter no mínimo :min caracteres.',
            'text_title.max' => 'O título deve conter no máximo :max caracteres',

            'text_note.required' => 'O texto é obrigatório.',
            'text_note.min' => 'O texto deve conter no mínimo :min caracteres',
            'text_note.max' => 'O texto deve conter no máximo :max caracteres',
        ]);

        $id = session('user.id');

        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
        
    }

    public function editNote($id)
    {
        $id = Operations::decryptId($id);

        if ($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request)
    {
        $request->validate([
            'text_title' => 'required|min:3|max:200', 
            'text_note' => 'required|min:3|max:3000'
        ],
        [
            'text_title.required' => 'O título é obrigatório.',
            'text_title.min' => 'O título deve conter no mínimo :min caracteres.',
            'text_title.max' => 'O título deve conter no máximo :max caracteres',

            'text_note.required' => 'O texto é obrigatório.',
            'text_note.min' => 'O texto deve conter no mínimo :min caracteres',
            'text_note.max' => 'O texto deve conter no máximo :max caracteres',
        ]);
        
                
        if ($request->note_id == null) {
            return redirect()->route('home');
        }

        $id = Operations::decryptId($request->note_id);
        
        if ($id === null) {
            return redirect()->route('home');
        }
        
        $note = Note::find($id);

        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        return redirect()->route('home');
    }

    

    public function deleteNote($id)
    {
        $id = Operations::decryptId($id);;
        
        if ($id === null) {
            return redirect()->route('home');
        }

        $note = Note::find($id);

        return view('delete_note', ['note' => $note]);
    }
    public function deleteNoteConfirm($id)
    {
        $id = Operations::decryptId($id);
        
        if ($id === null) {
            return redirect()->route('home');
        }
        
        $note = Note::find($id);

        //soft delete 1
        // $note->deleted_at = date('Y:m:d H:i:s');
        // $note->save();
        
        // soft delete, but with property in model.
        $note->forceDelete();


        return redirect()->route('home');
    }
};
