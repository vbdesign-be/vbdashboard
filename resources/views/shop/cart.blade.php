@extends('layouts/app')

@section('title', 'Winkelmandje')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Winkelmandje</h2>
          </div>
        </div>

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <a href="/domein/toevoegen">Back knop</a>
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

        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-4 bg-white shadow rounded">
            <div class="flex px-6 pb-4 border-b">
              <h3 class="text-xl font-bold">Winkelmandje</h3>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left"><th class="pb-3 font-medium px-6">Product</th><th class="pb-3 font-medium">Looptijd</th><th class="pb-3 font-medium">prijs</th><th class="pb-3 font-medium">Totaal</th></tr>
                </thead>
                <tbody>
                <form class="domainForm" method="post" action="/domein/koop/domein">
                @csrf
                  <tr id="winkelmandje" class="table__item text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium"><div>{{ $domain }}<input class="domein" name="domein" type="hidden" value="{{$domain}}"></div></td>
                    <td class="font-medium">1 jaar</td>
                    <td class="font-medium">1 x €{{$price}}</td>
                    <td class="font-medium">€{{$price}}</td>
                    <td><a class="delete" href="">verwijder btn</a></td>
                  </tr>
                </tbody>
              </table>
              <input type="hidden" name="prijs" value="{{$price}}">
              <div class="form__btn">
                <button class="inline-block w-full md:w-auto px-4 py-3 font-medium text-sm text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">koop</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </section>
        

        


        
        

@endsection