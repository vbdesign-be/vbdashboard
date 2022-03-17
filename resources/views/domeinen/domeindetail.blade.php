@extends('layouts/app')

@section('title', 'Domeinnaam')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Domeinnaam</h2>
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

        @if($flash = session('error'))
        @component('components/notification')
            @slot('type') red @endslot
            @slot('size')  notification-profile  @endslot
            @slot('textcolor') red @endslot
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
          <div class="pt-4 bg-white shadow rounded">
            <div class="flex px-6 pb-4 border-b">
              <h3 class="text-xl font-bold">emailboxen</h3>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left"><th class="pb-3 font-medium">Email</th><th class="pb-3 font-medium">Domeinnaam</th><th class="pb-3 font-medium">Status</th></tr>
                </thead>
                <tbody>
                  <tr id="emailBoxes" class="table__item text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">info@test.be</td>
                    <td class="font-medium">test.be</td>
                    <td>
                      <span class="inline-block py-1 px-2 text-white bg-green-500 rounded-full">active</span>
                    </td>
                    <td><form action="/domein/email/delete" method="post">@csrf<input type="hidden" name="email" value="jonathan@vbdesign.be"><input type="submit" value="verwijder btn"></form></td>
                  </tr>
                </tbody>
                </table>

                <div class="form__btn">
                <a class="emailAddBtn inline-flex items-center py-2 px-3 rounded text-xs text-white bg-indigo-500 hover:bg-indigo-600 rounded" href="#">
                <span class="mr-1">
                  <svg width="14" height="14" viewbox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.3335 12.3333H2.3335C2.15669 12.3333 1.98712 12.2631 1.86209 12.1381C1.73707 12.013 1.66683 11.8435 1.66683 11.6666V9.66665C1.66683 9.48984 1.59659 9.32027 1.47157 9.19524C1.34654 9.07022 1.17697 8.99998 1.00016 8.99998C0.823352 8.99998 0.653782 9.07022 0.528758 9.19524C0.403734 9.32027 0.333496 9.48984 0.333496 9.66665V11.6666C0.333496 12.1971 0.54421 12.7058 0.919283 13.0809C1.29436 13.4559 1.80306 13.6666 2.3335 13.6666H4.3335C4.51031 13.6666 4.67988 13.5964 4.8049 13.4714C4.92992 13.3464 5.00016 13.1768 5.00016 13C5.00016 12.8232 4.92992 12.6536 4.8049 12.5286C4.67988 12.4036 4.51031 12.3333 4.3335 12.3333V12.3333ZM1.00016 4.99998C1.17697 4.99998 1.34654 4.92974 1.47157 4.80472C1.59659 4.67969 1.66683 4.51012 1.66683 4.33331V2.33331C1.66683 2.1565 1.73707 1.98693 1.86209 1.86191C1.98712 1.73688 2.15669 1.66665 2.3335 1.66665H4.3335C4.51031 1.66665 4.67988 1.59641 4.8049 1.47138C4.92992 1.34636 5.00016 1.17679 5.00016 0.99998C5.00016 0.823169 4.92992 0.653599 4.8049 0.528575C4.67988 0.403551 4.51031 0.333313 4.3335 0.333313H2.3335C1.80306 0.333313 1.29436 0.544027 0.919283 0.9191C0.54421 1.29417 0.333496 1.80288 0.333496 2.33331V4.33331C0.333496 4.51012 0.403734 4.67969 0.528758 4.80472C0.653782 4.92974 0.823352 4.99998 1.00016 4.99998ZM11.6668 0.333313H9.66683C9.49002 0.333313 9.32045 0.403551 9.19543 0.528575C9.0704 0.653599 9.00016 0.823169 9.00016 0.99998C9.00016 1.17679 9.0704 1.34636 9.19543 1.47138C9.32045 1.59641 9.49002 1.66665 9.66683 1.66665H11.6668C11.8436 1.66665 12.0132 1.73688 12.1382 1.86191C12.2633 1.98693 12.3335 2.1565 12.3335 2.33331V4.33331C12.3335 4.51012 12.4037 4.67969 12.5288 4.80472C12.6538 4.92974 12.8234 4.99998 13.0002 4.99998C13.177 4.99998 13.3465 4.92974 13.4716 4.80472C13.5966 4.67969 13.6668 4.51012 13.6668 4.33331V2.33331C13.6668 1.80288 13.4561 1.29417 13.081 0.9191C12.706 0.544027 12.1973 0.333313 11.6668 0.333313ZM9.66683 6.99998C9.66683 6.82317 9.59659 6.6536 9.47157 6.52858C9.34654 6.40355 9.17697 6.33331 9.00016 6.33331H7.66683V4.99998C7.66683 4.82317 7.59659 4.6536 7.47157 4.52858C7.34654 4.40355 7.17697 4.33331 7.00016 4.33331C6.82335 4.33331 6.65378 4.40355 6.52876 4.52858C6.40373 4.6536 6.3335 4.82317 6.3335 4.99998V6.33331H5.00016C4.82335 6.33331 4.65378 6.40355 4.52876 6.52858C4.40373 6.6536 4.3335 6.82317 4.3335 6.99998C4.3335 7.17679 4.40373 7.34636 4.52876 7.47138C4.65378 7.59641 4.82335 7.66665 5.00016 7.66665H6.3335V8.99998C6.3335 9.17679 6.40373 9.34636 6.52876 9.47138C6.65378 9.59641 6.82335 9.66665 7.00016 9.66665C7.17697 9.66665 7.34654 9.59641 7.47157 9.47138C7.59659 9.34636 7.66683 9.17679 7.66683 8.99998V7.66665H9.00016C9.17697 7.66665 9.34654 7.59641 9.47157 7.47138C9.59659 7.34636 9.66683 7.17679 9.66683 6.99998ZM13.0002 8.99998C12.8234 8.99998 12.6538 9.07022 12.5288 9.19524C12.4037 9.32027 12.3335 9.48984 12.3335 9.66665V11.6666C12.3335 11.8435 12.2633 12.013 12.1382 12.1381C12.0132 12.2631 11.8436 12.3333 11.6668 12.3333H9.66683C9.49002 12.3333 9.32045 12.4036 9.19543 12.5286C9.0704 12.6536 9.00016 12.8232 9.00016 13C9.00016 13.1768 9.0704 13.3464 9.19543 13.4714C9.32045 13.5964 9.49002 13.6666 9.66683 13.6666H11.6668C12.1973 13.6666 12.706 13.4559 13.081 13.0809C13.4561 12.7058 13.6668 12.1971 13.6668 11.6666V9.66665C13.6668 9.48984 13.5966 9.32027 13.4716 9.19524C13.3465 9.07022 13.177 8.99998 13.0002 8.99998Z" fill="#F1988F"></path>
                  </svg>
                </span>
                <span>Emailbox toevoegen</span>
              </a>
              </div>

            </div>
          </div>
        </div>
      </section>

      <section id="emailAdd" class="py-8 hidden">
          <div class="container px-4 mx-auto">
            <h1>blablabla</h1>
          </div>
      </section>
    </div>


      

        

        
        

@endsection