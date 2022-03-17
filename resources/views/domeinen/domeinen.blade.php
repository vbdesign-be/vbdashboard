@extends('layouts/app')

@section('title', 'Domeinnamen')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
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
                  <tr class="text-xs text-gray-500 text-left"><th class="pb-3 font-medium">Domeinnaam</th><th class="pb-3 font-medium">E-mailbox</th><th class="pb-3 font-medium">Status</th></tr>
                </thead>
                <tbody>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    
                    
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">Completed</span>
                    </td>
                  </tr>
                  <tr class="text-xs">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    
                    
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-red-500 rounded-full">Canceled</span>
                    </td>
                  </tr>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    
                    
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-orange-500 rounded-full">Pending</span>
                    </td>
                  </tr>
                  <tr class="text-xs">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    
                    
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">Completed</span>
                    </td>
                  </tr>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    
                    
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">Completed</span>
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </section>
      </div>

        

        
        

@endsection