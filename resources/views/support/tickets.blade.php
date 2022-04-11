@extends('layouts/app')

@section('title', 'Support')

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
                <form class="search__form search__form--ticket flex gap-4" action="">
                  <input class="border search__input rounded" type="text" name="search">
                  <button class="rounded search__btn bg-blue-500 text-white" type="submit">Zoek</button>
                </form>
                <a class="addTicketBtn search__addBtn" href="">Ticket toevoegen</a>
              </div>
            </div>

          </div>
        </section>

        <section class="py-8 hidden form--addTicket">
          <div class="container px-4 mx-auto">
            <form enctype="multipart/form-data"  class="bg-white shadow rounded py-6 px-6" action="/support/ticket/add" method="post" >
            @csrf
            <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
              <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
            <div class="mb-6">
              <label class="block text-sm font-medium mb-2" for="onderwerp">Onderwerp</label>
              <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="onderwerp" value="{{ old('onderwerp') }}">
            </div>
            </div>
            <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
              <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="type">Type</label>
                <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="number" name="type" value="{{ old('type') }}">
                  
                  <option value="type">type</option>
                 
                </select>
              </div>
            </div>
            </div>
      
            <div class="mb-6">
              <label class="block text-sm font-medium mb-2" for="beschrijving">Beschrijving</label>
              <textarea class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="beschrijving" rows="5" value="{{ old('beschrijving') }}"></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="attachment">Attachment</label>
                <input name="attachment" type="file">
              </div>
      
            <div class="form__btn">
              <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Offerte aanvragen</button>
            </div>

          </form>
          </div>

        </section>

      
      
      

        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="flex flex-wrap -m-4">
            
            <a href="/support/ticket/1" class="ticket w-full md:w-1/2 lg:w-1/4 p-4">
                <div class="p-6 mb-4 bg-white rounded shadow">
                <div class="flex justify-between items-center mb-6">
                  <span class="inline-block py-1 px-2 bg-blue-50 text-xs text-blue-500 rounded-full ticket__status">status</span>
                </div>
                <div class="mb-4">
                  <h3 class="mb-2 font-medium ticket__title">Onderwerp</h3>
                </div>
                </div>
            </a>
            
          </div>
        </div>
      </section>

      @foreach($test as $t)
      <p>{{$t->test}}</p>
      @endforeach


        
        
        

@endsection