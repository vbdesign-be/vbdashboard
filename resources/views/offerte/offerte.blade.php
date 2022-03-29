@extends('layouts/app')

@section('title', 'Offertes')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>


          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Offertes</h2>
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
                <h3 class="text-xl font-bold">Recente offertes</h3>
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
                @for($x = 0; $x < count($offertes); $x++)
                @foreach($offertes[$x] as $f)
                    <tr class="table__item text-xs bg-gray-50">
                      <td class="flex items-center py-4 px-6 font-medium">
                        <p>{{ $f->title }}</p>
                      </td>
                      <td class="font-medium">{{ $f->reference }}</td>
                      <td class="font-medium">{{ '€'.$f->estimated_value->amount }}</td>
                      <td>
                        @if($f->status === "lost")
                          @component('components/status')
                            @slot('color') red @endslot
                              {{$f->status}}
                          @endcomponent
                        @endif
                        @if($f->status === "won")
                          @component('components/status')
                            @slot('color') green @endslot
                              {{$f->status}}
                          @endcomponent
                        @endif
                        @if($f->status === "open")
                          @component('components/status')
                            @slot('color') orange @endslot
                              {{$f->status}}
                          @endcomponent
                        @endif
                      </td>
                      <td><a class="btn--download" target="_blank" href="/getDeal/{{ $f->id }}">download icon</a></td>
                    </tr>
                @endforeach
                @endfor
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>


      @if($errors->any())
            @component('components/notification')
            @slot('type') red @endslot
            @slot('size') notification-mini   @endslot
            @slot('textcolor') red @endslot
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endcomponent
        @endif

        


      <div class="form--offerte__container container px-4 mx-auto">
      <h1 class="mb-2 text-4xl font-bold font-heading form__title">Vraag hier je offerte aan</h1>
      
      <form id="offerteAanvragen" class="bg-white shadow rounded py-6 px-6" action="/offerte/post" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
      <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="titel">Titel offerte</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="titel" value="{{ old('titel') }}">
      </div>
      </div>
      <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijf">Bedrijf</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijf">
          @foreach($comps as $comp)
          <option value="{{$comp->data->name}}">{{$comp->data->name}}</option>
          @endforeach
        <select>
      </div>
      </div>
      </div>
      
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="deadline">Gewenste deadline</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="date" name="deadline" value="{{ old('deadline') }}">
      </div>
      </div>
      <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="kostprijs">Maximale kostprijs</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="number" name="kostprijs" value="{{ old('kostprijs') }}">
      </div>
      </div>
      </div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="samenvatting">Samenvatting</label>
        <textarea class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="samenvatting" rows="5" value="{{ old('samenvatting') }}"></textarea>
      </div>

      <input class="hidden" type="text" name="company" value="">
      
      <div class="form__btn">
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Offerte aanvragen</button>
      </div>

      </form>
      </div>
        

@endsection