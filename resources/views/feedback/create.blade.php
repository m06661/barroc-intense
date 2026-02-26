@extends($feedback ? 'layouts.guest' : 'layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">

            <h1 class="text-3xl font-bold mb-6 text-gray-900">
                {{ $feedback ? 'Give Feedback' : 'Create Feedback Request' }}
            </h1>

            <div class="bg-white rounded-lg shadow-md p-8">

                <form id="feedback-form"
                      action="{{ $feedback ? route('feedback.store', $feedback->id) : route('feedback.request.store') }}"
                      method="POST"
                      class="space-y-6">
                    @csrf

                    @if ($feedback)
                        <!-- READ ONLY machine -->
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Machine</p>
                            <p class="font-semibold text-gray-900">
                                {{ $feedback->machine?->type ?? 'Unknown machine' }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Serial: <span class="font-mono text-gray-800">{{ $feedback->machine?->serial_number ?? 'N/A' }}</span>
                            </p>

                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Monteur</p>
                                <p class="font-semibold text-gray-900">
                                    {{ $feedback->technician?->name ?? '—' }}
                                </p>
                                @if($feedback->technician?->region)
                                    <p class="text-sm text-gray-600 mt-1">
                                        Regio: <span class="font-mono text-gray-800">{{ $feedback->technician->region }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>


                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-900 mb-4">
                                Rate your experience (1–5)
                            </label>

                            <div class="flex gap-3 justify-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="score" value="{{ $i }}" class="hidden peer"
                                            {{ (int)old('score') === $i ? 'checked' : '' }}>
                                        <span class="text-5xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-300">
                                            ★
                                        </span>
                                    </label>
                                @endfor
                            </div>

                            @error('score')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comments -->
                        <div>
                            <label for="comments" class="block text-sm font-medium text-gray-900 mb-2">
                                Comments (optional)
                            </label>

                            <textarea
                                id="comments"
                                name="comments"
                                rows="4"
                                maxlength="1000"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2"
                                placeholder="Share your feedback...">{{ old('comments') }}</textarea>

                            @error('comments')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                    @else
                        <!-- Machine selection -->
                        <div>
                            <label for="machine_id" class="block text-sm font-medium text-gray-900 mb-2">
                                Select Machine
                            </label>

                            <select id="machine_id" name="machine_id" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">-- Choose a machine --</option>
                                @foreach(($machines ?? []) as $machine)
                                    <option value="{{ $machine->id }}" {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
                                        {{ $machine->type }} — {{ $machine->serial_number }}
                                        @if($machine->location) ({{ $machine->location }}) @endif
                                    </option>
                                @endforeach
                            </select>

                            @error('machine_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Technician selection -->
                        <div>
                            <label for="technician_id" class="block text-sm font-medium text-gray-900 mb-2">
                                Assign Technician
                            </label>

                            <select id="technician_id" name="technician_id" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2">
                                <option value="">-- Choose a technician --</option>
                                @foreach(($technicians ?? []) as $tech)
                                    <option value="{{ $tech->id }}" {{ old('technician_id') == $tech->id ? 'selected' : '' }}>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('technician_id')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm text-blue-800">
                            Dit maakt een <strong>pending</strong> feedback request aan. De klant vult later score en comments in via de link.
                        </div>
                    @endif

                    <div class="flex gap-4">
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg">
                            {{ $feedback ? 'Submit Feedback' : 'Create Request' }}
                        </button>

                        <a href="{{ route('feedback.index') }}"
                           class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 rounded-lg text-center">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
