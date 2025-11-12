<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController; // Voeg CategoryController toe
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Hier worden alle routes van je webapplicatie gedefinieerd.
| Routes zijn gegroepeerd en voorzien van middleware en logische secties.
|
*/

// ------------------------------
// Standaard Welkomstpagina
// ------------------------------
Route::get('/', function () {
    return view('welcome');
});

// ------------------------------
// Dashboard Routes
// ------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/index', function () {
        return view('index');
    })->name('index');
});

// ------------------------------
// Contactpagina
// ------------------------------
Route::middleware('auth')->get('/contact', function () {
    return view('contact');
})->name('contact');

//order routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
// ------------------------------
// Lease Management Routes alvast
// ------------------------------
Route::middleware('auth')->prefix('leases')->name('leases.')->group(function () {
    Route::get('/', [LeaseController::class, 'index'])->name('index');
    Route::get('/create', [LeaseController::class, 'create'])->name('create');
    Route::post('/', [LeaseController::class, 'store'])->name('store');
    Route::get('/{lease}/edit', [LeaseController::class, 'edit'])->name('edit');
    Route::put('/{lease}', [LeaseController::class, 'update'])->name('update');
    Route::delete('/{lease}', [LeaseController::class, 'destroy'])->name('destroy');
});

// ------------------------------
// Product Management Routes alvast
// ------------------------------
Route::middleware('auth')->prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
});

// ------------------------------
// Category Management Routes alvast
// ------------------------------
Route::middleware('auth')->prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index'); // Categorieën overzicht
    Route::get('/create', [CategoryController::class, 'create'])->name('create'); // Categorie aanmaken
    Route::post('/', [CategoryController::class, 'store'])->name('store'); // Categorie opslaan
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show'); // Categorie details
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit'); // Categorie bewerken
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update'); // Categorie updaten
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy'); // Categorie verwijderen
});

// ------------------------------
// Profielbeheer Routes
// ------------------------------
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// ------------------------------
// Authentication Routes
// ------------------------------
require __DIR__.'/auth.php';
