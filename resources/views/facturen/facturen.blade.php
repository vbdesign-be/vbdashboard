@extends('layouts/app')

@section('title', 'Facturen')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>


          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Facturen</h2>
          </div>
        </div>

        
        

        <section class="py-8">
          <div class="container px-4 mx-auto">
            <div class="bg-white shadow rounded py-6 px-6">
              <div class="search">
                <form class="search__form search__form--factuur flex gap-4" action="">
                  <input class="border search__input rounded" type="text" name="search">
                  <button class="rounded search__btn bg-blue-500 text-white" type="submit">Zoek</button>
                </form>
              </div>
            </div>
          </div>
        </section>
        
        <section class="py-8">
        <div class="container px-4 mx-auto">
          <div class="pt-6 bg-white shadow rounded">
            <div class="px-6 border-b">
              <div class="flex flex-wrap items-center mb-6">
                <h3 class="text-xl font-bold">Overzicht Facturen</h3>
              </div>
            </div>
            <div class="p-4 overflow-x-auto">
              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left">
                    <th class="flex items-center pl-6 py-4 font-medium">
                      <input class="mr-3 invisible" type="checkbox" name="" id="">
                      <a class="flex items-center" href="#">
                        <span>Nr.</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>title</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Bedrag</span>
                        
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Datum</span>
                      </a>
                    </th>
                    <th class="py-4 font-medium">
                      <a class="flex items-center" href="#">
                        <span>Status</span>
                      </a>
                    </th>
                  </tr>
                </thead>
                <tbody>
                @if(!empty($facturen))
                @for($x = 0; $x < count($facturen); $x++)
                @foreach($facturen[$x] as $fac)
                    @if(date('d/m/y') > date('d/m/Y', strtotime($fac->due_on)) && $fac->status === "outstanding")
                    <tr class="table__item facturen text-xs bg-red-50">
                    @else
                    <tr class="table__item facturen text-xs bg-gray-50">
                    @endif
                      <td class="flex items-center factuur__number py-4 px-6 font-medium">
                        <p>{{$fac->invoice_number}}</p>
                      </td>
                      <td class="font-medium factuur__name">{{$fac->invoicee->name}}</td>
                      <td class="font-medium factuur__amount">€{{$fac->total->tax_inclusive->amount}}</td>
                      <td class="font-medium factuur__date">{{ date('d/m/Y', strtotime($fac->due_on))}}</td>
                      <td class="font-medium factuur__status">
                          @switch($fac->status)
                            @case("matched")
                                Betaald
                                @break
                            @case("draft")
                                Nog niet ingebracht
                                @break
                            @case("outstanding")
                                Nog te betalen
                                @break
                          @endswitch
                      </td>
                      <td><a class="btn--download" target="_blank" href="/factuur/download/{{$fac->id}}">download icon</a></td>
                    </tr>
                @endforeach
                @endfor
                @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </section>
        

@endsection