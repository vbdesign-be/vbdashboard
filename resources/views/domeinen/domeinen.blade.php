@extends('layouts/app')

@section('title', 'Domeinnamen')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        <div wire:loading>Loading...</div>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Domeinnamen</h2>
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
      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-4 bg-white shadow rounded">
            <div class="flex px-6 pb-4 border-b">
              <h3 class="text-xl font-bold">Mijn domeinnamen</h3>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left"><th class="pb-3 font-medium">Domeinnaam</th><th class="pb-3 font-medium">E-mailbox</th><th class="pb-3 font-medium">Status</th><th style="visibility:hidden">bewerk knopjes </th></tr>
                </thead>
                <tbody>
                  @if(!empty($orders))
                  @foreach($orders as $order)
                  <tr class="table__item text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">{{ $order->domain }}</td>

                    <td class="font-medium">
                      <ul class="mt-2 ">
                      @foreach($order->emailorder as $email)
                      <li class="mb-2">{{$email->email}}</li>
                      @endforeach
                      </ul>
                      
                    </td>
                    
                    <td>
                    @if($order->status === "failed")
                          @component('components/domainstatus')
                            @slot('color') red @endslot
                              {{$order->status}}
                          @endcomponent
                        @endif
                        @if($order->status === "active")
                          @component('components/domainstatus')
                            @slot('color') green @endslot
                              {{$order->status}}
                          @endcomponent
                        @endif
                        @if($order->status === "pending")
                          @component('components/domainstatus')
                            @slot('color') orange @endslot
                              {{$order->status}}
                          @endcomponent
                        @endif
                    </td>
                    <td>@if($order->status !== "ordered")<a data-domain="{{$order->domain}}" class="domainDetailBtn" href="domein/{{$order->domain}}">bewerk knopje</a>@else<div></div>@endif</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </section>
      
      </div>

      

        
        

@endsection