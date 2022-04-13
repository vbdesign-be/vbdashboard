@extends('layouts/app')

@section('title', 'Facturen')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>


          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Facturen</h2>
          </div>
        </div>

        
        

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
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Overzicht Facturen</h3>
              </div>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left">
                    <th class="flex items-center pl-6 py-4 font-medium">
                      <input class="mr-3 invisible" type="checkbox" name="" id="">
                      <a class="flex items-center" href="#">
                        <span>Titel</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Reference nr.</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Waarde</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Status</span>
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Bekijken</span>
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody>
               
                    <tr class="table__item text-xs bg-gray-50">
                      <td class="flex items-center py-4 px-6 font-medium">
                        <p>title</p>
                      </td>
                      <td class="font-medium">referencie</td>
                      <td class="font-medium">centjes</td>
                      <td>
                        status
                      </td>
                      <td><a class="btn--download" target="_blank" href="">download icon</a></td>
                    </tr>
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </section>
        

@endsection