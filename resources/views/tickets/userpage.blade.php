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
            <a href="/tickets">Back knop</a>
          </div>
        </section>

        
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Tickets {{$user->firstname}} {{$user->lastname}}</h3>
              </div>
            </div>
            <div class="menu--horizontal pb-2 bg-gray-200 px-6">
                    <a class="menu--horizontal__item menu--horizontal--active ticketsBtn" href="">Tickets</a>
                    <a class="menu--horizontal__item timelineBtn" href="">Tijdlijn</a>
            </div>
          </div>
        </div>
    </section>

    <section class="py-8 agentTickets ">
        <div class="container px-4 mx-auto">
            @forelse($tickets as $ticket)
            <div class="ticket p-4 mb-4 bg-white shadow flex gap-20 rounded w-full mx-auto">
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
            @empty
            <div class="pt-6 bg-white shadow rounded mb-2">
                <p>Deze gebruiker heeft momenteel geen tickets</p>
            </div>
            @endforelse
        </div>
    </section>

    <section class="py-8 agentTimeline hidden">
        <div class="container px-4 mx-auto">
          timeline
            @forelse($timeline as $time)
            <div class="ticket p-4 mb-4 bg-white shadow rounded w-full mx-auto">
                    @if(isset($time['ticket_id']))
                    <div class="ticket p-4 mb-4 bg-white shadow flex gap-20 rounded w-full mx-auto">
                    <div class="ticket_time">
                      <p>{{ date('d/m/Y', strtotime($time['created_at']))}}</p>
                      <p>{{ date('h:i:s', strtotime($time['created_at']))}}</p>
                    </div>
                    <div class="ticket__info">
                        <p>Reactie op ticket nr: {{$time['ticket_id']}}</p>
                        @if($time['user']['id'] === Auth::id())
                        <p>Jij schreef:</p>
                        @else
                        <p>{{$time['user']['firstname']}} schreef:</p>
                        @endif
                        <a href="/ticket/{{$time['ticket_id']}}"><strong>{{substr($time['text'],0,25)}}...</strong></a>
                    </div>
                </div>
                    @else
                    <div class="ticket p-4 mb-4 bg-white shadow rounded flex gap-20 w-full mx-auto">
                    <div class="ticket_time">
                      <p>{{ date('d/m/Y', strtotime($time['created_at']))}}</p>
                      <p>{{ date('h:i:s', strtotime($time['created_at']))}}</p>
                    </div>
                    <div class="ticket__info">
                      <p>Ticket</p>
                        
                        <p>Nr: {{$time['id']}}  <a href="/ticket/{{$time['id']}}"><strong>{{$time['subject']}}</strong></a></p>
                        
                          <a href="/ticket/account/{{$time['user_id']}}">{{$ticket->user->firstname}} {{$ticket->user->lastname}}</a>
                        
                    </div>
                    <div class="ticket_tags">
                        <p>Tag:</p>
                        @foreach($time['tickets_tags'] as $t)
                        <p>{{$t['tag']['name']}}</p>
                        @endforeach
                    </div>
                    <div class="ticket_filters">
                        <p>{{$time['priority']['name']}}</p>
                        <p>{{$time['status']['name']}}</p>
                        <p>{{$time['type']['name']}}</p>
                    </div>
                </div>
                    @endif
                    
                    
                </div>
            @empty
            <div class="pt-6 bg-white shadow rounded mb-2">
                <p>Deze gebruiker heeft momenteel geen tickets</p>
            </div>
            @endforelse
        </div>
    </section>
        

@endsection