<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/db-test', function () {
    try {
        return User::count() . ' users';
    } catch (\Exception $e) {
        return response('DB ERROR: '.$e->getMessage(), 500);
    }
});

// Cart routes
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/add/{isbn}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{isbn}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Admin auth
Route::get('/admin/login', [\App\Http\Controllers\AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [\App\Http\Controllers\AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [\App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin area - book CRUD (protected by AdminAuth middleware)
Route::prefix('admin')->middleware([\App\Http\Middleware\AdminAuth::class])->name('admin.')->group(function () {
    Route::resource('books', \App\Http\Controllers\Admin\BookController::class);
});

// Development convenience route to impersonate seeded admin (local only)
Route::get('/admin/impersonate', function () {
    if (!app()->environment('local')) {
        abort(403);
    }
    session(['admin_id' => 1, 'admin_username' => 'admin_yehia']);
    return redirect()->route('admin.books.index');
});

// Theme toggle (persist in session)
Route::get('/theme/toggle', function () {
    $theme = session('theme','dark') === 'light' ? 'dark' : 'light';
    session(['theme' => $theme]);
    return back();
})->name('theme.toggle');

// Local-only helper to set a user's name in session (for integration with external auth)
Route::get('/auth/set-name', function () {
    if (!app()->environment('local')) {
        abort(403);
    }
    $name = request('name');
    if (!$name) {
        return response('Provide ?name=...', 400);
    }
    session(['user_name' => $name]);
    return redirect('/');
});
