@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8 flex items-center">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <div class="inline-flex items-center justify-center h-16 w-16 rounded-full bg-blue-100">
                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Feedback ontvangen</h1>
            <p class="text-gray-600 mb-6">
                Dank u wel! We hebben uw feedback al ontvangen.
            </p>

            @if ($feedback->score)
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">Uw score:</p>
                    <div class="text-3xl">
                        @for ($i = 0; $i < $feedback->score; $i++)
                            <span class="text-yellow-400">★</span>
                        @endfor
                    </div>
                </div>
            @endif

            <p class="text-xs text-gray-500">
                Uw feedback helpt ons om beter te worden.
            </p>
        </div>
    </div>
@endsection
