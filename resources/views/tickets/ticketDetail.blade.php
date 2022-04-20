@extends('layouts/app')

@section('title', 'Ticket')

@section('content')

<div class="">
        
        <div>
        <x-head.tinymce-config/>
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Ticket: {{$ticket->id}}</h2>
          </div>
        </div>

        @if($errors->any())
            @component('components/notification')
            @slot('type') red @endslot
            @slot('size') notification-profile   @endslot
            @slot('textcolor') red @endslot
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endcomponent
        @endif

        @if($flash = session('message'))
        @component('components/notification')
            @slot('type') green @endslot
            @slot('size')  notification-profile  @endslot
            @slot('textcolor') green @endslot
            <ul>
                <li>{{ $flash }}</li>
            </ul>
        @endcomponent
        @endif

        @if($flash = session('notification'))
        @component('components/notification')
            @slot('type') indigo @endslot
            @slot('size')  notification-profile  @endslot
            @slot('textcolor') indigo @endslot
            <ul>
                <li>{{ $flash }}</li>
            </ul>
        @endcomponent
        @endif

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
            @if(!empty($ticket->user_id))
            <p>{{$ticket->user->firstname}}</p>
            @else
            <p>{{$ticket->email}}</p>
            @endif
              <div class="grid grid-cols-2">
                <p class="">{{$ticket->subject}}</p>
                <div class="justify-self-end">
                  <!-- Status wijzigen -->
                  <form method="post" action="/ticket/statusUpdate">
                  @csrf
                  <select name="status" id="">
                    @foreach($statuses as $s)
                    @if($s->id === $ticket->status_id)
                    <option selected value="{{$s->id}}">{{$s->name}}</option>
                    @else
                    <option value="{{$s->id}}">{{$s->name}}</option>
                    @endif
                    
                    @endforeach
                </select>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                <button>Status wijzigen</button>
                </form>
                <!-- Priority wijzigen -->
                <form method="post" action="/ticket/priorityUpdate">
                  @csrf
                  <select name="priority" id="">
                    @foreach($priorities as $p)
                    @if($p->id === $ticket->priority_id)
                    <option selected value="{{$p->id}}">{{$p->name}}</option>
                    @else
                    <option value="{{$p->id}}">{{$p->name}}</option>
                    @endif
                    
                    @endforeach
                </select>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                <button>Priority wijzigen</button>
                </form>
                <!-- Type wijzigen -->
                <form method="post" action="/ticket/typeUpdate">
                  @csrf
                  <select name="type" id="">
                    @foreach($types as $t)
                    @if($t->id === $ticket->type_id)
                    <option selected value="{{$t->id}}">{{$t->name}}</option>
                    @else
                    <option value="{{$t->id}}">{{$t->name}}</option>
                    @endif
                    
                    @endforeach
                </select>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                <button>Type wijzigen</button>
                </form>
               
                <livewire:show-tag :ticket_id="$ticket->id">
                  
              </div>
                <p class="italic">{{ date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</p>
              </div>
              @if(!empty($ticket->cc[0]))
                <div class="flex">
                  cc:
                  @foreach($ticket->cc as $cc)
                  {{$cc->email}},
                  @endForeach
                </div>
              @endif
              <div class="mt-6">
                <p>{!! $ticket->body !!}</p>
              </div>
              @if(!empty($ticket->attachmentsTicket[0]))
              <div class="mt-6">
                <p>Attachments:</p>
                @foreach($ticket->attachmentsTicket as $att)
                <a href="/attachments/{{$att->src}}" download>{{$att->name}}</a>
                @endforeach
              </div>
              @endif
            </div>
          </div>
        </section>

        

        <livewire:note :ticket_id="$ticket->id"/>

        @if(!empty($ticket->reactions[0]))
        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
             @foreach($ticket->reactions as $reaction)
              @if(!empty($reaction->user_id))
              @if($reaction->user->id === $ticket->agent_id)
              <div class="bg-blue-200 w-shadow rounded w-8/12 ml-auto mb-6 py-6 px-6">
                <p class="mb-4">Jij schreef: </p>
                <p>{!! $reaction->text !!}</p>
                @if(!empty($reaction->attachmentsReaction[0]))
                <div class="mt-6">
                <p>Attachments:</p>
                @foreach($reaction->attachmentsReaction as $att)
                <a href="/attachments/{{$att->src}}" download>{{$att->name}}</a>
                @endforeach
                </div>
                @endif
              </div>
              @else
              <div class="bg-gray-200 shadow rounded w-8/12 mr-auto mb-6 py-6 px-6">
                @if(!empty($reaction->user_id))
                <p class="mb-4">{{$reaction->user->firstname}} schreef: </p>
                @else
                <p class="mb-4">{{$reaction->email}} schreef: </p>
                @endif
                <p>{!! $reaction->text !!}</p>
                @if(!empty($reaction->attachmentsReaction[0]))
                <div class="mt-6">
                <p>Attachments:</p>
                @foreach($reaction->attachmentsReaction as $att)
                <a href="/attachments/{{$att->src}}" download>{{$att->name}}</a>
                @endforeach
                </div>
                @endif
              </div>
              @endif
              @else
              <div class="bg-gray-200 shadow rounded w-8/12 mr-auto mb-6 py-6 px-6">
                <p class="mb-4">{{$reaction->email}} schreef: </p>
                <p>{!! $reaction->text !!}</p>
                @if(!empty($reaction->attachmentsReaction[0]))
                <div class="mt-6">
                <p>Attachments:</p>
                @foreach($reaction->attachmentsReaction as $att)
                <a href="/attachments/{{$att->src}}" download>{{$att->name}}</a>
                @endforeach
                </div>
                @endif
              </div>
              @endif
             @endforeach
            </div>
          </div>
        </section>
        @endif

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <form enctype="multipart/form-data" action="/ticket/reaction/add" method="post">
              @csrf
                <textarea id="myeditorinstance" class="w-full border p-5" name="reactie" rows="5" placeholder="Schrijf hier je reactie"></textarea>
                <div class="my-6">
                <label class="block text-sm font-medium mb-2" for="attachment">Attachment</label>
                <input name="attachments[]" type="file" accept=".png, .jpg, .jpeg, .pdf" multiple>
                </div>
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="flex justify-end mt-6">
                <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Reactie plaatsen</button>
                </div>
              </form>
            </div>
          </div>
        </section>

        <section class="py-6">
        <form enctype="multipart/form-data" action="/ticket/spam/add" method="post">
              @csrf
                @if(!empty($ticket->email))
                <input type="hidden" name="email" value="{{$ticket->email}}">
                @else
                <input type="hidden" name="email" value="{{$ticket->user->email}}">
                @endif
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="flex justify-center mt-6">
                <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">spam</button>
                </div>
              </form>
        </section>


        
        
        

@endsection