@extends('layouts.guest')

@section('content')
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Uw feedback</h1>
        <p class="text-gray-600 mt-1">Hier ziet u wat wij hebben ontvangen.</p>
    </div>

    <!-- Machine -->
    <div class="bg-gray-50 rounded-lg border border-gray-100 p-4 mb-4 text-left">
        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Machine</p>
        <p class="font-semibold text-gray-900">
            {{ $feedback->machine?->type ?? 'Unknown machine' }}
        </p>
        <p class="text-sm text-gray-600 mt-1">
            Serial:
            <span class="font-mono text-gray-800">
                {{ $feedback->machine?->serial_number ?? 'N/A' }}
            </span>
        </p>
    </div>

    <!-- Technician (nieuw) -->
    <div class="bg-gray-50 rounded-lg border border-gray-100 p-4 mb-4 text-left">
        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Monteur</p>

        @if($feedback->technician)
            <p class="font-semibold text-gray-900">
                {{ $feedback->technician->name }}
            </p>

            @if($feedback->technician->region)
                <p class="text-sm text-gray-600 mt-1">
                    Regio:
                    <span class="font-mono text-gray-800">
                        {{ $feedback->technician->region }}
                    </span>
                </p>
            @endif
        @else
            <p class="text-gray-500 italic">
                Geen monteur toegewezen.
            </p>
        @endif
    </div>

    <!-- Score -->
    <div class="bg-gray-50 rounded-lg border border-gray-100 p-4 mb-4">
        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Score</p>

        <div class="text-3xl">
            @for ($i = 1; $i <= 5; $i++)
                <span class="{{ $i <= ($feedback->score ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}">
                    ★
                </span>
            @endfor
        </div>
    </div>

    <!-- Comments -->
    <div class="bg-gray-50 rounded-lg border border-gray-100 p-4">
        <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Opmerking</p>

        @if($feedback->comments)
            <p class="text-gray-700 italic">
                “{{ $feedback->comments }}”
            </p>
        @else
            <p class="text-gray-500 italic">
                Geen opmerking achtergelaten.
            </p>
        @endif

        <p class="text-xs text-gray-500 mt-3">
            Wilt u nog iets toevoegen? Neem contact op met onze support.
        </p>
    </div>

    <div class="mt-6">
        <a href="{{ route('feedback.index') }}"
           class="w-full block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition shadow-sm">
            Terug naar feedback overzicht
        </a>
    </div>
@endsection
