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
            <a href="/domein">Back knop</a>
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
        <div class="pt-4 bg-white shadow rounded">
          <div class="flex px-6 pb-4 border-b">
            <h3 class="text-xl font-bold">Informatie {{$domain}}</h3>
          </div>
          <div class="px-6 py-4 overflow-x-auto">
            <p>Eindigd op: {{ $expiration_date }}</p>
          </div>
          <div class="px-6 py-4 overflow-x-auto grid grid-cols-12 items-center">
            <div class="col-span-4">
              <p class="text-lg mb-2">Actieve nameservers</p>
              @foreach($nameservers as $n)
              <p>{{ $n }}</p>
              @endforeach
            </div>
            <div class="col-span-2">
              <a href="/domein/{{$domain}}/nameservers">Beheer nameservers</a>
            </div>
          </div>
          <div class="px-6 py-4 overflow-x-auto grid grid-cols-12 items-center">
            <div class="col-span-4">
              <p class="text-lg mb-2">Emailboxen</p>
              <p>actieve emailboxen: {{$numberEmails}}</p>
            </div>
            <div class="col-span-2">
              <a href="/domein/{{$domain}}/email">Beheer emailboxen</a>
            </div>
          </div>
          <div class="px-6 py-4 overflow-x-auto grid grid-cols-12 items-center">
            <div class="col-span-4">
              <p class="text-lg mb-2">DNS records</p>
              <p>actieve DNS records: {{ $numberDNS }}</p>
            </div>
            <div class="col-span-2">
              <a href="/domein/{{$domain}}/dns">Beheer DNS records</a>
            </div>
          </div>
        </div>
      </div>
      </section>

      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="py-4 bg-white shadow rounded">
            <div class="w-6/12 mx-auto flex justify-center">
              <a class="deleteDomainBtn bg-red-500 rounded p-2 text-white" href="">Verwijder {{$domain}}</a>
            </div>
          </div>
        </div>
      </section>

      <div class="modal modal--deleteDomain hidden">
        <span class="close" title="Close"></span>
        <form class="modal-content" action="/domein/delete" method="POST">
        @csrf
            <div class="container--modal">
                <h1>Delete {{$domain}}</h1>
            <div class="clearfix">
                <button type="button"  class="cancelbtn cancelDomainbtn">Cancel</button>
                <input type="hidden" value="{{$domain}}" name="domain">
                <button type="submit"  class="deletebtn" >Delete</button>
            </div>
            </div>
        </form>
    </div>

    </div>


      

        

        
        

@endsection