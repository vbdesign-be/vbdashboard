@extends('layouts/app')

@section('title', 'Afspraak')

@section('content')

<div class="">

    <x-menu />
        
        <div>
          
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Afspraak </h2>
          </div>
        </div>
        
        <div class="kalender container px-4 mx-auto bg-white p-6 relative rounded shadow">
        <!-- Calendly inline widget begin -->
          <div id="kalender" class="calendly-inline-widget" style="min-width:320px;height:580px;" data-auto-load="false">
          <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
          <script>
            Calendly.initInlineWidget({
              url: 'https://calendly.com/jonathan-764'
            });
          </script>
          </div>
        <!-- Calendly inline widget end -->
      </div>
        

@endsection