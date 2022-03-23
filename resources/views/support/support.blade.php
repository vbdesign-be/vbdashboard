@extends('layouts/app')

@section('title', 'Support')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Support</h2>
          </div>
        </div>


        <section class="py-8">
          <div class="container px-4 mx-auto">

          <div class="mb-8 p-8 bg-indigo-500 rounded">
            <div class="flex flex-wrap items-center -mx-4">
              <div class="w-full lg:w-2/3 px-4">
                <h2 class="text-3xl text-white font-bold">Heb je hulp nodig?</h2>
                <p class="text-indigo-50">Hieronder helpen we je graag verder</p>
              </div>
              <div class="w-full lg:w-1/3 px-4 flex items-center">
                <img src="artemis-assets/images/office.png" alt=""></div>
            </div>
          </div>

          <div class="mb-8 flex flex-wrap items-center justify-center  gap-6">
            <a href="/support/faq" class="titlecard w-5/12 rounded bg-white py-8 px-12 shadow">
              <h1 class="text-center font-bold text-3xl">Faq</h1>
              <p class="text-center mx-auto w-8/12 my-8 text-base">Hier vind je de meest gestelde vragen door onze klanten.</p>
              <img src="" alt="logo faqs">
            </a>

            <a href="support/tickets" class="titlecard w-5/12 rounded bg-white py-8 px-12 shadow">
              <h1 class="text-center font-bold text-3xl">Tickets</h1>
              <p class="text-center mx-auto w-8/12 my-8 text-base">Hier kan je ons een vraag stellen en je vragen opvolgen.</p>
              <img src="" alt="logo faqs">
            </a>
            
            
          </div>

          
        </div>
      </section>
        
        

@endsection