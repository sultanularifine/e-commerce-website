<?php

use App\Http\Controllers\Admin\AboutInfoController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ContactPageController;
use App\Http\Controllers\Admin\HeaderSettingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FooterSettingController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\User\ProductPageController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ContactController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\HomepageController;
use App\Http\Controllers\User\SearchController;
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
            Route::get('/{editId?}', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/', [DashboardController::class, 'store'])->name('todo.store');
            Route::put('//{id}', [DashboardController::class, 'update'])->name('todo.update');
            Route::delete('//{id}', [DashboardController::class, 'destroy'])->name('todo.destroy');
        });
        Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('profile/settings', [ProfileController::class, 'settings'])->name('settings.index');
        Route::put('profile/settings', [ProfileController::class, 'update'])->name('profile.update');

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
        Route::post('/products/status/{product}', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('slider', SliderController::class);
        Route::resource('header-settings', HeaderSettingController::class);
        Route::resource('footer', FooterSettingController::class);
        Route::resource('about', AboutInfoController::class);
        Route::resource('stats', StatController::class);
        Route::resource('team-members', TeamMemberController::class);
         Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('admin.contact.index');
    Route::get('contact-messages/{id}', [ContactMessageController::class, 'show'])->name('admin.contact.show');
    Route::delete('contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('admin.contact.destroy');
        Route::get('contact-page', [ContactPageController::class, 'index'])->name('contact-page.index');
        Route::get('contact-page/{id}/edit', [ContactPageController::class, 'edit'])->name('contact-page.edit');
        Route::put('contact-page/{id}', [ContactPageController::class, 'update'])->name('contact-page.update');
        Route::prefix('order')->group(function () {
            Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
            Route::get('/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
            Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
            Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');
            Route::get('/pending', [OrderController::class, 'pending'])->name('admin.orders.pending');
            Route::get('/processing', [OrderController::class, 'processing'])->name('admin.orders.processing');
            Route::get('/completed', [OrderController::class, 'completed'])->name('admin.orders.completed');
            Route::get('/cancelled', [OrderController::class, 'cancelled'])->name('admin.orders.cancelled');
        });
    });
});

Route::redirect('/', '/home');
Route::get('/home', [HomepageController::class, 'index'])->name('home');
Route::get('/about', [HomepageController::class, 'about'])->name('about');
Route::resource('product', ProductPageController::class);
Route::get('/product/{slug}', [ProductPageController::class, 'show'])->name('products.view');
Route::get('/new-arrivals', [ProductPageController::class, 'newArrivals'])->name('products.newArrivals');

Route::post('/cart/buy/{product}', [CartController::class, 'buyNow'])->name('cart.buy');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');
Route::get('/search', [SearchController::class, 'index'])->name('search');