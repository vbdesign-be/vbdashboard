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
        <div class="form--avatar__group w-full md:w-1/2 px-8 mb-4 md:mb-0"></div>
        <div class="form--avatar__group form--avatar__group--left w-full md:w-1/2 px-4 mb-4 md:mb-0"><p>{{ $company->name }}</p></div>
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
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsnaam" value="{{ $company->name }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsemail">Bedrijfsemail</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsemail" value="{{ $company->email }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      <label class="block text-sm font-medium mb-2" for="btw-nummer">BTW-nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="btw-nummer" value="{{ $company->vat_number }}">
      </div>
      </div>
      </div>

      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="telefoon">Telefoon</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="telefoon" value="{{ $company->phone }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="website">Website</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="website" value="{{ $company->website }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="btw-plichtig">Btw-plichtig?</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="btw-plichtig" value="">
          <option value="yes">Ja</option>
          <option value="no">Nee</option>
        </select>
      </div>
      </div>
      </div>
      
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="straat">Straat + nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="straat" value="{{ $company->street }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="postcode">Postcode</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="postcode" value="{{ $company->postal }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="stad">Stad</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="stad" value="{{ $company->city }}">
      </div>
      </div>
      </div>

      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="sector">Sector</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="sector" value="">
          <option value="development">Development</option>
          <option value="design">Design</option>
        </select>
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsvorm">Bedrijfsvorm</label>
        <select class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsvorm" value="">
          @foreach($businessTypes as $businessType)
          <option value="{{ $businessType->id }}" @if($company->business_type->id === $businessType->id) selected @endif>{{ $businessType->name }}</option>
          @endforeach
        </select>
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <input type="hidden"  name="company_id" value="{{ $company->id }}">
      </div>
      </div>
      </div>


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