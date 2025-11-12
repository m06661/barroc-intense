@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="flex justify-center mb-4 mt-8">
        <img src="{{ asset('images/logo1_groot.png') }}" alt="Barroc Intens Logo" class="max-h-32">
    </div>

    <div class="bg-white flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Titel -->
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Log in op je account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Of
                    <a href="{{ route('register') }}" class="font-medium text-yellow-500 hover:text-yellow-600">
                        registreer een nieuw account
                    </a>
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Formulier -->
            <form method="POST" action="{{ route('login') }}" class="bg-white shadow-lg rounded-lg p-8 border border-yellow-500">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-yellow-500 shadow-sm focus:ring-yellow-400"
                               name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-yellow-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-400">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
@endsection

