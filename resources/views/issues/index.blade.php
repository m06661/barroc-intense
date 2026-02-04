@extends('layouts.app')

@section('title', 'Issues Overview')

@section('content')
    <div class="bg-yellow-50 min-h-screen py-10">

        <!-- Page Header -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-yellow-700">Storing Overzicht</h1>
        </div>

        <!-- STORING DASHBOARD -->
        <div class="max-w-6xl mx-auto mb-10 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Storingen (7 dagen)</div>
                <div class="text-2xl font-bold">{{ $stats['last_7_days'] }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Storingen (30 dagen)</div>
                <div class="text-2xl font-bold">{{ $stats['last_30_days'] }}</div>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <div class="text-sm text-gray-500">Open storingen</div>
                <div class="text-2xl font-bold text-red-600">{{ $stats['open'] }}</div>
            </div>
        </div>

        <!-- Filters -->
            <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Filters</h2>

                <form method="GET"
                    action="{{ route('issues.index') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="w-full border-gray-300 rounded p-2"
                            placeholder="Search issues, machines, customers...">
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded p-2">
                            <option value="all">All</option>
                            <option value="open" {{ request('status')=='open' ? 'selected' : '' }}>Open</option>
                            <option value="in progress" {{ request('status')=='in progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ request('status')=='resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                        <select name="priority" class="w-full border-gray-300 rounded p-2">
                            <option value="all">All</option>
                            <option value="low" {{ request('priority')=='low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority')=='medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority')=='high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>

                    <!-- Customer -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                        <select name="customer" class="w-full border-gray-300 rounded p-2">
                            <option value="all">All Customers</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ request('customer')==$customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-4 text-right">
                        <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded shadow-md">
                            Apply Filters
                        </button>
                    </div>

                </form>
            </div>

        <div class="max-w-6xl mx-auto mb-6 flex justify-end">
            <a href="{{ route('issues.create') }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                + New Issue
            </a>
        </div>


        <!-- Issues Table -->
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">All Issues</h2>
            <div class="overflow-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-md">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Machine</th>
                        <th class="px-4 py-2 text-left">Customer</th>
                        <th class="px-4 py-2 text-left">Priority</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Reported At</th>
                        <th class="px-4 py-2 text-left"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($issues as $issue)
                        <tr class="border-b">
                            <td class="px-4 py-2 font-semibold">{{ $issue->id }}</td>
                            <td class="px-4 py-2">
                                {{ $issue->machine->type }}<br>
                                <span class="text-gray-500 text-sm">{{ $issue->machine->serial_number }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $issue->machine->customer->name }}</td>
                            <td class="px-4 py-2">
                                <span class="
                                    px-2 py-1 rounded text-white text-sm
                                    @if($issue->priority == 'high') bg-red-600
                                    @elseif($issue->priority == 'medium') bg-yellow-500
                                    @else bg-gray-500 @endif
                                ">
                                    {{ ucfirst($issue->priority) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="
                                    px-2 py-1 rounded text-white text-sm
                                    @if($issue->status == 'open') bg-red-600
                                    @elseif($issue->status == 'in progress') bg-yellow-500
                                    @else bg-green-600 @endif
                                ">
                                    {{ ucfirst($issue->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $issue->reported_at }}</td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <a href="{{ route('issues.show', $issue->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded shadow">
                                    View
                                </a>

                                {{-- Frequentie waarschuwing --}}
                                @php
                                    $recent_count = $issue->machine->issues()
                                        ->where('created_at', '>=', now()->subDays(30))
                                        ->count();
                                @endphp
                                @if($recent_count >= 3)
                                    <span class="ml-2 text-red-600 font-bold">⚠</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">No issues found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $issues->withQueryString()->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
@endsection
