@extends('layouts/app')

@section('title', 'Tickets samenvoegen')

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
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Ticket</h3>
              </div>
            </div>
            <div class="p-4 bg-gray-200 overflow-x-auto">

                
                    <div class="ticket--agent ticket--og p-4 mb-4 bg-white shadow rounded w-full mx-auto">
                    <div class="ticket__info">
                        @if($ticket->isOpen === 0) <p>NIEUW</p> @endif
                        <p>Nr: {{$ticket->id}}  <a href="/ticket/{{$ticket->id}}"><strong>{{$ticket->subject}}</strong></a></p>
                        @if(!empty($ticket->email))
                            <p>{{$ticket->email}}</p>
                        @else
                            <a href="/ticket/account/{{$ticket->user->id}}">{{$ticket->user->firstname}} {{$ticket->user->lastname}}</a>
                        @endif
                    </div>
                    <div class="ticket_tags">
                        <p>Tag:</p>
                        @foreach($ticket->tickets_tags as $t)
                        <p>{{$t->tag->name}}</p>
                        @endforeach
                    </div>
                    <div class="ticket_filters">
                        <p>{{$ticket->priority->name}}</p>
                        <p>{{$ticket->status->name}}</p>
                        <p>{{$ticket->type->name}}</p>
                    </div>
                </div>
               
            </div>
          </div>
        </div>
    </section>

    <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Tickets om samen te voegen</h3>
              </div>
            </div>
            <div class="p-4 bg-gray-200 overflow-x-auto">

                    @foreach($allTickets as $t)
                    <div data-id="{{$t->id}}" class="ticket--agent ticket--merge p-4 mb-4 bg-white shadow rounded w-full mx-auto">
                    <div class="ticket__info">
                        @if($t->isOpen === 0) <p>NIEUW</p> @endif
                        <p>Nr: {{$t->id}}  <a href="/ticket/{{$t->id}}"><strong>{{$t->subject}}</strong></a></p>
                        @if(!empty($t->email))
                            <p>{{$t->email}}</p>
                        @else
                            <a href="/ticket/account/{{$t->user->id}}">{{$t->user->firstname}} {{$t->user->lastname}}</a>
                        @endif
                    </div>
                    <div class="ticket_tags">
                        <p>Tag:</p>
                        @foreach($t->tickets_tags as $tag)
                        <p>{{$tag->tag->name}}</p>
                        @endforeach
                    </div>
                    <div class="ticket_filters">
                        <p>{{$t->priority->name}}</p>
                        <p>{{$t->status->name}}</p>
                        <p>{{$t->type->name}}</p>
                    </div>
                </div>
               @endforeach
            </div>
          </div>
        </div>
    </section>
    
    <form enctype="multipart/form-data" action="/tickets/merge" method="post">
        @csrf
        <input type="hidden" name="ticket1" value="{{$ticket->id}}">
        <input type="hidden" class="ticket2" name="ticket2" value="">
        <button type="submit">Voeg samen</button>
    </form>

        

@endsection