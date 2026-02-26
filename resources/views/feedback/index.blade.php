@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Your Feedback Requests
                </h1>

                <a href="{{ route('feedback.request.create') }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg transition">
                    + Create Feedback Request
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-lg p-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($feedbacks->isEmpty())
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">
                        No feedback requests at this time.
                    </p>
                </div>
            @else
                <div class="grid gap-6">
                    @foreach ($feedbacks as $feedback)
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">

                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        {{ $feedback->machine->type ?? 'Unknown machine' }}
                                    </h3>

                                    <p class="text-sm text-gray-600 mt-1">
                                        Serial: {{ $feedback->machine->serial_number ?? 'N/A' }}
                                    </p>
                                </div>

                                <div>
                                    @if ($feedback->isFeedbackGiven())
                                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                            ✓ Completed
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                            ⏳ Pending
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="text-sm text-gray-600 mb-4 space-y-1">
                                <p>
                                    <strong>Requested:</strong>
                                    {{ $feedback->feedback_requested_at?->format('d-m-Y H:i') ?? 'N/A' }}
                                </p>

                                <p>
                                    <strong>Technician:</strong>
                                    {{ $feedback->technician?->name ?? '—' }}
                                </p>
                            </div>

                            @if ($feedback->isFeedbackGiven())
                                <div class="mb-4 text-yellow-500 text-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="{{ $i <= $feedback->score ? '' : 'text-gray-300' }}">★</span>
                                    @endfor
                                </div>

                                <a href="{{ route('feedback.review', $feedback->id) }}"
                                   class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg">
                                    Review
                                </a>
                            @else
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('feedback.create', $feedback->id) }}"
                                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                                        Open customer form
                                    </a>

                                    <input
                                        class="w-full sm:w-auto flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-700"
                                        value="{{ route('feedback.create', $feedback->id) }}"
                                        readonly
                                        onclick="this.select();"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-2">
                                    Tip: klik in het veld en kopieer de link om naar de klant te sturen.
                                </p>
                            @endif

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
@endsection
