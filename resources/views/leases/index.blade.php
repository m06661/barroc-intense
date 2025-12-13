@extends('layouts.app')

@section('title', 'Lease Contracts')

@section('content')
    <div class="min-h-screen py-12 px-6 lg:px-8" style="background-color: #FFFBEA;">
        <div class="text-center mb-6">
            <h1 class="text-4xl font-extrabold text-gray-900">Lease Contracts</h1>
            <p class="mt-2 text-gray-700">Beheer alle leasecontracten van klanten.</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Overzicht</h2>
                <a href="{{ route('leases.create') }}" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-600">
                    + Nieuw Leasecontract
                </a>
            </div>

            <table class="table-auto w-full">
                <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="px-4 py-2">Titel</th>
                    <th class="px-4 py-2">Beschrijving</th>
                    <th class="px-4 py-2">Klant</th>
                    <th class="px-4 py-2">Startdatum</th>
                    <th class="px-4 py-2">Einddatum</th>
                    <th class="px-4 py-2">BKR Check</th>
                    <th class="px-4 py-2">Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach($leases as $lease)
                    <tr>
                        <td class="border px-4 py-2">{{ $lease->title }}</td>
                        <td class="border px-4 py-2">{{ Str::limit($lease->description, 50) }}</td>
                        <td class="border px-4 py-2">{{ $lease->customer->name ?? 'Geen klant' }}</td>
                        <td class="border px-4 py-2">{{ $lease->start_date }}</td>
                        <td class="border px-4 py-2">{{ $lease->end_date }}</td>
                        <td class="border px-4 py-2">{{ $lease->bkr_check ? 'Ja' : 'Nee' }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('leases.edit', $lease->id) }}" class="text-yellow-500 hover:underline">Bewerken</a>

                            <form action="{{ route('leases.destroy', $lease->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Weet je zeker dat je dit wilt verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
