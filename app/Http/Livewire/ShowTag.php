<?php

namespace App\Http\Livewire;

use App\Models\Tickets_Tags;
use Livewire\Component;

class ShowTag extends Component
{
    
    public $ticket_id;

    // protected $listeners = ['deleteTag' => 'deleteTag'];

    public function deleteTag($tickets_tags_id){
        $tickets_tags = Tickets_Tags::find($tickets_tags_id)->first();
        $tickets_tags->delete();
    }

    

    public function render()
    {
        return view('livewire.show-tag',[ 
            'tickets_tags' => Tickets_Tags::where('ticket_id', $this->ticket_id)->get()
        ]);
    }
}
