<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Haal alle categorieën op
        $categories = Category::all();

        // Geef de categorieën door aan de dashboard view
        return view('dashboard', compact('categories'));
    }

    public function create()
    {
        // Toon het formulier om een nieuwe categorie aan te maken
        return view('categories.create');
    }
//
//    public function store(Request $request)
//    {
//        // Valideer de gegevens
//        $data = $request->validate([
//            'name' => 'required|string|max:255',
//            'description' => 'nullable|string|max:1000',
//        ]);
//
//        // Maak de nieuwe categorie aan
//        Category::create($data);
//
//        // Redirect naar de dashboard view met een succes bericht
//        return redirect()->route('dashboard')->with('success', 'Categorie toegevoegd.');
//    }
//
//    public function show(Category $category)
//    {
//        // Toon de details van een categorie
//        return view('categories.show', compact('category'));
//    }
//
//    public function edit(Category $category)
//    {
//        // Toon het formulier om een bestaande categorie te bewerken
//        return view('categories.edit', compact('category'));
//    }
//
//    public function update(Request $request, Category $category)
//    {
//        // Valideer de gegevens
//        $data = $request->validate([
//            'name' => 'required|string|max:255',
//            'description' => 'nullable|string|max:1000',
//        ]);
//
//        // Werk de bestaande categorie bij
//        $category->update($data);
//
//        // Redirect naar de dashboard view met een succes bericht
//        return redirect()->route('dashboard')->with('success', 'Categorie bijgewerkt.');
//    }
//
//    public function destroy(Category $category)
//    {
//        // Verwijder de categorie
//        $category->delete();
//
//        // Redirect naar de dashboard view met een succes bericht
//        return redirect()->route('dashboard')->with('success', 'Categorie verwijderd.');
//    }
}
