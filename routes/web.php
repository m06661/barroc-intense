<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LeaseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerDocumentController;
use App\Models\Customer;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\CustomerController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/index', function () {
        return view('index');
    })->name('index');
});

// ------------------------------
// Contactpagina
// ------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/contact', [ContactController::class, 'show'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
});

// ------------------------------
// Order Routes
// ------------------------------
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::post('/orders/{id}/priority', [OrderController::class, 'updatePriority'])->name('orders.updatePriority');

// ------------------------------
// Customer Document Routes
// ------------------------------
Route::prefix('customers/{customer}/documents')->group(function () {
    Route::get('/', [CustomerDocumentController::class, 'index'])->name('documents.index');
    Route::post('/', [CustomerDocumentController::class, 'store'])->name('documents.store');
    Route::delete('/{document}', [CustomerDocumentController::class, 'destroy'])->name('documents.destroy');
});

// ------------------------------
// Customers Routes
// ------------------------------
Route::get('/customers', function () {
    $customers = Customer::all();
    return view('customers.index', compact('customers'));
});

// ------------------------------
// Lease Management Routes
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
// Role Management Routes
// ------------------------------
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/roles/assign', [RoleController::class, 'assignForm'])->name('roles.assign');
    Route::post('/roles/assign/{user}', [RoleController::class, 'assignRoles'])->name('roles.assign.save');
});

// ------------------------------
// Product Management Routes
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
// Category Management Routes
// ------------------------------
Route::middleware('auth')->prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
});

// ------------------------------
// Profile Management Routes
// ------------------------------
Route::middleware('auth')->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// ------------------------------
// Audit Log
// ------------------------------
Route::middleware('auth')->get('/audit', [AuditLogController::class, 'index'])
    ->name('audit.index');  // <- belangrijke aanpassing


// ------------------------------
// Search
// ------------------------------
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::post('/orders/{id}/deliver', [OrderController::class, 'markDelivered'])
    ->name('orders.markDelivered')
    ->middleware('auth');


// ------------------------------
// Authentication Routes
// ------------------------------
require __DIR__ . '/auth.php';

Route::get('/customers/{customer}/issues', [CustomerController::class, 'issues'])
    ->name('customers.issues');


Route::middleware(['auth'])->group(function () {
    Route::resource('issues', IssueController::class);

    Route::post(
        '/issues/{issue}/actions',
        [IssueController::class, 'addAction']
    )->name('issues.actions.add');
});