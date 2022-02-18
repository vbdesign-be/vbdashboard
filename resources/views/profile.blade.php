@extends('layouts/app')

@section('title', 'Profile')

@section('content')


<div class="">

    <x-menu />
        
        <div>
          <div class="mx-auto lg:ml-80">
        <div class="py-8 px-6">
          <div class="container px-4 mx-auto">
            <h2 class="text-2xl font-bold">Pas hier je gegevens van je profiel aan</h2>
          </div>
        </div>
        
        

            <!-- code van het formulier van de gegevens -->

            <div class="form__container form__container--big">


            <form action="user/editUser/{{ $user->id }}" method="post" class="form--mini">
            @csrf

                <div class="form__column form__column--left">
                    <div class="input-group">
                        <label class="label" for="lastname">Familienaam</label>
                        <input class="input" type="text" name="familienaam" value="{{ $user->lastname }}">
                    </div>

                    <div class="input-group">
                        <label class="label" for="firstname">Voornaam</label>
                        <input class="input" type="text" name="voornaam" value="{{ $user->firstname }}">
                    </div>

                    <div class="input-group">
                        <label class="label" for="email">Email</label>
                        <input class="input" type="text" name="email" value="{{ $user->email }}">
                    </div>

                    <div class="input-group">
                        <label class="label" for="btw">Btw-nummer</label>
                        <input class="input" type="text" name="btwnummer" value="{{ $user->btwnumber }}">
                    </div>
                </div>

                <div class="form__column form__column--right">
                    <div class="input-group">
                        <label class="label" for="gsm">Gsm</label>
                        <input class="input" type="text" name="gsm" value="{{ $user->gsm }}">
                    </div>

                <div class="input-group">
                    <label class="label" for="phone">Telefoon</label>
                    <input class="input" type="text" name="telefoon" value="{{ $user->phone }}">
                </div>

                <div class="input-group">
                    <label class="label" for="city">Stad</label>
                    <input class="input" type="text" name="stad" value="{{ $user->city }}">
                </div>

                <div class="input-group">
                    <label class="label" for="sector">Sector</label>
                    <input class="input" type="text" name="sector" value="{{ $user->sector }}">
                </div>

            </div>

            <div class="form__btn" >
                <input class="btn" type="submit"  value="Registreer">
            </div>

        </form>

        </div>

        
        </div>
        </div>
      </div>
    


@endsection