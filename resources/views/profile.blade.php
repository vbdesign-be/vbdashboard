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
        
        <form action="/user/register" method="post" class="form--mini shadow-md">
        @csrf
      
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="familienaam">Familienaam</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="familienaam" value="{{ $user->lastname }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="voornaam">Voornaam</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="voornaam" value="{{ $user->firstname }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="email">Email</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="email" value="{{ $user->email }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="bedrijfsnaam">Bedrijfsnaam</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsnaam" value="{{ $user->company }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="btwnummer">Btw-nummer</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="btwnummer" value="{{ $user->btw }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="gsm">Gsm-nummer</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="gsm" value="{{ $user->gsm }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="telefoon">Telefoon</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="telefoon" value="{{ $user->phone }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="adres">adres</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="adres" value="{{ $user->adress }}"></div>
            
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="stad">Stad</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="stad" value="{{ $user->city }}"></div>
            
                <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="">Sector</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="sector" value="{{ $user->sector }}"></div>
            
            <div class="form__btn">
            <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Opslaan</button>
            </div>
      
      </form>

        

            

        
        </div>
        </div>
      </div>
    


@endsection