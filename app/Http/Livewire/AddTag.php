<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\Tickets_Tags;
use Illuminate\Http\Request;
use Livewire\Component;

class AddTag extends Component
{
    public $ticket_id;
    
    public function addTag(Request $request){

        $credentials = $request->validate([
            'tag' => 'required',
        ]);

        $textTag = $request->input('tag');
        $ticket_id = $request->input('ticket_id');
        //tags splisten dankzij de komma en spatie
        $tags = explode(', ', $textTag);
        //tag id gaan halen of tag maken
        foreach($tags as $tag){
            $oldTag = Tag::where('name', $tag)->first();
            if(empty($oldTag)){
                $newTag = new Tag();
                $newTag->name = $tag;
                $newTag->save();
                $ticketsTags = new Tickets_Tags();
                $ticketsTags->ticket_id = $ticket_id;
                $ticketsTags->tag_id = $newTag->id;
                $ticketsTags->save();
            }else{
                $ticketsTags = new Tickets_Tags();
                $ticketsTags->ticket_id = $ticket_id;
                $ticketsTags->tag_id = $oldTag->id;
                $ticketsTags->save();
            }
        }
        
        $request->session()->flash('message', 'tags opgeslagen');
        return redirect('/ticket/'.$ticket_id);
    }
    
    public function render()
    {
        return view('livewire.add-tag');
    }
}
