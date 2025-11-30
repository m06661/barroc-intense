
@extends('layouts.app')

@section('content')
    <h2 class="text-xl font-bold mb-4">
        Zoekresultaten voor: "{{ $search }}"
    </h2>

    {{-- Orders --}}
    @if($orders->count())
        <h3 class="text-lg font-semibold mt-6">Orders</h3>
        @foreach($orders as $order)
            <div class="border p-3 rounded mb-3">
                <p><strong>Ordernummer:</strong> {{ $order->order_number }}</p>
                <p><strong>Klant:</strong> {{ $order->customer->name }}</p>
                <p><strong>Machine-ID:</strong> {{ $order->machine->machine_id }}</p>
            </div>
        @endforeach
    @endif

    {{-- Customers --}}
    @if($customers->count())
        <h3 class="text-lg font-semibold mt-6">Klanten</h3>
        @foreach($customers as $customer)
            <div class="border p-3 rounded mb-3">
                <p><strong>Naam:</strong> {{ $customer->name }}</p>
                <p><strong>Email:</strong> {{ $customer->email }}</p>
            </div>
        @endforeach
    @endif

    {{-- Machines --}}
    @if($machines->count())
        <h3 class="text-lg font-semibold mt-6">Machines</h3>
        @foreach($machines as $machine)
            <div class="border p-3 rounded mb-3">
                <p><strong>Machine-ID:</strong> {{ $machine->machine_id }}</p>
                <p><strong>Type:</strong> {{ $machine->type }}</p>
            </div>
        @endforeach
    @endif

    {{-- Leases --}}
    @if($leases->count())
        <h3 class="text-lg font-semibold mt-6">Leases</h3>
        @foreach($leases as $lease)
            <div class="border p-3 rounded mb-3">
                <p><strong>Lease:</strong> {{ $lease->lease_number }}</p>
                <p><strong>Status:</strong> {{ $lease->status }}</p>
            </div>
        @endforeach
    @endif

    @if($orders->isEmpty() && $customers->isEmpty() && $machines->isEmpty() && $leases->isEmpty())
        <p>Geen resultaten gevonden.</p>
    @endif

@endsection
