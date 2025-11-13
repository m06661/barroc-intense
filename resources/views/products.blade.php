@extends('layouts.app')

@section('title', 'Producten')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Productenbeheer</h1>

        {{-- Success bericht --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulier voor nieuw product --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Nieuw product toevoegen
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Naam</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Beschrijving</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Prijs (€)</label>
                            <input type="number" name="price" step="0.01" class="form-control" value="{{ old('price') }}" required>
                            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label">Voorraad</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                            @error('stock') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Product opslaan</button>
                </form>
            </div>
        </div>

        {{-- Overzicht van producten --}}
        <div class="card">
            <div class="card-header bg-secondary text-white">
                Huidige producten
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Beschrijving</th>
                        <th>Prijs (€)</th>
                        <th>Voorraad</th>
                        <th>Aangemaakt op</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description ?? '-' }}</td>
                            <td>€{{ number_format($product->price, 2, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->created_at->format('d-m-Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Nog geen producten toegevoegd.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
