<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\OrderController;
use App\Http\Controllers\Web\PaymentController;
use App\Models\Category;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| All application routes are defined here.
| Public routes, authentication, and admin-protected routes are separated
| for better clarity.
|--------------------------------------------------------------------------
*/

/**
 * -----------------------------
 * Authentication Routes
 * -----------------------------
 */
Auth::routes(['verify' => true]);

// Login & Logout
// Route::get('/testadmin', [AdminHomeController::class, 'testadmin'])->name('testadmin');
// Route::get('/testweb', [ItemController::class, 'testweb'])->name('testweb');
Route::get('/search', [ItemController::class, 'search'])->name('items.search');
Route::get('/ajax-search', [ItemController::class, 'ajaxSearch'])->name('items.ajax.search');
Route::get('/item/{id}', [ItemController::class, 'showItem'])->name('items.show');
Route::get('/', [ItemController::class, 'home'])->name('home');
Route::get('/home/shopbycategory/{category}', [ItemController::class, 'shopbyCategory'])->name('shopbycategory');
Route::get('/login', [AdminHomeController::class, 'root'])->name('login');
Route::post('/login', [AdminHomeController::class, 'login'])->name('login.submit');

Route::post('/register', [AdminHomeController::class, 'register'])->name('register.submit');

Route::post('/logout', [AdminHomeController::class, 'logout'])->name('logout');


// Language switcher
Route::get('/lang/{locale}', [AdminHomeController::class, 'lang'])->name('lang');

