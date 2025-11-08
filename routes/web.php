<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HeaderSettingController;
use App\Http\Controllers\Admin\TodoController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\ProductPageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\User\HomepageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();


Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    // Todo Routes
    Route::prefix('admin')->group(function () {
        Route::prefix('dashboard')->group(function () {
            Route::get('/', [TodoController::class, 'index'])->name('dashboard');
            Route::post('/', [TodoController::class, 'store'])->name('todo.store');
            Route::get('//{id}', [TodoController::class, 'edit'])->name('todo.edit');
            Route::put('//{id}', [TodoController::class, 'update'])->name('todo.update');
            Route::delete('//{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
        });

        //Blog Controller
        Route::prefix('blog')->group(function () {
            Route::get('/list', [BlogController::class, 'index'])->name('blog.list');
            Route::get('/create', [BlogController::class, 'create'])->name('blog.create');
            Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
            Route::get('/show/{id}', [BlogController::class, 'show'])->name('blog.show');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blog.edit');
            Route::put('/update/{id}', [BlogController::class, 'update'])->name('blog.update');
            Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
        });
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('header-settings', HeaderSettingController::class);
    });
});
Route::redirect('/', '/home');
Route::get('/home', [HomepageController::class, 'index'])->name('home');
Route::resource('product', ProductPageController::class);
Route::get('/product/{slug}', [ProductPageController::class, 'show'])->name('products.show');
Route::get('/cart', [ProductPageController::class, 'cart'])->name('cart');
