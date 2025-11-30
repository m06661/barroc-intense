<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name'        => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('dashboard')->with('success', 'Categorie aangemaakt!');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update([
            'name'        => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('dashboard')->with('success', 'Categorie bijgewerkt!');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard')->with('success', 'Categorie verwijderd!');
    }
}
