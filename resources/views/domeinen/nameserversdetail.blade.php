@extends('layouts/app')

@section('title', 'Domeinnaam')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">domeinnaam: {{ $domain }}</h2>
          </div>
        </div>

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <a class="nameBackBtn" data-domain="{{$domain}}" href="/domein/{{$domain}}">Back knop</a>
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

    

    <div class="container px-4 mx-auto">

      <section class="py-8">
          <div class="container px-4 mx-auto">
          <form class="nameserverUpdate mt-6 px-6 pb-6 pt-4 bg-white shadow rounded" action="/domein/nameservers/update" method="post">
          @csrf
            
      
            <p class="text-xl my-6 text-center text-base">Nameservers</p>
      
            <div class="container px-4 mx-auto w-6/12">
            <div class="">
                
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" for="nameserver1">Nameserver 1</label>
                    <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="nameserver1" @if(!empty($nameservers[0]))value="{{$nameservers[0]}}" @endif>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" for="nameserver2">Nameserver 2</label>
                    <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="nameserver2" @if(!empty($nameservers[1]))value="{{$nameservers[1]}}" @endif>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2" for="nameserver3">Nameserver 3</label>
                    <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="nameserver3" @if(!empty($nameservers[2]))value="{{$nameservers[2]}}" @endif>
                </div>
                
                <input type="hidden" name="domein" value="{{$domain}}">
              </div>
            <div class="form__btn">
            <button class="nameserverUpdateBtn inline-block w-full md:w-auto px-4 py-3 font-medium text-sm text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Update</button>
            </div>
          </div>
          </form>
          </div>
      </section>
    </div>


      

        

        
        

@endsection