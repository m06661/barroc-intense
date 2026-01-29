@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-12 px-4 sm:px-6 lg:px-8 flex items-center">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
            <!-- Success Icon -->
            <div class="mb-6">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-green-100">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dank je wel!</h1>
            <p class="text-gray-600 mb-8">
                Uw feedback is succesvol verzonden. Dit helpt ons om uw service te verbeteren.
            </p>

            <!-- Score Display -->
            @if ($feedback->score)
                <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Uw score:</p>
                    <div class="text-4xl">
                        @for ($i = 0; $i < $feedback->score; $i++)
                            <span class="text-yellow-400">★</span>
                        @endfor
                        @for ($i = $feedback->score; $i < 5; $i++)
                            <span class="text-gray-300">★</span>
                        @endfor
                    </div>
                </div>
            @endif

            <p class="text-xs text-gray-500">
                U kunt dit scherm nu sluiten.
            </p>
        </div>
    </div>
@endsection
