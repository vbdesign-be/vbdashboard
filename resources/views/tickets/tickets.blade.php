@extends('layouts/app')

@section('title', 'Tickets')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>


          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Tickets</h2>
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
              <div class="search">
                <form class="search__form search__form--agent  flex gap-4" action="">
                  <input class="border search__input rounded" type="text" name="search">
                  <button class="rounded search__btn bg-blue-500 text-white" type="submit">Zoek</button>
                </form>
              </div>
            </div>
          </div>
        </section>
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Overzicht Tickets voor {{Auth::user()->firstname}}</h3>
              </div>
            </div>
            <div class="p-4 bg-gray-200 overflow-x-auto">

                @foreach($tickets as $ticket)
                    <div class="ticket--agent p-4 mb-4 bg-white shadow rounded w-full mx-auto">
                    <div class="ticket__info">
                        @if($ticket->isOpen === 0) <p>NIEUW</p> @endif
                        <p>Nr: {{$ticket->id}}  <a href="/ticket/{{$ticket->id}}"><strong class="ticket__subject">{{$ticket->subject}}</strong></a></p>
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
                @endforeach
            </div>
          </div>
        </div>
    </section>
        

@endsection