@extends('layouts/app')

@section('title', 'Frequently asked questions')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Frequently asked questions</h2>
          </div>
        </div>


        <section class="py-8">
          <div class="container px-4 mx-auto">

          <h1 class="mb-8 font-bold text-3xl">Hieronder vind je een lijst met de meest gestelde vragen</h1>

          <ul class="mb-8">
            
            @foreach($faqs as $f)
              <li id="faq-item" class="py-6 px-6 mb-3 bg-white shadow rounded">
                  <button id="btn" class="w-full flex justify-between items-center">
                    <h3 class="text-base font-bold">{{ $f->question }}</h3>
                    <span>
                      <svg width="10" height="6" viewbox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.08317 0.666657C8.74984 0.333323 8.24984 0.333323 7.91651 0.666657L4.99984 3.58332L2.08317 0.666657C1.74984 0.333323 1.24984 0.333323 0.916504 0.666657C0.583171 0.99999 0.583171 1.49999 0.916504 1.83332L4.41651 5.33332C4.58317 5.49999 4.74984 5.58332 4.99984 5.58332C5.24984 5.58332 5.4165 5.49999 5.58317 5.33332L9.08317 1.83332C9.41651 1.49999 9.41651 0.99999 9.08317 0.666657Z" fill="#8594A5"></path></svg></span>
                  </button>
                  <p id="answer" class="hidden mt-3 pr-6 text-sm text-gray-500">{{ $f->answer }}</p>
                  </li>
                  @endforeach
            
            </ul>
        </div>
      </section>
        
        

@endsection