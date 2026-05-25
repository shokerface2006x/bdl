<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;





Route::get('/', function () {
    $products = Product::all();
    return view('welcome', compact('products'));
});




Route::get('/product/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('product.show', compact('product'));
})->name('product.show');


Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'storeOrder'])->name('cart.order.store');
Route::get('/thanks', function () {
    return view('cart.success');
})->name('cart.success');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/order/{id}', [ProfileController::class, 'showOrder'])->name('orders.show');
    // Стандартные роуты профиля (из Breeze)
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ГРУППА АДМИНКИ
Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin']
], function () {
    // Товары (CRUD)
    Route::resource('products', ProductController::class);

    // Заказы
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});



require __DIR__.'/auth.php';
