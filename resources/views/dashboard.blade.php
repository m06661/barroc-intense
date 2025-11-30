@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-yellow-50 min-h-screen">

        <!-- Dashboard Header -->
        <div class="text-center py-12">
            <h1 class="text-5xl font-bold text-yellow-700">Dashboard</h1>
        </div>

        <!-- PRODUCTEN BEHEER -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Producten</h2>

            {{-- Nieuw Product Toevoegen --}}
            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-3">Nieuw Product Toevoegen</h3>
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-lg shadow-md">
                            Product Aanmaken
                        </button>
                    </div>
                </form>
            </div>

            <!-- Producten Tabel -->
            <table class="min-w-full bg-white border border-gray-300 rounded-md">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">Productnaam</th>
                    <th class="px-4 py-2 text-left">Prijs</th>
                    <th class="px-4 py-2 text-left">Voorraad</th>
                    <th class="px-4 py-2 text-left">Gereserveerd</th>
                    <th class="px-4 py-2 text-left">Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr class="border-b">
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
                        <td class="px-4 py-2">{{ $product->reservedQuantity() }}</td>
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
                        <td colspan="5" class="text-center py-4 text-gray-500">Geen producten gevonden.</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <!-- CATEGORIEËN BEHEER -->
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6 mt-12">
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
