<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PromoCardController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\SocialMediaLinkController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\Store\CheckoutController;
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

require base_path('routes/store.php');

// Reports what this deployment is running and what it is connected to, so
// "the site has not changed" can be diagnosed without guessing.
Route::get('/__status', \App\Http\Controllers\StatusController::class);

// Migrates and seeds from inside the running site — the path that works even
// when the build image has no PHP binary. Hidden unless SETUP_TOKEN is set,
// and excluded from CSRF because it is reached with a token, not a session.
Route::match(['get', 'post'], '/__setup', \App\Http\Controllers\SetupController::class)
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// Admin login route (separate from customer login)
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('login');

// Redirect /login to customer login to avoid confusion
Route::get('/login', function () {
    return redirect()->route('customer.login');
});

// Public registration is disabled: accounts in the users table are staff
// accounts and must only be created by an existing admin or the installer.
Auth::routes(['register' => false]);

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    /* Dashboard */
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    /* Categiries */
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/data', [CategoryController::class, 'getCategories'])->name('categories.data');
    Route::post('/admin/categories/update-status', [CategoryController::class, 'updateCategoryStatus'])->name('categories.updateStatus');

    /* Products */
    Route::resource('products', ProductController::class)->except(['show']);
    Route::post('products/data', [ProductController::class, 'getProducts'])->name('products.data');
    Route::post('admin/products/updateStatus', [ProductController::class, 'updateStatus'])->name('products.updateStatus');

    /* Brands */
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('admin/brands/getdata', [BrandController::class, 'getData'])->name('brands.getData');
    Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::delete('brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::post('brands/update-status', [BrandController::class, 'updateStatus'])->name('brands.updateStatus');

    /* change Language */
    Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('change.language');

    /* Menus */
    Route::resource('menus', MenuController::class);
    Route::post('menus/data', [MenuController::class, 'getData'])->name('menus.data');
    Route::resource('menus.items', MenuItemController::class)->shallow();
    Route::get('menus-items', [MenuItemController::class, 'index'])->name('menus.item.index');
    Route::post('menus-items/getdata', [MenuItemController::class, 'getData'])->name('menus.item.getData');

    /* Banners */
    Route::resource('banners', BannerController::class);
    Route::post('banners/data', [BannerController::class, 'getData'])->name('banners.data');
    Route::put('/banners/toggle-status/{id}', [BannerController::class, 'toggleStatus'])->name('banners.toggleStatus');
    Route::post('/banners/update-status', [BannerController::class, 'updateStatus'])->name('banners.updateStatus');

    /* Promo Cards */
    Route::resource('promo-cards', PromoCardController::class);
    Route::post('promo-cards/update-status', [PromoCardController::class, 'updateStatus'])->name('promo-cards.updateStatus');

    /* Social Media Links */
    Route::resource('social-media-links', SocialMediaLinkController::class);
    Route::post('social-media-links/data', [SocialMediaLinkController::class, 'getData'])->name('social-media-links.data');

    /* Orders */
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::patch('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/data', [OrderController::class, 'getData'])->name('orders.data');

    /* Coupons */
    Route::resource('coupons', CouponController::class);

    /* Product Variants */
    Route::resource('product_variants', ProductVariantController::class);
    Route::post('/product_variants/data', [ProductVariantController::class, 'getData'])->name('product_variants.data');

    /* Customers */
    Route::resource('customers', CustomerController::class);
    Route::get('admin/customers/data', [CustomerController::class, 'getCustomerData'])->name('customers.data');

    /* Reviews */
    Route::get('/reviews/data', [ProductReviewController::class, 'getData'])->name('reviews.data');
    Route::resource('reviews', ProductReviewController::class)->except(['create', 'store']);

    /* Attributes */
    Route::resource('attributes', AttributeController::class);

    /* Attribute Value Management */
    Route::post('attributes/{attribute}/values', [AttributeController::class, 'storeValue'])->name('attributes.values.store');
    Route::delete('values/{value}', [AttributeController::class, 'destroyValue'])->name('values.destroy');
    Route::post('attributes/data', [AttributeController::class, 'getAttributesData'])->name('attributes.data');

    /* Attribute Value Translations Management */
    Route::post('values/{value}/translations', [AttributeController::class, 'storeTranslation'])->name('values.translations.store');
    Route::delete('translations/{translation}', [AttributeController::class, 'destroyTranslation'])->name('translations.destroy');

    /* Vendors */
    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/data', [VendorController::class, 'getVendorData'])->name('vendors.data');
    Route::delete('vendors/{id}', [VendorController::class, 'destroy'])->name('vendors.destroy');
    Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('vendors', [VendorController::class, 'store'])->name('vendors.store');

    /* Pages */
    Route::resource('pages', PageController::class);
    Route::post('pages/update-status', [PageController::class, 'updatePageStatus'])->name('pages.updateStatus');
    Route::post('pages/data', [PageController::class, 'data'])->name('pages.data');

    /* Shipping Zones - Temporarily Commented Out */
    // Route::resource('shipping-zones', Admin\ShippingZoneController::class);
    // Route::post('shipping-zones/data', [Admin\ShippingZoneController::class, 'getData'])->name('shipping-zones.data');
    // Route::post('shipping-zones/toggle-status', [Admin\ShippingZoneController::class, 'toggleStatus'])->name('shipping-zones.toggle-status');

    /* payments */
    Route::get('payments/get-data', [PaymentController::class, 'getData'])->name('payments.getData');
    Route::resource('payments', PaymentController::class)->only(['index', 'destroy', 'show']);

    /* Refunds */
    Route::get('refunds', [RefundController::class, 'index'])->name('refunds.index');
    Route::get('refunds/data', [RefundController::class, 'getData'])->name('refunds.getData');
    Route::delete('refunds/{refund}', [RefundController::class, 'destroy'])->name('refunds.destroy');
    Route::get('refunds/{refund}', [RefundController::class, 'show'])->name('refunds.show');

    /* Payment Gateways */
    Route::get('payment-gateways', [PaymentGatewayController::class, 'index'])->name('payment-gateways.index');
    Route::get('payment-gateways/data', [PaymentGatewayController::class, 'getData'])->name('payment-gateways.getData');
    Route::get('payment-gateways/{paymentGateway}/edit', [PaymentGatewayController::class, 'edit'])->name('payment-gateways.edit');
    Route::put('payment-gateways/{paymentGateway}', [PaymentGatewayController::class, 'update'])->name('payment-gateways.update');
    Route::delete('payment-gateways/{paymentGateway}', [PaymentGatewayController::class, 'destroy'])->name('payment-gateways.destroy');

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /* Newsletter Subscribers */
    Route::get('subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('subscribers/{id}', [SubscriberController::class, 'destroy'])->name('subscribers.destroy');
    Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
    Route::patch('subscribers/{id}/status', [SubscriberController::class, 'updateStatus'])->name('subscribers.update-status');
    Route::get('subscribers/compose', [SubscriberController::class, 'compose'])->name('subscribers.compose');
    Route::post('subscribers/send', [SubscriberController::class, 'send'])->name('subscribers.send');

    /* Site Settings */
    Route::get('site-settings', [SiteSettingsController::class, 'index'])->name('site-settings.index');
    Route::get('site-settings/edit', [SiteSettingsController::class, 'edit'])->name('site-settings.edit');
    Route::put('site-settings/update', [SiteSettingsController::class, 'update'])->name('site-settings.update');
    Route::post('site-settings/theme', [SiteSettingsController::class, 'updateTheme'])->name('site-settings.theme.update');
});

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
// PayPal success callback
Route::get('/checkout/paypal/success', [CheckoutController::class, 'paypalSuccess'])
    ->name('paypal.success');
// PayPal cancel callback
Route::get('/checkout/paypal/cancel', [CheckoutController::class, 'paypalCancel'])
    ->name('paypal.cancel');

/* Notification Dismiss */
Route::post('/notification/dismiss', function() {
    session(['notification_dismissed' => true]);
    return response()->json(['success' => true]);
})->name('notification.dismiss');
