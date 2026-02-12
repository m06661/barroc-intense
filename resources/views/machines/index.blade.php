@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-[#FFFBEA]">
        <div class="container mx-auto px-4 py-8">
            <div class="max-w-6xl mx-auto">

                <!-- Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Machines</h1>
                        <p class="text-gray-600 mt-1">Overzicht van machines, status en klant.</p>
                    </div>
                </div>

                @if ($machines->isEmpty())
                    <div class="bg-white border border-yellow-200 rounded-lg p-8 text-center shadow-sm">
                        <p class="text-gray-700 text-lg">Geen machines gevonden.</p>
                    </div>
                @else
                    <!-- Table (styled) -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50">
                                <tr class="text-left text-gray-700">
                                    <th class="px-6 py-4 font-semibold">Type</th>
                                    <th class="px-6 py-4 font-semibold">Serial</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold">Customer</th>
                                </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100">
                                @foreach($machines as $machine)
                                    @php
                                        $status = strtolower($machine->status ?? '');
                                        $badgeClass = match($status) {
                                            'installed' => 'bg-green-100 text-green-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'maintenance' => 'bg-yellow-100 text-yellow-800',
                                            'inactive' => 'bg-gray-200 text-gray-800',
                                            default => 'bg-gray-200 text-gray-800',
                                        };
                                    @endphp

                                    <tr class="hover:bg-yellow-50/40 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900">{{ $machine->type }}</div>
                                            @if($machine->location)
                                                <div class="text-gray-500 text-xs mt-1">
                                                    Location: {{ $machine->location }}
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 font-mono text-gray-800">
                                            {{ $machine->serial_number }}
                                        </td>

                                        <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                            {{ ucfirst($machine->status ?? 'unknown') }}
                                        </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="text-gray-900 font-medium">
                                                {{ $machine->customer->name ?? '—' }}
                                            </div>

                                            @if($machine->installed_at)
                                                <div class="text-gray-500 text-xs mt-1">
                                                    Installed: {{ $machine->installed_at->format('d-m-Y') }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <!-- Optional: small footer -->
                    <div class="mt-4 text-xs text-gray-500">
                        Totaal: {{ $machines->count() }} machines
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
