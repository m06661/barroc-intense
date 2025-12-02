<!-- resources/views/index.blade.php -->
@extends('layouts.app')

@section('title', 'Welkom bij Barroc Intens')

@section('content')
    <div class="bg-yellow-50 min-h-screen">
        <div class="text-center py-12">
            <!-- Logo -->
            <img src="{{ asset('images/logo1_groot.png') }}" alt="Barroc Intens Logo" class="mx-auto mb-6 w-32">

            <!-- Welkomsttekst -->
            <h1 class="text-5xl font-bold text-yellow-700">Welkom bij Barroc Intens!</h1>
            <p class="mt-4 text-gray-700 text-lg">
                Wij combineren smaak, innovatie en techniek om jouw koffie-ervaring naar een hoger niveau te tillen.
            </p>
        </div>

        <!-- Korte uitleg -->
        <div class="max-w-4xl mx-auto text-center mt-8">
            <p class="text-gray-600 text-md">
                Ontdek onze premium koffiebonen en innovatieve koffiezetapparaten. Barroc Intens staat voor
                kwaliteit, stijl en een perfecte kop koffie. Word lid van ons platform en ervaar hoe wij jouw koffiepauze
                onvergetelijk maken.
            </p>
        </div>

        <!-- Gebruikersstatus -->
        <div class="mt-10 text-center">
            @auth
                <p class="text-green-600 text-xl">
                    Welkom terug, <strong>{{ Auth::user()->name }}</strong>! Ga naar je
                    <a href="{{ route('dashboard') }}" class="text-yellow-600 underline">dashboard</a>.
                </p>
            @else
                <p class="text-gray-600 text-md">
                    Je bent nog niet ingelogd. <a href="{{ route('login') }}" class="text-yellow-600 underline">Log in</a> of
                    <a href="{{ route('register') }}" class="text-yellow-600 underline">registreer</a> om meer te ontdekken.
                </p>
            @endauth
        </div>

        <!-- Call-to-Action Knoppen -->
        <div class="mt-12 text-center">
            <a href="{{ route('contact') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg mx-2">
                Contacteer ons
            </a>
            <a href="{{ route('products.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg mx-2">
                Bekijk ons aanbod
            </a>
        </div>
    </div>
@endsection
