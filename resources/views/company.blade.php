@extends('layouts/app')

@section('title', 'Company')

@section('content')




<div class="">

    <x-menu />
        
        <div>
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Profiel van {{ $company->name }}</h2>
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

        
        <div class="container px-4 mx-auto bg-white p-6 relative rounded shadow">


      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-2/3 px-4 mb-4 md:mb-0">
      <form enctype="multipart/form-data" class="form--avatar flex flex-wrap -mx-4 -mb-4 md:mb-0" action="/user/updateAvatar" method="post">
      @csrf
        <div class="form--avatar__group w-full md:w-1/2 px-8 mb-4 md:mb-0"><p>{{ $company->name }}</p></div>
        <div class="form--avatar__group form--avatar__group--left w-full md:w-1/2 px-4 mb-4 md:mb-0"><p></p></div>
        <div class="form--avatar__group w-full md:w-1/2 px-8 mb-4 md:mb-0"></div>
        <div class="form--avatar__group form--avatar__group--left w-full md:w-1/2 px-4 mb-4 md:mb-0"></div>
      </form>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0"></div>
      </div>
      
      
      
      <form class="" action="/company/update" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsnaam">Bedrijfsnaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsnaam" value="@if(!empty($company->name)) {{$company->name}} @endif">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsemail">Bedrijfsemail</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsemail" value="@if(!empty($company->email)) {{$company->email}} @endif">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      <label class="block text-sm font-medium mb-2" for="btw-nummer">BTW-nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="btw-nummer" value="@if(!empty($company->vat_number)) {{$company->vat_number}} @endif">
      </div>
      </div>
      </div>

      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="telefoon">Telefoon</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="telefoon" value="@if(!empty($company->phone)) {{$company->phone}} @endif">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="website">Website</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="website" value="@if(!empty($company->website)) {{$company->website}} @endif">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsvorm">Bedrijfsvorm</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsvorm" value="">
          @if(!empty($company->business_type))
            @foreach($businessTypes as $businessType)
              <option value="{{ $businessType->id }}" @if( $company->business_type->id === $businessType->id) selected @endif>{{ $businessType->name }}</option>
            @endforeach
          @else
          <option value="" >Kies bedrijfsvorm</option>
          @foreach($businessTypes as $businessType)
              <option value="{{ $businessType->id }}">{{ $businessType->name }}</option>
          @endforeach
          @endif
        </select>
      </div>
      </div>
      </div>
      
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="straat">Straat + nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="straat" value="@if(!empty($company->street)) {{$company->street}} @endif">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="postcode">Postcode</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="postcode" value="@if(!empty($company->postal)) {{$company->postal}} @endif">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="stad">Stad</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="stad" value="@if(!empty($company->city)) {{$company->city}} @endif">
      </div>
      </div>
      </div>

      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="provincie">Provincie</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="provincie" value="">
          @if(!empty($provines))
            @foreach($provinces as $p)
              <option value="{{ $p->id }}" @if($p->id && $p->id === $company->province) selected @endif  >{{$p->name}}</option>
            @endforeach
          @else
            <option value="">Kies provincie</option>
            @foreach($provinces as $p)
              <option value="{{ $p->id }}">{{$p->name}}</option>
            @endforeach
          @endif
        </select>
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      <label class="block text-sm font-medium mb-2" for="land">Land</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="land" value="">
          <option value="BE" selected>België</option>
        </select>
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        
      </div>
      </div>
      </div>

      <input type="hidden"  name="company_id" value="{{ $company->id }}">

      <div class="form__btn">
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Aanpassen</button>
      </div>
      
      </form>

      
        

      </div>

      <div class="container--companies container px-4 mx-auto p-6 relative">
        <h2 class="text-2xl font-bold">Contactpersonen van {{ $company->name }}</h2>
      </div>  


      <div class="container px-4 mx-auto bg-white p-6 relative rounded shadow">
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        @foreach($company->users as $u)
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0"><a class="btn btn--company shadow" @if($u->id === $user->teamleader_id) href="/profiel" @endif >{{ $u->first_name .' '. $u->last_name }}</a></div> 
       @endforeach
      </div>
      </div>


      
    


@endsection