@extends('layouts.app')

@section('title', 'Sales Funnel')

@section('content')
    <div class="bg-yellow-50 min-h-screen py-10">

        <!-- Page Header -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-yellow-700">Sales Funnel Overzicht</h1>
            <p class="text-gray-600 mt-2">Beheer je klanten door de sales pipeline</p>
        </div>

        <!-- FUNNEL VISUALISATIE -->
        <div class="max-w-7xl mx-auto mb-10">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Pipeline Overzicht</h2>

                <!-- Funnel Stages -->
                <div class="grid grid-cols-5 gap-4 mb-6">
                    <div class="text-center">
                        <div class="bg-gray-500 text-white rounded-lg p-6 shadow-lg transform hover:scale-105 transition">
                            <div class="text-4xl mb-2">🔍</div>
                            <div class="text-3xl font-bold">{{ $funnelStats['lead'] }}</div>
                            <div class="text-sm mt-2">Lead</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-500 text-white rounded-lg p-6 shadow-lg transform hover:scale-105 transition">
                            <div class="text-4xl mb-2">💼</div>
                            <div class="text-3xl font-bold">{{ $funnelStats['prospect'] }}</div>
                            <div class="text-sm mt-2">Prospect</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-yellow-500 text-white rounded-lg p-6 shadow-lg transform hover:scale-105 transition">
                            <div class="text-4xl mb-2">📄</div>
                            <div class="text-3xl font-bold">{{ $funnelStats['quote_sent'] }}</div>
                            <div class="text-sm mt-2">Offerte</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-green-500 text-white rounded-lg p-6 shadow-lg transform hover:scale-105 transition">
                            <div class="text-4xl mb-2">✅</div>
                            <div class="text-3xl font-bold">{{ $funnelStats['customer'] }}</div>
                            <div class="text-sm mt-2">Klant</div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="bg-purple-500 text-white rounded-lg p-6 shadow-lg transform hover:scale-105 transition">
                            <div class="text-4xl mb-2">🚚</div>
                            <div class="text-3xl font-bold">{{ $funnelStats['delivered'] }}</div>
                            <div class="text-sm mt-2">Geleverd</div>
                        </div>
                    </div>
                </div>

                <!-- Conversie Rate -->
                <div class="text-center mt-8 p-4 bg-gray-100 rounded-lg">
                    <div class="text-sm text-gray-600">Conversie Rate</div>
                    <div class="text-4xl font-bold text-green-600">{{ $conversionRate }}%</div>
                    <div class="text-xs text-gray-500 mt-1">
                        Van {{ array_sum($funnelStats) }} leads zijn {{ $funnelStats['delivered'] }} geleverd
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTERS -->
        <div class="max-w-7xl mx-auto mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <form method="GET" action="{{ route('sales-funnel.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter op Stadium</label>
                        <select name="stage" class="w-full border-gray-300 rounded p-2">
                            <option value="all" {{ $stage == 'all' ? 'selected' : '' }}>Alle Stadia</option>
                            <option value="lead" {{ $stage == 'lead' ? 'selected' : '' }}>🔍 Lead</option>
                            <option value="prospect" {{ $stage == 'prospect' ? 'selected' : '' }}>💼 Prospect</option>
                            <option value="quote_sent" {{ $stage == 'quote_sent' ? 'selected' : '' }}>📄 Offerte</option>
                            <option value="customer" {{ $stage == 'customer' ? 'selected' : '' }}>✅ Klant</option>
                            <option value="delivered" {{ $stage == 'delivered' ? 'selected' : '' }}>🚚 Geleverd</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Accountmanager</label>
                        <select name="assigned_to" class="w-full border-gray-300 rounded p-2">
                            <option value="all" {{ $assignedTo == 'all' ? 'selected' : '' }}>Alle Accountmanagers</option>
                            @foreach($accountManagers as $manager)
                                <option value="{{ $manager->id }}" {{ $assignedTo == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded shadow-md">
                            Filter Toepassen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- KLANTEN TABEL -->
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">
                    Klanten
                    <span class="text-gray-500 text-lg">({{ $customers->count() }})</span>
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300 rounded-md">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Klant</th>
                            <th class="px-4 py-2 text-left">Stadium</th>
                            <th class="px-4 py-2 text-left">Accountmanager</th>
                            <th class="px-4 py-2 text-left">Laatste Contact</th>
                            <th class="px-4 py-2 text-left">Activiteiten</th>
                            <th class="px-4 py-2 text-left">Acties</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($customers as $customer)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="font-semibold">{{ $customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-3 py-1 {{ $customer->getFunnelStageColor() }} text-white text-sm rounded-full">
                                        {{ $customer->getFunnelStageIcon() }} {{ $customer->getFunnelStageLabel() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($customer->assignedUser)
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold mr-2">
                                                {{ strtoupper(substr($customer->assignedUser->name, 0, 1)) }}
                                            </div>
                                            {{ $customer->assignedUser->name }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Niet toegewezen</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($customer->last_contact_date)
                                        <div>{{ $customer->last_contact_date->format('d-m-Y') }}</div>
                                        @php
                                            $days = $customer->daysSinceLastContact();
                                        @endphp
                                        @if($days !== null)
                                            <div class="text-xs {{ $days > 14 ? 'text-red-600' : 'text-gray-500' }}">
                                                {{ $days }} dagen geleden
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-gray-400 italic">Geen contact</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                        {{ $customer->activities->count() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('customers.show', $customer->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded shadow text-sm">
                                        Bekijk Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-8 text-gray-500">
                                    Geen klanten gevonden met de geselecteerde filters.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
