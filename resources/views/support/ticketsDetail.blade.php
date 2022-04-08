@extends('layouts/app')

@section('title', 'Ticket')

@section('content')

<div class="">
        
        <div>
          
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
              <div class="grid grid-cols-2">
                <p class="">{{$ticket->subject}}</p>
                <div class="justify-self-end"><form method="post" action="/support/ticket/statusUpdate">
                @csrf
                  <select name="status" id="">
                    @foreach($statusTypes as $key => $t)
                    @if($t[1] === $status)
                    <option selected name="status" value="{{$key}}">{{$t[1]}}</option>
                    @else
                    <option name="status" value="{{$key}}">{{$t[1]}}</option>
                    @endif
                    @endforeach
                </select>
                <input type="hidden" value="{{$ticket->id}}" name="ticket_id">
                <button>Status wijzigen</button>
                </form></div>
                <p class="italic">{{$date}}</p>
              </div>
              <div class="mt-6">
                <p class="">{{$ticket->description_text}}</p>
              </div>
            </div>
          </div>
        </section>

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              @foreach($conversation as $c)
              @if($c->user_id === $ticket->requester_id)
              <div class="bg-blue-200 shadow rounded mb-6 py-6 px-6">
                <p>{{$c->body_text}}</p>
              </div>
              @else
              <div class="bg-gray-200 shadow rounded mb-6 py-6 px-6">
                <p>{{$c->body_text}}</p>
              </div>
              @endif
              @endforeach
            </div>
          </div>
        </section>

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <form action="/support/ticket/conversation/add" method="post">
              @csrf
                <textarea class="w-full border p-5" name="reactie" rows="5" placeholder="Schrijf hier je reactie"></textarea>
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <input type="hidden" name="requester_id" value="{{$requester_id}}">
                <div class="flex justify-end mt-6">
                <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Reactie plaatsen</button>
                </div>
              </form>
            </div>
          </div>
        </section>


        
        
        

@endsection