<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use App\Models\Tickets_Tags;
use Livewire\Component;

class ShowTag extends Component
{
    
    public $ticket_id;
    public $tagInput;

    // protected $listeners = ['deleteTag' => 'deleteTag'];

    public function deleteTag($tickets_tags_id){
        Tickets_Tags::destroy($tickets_tags_id);
        
    }

    public function addTag(){
        $tags = explode(', ', $this->tagInput);
        foreach($tags as $tag){
            $oldTag = Tag::where('name', $tag)->first();
            if(empty($oldTag)){
                $newTag = new Tag();
                $newTag->name = $tag;
                $newTag->save();
                $ticketsTags = new Tickets_Tags();
                $ticketsTags->ticket_id = $this->ticket_id;
                $ticketsTags->tag_id = $newTag->id;
                $ticketsTags->save();
            }else{
                $checkTags = Tickets_Tags::where('tag_id', $oldTag->id)->where('ticket_id', $this->ticket_id)->first();
                if(empty($checkTags)){
                    $ticketsTags = new Tickets_Tags();
                    $ticketsTags->ticket_id = $this->ticket_id;
                    $ticketsTags->tag_id = $oldTag->id;
                    $ticketsTags->save();
                }
                
            }
        }
        $this->tagInput = " ";
    }

    

    public function render()
    {
        return view('livewire.show-tag',[ 
            'tickets_tags' => Tickets_Tags::where('ticket_id', $this->ticket_id)->get()
        ]);
    }
}
