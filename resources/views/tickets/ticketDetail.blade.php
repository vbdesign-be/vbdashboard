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

        @if($flash = session('error'))
        @component('components/notification')
            @slot('type') red @endslot
            @slot('size')  notification-profile  @endslot
            @slot('textcolor') red @endslot
            <ul>
                <li>{{ $flash }}</li>
            </ul>
        @endcomponent
        @endif

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <a href="/tickets">Back knop</a>
          </div>
        </section>

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <div class="grid grid-cols-2">
                <div>
                @if(!empty($ticket->user_id))
                  <p class="text-xl font-bold mb-4">{{$ticket->user->firstname}}:</p>
                @else
                  <p class="text-xl font-bold mb-4">{{$ticket->email}}:</p>
                @endif
                  <p class="text-lg font-bold">{{$ticket->subject}}</p>
                  <p class="italic">{{ date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</p>
                </div>
                
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

        @if(!empty($reactions[0]))
        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
             @foreach($reactions as $reaction)
              @if(!empty($reaction->user_id))
              @if($reaction->user->id === $ticket->agent_id)
              <div><img class=" w-16 h-16 p-1 mb-4 mx-auto rounded-full border border-indigo-50" src="{{url('')}}/img/{{ $reaction->user->avatar }}" alt="avatar"></div>
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
              @if(!empty($reaction->user_id))
              <div><img class=" w-16 h-16 p-1 mb-4 mx-auto rounded-full border border-indigo-50" src="{{url('')}}/img/{{ $reaction->user->avatar }}" alt="avatar"></div>
              @endif
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

        

      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="py-4">
            <div class="w-6/12 mx-auto flex justify-center">
              <a class="mergeTicketBtn bg-indigo-500 rounded p-2 text-white" href="/ticket/samenvoegen/{{$ticket->id}}">Samenvoegen</a>
            </div>
          </div>
        </div>
      </section>

      <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <p>Afzender wijzigen</p>
              <form enctype="multipart/form-data" action="/ticket/changeuser" method="post">
              @csrf
                
                <div class="my-6">
                <label class="block text-sm font-medium mb-2" for="email">Email</label>
                <input class="border" type="text" name="email">
                </div>
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="flex justify-center mt-6">
                <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Wijzig</button>
                </div>
              </form>
            </div>
          </div>
        </section>

      <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <p>Ticket doorsturen</p>
              <form enctype="multipart/form-data" action="/ticket/send" method="post">
              @csrf
                
                <div class="my-6">
                <label class="block text-sm font-medium mb-2" for="email">Email</label>
                <input class="border" type="text" name="email">
                </div>
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <div class="flex justify-center mt-6">
                <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Doorsturen</button>
                </div>
              </form>
            </div>
          </div>
        </section>
      

      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="py-4 bg-white shadow rounded">
            <div class="w-6/12 mx-auto flex justify-center">
              <a class="deleteTicketBtn bg-red-500 rounded p-2 text-white" href="">Verwijder ticket</a>
            </div>
          </div>
        </div>
      </section>

      <div class="modal modal--deleteTicket hidden">
        <span class="close" title="Close"></span>
        <form class="modal-content" action="/ticket/delete" method="POST">
        @csrf
            <div class="container--modal">
                <h1>Delete ticket nr: {{$ticket->id}}</h1>
            <div class="clearfix">
                <button type="button"  class="cancelbtn cancelTicketbtn">Cancel</button>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                <button type="submit"  class="deletebtn" >Delete</button>
            </div>
            </div>
        </form>
    </div>


        
        
        

@endsection