@extends('layouts/app')

@section('title', 'DNS')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">DNS</h2>
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
              <h3 class="text-xl font-bold">DNS management for {{$domain}}</h3>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left"><th class="px-6 pb-3 font-medium">Type</th><th class="pb-3 font-medium">Name</th><th class="pb-3 font-medium">Content</th><th class="pb-3 font-medium">TTL</th></tr>
                </thead>
                <tbody>
                  
                  <tr class="table__item text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">test</td>

                    <td class="font-medium ">
                      test
                    </td>
                    
                    <td>
                        test
                    </td>
                    <td>900</td>
                    <td>bewerk knopje</td>
                  </tr>
                 
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </section>
      </div>

        

        
        

@endsection