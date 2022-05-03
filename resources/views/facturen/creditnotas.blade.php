@extends('layouts/app')

@section('title', 'Creditnotas')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>


          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Creditnotas</h2>
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

        
        

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <div class="search">
                <form class="search__form search__form--factuur flex gap-4" action="">
                  <input class="border search__input rounded" type="text" name="search">
                  <button class="rounded search__btn bg-blue-500 text-white" type="submit">Zoek</button>
                </form>
              </div>
            </div>
          </div>
        </section>
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="grid grid-cols-2 items-center mb-6">
                <h3 class="text-xl font-bold">Overzicht Creditnotas</h3>
                <a class="justify-self-end" href="/facturen">Bekijk facturen</a>
              </div>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left">
                    <th class="flex items-center pl-6 py-4 font-medium">
                      <input class="mr-3 invisible" type="checkbox" name="" id="">
                      <a class="flex items-center" href="#">
                        <span>Nr.</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>title</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Bedrag</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Datum</span>
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Status</span>
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody>
                @if(!empty($creditnotas))
                @foreach($creditnotas as $credit)
                  @if(!empty($credit['note']->data))
                    <tr class="table__item facturen text-xs bg-gray-50">
                      <td class="flex items-center factuur__number py-4 px-6 font-medium">
                        <p>{{$credit['note']->data[0]->credit_note_number}}</p>
                      </td>
                      <td class="font-medium factuur__name">{{$credit['title']}}</td>
                      <td class="font-medium factuur__amount">€{{$credit['note']->data[0]->total->payable->amount}}</td>
                      <td class="font-medium factuur__date">{{ date('d/m/Y', strtotime($credit['note']->data[0]->credit_note_date))}}</td>
                      <td class="font-medium factuur__status">
                         {{$credit['note']->data[0]->status}}
                      </td>
                      <td><a class="btn--download" target="_blank" href="/creditnota/download/{{$credit['note']->data[0]->id}}">download icon</a></td>
                    </tr>
                  @endif
                @endforeach
                @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </section>
        

@endsection