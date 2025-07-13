<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GearController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

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

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Special admin setup route (remove after use)
Route::get('/setup-admin', function () {
    // Only works in local environment
    if (!app()->environment('local')) {
        abort(404);
    }
    
    $user = auth()->user();
    
    if (!$user) {
        return redirect()->route('login')
            ->with('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.');
    }
    
    $user->is_admin = 1;
    $user->save();
    
    return "Selamat! Akun " . $user->email . " telah menjadi admin. <a href='/admin'>Buka Admin Panel</a>";
});

// Product Routes
Route::get('/products/bikes', [ProductController::class, 'bikes'])->name('products.bikes');
Route::get('/products/gear', [GearController::class, 'index'])->name('products.gear');
Route::get('/products/bikes/{bike}', [ProductController::class, 'showBike'])->name('products.bike.show');
Route::get('/products/gear/{gear}', [GearController::class, 'show'])->name('products.gear.show');

// User Routes (Auth Required)
Route::group(['middleware' => 'auth'], function () {
    // Cart Routes
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::put('/update/{cart}', [CartController::class, 'update'])->name('update');
        Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('remove');
    });

    // Order Routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/history', [OrderController::class, 'history'])->name('history');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });
    
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// News Routes
Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/{news}', [NewsController::class, 'show'])->name('show');
});

// Event Routes
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{event}', [EventController::class, 'show'])->name('show');
});

// Contact Routes
Route::prefix('contact')->name('contact.')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::post('/store', [ContactController::class, 'store'])->name('store');
});

// Admin Routes
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/bikes', [AdminProductController::class, 'bikes'])->name('bikes');
        Route::get('/gear', [AdminProductController::class, 'gear'])->name('gear');
        Route::get('/bikes/create', [AdminProductController::class, 'createBike'])->name('bikes.create');
        Route::post('/bikes', [AdminProductController::class, 'storeBike'])->name('bikes.store');
        Route::get('/bikes/{bike}/edit', [AdminProductController::class, 'editBike'])->name('bikes.edit');
        Route::put('/bikes/{bike}', [AdminProductController::class, 'updateBike'])->name('bikes.update');
        Route::delete('/bikes/{bike}', [AdminProductController::class, 'destroyBike'])->name('bikes.destroy');
        Route::get('/gear/create', [AdminProductController::class, 'createGear'])->name('gear.create');
        Route::post('/gear', [AdminProductController::class, 'storeGear'])->name('gear.store');
        Route::get('/gear/{gear}/edit', [AdminProductController::class, 'editGear'])->name('gear.edit');
        Route::put('/gear/{gear}', [AdminProductController::class, 'updateGear'])->name('gear.update');
        Route::delete('/gear/{gear}', [AdminProductController::class, 'destroyGear'])->name('gear.destroy');
    });
    
    // Order Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::put('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
    });
    
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    
    // News Management
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [AdminNewsController::class, 'index'])->name('index');
        Route::get('/create', [AdminNewsController::class, 'create'])->name('create');
        Route::post('/', [AdminNewsController::class, 'store'])->name('store');
        Route::get('/{news}/edit', [AdminNewsController::class, 'edit'])->name('edit');
        Route::put('/{news}', [AdminNewsController::class, 'update'])->name('update');
        Route::delete('/{news}', [AdminNewsController::class, 'destroy'])->name('destroy');
    });
    
    // Event Management
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', [AdminEventController::class, 'index'])->name('index');
        Route::get('/create', [AdminEventController::class, 'create'])->name('create');
        Route::post('/', [AdminEventController::class, 'store'])->name('store');
        Route::get('/{event}/edit', [AdminEventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [AdminEventController::class, 'update'])->name('update');
        Route::delete('/{event}', [AdminEventController::class, 'destroy'])->name('destroy');
    });
    
    // Category Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index'])->name('index');
        Route::get('/create', [AdminCategoryController::class, 'create'])->name('create');
        Route::post('/', [AdminCategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('destroy');
    });
});

require __DIR__.'/auth.php';
