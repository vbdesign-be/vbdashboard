@extends('layouts/app')

@section('title', 'Profile')

@section('content')


<div class="">

    <x-menu />
        
        <div>
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Profiel van {{ $user->firstname }}</h2>
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

        
        <div class="container px-4 mx-auto bg-white p-6 relative rounded shadow">
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-2/3 px-4 mb-4 md:mb-0">
      <form enctype="multipart/form-data" class="flex flex-wrap -mx-4 -mb-4 md:mb-0" action="/user/updateAvatar" method="post">
      @csrf
        <div class="form__img w-full md:w-1/3 px-4 mb-4 md:mb-0"><img class="w-20 h-20 p-1 mb-4 mx-auto rounded-full border border-indigo-50" src="https://images.unsplash.com/photo-1597223557154-721c1cecc4b0?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=800&amp;q=80" alt=""></div>
        <div class="form__file w-full md:w-1/3 px-4 mb-4 md:mb-0"><input type="file"></div>
        <div class="form__file__btn w-full md:w-1/3 px-4 mb-4 md:mb-0"><button class="form__avatar__btn inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Submit</button></div>
        
        </form>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0"></div>
      </div>
      
      <div class="form__select__container container container px-4 mx-auto">
      <div class="px-4 mx-auto w-52">
        <label class="block text-sm font-medium mb-2" for="">Label for select</label>
        <div class="relative">
          <select class="appearance-none block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="field-name"><option value="profiel">Profiel</option><option value="company">Bedrijf</option></select><div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"></path></svg></div>
        </div>
      </div>
      </div>
      
      <form class="form--user" action="/user/update" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="familienaam">Familienaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="familienaam" value="{{ $user->lastname }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="voornaam">Voornaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="voornaam" value="{{ $user->firstname }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="email">Email</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="email" value="{{ $user->email }}">
      </div>
      </div>
      </div>
      
      
      <div class="form__btn">
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Aanpassen</button>
      </div>
        </form>

      <form class="form--company" action="" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="familienaam">Familienaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="familienaam" value="{{ $user->lastname }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="voornaam">Voornaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="voornaam" value="{{ $user->firstname }}">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="email">Email</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="email" value="{{ $user->email }}">
      </div>
      </div>
      </div>
      
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="">Label for text</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="" placeholder="Write a text">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="">Label for text</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="" placeholder="Write a text">
      </div>
      </div>
        <div class="w-full md:w-1/3 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="">Label for text</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="" placeholder="Write a text">
      </div>
      </div>
      </div>
      
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Submit</button>
      </form>

      </div>
    


@endsection