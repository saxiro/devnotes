<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NoteController extends Controller
{
    private $array = ['error'=>'', 'result' => []];

    public function all(){
        $notes = Note::all();

        foreach($notes as $note){
            $this->array['result'][] = [
                'id' => $note->id,
                'title' => $note->title
            ];
        }

        return $this->array;
    }

    public function one($id){
        $note = Note::find($id);

        if($note){
            
            $this->array['result'] = [
                'id' => $note->id,
                'title' => $note->title,
                'body' => $note->body
            ];

        } else {

            $this->array['error'] = "Nota inexistente no sistema.";
        
        }
        return $this->array;
    }

    public function new(Request $request){
        $note = new Note;

        $note->title = $request->title;
        $note->body = $request->body;

        if($note->title && $note->body){
            $note->save();

            $this->array['result']= [
                'id' => $note->id,
                'title' => $note->title,
                'body' => $note->body
            ];
        } else {
            $this->array['error'] = "Dados inválidos";
        }
        

        
        return $this->array;
    }

    public function edit(Request $request, $id){
        $note = Note::find($id);

        if($note){
            if($request->title){

                $note->title = $request->title;
                $note->body = $request->body;
                $note->save();

                $this->array['result']=[
                    'title' => $note->title,
                    'body' => $note->body
                ];

            } else {
                $this->array['error'] = "O título deve ser preenchido.";
            }
        } else {
            $this->array['error'] = "Nota não encontrada.";
        }

        return $this->array;
    }

    public function destroy($id){
        $note = Note::find($id);

        if($note){
            $note->delete();
        } else {
            $this->array['error'] = "ID inexistente";
        }

        return $this->array;

    }
}
