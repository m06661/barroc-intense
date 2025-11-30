<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Alle producten ophalen
    public function index()
    {
        $products = Product::all();
        return view('dashboard', compact('products'));
    }

    // Nieuw product aanmaken
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create([
            'name'          => $request->name,
            'sku'           => $request->sku ?? null,
            'price'         => $request->price,
            'stock'         => $request->stock,
            'minimum_stock' => 0,
        ]);

        return redirect()->route('dashboard')->with('success', 'Product aangemaakt!');
    }

    // Product bewerken inline via dashboard
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'  => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer|min:0',
        ]);

        $product->update([
            'name'  => $request->name ?? $product->name,
            'sku'   => $request->sku ?? $product->sku,
            'price' => $request->price ?? $product->price,
            'stock' => $request->stock ?? $product->stock,
        ]);

        return redirect()->route('dashboard')->with('success', 'Product bijgewerkt!');
    }

    // Product verwijderen
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard')->with('success', 'Product verwijderd!');
    }
}
