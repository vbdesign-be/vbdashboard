@extends('layouts/app')

@section('title', 'Support')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Tickets</h2>
          </div>
        </div>

        <div class="px-4 mx-auto">
        <h1 class="mb-2 text-4xl font-bold font-heading form__title">titel</h1>
      
      <form id="" class="bg-white shadow rounded py-6 px-6" action="" method="post">
      @csrf
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="titel">Titel</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="titel" value="{{ old('titel') }}">
      </div>
      </div>
        <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="kostprijs">Maximale kostprijs</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="number" name="kostprijs" value="{{ old('kostprijs') }}">
      </div>
      </div>
      </div>
      
      <div class="flex flex-wrap -mx-4 -mb-4 md:mb-0">
        <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="deadline">Gewenste deadline</label>
        <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="date" name="deadline" value="{{ old('deadline') }}">
      </div>
      </div>
        <div class="w-full md:w-1/2 px-4 mb-4 md:mb-0">
      
      </div>
      </div>
      
      <div class="mb-6">
        <label class="block text-sm font-medium mb-2" for="samenvatting">Samenvatting</label>
        <textarea class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="samenvatting" rows="5" value="{{ old('samenvatting') }}"></textarea>
      </div>

      <input class="hidden" type="text" name="company" value="">
      
      <div class="form__btn">
      <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Offerte aanvragen</button>
      </div>

      </form>
      </div>

        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="flex flex-wrap -m-4">
            <a href="#" class="w-full md:w-1/2 lg:w-1/4 p-4">
                <div class="p-6 mb-4 bg-white rounded shadow">
                <div class="flex justify-between items-center mb-6">
                  <span class="inline-block py-1 px-2 bg-blue-50 text-xs text-blue-500 rounded-full">Status</span>
                </div>
                <div class="mb-4">
                  <h3 class="mb-2 font-medium">Ticket title</h3>
                  <p class="text-sm text-gray-500">eerste paar woorden van ticket</p>
                </div>
                </div>
            </a>
          </div>
        </div>
      </section>


        
        
        

@endsection