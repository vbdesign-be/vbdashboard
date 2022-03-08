@extends('layouts/app')

@section('title', 'Bugfix')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Bugfix: {{ $project->title }}</h2>
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


    <div class="container px-4 mx-auto">
      

      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="px-6 pb-6 pt-4 bg-white shadow rounded">
            <div class="flex flex-wrap items-center mb-3">
              <div>
                <div class="flex items-center">
                  <h3 class="mr-2 text-xl font-bold">Bugfixes</h3>
                  
                </div>
                <p class="text-sm text-gray-500">Lijst met alle bugfixes voor {{ $project->title }}</p>
              </div>
              
            </div>

            @if(!empty($bugfixes))
            @foreach($bugfixes as $bugfix)
            <div class="flex justify-between items-center mb-2 p-4 bg-gray-50 rounded">
              <div class="flex items-center">
                <span class="inline-flex w-10 h-10 mr-3 justify-center items-center bg-purple-50 rounded">
                  <svg width="16" height="20" viewbox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12H5C4.73478 12 4.48043 12.1054 4.29289 12.2929C4.10536 12.4804 4 12.7348 4 13C4 13.2652 4.10536 13.5196 4.29289 13.7071C4.48043 13.8946 4.73478 14 5 14H9C9.26522 14 9.51957 13.8946 9.70711 13.7071C9.89464 13.5196 10 13.2652 10 13C10 12.7348 9.89464 12.4804 9.70711 12.2929C9.51957 12.1054 9.26522 12 9 12ZM13 2H11.82C11.6137 1.41645 11.2319 0.910998 10.7271 0.552938C10.2222 0.194879 9.61894 0.00173951 9 0H7C6.38106 0.00173951 5.7778 0.194879 5.27293 0.552938C4.76807 0.910998 4.38631 1.41645 4.18 2H3C2.20435 2 1.44129 2.31607 0.87868 2.87868C0.316071 3.44129 0 4.20435 0 5V17C0 17.7956 0.316071 18.5587 0.87868 19.1213C1.44129 19.6839 2.20435 20 3 20H13C13.7956 20 14.5587 19.6839 15.1213 19.1213C15.6839 18.5587 16 17.7956 16 17V5C16 4.20435 15.6839 3.44129 15.1213 2.87868C14.5587 2.31607 13.7956 2 13 2ZM6 3C6 2.73478 6.10536 2.48043 6.29289 2.29289C6.48043 2.10536 6.73478 2 7 2H9C9.26522 2 9.51957 2.10536 9.70711 2.29289C9.89464 2.48043 10 2.73478 10 3V4H6V3ZM14 17C14 17.2652 13.8946 17.5196 13.7071 17.7071C13.5196 17.8946 13.2652 18 13 18H3C2.73478 18 2.48043 17.8946 2.29289 17.7071C2.10536 17.5196 2 17.2652 2 17V5C2 4.73478 2.10536 4.48043 2.29289 4.29289C2.48043 4.10536 2.73478 4 3 4H4V5C4 5.26522 4.10536 5.51957 4.29289 5.70711C4.48043 5.89464 4.73478 6 5 6H11C11.2652 6 11.5196 5.89464 11.7071 5.70711C11.8946 5.51957 12 5.26522 12 5V4H13C13.2652 4 13.5196 4.10536 13.7071 4.29289C13.8946 4.48043 14 4.73478 14 5V17ZM11 8H5C4.73478 8 4.48043 8.10536 4.29289 8.29289C4.10536 8.48043 4 8.73478 4 9C4 9.26522 4.10536 9.51957 4.29289 9.70711C4.48043 9.89464 4.73478 10 5 10H11C11.2652 10 11.5196 9.89464 11.7071 9.70711C11.8946 9.51957 12 9.26522 12 9C12 8.73478 11.8946 8.48043 11.7071 8.29289C11.5196 8.10536 11.2652 8 11 8Z" fill="#382CDD"></path>
                  </svg>
                </span>
                <div>
                  <h4 class="text-sm font-medium">{{ $bugfix->name }}</h4>
                  <p class="text-xs text-gray-500">Development Department</p>
                </div>
                <div class="ml-20">
                  <h4 class="text-sm font-medium">{{ $bugfix->date_created}}</h4>
                </div>
              </div>
              <div class="flex items-center">
                <span style="background-color: {{$bugfix->status->color}};" class="bugfix__status__text inline-block mr-3 py-1 px-2 bg-indigo-50 text-xs rounded-full">{{ $bugfix->status->status }}</span>
              </div>
            </div>
            @endforeach
            @endif
            
            
            </div>
          </div>
        </div>
      </section>

      <section class="py-8">
        <div class="container px-4 mx-auto">
        
        <form class="px-6 pb-6 pt-4 bg-white shadow rounded" action="/project/addBugfix" method="post">
        @csrf
            <div class="flex items-center">
                <h3 class="mr-2 text-xl font-bold">Bugfix toevoegen</h3>  
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="titel">Titel</label>
                <input class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" type="text" name="titel" placeholder="Write a text">
            </div>
      
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2" for="beschrijving">Beschrijving</label>
                <textarea class="block w-full px-4 py-3 mb-2 text-sm placeholder-gray-500 bg-white border rounded" name="beschrijving" rows="5" placeholder="Write something..."></textarea>
            </div>
            
            <input name="project_id" type="hidden" value="{{ $project->id }}">
            <input name="id" type="hidden" value="{{ $project->id }}">
            

            <div class="form__btn">
            <button class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Bugfix toevoegen</button>
            </div>
        </form>

        </div>
      </section>

      </div>

      </div>

@endsection