@extends('layouts.app')

@section('title', 'Leasecontract Bewerken')

@section('content')
    <div class="min-h-screen py-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Leasecontract Bewerken</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-3xl mx-auto">
            <form action="{{ route('leases.update', $lease->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Titel</label>
                    <input type="text" name="title" value="{{ $lease->title }}"
                           class="block w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Beschrijving</label>
                    <textarea name="description" rows="4"
                              class="block w-full border-gray-300 rounded-md">{{ $lease->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Startdatum</label>
                    <input type="date" name="start_date" value="{{ $lease->start_date }}"
                           class="block w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Einddatum</label>
                    <input type="date" name="end_date" value="{{ $lease->end_date }}"
                           class="block w-full border-gray-300 rounded-md" required>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-2">Klant</label>
                    <select name="customer_id" class="block w-full border-gray-300 rounded-md" required>
                        <option value="" disabled>Kies een klant</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ $lease->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="bkr_check" value="0">

                <div class="mb-6">
                    <label class="block font-semibold mb-2">BKR Check</label>
                    <input type="checkbox" name="bkr_check" value="1" {{ $lease->bkr_check ? 'checked' : '' }}>
                </div>

                <div class="flex justify-end">
                    <button class="bg-yellow-500 text-white py-2 px-4 rounded-lg">
                        Bijwerken
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
