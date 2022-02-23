@extends('layouts/app')

@section('title', 'Dashboard')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Projecten</h2>
          </div>
        </div>


        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="relative py-24 px-16 text-center rounded overflow-hidden bg-cover bg-center" style="background-image: url('artemis-assets/images/saly.png');">
            <div class="absolute inset-0 bg-purple-500 bg-opacity-90"></div>
            <div class="relative">
              <h3 class="mb-2 text-4xl font-medium text-red-300">
                <span class="text-white">Heb je een</span>
                <span> nieuw project </span>
                <span class="text-white">voor ons?</span>
              </h3>
              <p class="mb-4 text-sm text-blue-100">Vraag vrijblijvend een offerte aan!</p>
              <a class="inline-flex items-center py-2 px-3 rounded text-xs text-white bg-red-500 hover:bg-red-600 rounded" href="/offerte#offerteAanvragen">
                <span>Offerte aanvragen</span>
              </a>
            </div>
          </div>
        </div>
      </section>
        
        

@endsection