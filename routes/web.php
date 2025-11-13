<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerDocumentController;
use App\Models\Customer;


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//contact page route
Route::middleware('auth')->get('/contact', function () {
    return view('contact');
})->name('contact');

//order routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


Route::prefix('customers/{customer}/documents')->group(function () {
    Route::get('/', [CustomerDocumentController::class, 'index'])->name('documents.index');
    Route::post('/', [CustomerDocumentController::class, 'store'])->name('documents.store');
    Route::delete('/{filename}', [CustomerDocumentController::class, 'destroy'])->name('documents.destroy');
});

Route::get('/customers', function () {
    $customers = Customer::all();
    return view('customers.index', compact('customers'));
});


require __DIR__.'/auth.php';
