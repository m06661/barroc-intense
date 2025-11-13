@extends('layouts.app')

@section('title', 'Wachtwoord Vergeten')

@section('content')
    <div class="bg-white flex items-center justify-center py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Titel -->
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    {{ __('Forgot your password?') }}
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Formulier -->
            <form method="POST" action="{{ route('password.email') }}" class="bg-white shadow-lg rounded-lg p-8 border border-yellow-500">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-yellow-500 focus:ring-yellow-500"
                                  type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Submit Button and Back Link -->
                <div class="flex items-center justify-between mt-6">
                    <x-primary-button class="ml-3 bg-yellow-500 hover:bg-yellow-600 focus:ring-yellow-400">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>

                    <!-- Link to go back to login page -->
                    <a href="{{ route('login') }}" class="text-sm text-yellow-500 hover:text-yellow-600">
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
