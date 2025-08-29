<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImportController;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('admin/products', function(){
//     // dd('admin products');
//     return view('admin.products.index');
// });

Route::prefix('admin')->group(function() {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');   
    Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout'); 

    

});
// Protected admin routes
Route::middleware('auth:admin')->prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('products/store', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('products/show/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::delete('products/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('products/update/{id}', [ProductController::class, 'update'])->name('admin.products.update');



    Route::get('products/import', [ProductImportController::class, 'showImportForm'])->name('admin.products.import');
    Route::post('products/import', [ProductImportController::class, 'import'])->name('admin.products.import.process');
    
    

});

Route::middleware(['auth:admin'])->prefix('admin')->group(function() {

});