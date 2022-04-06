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
                <p class="justify-self-end">{{$status}}</p>
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


        
        
        

@endsection