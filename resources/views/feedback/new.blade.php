@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-8 text-gray-900">Create New Feedback</h1>

            <div class="bg-white rounded-lg shadow-md p-8">
                <form action="{{ route('feedback.store', 1) }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Machine Selection -->
                    <div>
                        <label for="machine_id" class="block text-sm font-medium text-gray-900 mb-2">
                            Select Machine
                        </label>
                        <select id="machine_id" name="machine_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">-- Choose a machine --</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}">
                                    {{ $machine->type }} ({{ $machine->serial_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('machine_id')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-900 mb-4">
                            Rate your experience (1-5 stars)
                        </label>
                        <div class="flex gap-3 justify-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="score" value="{{ $i }}" class="hidden peer" required>
                                    <span class="text-5xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-300 transition duration-200 block">
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                            placeholder="Share your feedback here...">
                    </textarea>
                        <p class="text-xs text-gray-500 mt-1">Max. 1000 characters</p>
                        @error('comments')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition">
                            Submit Feedback
                        </button>
                        <a href="{{ route('feedback.index') }}" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white font-bold py-3 px-4 rounded-lg transition text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
