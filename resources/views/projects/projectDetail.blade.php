@extends('layouts/app')

@section('title', 'Project')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Project: {{ $project->title }}</h2>
          </div>
        </div>

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <a href="/">Back knop</a>
          </div>
        </section>

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
        <div  class="project w-full ">
              <div class="p-6 bg-white rounded">
                <div class="flex items-center mb-6">
                  <span class="project__icon__container flex-shrink-0 inline-flex justify-center items-center mr-3 w-10 h-10 rounded-full">
                    <svg width="18" height="16" viewbox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M14.8335 2.58333H9.60014L9.33348 1.75C9.1606 1.26102 8.83993 0.837918 8.41589 0.539299C7.99185 0.24068 7.48544 0.0813322 6.96681 0.0833316H3.16681C2.50377 0.0833316 1.86788 0.346724 1.39904 0.815565C0.930201 1.28441 0.666809 1.92029 0.666809 2.58333V13.4167C0.666809 14.0797 0.930201 14.7156 1.39904 15.1844C1.86788 15.6533 2.50377 15.9167 3.16681 15.9167H14.8335C15.4965 15.9167 16.1324 15.6533 16.6012 15.1844C17.0701 14.7156 17.3335 14.0797 17.3335 13.4167V5.08333C17.3335 4.42029 17.0701 3.78441 16.6012 3.31557C16.1324 2.84672 15.4965 2.58333 14.8335 2.58333ZM15.6668 13.4167C15.6668 13.6377 15.579 13.8496 15.4227 14.0059C15.2665 14.1622 15.0545 14.25 14.8335 14.25H3.16681C2.9458 14.25 2.73383 14.1622 2.57755 14.0059C2.42127 13.8496 2.33348 13.6377 2.33348 13.4167V2.58333C2.33348 2.36232 2.42127 2.15036 2.57755 1.99408C2.73383 1.8378 2.9458 1.75 3.16681 1.75H6.96681C7.14151 1.74955 7.31194 1.80401 7.454 1.9057C7.59606 2.00739 7.70257 2.15115 7.75848 2.31667L8.20848 3.68333C8.26438 3.84885 8.37089 3.99261 8.51295 4.0943C8.65501 4.19598 8.82544 4.25045 9.00014 4.25H14.8335C15.0545 4.25 15.2665 4.3378 15.4227 4.49408C15.579 4.65036 15.6668 4.86232 15.6668 5.08333V13.4167Z" fill="#E6D4F8"></path>
                    </svg>
                  </span>
                  <div>
                    <p class="text-xs font-bold">{{ $project->title }}</p>
                  </div>
                </div>
                <div>
                  <div class="flex items-center justify-between mb-10">
                  </div>
                  <div class="flex items-center">
                    <span class="inline-block py-1 px-2 mr-2 rounded-full text-xs bg-indigo-50 text-black-500">{{ $project->status }}</span>
                  </div>
                </div>
              </div>
</div>
          </div>
        
      </section>

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
            <div class="form__btn">
            <a href="/project/bugfix/{{ $project->id }}" class="inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" href="">Bekijk bugfixes</a>
            </div>
            </div>
          </div>
        </div>
      </section>

      <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="px-6 pb-6 pt-4 bg-white shadow rounded">
            <div class="flex flex-wrap items-center mb-3">
              <form class="px-6 pb-6 pt-4 bg-white shadow rounded" action="/project/addAsset" method="post" enctype="multipart/form-data">
              @csrf

                <label class="btn--mini  custom-file-upload"><input name="bestanden[]" type="file" multiple/>Bestanden kiezen</label>
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <button class="btn--mini form__avatar__btn inline-block w-full md:w-auto px-6 py-3 font-medium text-white bg-indigo-500 hover:bg-indigo-600 rounded transition duration-200" type="submit">Upload bestanden</button>
            
            
              </form>
            </div>
            </div>
          </div>
      </section>

      <section class="py-8">
      <div class="container px-4 mx-auto">
        
        

        </div>
      </section>



      </div>
      </div>

@endsection