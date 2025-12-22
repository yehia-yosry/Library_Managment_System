<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// 1. Add New Books
Route::get('/admin/books/create', [AdminController::class, 'createBook'])->name('admin.books.create');
Route::post('/admin/books/store', [AdminController::class, 'storeBook'])->name('admin.books.store');

// 2. Modify Existing Books
Route::get('/admin/books/search', [AdminController::class, 'searchBookForEdit'])->name('admin.books.search');
Route::get('/admin/books/edit/{isbn}', [AdminController::class, 'editBook'])->name('admin.books.edit');
Route::post('/admin/books/update/{isbn}', [AdminController::class, 'updateBook'])->name('admin.books.update');

// 4. Confirm Orders
Route::get('/admin/orders', [AdminController::class, 'listOrders'])->name('admin.orders.list');
Route::post('/admin/orders/confirm/{id}', [AdminController::class, 'confirmOrder'])->name('admin.orders.confirm');

// 5. Search for Books
Route::get('/admin/books/search-general', [AdminController::class, 'searchBooks'])->name('admin.books.search.general');

// 6. System Reports
Route::get('/admin/reports', [AdminController::class, 'reportsMenu'])->name('admin.reports.menu');
Route::get('/admin/reports/previous-month', [AdminController::class, 'previousMonthSales'])->name('admin.reports.previous.month');
Route::get('/admin/reports/specific-day', [AdminController::class, 'specificDaySalesForm'])->name('admin.reports.specific.day.form');
Route::post('/admin/reports/specific-day', [AdminController::class, 'specificDaySales'])->name('admin.reports.specific.day');
Route::get('/admin/reports/top-customers', [AdminController::class, 'topCustomers'])->name('admin.reports.top.customers');
Route::get('/admin/reports/top-books', [AdminController::class, 'topBooks'])->name('admin.reports.top.books');
Route::get('/admin/reports/book-orders', [AdminController::class, 'bookOrdersForm'])->name('admin.reports.book.orders.form');
Route::post('/admin/reports/book-orders', [AdminController::class, 'bookOrdersCount'])->name('admin.reports.book.orders');