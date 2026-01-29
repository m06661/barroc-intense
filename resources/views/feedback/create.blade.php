@extends('layouts.guest')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">⭐ Uw feedback</h1>
                <p class="text-gray-600 mt-2">Helpt u ons beter te worden?</p>
            </div>

            <!-- Machine Details -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h2 class="font-semibold text-gray-900 mb-3 text-sm">Machine Details</h2>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Type:</dt>
                        <dd class="font-medium text-gray-900">{{ $feedback->machine?->type ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Serienummer:</dt>
                        <dd class="font-medium text-gray-900">{{ $feedback->machine?->serial_number ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Technicus:</dt>
                        <dd class="font-medium text-gray-900">{{ $feedback->technician?->name ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Form -->
            <form action="{{ route('feedback.store', $feedback->id) }}" method="POST" class="space-y-6">
                @csrf

                <!-- Rating -->
                <div>
                    <label class="block text-sm font-medium text-gray-900 mb-4">
                        Hoe tevreden bent u met onze service?
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
                        Opmerkingen (optioneel)
                    </label>
                    <textarea
                        id="comments"
                        name="comments"
                        rows="4"
                        maxlength="1000"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                        placeholder="Deel uw ervaringen met ons..."
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">Max. 1000 karakters</p>
                    @error('comments')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md hover:shadow-lg"
                >
                    Feedback verzenden
                </button>
            </form>

            <!-- Footer -->
            <p class="text-xs text-gray-500 text-center mt-6">
                Dit bericht is automatisch gegenereerd. Uw privacy is voor ons belangrijk.
            </p>
        </div>
    </div>
@endsection
