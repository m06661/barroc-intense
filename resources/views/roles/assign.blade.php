@extends('layouts.app')

@section('content')
    <div class="bg-yellow-50 min-h-screen py-10">
        <div class="max-w-5xl mx-auto">

            <h1 class="text-4xl font-bold text-yellow-700 text-center mb-10">
                Rollen Toewijzen aan Gebruikers
            </h1>

            @foreach ($users as $user)
                <form
                    action="{{ route('roles.assign.save', $user->id) }}"
                    method="POST"
                    class="mb-8 bg-white shadow-md border-l-4 border-yellow-500 rounded-lg p-6 hover:shadow-xl transition-shadow duration-200"
                >
                    @csrf

                    <!-- Gebruikers Info -->
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
                        <span class="mr-2 text-yellow-600">👤</span>
                        {{ $user->name }} <span class="text-gray-500 text-lg ml-2">({{ $user->email }})</span>
                    </h3>

                    <!-- Checkboxes -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 mb-6">
                        @foreach ($roles as $role)
                            <label class="flex items-center space-x-2 text-gray-700">
                                <input
                                    type="checkbox"
                                    name="roles[]"
                                    value="{{ $role->id }}"
                                    class="rounded border-yellow-400 text-yellow-600 focus:ring-yellow-500"
                                    {{ $user->roles->contains($role->id) ? 'checked' : '' }}
                                >
                                <span>{{ ucfirst($role->name) }}</span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Submit Button -->
                    <button
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-5 rounded-lg shadow-md transition-transform hover:scale-105"
                    >
                        💾 Opslaan
                    </button>
                </form>
            @endforeach

        </div>
    </div>
@endsection
