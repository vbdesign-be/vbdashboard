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

        <!-- projecten -->

        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="flex flex-wrap -m-4">

          @foreach($projects as $project)
            <div class="project w-full md:w-1/2 lg:w-1/4 p-4">
              <div class="p-6 bg-white rounded">
                <div class="flex items-center mb-6">
                  <span class="project__icon__container flex-shrink-0 inline-flex justify-center items-center mr-3 w-10 h-10 rounded-full">
                    <svg width="18" height="16" viewbox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M14.8335 2.58333H9.60014L9.33348 1.75C9.1606 1.26102 8.83993 0.837918 8.41589 0.539299C7.99185 0.24068 7.48544 0.0813322 6.96681 0.0833316H3.16681C2.50377 0.0833316 1.86788 0.346724 1.39904 0.815565C0.930201 1.28441 0.666809 1.92029 0.666809 2.58333V13.4167C0.666809 14.0797 0.930201 14.7156 1.39904 15.1844C1.86788 15.6533 2.50377 15.9167 3.16681 15.9167H14.8335C15.4965 15.9167 16.1324 15.6533 16.6012 15.1844C17.0701 14.7156 17.3335 14.0797 17.3335 13.4167V5.08333C17.3335 4.42029 17.0701 3.78441 16.6012 3.31557C16.1324 2.84672 15.4965 2.58333 14.8335 2.58333ZM15.6668 13.4167C15.6668 13.6377 15.579 13.8496 15.4227 14.0059C15.2665 14.1622 15.0545 14.25 14.8335 14.25H3.16681C2.9458 14.25 2.73383 14.1622 2.57755 14.0059C2.42127 13.8496 2.33348 13.6377 2.33348 13.4167V2.58333C2.33348 2.36232 2.42127 2.15036 2.57755 1.99408C2.73383 1.8378 2.9458 1.75 3.16681 1.75H6.96681C7.14151 1.74955 7.31194 1.80401 7.454 1.9057C7.59606 2.00739 7.70257 2.15115 7.75848 2.31667L8.20848 3.68333C8.26438 3.84885 8.37089 3.99261 8.51295 4.0943C8.65501 4.19598 8.82544 4.25045 9.00014 4.25H14.8335C15.0545 4.25 15.2665 4.3378 15.4227 4.49408C15.579 4.65036 15.6668 4.86232 15.6668 5.08333V13.4167Z" fill="#E6D4F8"></path>
                    </svg>
                  </span>
                  <div>
                    <p class="text-xs font-bold">{{ $project->name }}</p>
                  </div>
                </div>
                <div>
          
                  
                  <div class="flex items-center justify-between mb-10">
                  </div>
                  <div class="relative w-full h-1 mb-3 rounded-full bg-gray-50">
                    @if($project->status->orderindex === 0)
                    <div style="background-color:{{$project->status->color}}" class="absolute top-0 left-0 h-full w-0/4 rounded-full"></div>
                    @elseif($project->status->orderindex === 1)
                    <div style="background-color:{{$project->status->color}}" class="absolute top-0 left-0 h-full w-1/4 rounded-full"></div>
                    @elseif($project->status->orderindex === 2)
                    <div style="background-color:{{$project->status->color}}" class="absolute top-0 left-0 h-full w-1/2 rounded-full"></div>
                    @elseif($project->status->orderindex === 3)
                    <div style="background-color:{{$project->status->color}}" class="absolute top-0 left-0 h-full w-3/4 rounded-full"></div>
                    @elseif($project->status->orderindex === 4 || $project->status->orderindex === 5)
                    <div style="background-color:{{$project->status->color}}" class="absolute top-0 left-0 h-full w-full rounded-full"></div>
                    @endif
                  </div>
                  <div class="flex items-center">
                    <span style="background-color:{{$project->status->color}}" class="inline-block py-1 px-2 mr-2 rounded-full text-xs text-black-500">{{ $project->status->status }}</span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
          </div>
        </div>
      </section>


      <!-- banner offerte -->
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="relative py-12 px-16 text-center rounded overflow-hidden bg-cover bg-center" style="background-color:black;">
            <div class="absolute inset-0 bg-purple-500 bg-opacity-90"></div>
            <div class="relative">
              <h3 class="mb-2 text-4xl font-medium text-indigo-300">
                <span class="text-white">Heb je een</span>
                <span> nieuw project </span>
                <span class="text-white">voor ons?</span>
              </h3>
              <p class="mb-4 text-sm text-blue-100">Vraag vrijblijvend een offerte aan!</p>
              <a class="inline-flex items-center py-2 px-3 rounded text-xs text-white bg-indigo-500 hover:bg-indigo-600 rounded" href="/offerte#offerteAanvragen">
                <span>Offerte aanvragen</span>
              </a>
            </div>
          </div>
        </div>
      </section>
        
        

@endsection