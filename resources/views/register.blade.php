
  @extends('layouts/app')

@section('title', 'Aanmelden')

@section('content')
  
    <div class="">
        
      

@if($errors->any())
    @component('components/notification')
        @slot('type') red @endslot
        @slot('mini') r @endslot
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endcomponent
@endif
        
      <form action="/user/register" method="post" class="form--mini shadow-md">
        @csrf
      <h1 class="mb-2 text-5xl font-bold font-heading form__title">Registreer je account</h1>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="familienaam">Familienaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="familienaam" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="voornaam">Voornaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="voornaam" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="email">Email</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="email" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="bedrijfsnaam">Bedrijfsnaam</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="bedrijfsnaam" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="btwnummer">Btw-nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="btwnummer" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="gsm">Gsm-nummer</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="gsm" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="telefoon">Telefoon</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="telefoon" placeholder="Write a text"></div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="adres">adres</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="adres" placeholder="Write a text"></div>
    
    <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="stad">Stad</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="stad" placeholder="Write a text"></div>
      
        <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="">Sector</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="sector" placeholder="Write a text"></div>
      
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Aanmelden</button>
      </form>
    </div>
    
@endsection
    

    <!-- <div class="form__container">

        <h1 class="form__title">Vul je informatie verder aan</h1>

        <form action="{{ url('user/register') }}" method="post" class="form form--big">
        @csrf

        <div class="form__column form__column--left">
            <div class="input-group">
                <label class="label" for="lastname">Familienaam</label>
                <input class="input" type="text" name="familienaam" value="{{ old('familienaam') }}">
            </div>

            <div class="input-group">
                <label class="label" for="firstname">Voornaam</label>
                <input class="input" type="text" name="voornaam" value="{{ old('voornaam') }}">
            </div>

            <div class="input-group">
                <label class="label" for="email">Email</label>
                <input class="input" type="text" name="email" value="{{ old('email') }} ">
            </div>

            <div class="input-group">
                <label class="label" for="btw">Btw-nummer</label>
                <input class="input" type="text" name="btwnummer" value="{{ old('btwnummer') }} ">
            </div>
        </div>

        <div class="form__column form__column--right">
            <div class="input-group">
                <label class="label" for="gsm">Gsm</label>
                <input class="input" type="text" name="gsm" value="{{ old('gsm') }} ">
            </div>

            <div class="input-group">
                <label class="label" for="phone">Telefoon</label>
                <input class="input" type="text" name="telefoon" value="{{ old('telefoon') }} ">
            </div>

            <div class="input-group">
                <label class="label" for="city">Stad</label>
                <input class="input" type="text" name="stad" value="{{ old('stad') }} ">
            </div>

            <div class="input-group">
                <label class="label" for="sector">Sector</label>
                <input class="input" type="text" name="sector" value="{{ old('sector') }} ">
            </div>

        </div>

        <div class="form__btn" >
            <input class="btn" type="submit"  value="Registreer">
        </div>

        </form>
         
    </div> -->

