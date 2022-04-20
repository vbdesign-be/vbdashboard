<?php

namespace App\Http\Livewire;

use App\Models\Notitie;

use Livewire\Component;

class Note extends Component

{
    public $ticket_id;
    public $textNote;

    public function updateNote(){
        $note = Notitie::where('ticket_id', $this->ticket_id)->first();
        if(empty($note)){
            $newNote = new Notitie();
            $newNote->ticket_id = $this->ticket_id;
            $newNote->text = $this->textNote;
            $newNote->save();
        }else{
            $note->text = $this->textNote;
            $note->save();
        }
    }

    public function mount(){
        $note = Notitie::where('ticket_id', $this->ticket_id)->first();
        if(!empty($note)){
            $this->textNote = $note->text;
        }
        
    }

    public function render()
    {
        return view('livewire.note', [
            'notitie' => Notitie::where('ticket_id', $this->ticket_id)->first()
        ]);
    }
}
