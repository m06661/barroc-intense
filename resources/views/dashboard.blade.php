@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-yellow-50 min-h-screen">

        <!-- Dashboard Header -->
        <div class="text-center py-12">
            <h1 class="text-5xl font-bold text-yellow-700">Dashboard</h1>
        </div>

        <!-- BESTELADVIES WAARSCHUWING -->
        @php
            $lowStockProducts = $products->filter(fn($p) => $p->isLowStock());
        @endphp

        @if($lowStockProducts->count() > 0)
            <div class="max-w-6xl mx-auto bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-6">
                <div class="flex items-start">
                    <span class="text-2xl mr-3">⚠️</span>
                    <div class="flex-1">
                        <h3 class="font-bold text-lg mb-2">🚨 Besteladvies: Lage voorraad gedetecteerd!</h3>
                        <p class="mb-2">De volgende producten hebben een voorraad op of onder het minimum:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($lowStockProducts as $product)
                                <li>
                                    <strong>{{ $product->name }}</strong>:
                                    <span class="font-semibold">{{ $product->stock }} stuks</span>
                                    (minimum: {{ $product->minimum_stock }})
                                    <span class="ml-2 text-sm bg-red-600 text-white px-2 py-0.5 rounded">
                                        → Bestel {{ $product->suggestedReorderQuantity() }} stuks
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- PRODUCTEN BEHEER -->
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Producten</h2>

            {{-- Nieuw Product Toevoegen --}}
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-3">Nieuw Product Toevoegen</h3>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naam</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Prijs (€)</label>
                            <input type="number" name="price" step="0.01" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Voorraad</label>
                            <input type="number" name="stock" value="0" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Min. Voorraad</label>
                            <input type="number" name="minimum_stock" value="10" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bestel aantal</label>
                            <input type="number" name="reorder_quantity" value="50" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow-md">
                            Product Aanmaken
                        </button>
                    </div>
                </form>
            </div>

            <!-- Producten Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-md">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Productnaam</th>
                        <th class="px-4 py-2 text-left">Prijs</th>
                        <th class="px-4 py-2 text-left">Voorraad</th>
                        <th class="px-4 py-2 text-left">Min. Voorraad</th>
                        <th class="px-4 py-2 text-left">Bestel aantal</th>
                        <th class="px-4 py-2 text-left">Gereserveerd</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Acties</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr class="border-b {{ $product->isCriticalStock() ? 'bg-red-50' : ($product->isLowStock() ? 'bg-yellow-50' : '') }}">
                            <td class="px-4 py-2">
                                <form action="{{ route('products.update', $product->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="name" value="{{ $product->name }}" class="w-32 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="price" value="{{ $product->price }}" step="0.01" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="stock" value="{{ $product->stock }}" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="minimum_stock" value="{{ $product->minimum_stock }}" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="reorder_quantity" value="{{ $product->reorder_quantity ?? 50 }}" class="w-20 border-gray-300 rounded p-1">
                            </td>
                            <td class="px-4 py-2">{{ $product->reservedQuantity() }}</td>
                            <td class="px-4 py-2">
                                @if($product->isCriticalStock())
                                    <span class="px-2 py-1 bg-red-600 text-white text-xs rounded font-bold">🚨 KRITIEK</span>
                                @elseif($product->isLowStock())
                                    <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded font-bold">⚠️ LAAG</span>
                                @else
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">✓ OK</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 flex items-center gap-2">
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded">Opslaan</button>
                                </form>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-700" onclick="return confirm('Verwijderen?')">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($products->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">Geen producten gevonden.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CATEGORIEËN BEHEER -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 mt-12 mb-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Categorieën</h2>

            {{-- Nieuwe Categorie --}}
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-3">Nieuwe Categorie</h3>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Naam</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded p-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Beschrijving</label>
                            <input type="text" name="description" class="w-full border-gray-300 rounded p-2">
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow-md">
                            Categorie Aanmaken
                        </button>
                    </div>
                </form>
            </div>

            <!-- Categorieën Tabel -->
            <table class="min-w-full bg-white border border-gray-300 rounded-md">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Naam</th>
                    <th class="px-4 py-2 text-left">Beschrijving</th>
                    <th class="px-4 py-2 text-left">Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <form action="{{ route('categories.update', $category->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="text" name="name" value="{{ $category->name }}" class="w-32 border-gray-300 rounded p-1">
                        </td>
                        <td class="px-4 py-2">
                            <input type="text" name="description" value="{{ $category->description }}" class="w-full border-gray-300 rounded p-1">
                        </td>
                        <td class="px-4 py-2 flex items-center gap-2">
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-2 rounded">Opslaan</button>
                            </form>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:text-red-700" onclick="return confirm('Verwijderen?')">Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if($categories->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center py-4 text-gray-500">Geen categorieën gevonden.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection
