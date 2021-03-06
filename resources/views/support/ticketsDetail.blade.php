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

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <a href="/support/tickets">Back knop</a>
          </div>
        </section>

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
              
              <div class="grid grid-cols-2">
                <p class="text-xl font-bold mb-4">{{$ticket->subject}}</p>
                <div class="justify-self-end"><form method="post" action="/support/ticket/statusUpdate">
                @csrf
                  <select name="status" id="">
                    @foreach($statuses as $s)
                    @if($s->name != "In behandeling")
                    @if($s->id === $ticket->status_id)
                    <option selected value="{{$s->id}}">{{$s->name}}</option>
                    @else
                    <option value="{{$s->id}}">{{$s->name}}</option>
                    @endif
                    @endif
                    @endforeach
                </select>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                <button>Status wijzigen</button>
                </form></div>
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

        @if(!empty($ticket->reactions[0]))
        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
             @foreach($ticket->reactions as $reaction)
              @if($reaction->user->id === $ticket->user_id)
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
              <div><img class=" w-16 h-16 p-1 mb-4 mx-auto rounded-full border border-indigo-50" src="{{url('')}}/img/{{ $reaction->user->avatar }}" alt="avatar"></div>
              <div class="bg-gray-200 shadow rounded w-8/12 mr-auto mb-6 py-6 px-6">
                <p class="mb-4">{{$reaction->user->firstname}} schreef: </p>
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
              <form enctype="multipart/form-data" action="/support/ticket/reaction/add" method="post">
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


        
        
        

@endsection