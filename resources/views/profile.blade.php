@extends('layouts/app')

@section('title', 'Profile')

@section('content')


<div class="">

    <x-menu />
        
        <div>
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Profiel van {{ $user->first_name ." ". $user->last_name }}</h2>
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
        <div class="form--avatar__group w-full md:w-1/2 px-8 mb-4 md:mb-0"><div><img class=" w-32 h-32 p-1 mb-4 mx-auto rounded-full border border-indigo-50" src="img/{{ $avatar }}" alt="avatar"></div></div>
        <div class="form--avatar__group form--avatar__group--left w-full md:w-1/2 px-4 mb-4 md:mb-0"><p>{{ $user->first_name ." ". $user->last_name }}</p></div>
        <div class="form--avatar__group w-full md:w-1/2 px-8 mb-4 md:mb-0"><label class="btn--mini  custom-file-upload"><input name="avatar" type="file"/>Afbeelding kiezen</label></div>
        <div class="form--avatar__group form--avatar__group--left w-full md:w-1/2 px-4 mb-4 md:mb-0"><button class="btn--mini form__avatar__btn inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Update avatar</button></div>
      </form>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0"></div>
      </div>
      
      
      
      <form class="form--user" action="/user/update" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="familienaam">Familienaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="familienaam" value="{{ $user->last_name }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="voornaam">Voornaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="voornaam" value="{{ $user->first_name }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="email">Email</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="email" value="{{ $email }}">
      </div>
      </div>
      </div>
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="telefoon">Telefoon</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="telefoon" value="{{ $phone }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="gsm">Gsm</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="gsm" value="{{ $mobile }}">
      </div>
      </div>
      </div>
      
      
      <div class="form__btn">
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Aanpassen</button>
      </div>
        </form>

      
        

      </div>

      <div class="container--companies container px-4 mx-auto p-6 relative">
        <h2 class="text-2xl font-bold">Bedrijven van {{ $user->first_name }}</h2>
      </div>  


      <div class="container px-4 mx-auto bg-white p-6 relative rounded shadow">
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        @foreach($companies as $company)
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0"><a href="/company/{{$company->id}}">{{ $company->name }}</a></div>
        @endforeach
      </div>
      </div>


      <!-- <form class="form--company" action="/company/update" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsnaam">Bedrijfsnaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsnaam" >
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsemail">Bedrijfsemail</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsemail" value="">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      <label class="block text-sm font-medium mb-2" for="btw-nummer">BTW-nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="btw-nummer" value="">
      </div>
      </div>
      </div>
      
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      <label class="block text-sm font-medium mb-2" for="telefoon">Telefoon</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="telefoon" value="">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="straat">Straat + nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="straat" value="">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="postcode">postcode</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="postcode" value="">
      </div>
      </div>
      </div>

      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="plaats">Plaats</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="plaats" value="">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      <label class="block text-sm font-medium mb-2" for="sector">Sector</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="sector" value="">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
      </div>
      </div>
      </div>

      <div class="form__btn">
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Aanpassen</button>
      </div>
      
      </form> -->
    


@endsection