@extends('layouts.app')

@section('title', 'Klanten')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start pt-20 pb-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

    <!-- Titel -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900">Klanten</h1>
        <p class="mt-2 text-gray-700 text-lg">Overzicht van alle klanten in Barroc Intense.</p>
    </div>

    <!-- Container -->
    <div class="bg-white rounded-xl shadow-lg w-full max-w-6xl border border-gray-100 p-8">

        @if($customers->count() === 0)
            <div class="text-center py-10 text-gray-600 text-lg">
                Geen klanten gevonden.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Naam</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Acties</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($customers as $customer)
                            <tr class="hover:bg-yellow-50 transition-colors">
                                <td class="px-6 py-4 text-gray-800 font-medium">{{ $customer->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $customer->email }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="/customers/{{ $customer->id }}/documents"
                                        class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-5 rounded-lg shadow-sm focus:ring-2 focus:ring-yellow-400 transition text-sm">
                                        Documenten
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif

    </div>

</div>
@endsection
