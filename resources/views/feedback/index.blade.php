@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header with Create Button -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Your Feedback Requests</h1>
                <a href="{{ route('feedback.new') }}"
                   class="bg-yellow-500 hover:bg-yellow-800 text-white font-bold py-2 px-6 rounded-lg transition">
                    + New Feedback
                </a>
            </div>

            @if ($feedbacks->isEmpty())
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">No feedback requests at this time.</p>
                </div>
            @else
                <div class="grid gap-6">
                    @foreach ($feedbacks as $feedback)
                        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        {{ $feedback->machine?->type ?? 'Machine' }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Serial: {{ $feedback->machine?->serial_number ?? 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    @if ($feedback->isFeedbackGiven())
                                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                            ✓ Completed
                                        </span>
                                    @else
                                        <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                                            ⏳ Pending
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4 text-sm text-gray-600">
                                <p>
                                    <strong>Requested:</strong>
                                    {{ $feedback->feedback_requested_at?->format('d-m-Y H:i') ?? 'N/A' }}
                                </p>
                                @if ($feedback->technician)
                                    <p><strong>Technician:</strong> {{ $feedback->technician->name }}</p>
                                @endif
                            </div>

                            @if ($feedback->isFeedbackGiven())
                                <div class="mb-4">
                                    <p class="text-yellow-500 text-lg">
                                        @for ($i = 0; $i < $feedback->score; $i++)
                                            ★
                                        @endfor
                                        @for ($i = $feedback->score; $i < 5; $i++)
                                            ☆
                                        @endfor
                                    </p>
                                    @if ($feedback->comments)
                                        <p class="text-gray-700 mt-2 italic">
                                            "{{ $feedback->comments }}"
                                        </p>
                                    @endif
                                </div>
                            @else
                                <a href="{{ route('feedback.create', $feedback->id) }}"
                                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                                    Give Feedback
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
