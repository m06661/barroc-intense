@extends('layouts.app')

@section('title', 'Orderdetails')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start pt-20 pb-12 px-6 lg:px-8" style="background-color: #FFFBEA;">

    <!-- Back button -->
    <div class="w-full max-w-4xl mb-6">
        <a href="{{ route('orders.index') }}" 
           class="inline-flex items-center text-yellow-700 font-semibold hover:underline">
            ← Terug naar overzicht
        </a>
    </div>

    <!-- Container -->
    <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl border border-gray-100 p-8">

        <!-- Titel -->
        <h1 class="text-3xl font-extrabold text-gray-900 mb-6">
            Order #{{ $order->id }}
        </h1>

        <!-- Order Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Klant</h2>
                <p class="text-gray-900 text-xl font-medium">
                    {{ $order->customer->name ?? 'Onbekende klant' }}
                </p>
                <p class="text-gray-600 text-sm mt-1">
                    Email: {{ $order->customer->email ?? 'n/a' }} <br>
                    Telefoon: {{ $order->customer->phone ?? 'n/a' }}
                </p>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Orderinformatie</h2>
                <p class="text-gray-700">
                    <strong>Datum:</strong> {{ $order->order_date ?? '-' }}
                </p>
                <p class="text-gray-700">
                    <strong>Totaal:</strong> €{{ number_format($order->total_amount, 2, ',', '.') }}
                </p>

                <p class="mt-2">
                    <strong>Status:</strong>
                    <span class="
                        inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->status === 'quote') bg-gray-200 text-gray-800
                        @elseif($order->status === 'contract') bg-blue-100 text-blue-700
                        @elseif($order->status === 'delivery') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'invoice') bg-green-100 text-green-800
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
            </div>

        </div>

        <!-- Status Update -->
        <div class="mb-10">
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Status aanpassen</h2>

            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-4">
                @csrf

                <select name="status" class="border border-gray-300 rounded-lg px-4 py-2 shadow-sm">
                    <option value="quote" {{ $order->status === 'quote' ? 'selected' : '' }}>Quote</option>
                    <option value="contract" {{ $order->status === 'contract' ? 'selected' : '' }}>Contract</option>
                    <option value="delivery" {{ $order->status === 'delivery' ? 'selected' : '' }}>Delivery</option>
                    <option value="invoice" {{ $order->status === 'invoice' ? 'selected' : '' }}>Invoice</option>
                </select>

                <button type="submit" 
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-6 rounded-lg shadow-sm transition">
                    Update
                </button>
            </form>
        </div>

        <!-- Invoices -->
        <div>
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Facturen</h2>

            @if($order->invoices->count() > 0)
                <ul class="space-y-3">
                    @foreach($order->invoices as $invoice)
                        <li class="p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                            <p class="text-gray-800 font-medium">Factuur #{{ $invoice->id }}</p>
                            <p class="text-gray-600 text-sm">Bedrag: €{{ number_format($invoice->amount, 2, ',', '.') }}</p>
                            <p class="text-gray-600 text-sm">Status: {{ ucfirst($invoice->status) }}</p>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Geen facturen gekoppeld aan deze order.</p>
            @endif
        </div>

    </div>
</div>
@endsection
