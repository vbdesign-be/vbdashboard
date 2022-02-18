@extends('layouts/app')

@section('title', 'Waiting for login')

@section('content')

@if($errors->any())
    @component('components/notification')
        @slot('type') danger @endslot
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endcomponent
@endif

@if($flash = session('error'))
@component('components/notification')
        @slot('type') danger @endslot
        <ul>
            <li>{{ $flash }}</li>
        </ul>
    @endcomponent
@endif

@if($flash = session('message'))
@component('components/notification')
        @slot('type') normal @endslot
        <ul>
            <li>{{ $flash }}</li>
        </ul>
    @endcomponent
@endif


<div class="notification notification--normal">
    <h1 class="notification__header" >Hallo {{ $user->firstname }}</h1>
    <p class="notification__text">Klik op de link die we hebben gestuurd op {{ $user->email }} </p>
</div>



@endsection