@extends('layouts/app')

@section('title', 'DNS')

@section('content')

<div class="">
        
        <div>
          
        <x-menu/>
        
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">DNS</h2>
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
              <h3 class="text-xl font-bold">DNS management for {{$domain}}</h3>
            </div>
            <div class="p-4 overflow-x-auto">


                <div class="w-full mb-6 grid grid-cols-12 ">
                    <form class="col-span-8 flex flex-wrap gap-4" action="">
                    @csrf
                        <input type="text" name="search" class="border w-10/12 ">
                        <input type="submit" value="Zoek">
                    </form>
                    <a class="dnsAddBtn col-span-3" href="">DNS record toevoegen</a>
                </div>

                <div class="dnsAdd hidden w-full mb-6">
                    <form class="grid grid-cols-12" method="POST" action="/domein/dns/add">
                    @csrf

                    <div class="col-span-1 col-end-1 flex flex-col">
                    <label for="type">Type</label>
                    <select name="type">
                        <option value="A">A</option>
                        <option value="AAAA">AAAA</option>
                        <option value="CAA">CAA</option>
                        <option value="CERT">CERT</option>
                        <option value="CNAME">CNAME</option>
                        <option value="DNSKEY">DNSKEY</option>
                        <option value="DS">DS</option>
                        <option value="HTTPS">HTTPS</option>
                        <option value="LOC">LOC</option>
                        <option value="MX">MX</option>
                        <option value="NAPTR">NAPTR</option>
                        <option value="NS">NS</option>
                        <option value="PTR">PTR</option>
                        <option value="SMIMEA">SMIMEA</option>
                        <option value="SPF">SPF</option>
                        <option value="SRV">SRV</option>
                        <option value="SSHFP">SSHFP</option>
                        <option value="SVCB">SVCB</option>
                        <option value="TLSA">TLSA</option>
                        <option value="TXT">TXT</option>
                        <option value="URI">URI</option>
                    </select>
                    </div>

                    <div class="col-span-3 flex flex-col">
                    <label for="name">Name</label>
                    <input name="name" type="text" class="border">
                    </div>

                    <div class="col-span-3 flex flex-col">
                    <label for="content">Content</label>
                    <input name="content" type="text" class="border">
                    </div>

                    <input name="zone" type="hidden" value="{{$zone}}">
                    <input name="domain" type="hidden" value="{{$domain}}">

                    <div>
                        <input type="submit" value="record toevoegen">
                    </div>

                    </div>
                    </form>
                </div>

                @if(!empty($dnsList))
                @foreach($dnsList as $key => $dns)
                <div class="editDns editDns--{{$key}}">
                <form method="post" action="/domein/dns/edit">
                @csrf
                    <div>
                        <p>type: {{$dns->type}}</p>
                        <input class="border" name="name" type="text" value="{{$dns->name}}">
                    </div>

                    <textarea class="border" name="content" type="text">{{$dns->content}}</textarea>
                    
                    <div>
                        <input type="submit" value="update DNS">
                        <a data-number="{{$key}}" class="dnsDelete" href="">Verwijder</a>
                    </div>
                    <input name="domain" type="hidden" value={{$domain}}>
                    <input name="zone" type="hidden" value={{$zone}}>
                    <input name="dns_id" type="hidden" value={{$dns->id}}>
                    <input name="type" type="hidden" value={{$dns->type}}>
                    </form>
                </div>
                @endforeach
                @endif



              <table class="table-auto w-full">
                <thead>
                  <tr class="text-xs text-gray-500 text-left"><th class="px-6 pb-3 font-medium">Type</th><th class="pb-3 font-medium">Name</th><th class="pb-3 font-medium">Content</th><th class="pb-3 font-medium">TTL</th></tr>
                </thead>
                <tbody>
                @if(!empty($dnsList))
                  @foreach($dnsList as $key => $dns)
                  <tr class="table__item text-xs bg-gray-50">
                    <td class="py-5 px-6 font-medium">{{$dns->type}}</td>
                    <td class="font-medium pr-6 ">{{$dns->name}}</td>
                    <td class="font-medium pr-6">{{$dns->content}}</td>
                    <td class="font-medium pr-6">{{$dns->ttl}}</td>
                    <td><a class="editDNSBtn" data-number={{$key}} href="">bewerk knopje</a></td>
                  </tr>
                 @endforeach
                 @endif
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      </section>

    @if(!empty($dnsList))
    @foreach($dnsList as $key => $dns)
      <div  class="hidden modal modal--{{$key}}">
        <span class="close" title="Close"></span>
        <form class="modal-content" action="/domein/dns/delete" method="POST">
        @csrf
            <div class="container">
                <h1>Delete DNS</h1>
                

    
            <div class="clearfix">
                <button type="button"  class="cancelbtn">Cancel</button>
                <input type="hidden" value="{{$dns->id}}" name="id">
                <input type="hidden" value="{{$zone}}" name="zone">
                <input type="hidden" value="{{$domain}}" name="domain">
                <button type="submit"  class="deletebtn" >Delete</button>
            </div>
            </div>
        </form>
    </div>
    @endforeach
    @endif






      </div>

      


@endsection