@extends('layouts/app')

@section('title', 'Tickets')

@section('content')

<div class="">
        
        <div>
        <x-head.tinymce-config/>
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
                <a class="addTicketAgentBtn search__addBtn" href="">Ticket toevoegen</a>
              </div>
            </div>
          </div>
        </section>

        <section class="py-8  form--addTicketAgent">
          <div class="container px-4 mx-auto">
            <form enctype="multipart/form-data"  class="bg-white shadow rounded py-6 px-6" action="/tickets/ticketAdd" method="post" >
            @csrf
            <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
              <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
                <div class="mb-6">
                  <label class="block text-sm font-medium mb-2" for="klant">Klant</label>
                  <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="klant" value="{{ old('klant') }}">
                </div>
                <div class="mb-6">
                  <label class="block text-sm font-medium mb-2" for="onderwerp">Onderwerp</label>
                  <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="onderwerp" value="{{ old('onderwerp') }}">
                </div>
                <div class="mb-6">
                  <label class="block text-sm font-medium mb-2" for="tags">Tags</label>
                  <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="tags" value="{{ old('tags') }}">
                </div>
              </div>
            <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
              <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="type">Type</label>
                <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="number" name="type" value="{{ old('type') }}">
                  @foreach($types as $type)
                  <option value="{{$type->id}}">{{$type->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="prioriteit">Prioriteit</label>
                <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="number" name="prioriteit" value="{{ old('type') }}">
                  @foreach($priorities as $p)
                  <option value="{{$p->id}}">{{$p->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            </div>
      
            <div class="mb-6">
            <label class="block text-sm font-medium mb-2" for="beschrijving">Beschrijving</label>
              <textarea id="myeditorinstance" class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="beschrijving" rows="5" value="{{ old('beschrijving') }}"></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="attachments">Attachment</label>
                <input name="attachments[]" type="file" accept=".png, .jpg, .jpeg, .pdf" multiple>
            </div>
      
            <div class="form__btn">
              <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Plaats ticket</button>
            </div>

          </form>
          </div>

        </section>
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Overzicht Tickets voor {{Auth::user()->firstname}}</h3>
              </div>
              <div class="mb-6">
                Filteren op: <select class="filterSelect" name="" id="">
                  @if(!empty($filter))
                  <option @if($filter === "date") selected @endif value="date">Datum</option>
                  <option @if($filter === "status") selected @endif  value="status">Status</option>
                  <option @if($filter === "priority") selected @endif  value="priority">Priority</option>
                  <option @if($filter === "type") selected @endif  value="Type">type</option>
                  @else
                  <option value="date">Datum</option>
                  <option value="status">Status</option>
                  <option value="priority">Priority</option>
                  <option value="type">Type</option>
                  @endif
                </select>
              </div>
            </div>
            <div class="p-4 bg-gray-200 overflow-x-auto">

                @foreach($tickets as $ticket)
                    <div class="ticket--agent p-4 mb-4 bg-white shadow rounded w-full mx-auto">
                    <div class="ticket__info">
                        @if($ticket->isOpen === 0) <p>NIEUW</p> @endif
                        <p>Nr: {{$ticket->id}}  <a href="/ticket/{{$ticket->id}}"><strong class="ticket__subject">{{$ticket->subject}}</strong></a></p>
                        @if(!empty($ticket->email))
                            <p class="ticket__sender">{{$ticket->email}}</p>
                        @else
                            <a class="ticket__sender" href="/ticket/account/{{$ticket->user->id}}">{{$ticket->user->firstname}} {{$ticket->user->lastname}}</a>
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