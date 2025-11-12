@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="flex justify-center mb-4 mt-8">
        <img src="{{ asset('images/logo1_groot.png') }}" alt="Barroc Intens Logo" class="max-h-32">
    </div>

    <div class="bg-white flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Titel -->
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Registreer een nieuw account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Of
                    <a href="{{ route('login') }}" class="font-medium text-yellow-500 hover:text-yellow-600">
                        log in met een bestaand account
                    </a>
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Formulier -->
            <form method="POST" action="{{ route('register') }}" class="bg-white shadow-lg rounded-lg p-8 border border-yellow-500">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-between mt-6">
                    <x-primary-button class="ml-3 bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-400">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection
