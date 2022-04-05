@extends('layouts/app')

@section('title', 'Shop')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Shop</h2>
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


        <div class="container px-4 mx-auto">
          <form class="px-6 pb-6 pt-4 bg-white shadow rounded" action="/shop/search" method="post">
          @csrf
            <h1 class="mb-2 text-4xl font-bold font-heading">Start met een gloednieuwe website</h1>
      
            <p class="mb-2 text-base">Bekijk of je domeinnaam nog beschikbaar is</p>
      
            <div class="container px-4 mx-auto w-80 flex items-center">
            <div class="">
              <input class="block w-full px-4 py-3  text-sm placeholder-gray-500 bg-white border rounded" type="text" name="domeinnaam" @if(!empty($domain)) value="{{$domain}}" @endif placeholder="voorbeeld.be">
            </div>
            <button class="inline-block w-full md:w-auto px-4 py-3 font-medium text-sm text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Submit</button>
          </div>
          </form>
        </div>

        @if(!empty($domain))
        <section class="py-8">
        <div class="container px-4 mx-auto">
          
          <div class="p-6 bg-white rounded shadow">
            <div class="flex justify-between items-center">
            <h3 class="font-medium">{{$domain}}</h3>
            <span class="inline-block py-1 px-2 bg-{{ $checkColor }}-50 text-xs text-{{ $checkColor }}-500 rounded-full">{{ $check }}</span>
            <div>
            @if($check === "Beschikbaar")<form method="post" action="/shop/winkelmandje">@csrf <input type="hidden" name="domain" value="{{ $domain }}"> <button type="submit" >Koop btn</button>  </form>@endif
            @if($check === "Niet beschikbaar")<form method="post" action="/shop/transfer">@csrf <input type="hidden" name="domain" value="{{ $domain }}"> <button type="submit" >verhuis btn</button>  </form>@endif
            
            </div>
            
            </div>
          </div>
         
        </div>
      </section>
      @endif


        
        

@endsection