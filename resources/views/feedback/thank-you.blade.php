@extends('layouts.guest')

@section('content')
    <div class="text-center">

        <div class="mb-6">
            <div class="inline-flex items-center justify-center h-14 w-14 rounded-full bg-green-100">
                <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
            Dank je wel!
        </h1>

        <p class="text-gray-600 mt-2">
            Uw feedback is succesvol verzonden. Dit helpt ons om onze service te verbeteren.
        </p>
    </div>

    @if ($feedback->score)
        <div class="mt-6 mb-6 p-5 bg-gray-50 rounded-lg border border-gray-100 text-left">
            <p class="text-sm text-gray-600 mb-2">Uw score</p>

            <div class="text-3xl">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $feedback->score ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                @endfor
            </div>

            @if($feedback->comments)
                <p class="mt-4 text-gray-700 italic">
                    “{{ $feedback->comments }}”
                </p>
            @else
                <p class="mt-4 text-gray-500 italic">
                    Geen extra opmerkingen.
                </p>
            @endif
        </div>
    @endif

    <p class="text-xs text-gray-500 mb-6 text-center">
        U kunt dit scherm nu sluiten of teruggaan naar het overzicht.
    </p>

    <div class="flex flex-col gap-3">
        <a href="{{ route('feedback.index') }}"
           class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-sm">
            Terug naar feedback overzicht
        </a>

        @if(Route::has('feedback.review'))
            <a href="{{ route('feedback.review', $feedback->id) }}"
               class="w-full bg-gray-100 hover:bg-gray-200 text-gray-900 font-semibold py-3 px-4 rounded-xl transition ring-1 ring-gray-200">
                Bekijk mijn review
            </a>
        @endif
    </div>

    <p class="text-center text-xs text-gray-500 mt-6">
        Barroc Intense • Feedback portal
    </p>
@endsection
