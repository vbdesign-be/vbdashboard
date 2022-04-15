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

        
        

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <div class="search">
                <form class="search__form  flex gap-4" action="">
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
                        <p>Nr: {{$ticket->id}}  <a href="/ticket/{{$ticket->id}}"><strong>{{$ticket->subject}}</strong></a></p>
                        @if(!empty($ticket->email))
                            <p>{{$ticket->email}}</p>
                        @else
                            <a href="/ticket/account/{{$ticket->user->id}}">{{$ticket->user->firstname}} {{$ticket->user->lastname}}</a>
                        @endif
                    </div>
                    <div class="ticket_tags">
                        <p>Tag:</p>
                        <p>{{$ticket->tag}}</p>
                    </div>
                    <div class="ticket_filters self-end">
                        <p>{{$ticket->priority}}</p>
                        <p>{{$ticket->status}}</p>
                        <p>{{$ticket->type}}</p>
                    </div>
                </div>
                @endforeach
            </div>
          </div>
        </div>
    </section>
        

@endsection