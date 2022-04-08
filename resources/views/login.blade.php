@extends('layouts/app')

@section('title', 'Login')

@section('content')




<div class="">

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

        
      <form action="/user/login" method="post" class="form--mini shadow-md">
      @csrf
      <h1 class="mb-2 text-5xl font-bold font-heading form__title">Login</h1>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="email">Test</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="email" placeholder="Write a text" value="{{ old('email') }}"></div>
      
    <div class="form__btn">
        <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Login</button>
    </div>
      
      </form>
</div>



@endsection