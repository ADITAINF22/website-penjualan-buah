<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\TransactionController;

// ==================================================
// HALAMAN PERTAMA (LANDING PAGE)
// ==================================================

Route::get('/', function () {
    $products = \App\Models\Product::where('stock', '>', 0)->latest()->take(6)->get();

    return view('welcome', compact('products'));
});


// ==================================================
// LOGIN
// ==================================================

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');


// ==================================================
// REGISTER
// ==================================================

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.process');


// ==================================================
// LOGOUT
// ==================================================

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


// ==================================================
// DASHBOARD PEMBELI
// ==================================================

Route::get('/dashboard/pembeli', function () {
    return view('dashboard_pembeli');
})
    ->middleware('auth')
    ->name('dashboard.pembeli');


// ==================================================
// DASHBOARD KASIR
// ==================================================

Route::get('/dashboard/kasir', function () {
    return view('dashboard_kasir');
})
    ->middleware('auth')
    ->name('dashboard.kasir');


// ==================================================
// DASHBOARD ADMIN
// ==================================================

Route::get('/dashboard/admin', [ProductController::class, 'dashboard'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard.admin');

// ==================================================
// DASHBOARD UTAMA
// ==================================================

Route::get('/dashboard', function () {
    return redirect()->route('dashboard.admin');
})
    ->middleware('auth')
    ->name('dashboard');


// ==================================================
// PRODUCTS
// ==================================================

Route::resource('/products', ProductController::class)
    ->middleware(['auth', 'role:admin']);


// ==================================================
// PEMBELI - KATALOG, KERANJANG, PESANAN
// ==================================================

Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/katalog', [OrderController::class, 'catalog'])->name('pembeli.katalog');
    Route::post('/keranjang/tambah/{product}', [OrderController::class, 'addToCart'])->name('pembeli.cart.add');
    Route::get('/keranjang', [OrderController::class, 'cart'])->name('pembeli.cart');
    Route::post('/keranjang/update/{productId}', [OrderController::class, 'updateCart'])->name('pembeli.cart.update');
    Route::delete('/keranjang/hapus/{productId}', [OrderController::class, 'removeFromCart'])->name('pembeli.cart.remove');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('pembeli.checkout');
    Route::get('/pesanan', [OrderController::class, 'history'])->name('pembeli.riwayat');
});

Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::get('/kasir/pos', [CashierController::class, 'pos'])->name('kasir.pos');
    Route::post('/kasir/tambah/{product}', [CashierController::class, 'addToCart'])->name('kasir.cart.add');
    Route::delete('/kasir/hapus/{productId}', [CashierController::class, 'removeFromCart'])->name('kasir.cart.remove');
    Route::post('/kasir/kosongkan', [CashierController::class, 'clearCart'])->name('kasir.cart.clear');
    Route::post('/kasir/checkout', [CashierController::class, 'checkout'])->name('kasir.checkout');
    Route::get('/kasir/riwayat', [CashierController::class, 'history'])->name('kasir.riwayat');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
});
