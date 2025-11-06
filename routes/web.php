<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductPageController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;


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


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ControllersProductController::class);
    
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
        //Settings Controller
        Route::prefix('settings')->group(function () {
            Route::get('/basic', [SettingsController::class, 'basic'])->name('settings.basic');
            Route::post('/basic', [SettingsController::class, 'store'])->name('settings.store');
            Route::get('/banner', [SettingsController::class, 'banner'])->name('settings.banner');
            Route::post('/banner', [SettingsController::class, 'heroImageStore'])->name('settings.imageStore');
            Route::delete('/banner/{id}', [SettingsController::class, 'heroImageDestroy'])->name('settings.destroy');
            Route::post('/contact/store', [SettingsController::class, 'contactStore'])->name('settings.contactStore');
            Route::get('/contact/show', [SettingsController::class, 'contactShow'])->name('settings.contactShow');
            Route::delete('/contacts/{id}', [SettingsController::class, 'contactDestroy'])->name('settings.contactDestroy');
        });
    });
});
Route::get('/ ', function () {
    return view('frontend.pages.home');
});

//  Route::redirect('/', '/admin/dashboard');