Route::middleware(['auth', 'verified', 'check.permission'])->group(function () {
    // all admin + user restricted routes here

    //Banner routes
    Route::get('/banners', [UserController::class, 'bannercreate'])->name('banners.create');
    Route::post('/banners/store', [UserController::class, 'bannerstore'])->name('banners.store');
    Route::get('/banners/index', [UserController::class, 'bannerIndex'])->name('banners.index');
    Route::get('banners/{id}', [UserController::class, 'bannerShow'])->name('banners.show');
    Route::get('banners/{id}/edit', [UserController::class, 'bannerEdit'])->name('banners.edit');
    Route::put('banners/{id}', [UserController::class, 'bannerUpdate'])->name('banners.update');
    Route::delete('banners/{id}', [UserController::class, 'bannerDestroy'])->name('banners.destroy');


    Route::middleware(['web'])->group(function () {
    Route::post('/track-action', [UserController::class, 'userstore'])
        ->name('track.action');
});

//category routes
Route::get('/category', [CategoryController::class, 'catindex'])->name('categories.index');
Route::get('/category/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/category/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/category/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

 Route::get('/index', [ItemController::class, 'index'])->name('item.index');
    Route::get('users/create', [UserController::class, 'create'])->name('user.add');      // user items add
    Route::post('users/webstore', [UserController::class, 'store'])->name('user.webstore');      //user items store
    Route::get('/item/user/view/{id}', [UserController::class, 'userview'])->name('item.userview');
     Route::get('/admin/users/create', [AdminHomeController::class, 'create'])->name('user.create'); //this is for super admin only  to create a new user
    Route::get('/admin/users', [AdminHomeController::class, 'userIndex'])->name('user.index'); //this is for super admin only to view all users
        Route::delete('/admin/users/{id}', [AdminHomeController::class, 'destroy'])->name('user.destroy'); // Delete user
    Route::post('/admin/users/bulk-action', [AdminHomeController::class, 'bulkAction'])->name('users.bulkAction');

    // Store new user
    Route::post('users/store', [AdminHomeController::class, 'store'])->name('user.store');
    Route::get('/category/{slug}', [UserController::class, 'categoryItems'])->name('category.items');
    Route::get('/generate-category-slugs', function() {
    if (!Schema::hasColumn('categories', 'slug')) {
        return "Error: 'slug' column does not exist!";
    }

    $categories = \App\Models\Category::all();
    foreach ($categories as $category) {
        if (!$category->slug) {
            $category->slug = \Illuminate\Support\Str::slug($category->Category_Name);
            $category->save();
        }
    }
    return "Slugs generated successfully!";
});


Route::prefix('items')->name('item.')->group(function () {
        Route::get('/create', [ItemController::class, 'create'])->name('add');
        Route::post('/store', [ItemController::class, 'store'])->name('store');
        Route::delete('/bulk-delete', [ItemController::class, 'bulkDelete'])->name('bulkDelete');
        Route::post('/delete-selected', [ItemController::class, 'deleteSelected'])->name('deleteSelected');
        Route::post('/export', [ItemController::class, 'export'])->name('export');
        Route::post('/import-items', [ItemController::class, 'import'])->name('import');

        Route::get('/categories', function () {
            return response()->json([
                'success' => true,
                'data' => \App\Models\Category::all(),
                'message' => 'Categories retrieved successfully'
            ]);
        })->name('categories');

        Route::get('/{id}/view', [ItemController::class, 'view'])->name('view');
        Route::get('/{id}/edit', [ItemController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [ItemController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [ItemController::class, 'destroy'])->name('destroy');
    });

    Route::get('/dashboard', [AdminHomeController::class, 'dashboardindex'])->name('dashboard');
    // Route::get('/dashboard/data', [AdminHomeController::class, 'dashboardData'])->name('dashboard.data');
    Route::delete('/dashboard/items/{id}', [AdminHomeController::class, 'deleteItem']);
    Route::get('/dashboard/data', [AdminHomeController::class, 'data'])->name('dashboard.data');

    /**
     * -----------------------------
     * Profile Routes
     * -----------------------------
     */

 Route::put('/user/{id}/update', [AdminHomeController::class, 'updateUserProfile'])
        ->name('user.update');
        Route::get('/user/{id}/edit', [AdminHomeController::class, 'userProfileEdit'])
        ->name('user.edit');
});
Route::middleware(['auth', 'verified'])->group(function () {

// ----------------- CART -----------------
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/checkout-selected', [CartController::class, 'checkoutSelected'])->name('cart.checkoutSelected');
Route::post('/cart/checkout/place-order', [CartController::class, 'placeOrder'])->name('cart.placeOrder');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
     Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Edit order (status, etc.)
    // Mark order as delivered (Admin)
Route::patch('admin/orders/{order}/mark-delivered', [OrderController::class, 'markAsDelivered'])
    ->name('admin.orders.markDelivered');

    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::get('my-orders', [OrderController::class, 'userOrders'])->name('user.orders');
    Route::get('my-orders/{order}/invoice', [OrderController::class, 'invoice'])->name('items.invoice');
    Route::post('my-orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('user.orders.cancel');
    // Delete order
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// ----------------- CHECKOUT -----------------
Route::post('/checkout/place-order/{itemId}', [OrderController::class, 'buyNowPlaceOrder'])->name('items.placeOrder');
Route::get('/checkout/buy-now/{itemId}', [OrderController::class, 'BuyNowcheckout'])->name('checkout.buyNow');
// ----------------- PAYMENT -----------------
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/payment/{order}', [PaymentController::class, 'pay'])->name('payment');
Route::get('/payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel/{order}', [PaymentController::class, 'cancel'])->name('payment.cancel');
// Fonepay routes
Route::prefix('orders')->middleware(['auth'])->group(function() {
    Route::get('/{order}/fonepay', [OrderController::class, 'fonepayPayment'])->name('payment.fonepay');

    // Success callback
    Route::get('/{order}/fonepay/success', [PaymentController::class, 'fonepaySuccess'])->name('payment.fonepay.success');

    // Fail callback
    Route::get('/{order}/fonepay/fail', [PaymentController::class, 'fonepayFail'])->name('payment.fonepay.fail');
});
// Esewa / COD order confirmation
Route::get('/order/success/{order}', [OrderController::class, 'paymentSuccess'])->name('order.success');
Route::get('/order/fail/{order}', [OrderController::class, 'paymentFail'])->name('order.fail');
 Route::get('/profile', [ItemController::class, 'show'])->name('item.profile');
    Route::get('/profile/settings', [ItemController::class, 'profilesetting'])->name('pages-profile-settings');
    Route::post('/profile/settings/update', [AdminHomeController::class, 'updateProfile'])->name('profile.settings.update');
Route::put('/profile/picture/{user}', [AdminHomeController::class, 'updateProfilePicture'])
     ->name('profile.picture.update')
     ->middleware('auth','verified');
      Route::get('account/settings', [AccountController::class, 'accountSettings'])->name('account.settings');

    Route::post('account/address/save', [AccountController::class, 'saveAddress'])->name('account.address.save');
    Route::post('account/payment/save', [AccountController::class, 'savePayment'])->name('account.payment.save');
    Route::post('account/notifications/save', [AccountController::class, 'saveNotificationSettings'])->name('account.notifications.save');
    Route::post('account/theme/save', [AccountController::class, 'saveTheme'])->name('account.theme.save');
    Route::post('account/profile/update', [AccountController::class, 'updateProfile'])->name('account.profile.update');
});
    Route::prefix('api')->group(function () {
    require base_path('routes/api.php'); // Keep API routes separate
});



    Route::resource('mains', ItemController::class);


Route::get('/test-mail', function () {
    Mail::raw('This is a test email from Laravel using Gmail SMTP.', function ($message) {
        $message->to('mandalkrish47@gmail.com')->subject('SMTP Test');
    });
    return 'Mail sent!';
});
