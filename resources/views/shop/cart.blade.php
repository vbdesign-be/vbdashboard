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
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Monthly</td>
                    <td>
                      
                    </td>
                  </tr>
                  <tr class="text-xs">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Monthly</td>
                    <td>
                      
                    </td>
                  </tr>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Lifetime</td>
                    <td>
                      
                    </td>
                  </tr>
                  <tr class="text-xs">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Yearly</td>
                    <td>
                      
                    </td>
                  </tr>
                  <tr class="text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">SR2451EW32</td>
                    <td class="font-medium">08.04.2021</td>
                    <td class="font-medium">name@shuffle.dev</td>
                    <td class="font-medium">Monthly</td>
                    <td>
                      
                    </td>
                  </tr>
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </section>
        

        


        
        

@endsection