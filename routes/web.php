<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\PasswordUpdateController;
use App\Http\Controllers\agent\CategoryController;
use App\Http\Controllers\customer\CartController;
use App\Http\Controllers\customer\OrderController;
use App\Http\Controllers\customer\WishlistController;
use App\Http\Controllers\customer\UserProfileController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\agent\ProductController;
use App\Http\Controllers\seller\SellerController;
use App\Http\Controllers\agent\ServiceController;
use App\Http\Controllers\admin\NotificationController;
use App\Http\Controllers\customer\ServiceOrderController;
use App\Http\Controllers\customer\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrowserSessionController;
use App\Http\Controllers\agent\AgentController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
|
*/


// GUEST ROUTES (Anyone can view these pages, no need for controller)

Route::get('/about-us', function () {
    return view('about_us');
})->name('about_us');
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/products/search', [GuestController::class, 'searchProductsOrServices'])->name('search');
Route::get('/products/filter', [GuestController::class, 'filterProducts'])->name('products.filter');
Route::get('/categories', [GuestController::class, 'viewCategories'])->name('categories');
Route::get('/products/{cat_id?}', [GuestController::class, 'viewProducts'])->name('products');
Route::get('/products/details/{id}', [GuestController::class, 'showProduct'])->name('products.details');
Route::get('/seller/{id}/profile', [GuestController::class, 'showSellerProfile'])->name('seller.profile');
Route::get('/seller/{id}/profile/navigate-to-shop', [GuestController::class, 'navigateToShop'])->name('seller.profile.navigate');
Route::get('/services', [GuestController::class, 'viewServices'])->name('services');
Route::get('/services/{service}', [GuestController::class, 'showService'])->name('services.show');
// Get Locations Routes
Route::get('/regions', [LocationController::class, 'getRegions']);
Route::get('/districts/{regionId}', [LocationController::class, 'getDistricts']);
Route::get('/wards/{districtId}', [LocationController::class, 'getWards']);
Route::get('/streets/{wardId}', [LocationController::class, 'getStreets']);
// Google maps API
Route::get('/location', [LocationController::class, 'getLocation']);
// Update Password
Route::middleware('auth')->group(function () {
    Route::post('password/update', [PasswordUpdateController::class, 'update'])->name('custom.password.update');

    // NEAR SHOPS

    Route::get('/nearest-sellers', [GuestController::class, 'showMap'])->name('showMap');
    Route::get('/search-nearest-sellers', [GuestController::class, 'searchNearestSellers'])->name('searchNearestSellers');
    Route::get('/shop/{id}', [GuestController::class, 'show'])->name('shop.show');
});
// Customizing default jetstream routes
require_once __DIR__ . '/jetstream.php';


/****** CUSTOMER ROUTES ******/
Route::middleware([
    // 'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified',
    'customer'
])->prefix('customer')->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{id}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/totals', [CartController::class, 'getTotals'])->name('cart.totals');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/log-js-error', [CartController::class, 'logJSError'])->name('log.js.error');
    // Order Routes
    Route::get('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    // Wishlist Routes
    Route::get('wishlist', [WishlistController::class, 'showWishlist'])->name('wishlist.index');
    Route::post('wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    //REVIEWS
    Route::post('/product/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    // Services on customer side
    Route::get('/services', [ServiceOrderController::class, 'service'])->name('service.index');
    Route::post('/services/{service}/order', [ServiceOrderController::class, 'store'])->name('services.order');
    Route::get('/service/orders/{serviceOrder}', [ServiceOrderController::class, 'service_orders'])->name('service-orders.show');
    Route::delete('/service/orders/{serviceOrder}', [ServiceOrderController::class, 'destroy'])->name('service-orders.destroy');

    // Profile
    Route::post('/update-profile', [UserProfileController::class, 'updateAccountDetails'])->name('update-account-details');
    Route::put('/{user}/location', [UserProfileController::class, 'updateLocation'])->name('profile.updateLocation');

    // Subscribe to shop/service
    Route::post('/sellers/{seller}/subscribe', [UserProfileController::class, 'subscribe'])->name('subscribe.seller');
    Route::delete('/sellers/{seller}/unsubscribe', [UserProfileController::class, 'unsubscribe'])->name('unsubscribe.seller');
});


/****** SELLER ROUTES ******/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'seller'
])->prefix('seller')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    Route::get('/customers', [SellerController::class, 'customers'])->name('seller.customers');


    //REVIEWS
    Route::get('/reviews', [SellerController::class, 'reviews'])->name('seller.reviews');
    // seller view all orders via this controller
    Route::get('/orders', [SellerController::class, 'view_orders'])->name('seller.orders.index');
    Route::get('/seller/service-orders', [ServiceController::class, 'serviceOrdes'])->name('service-orders');

    // Settings
    Route::get('/profile-settings', [SellerController::class, 'profileDetailsSettings'])->name('user.settings.profile-details');
    Route::post('/update-profile', [SellerController::class, 'updateSellerDetails'])->name('update-user-details');
    Route::put('/{user}/location', [SellerController::class, 'updateSellerLocation'])->name('update-seller-location');
    Route::delete('/permanent-delete-my-account', [SellerController::class, 'deleteSellerAccount'])->name('seller-account.destroy');
    Route::delete('/remove-my-location', [SellerController::class, 'removeSellerLocation'])->name('seller-location.destroy');
    Route::get('/profile-settings', [SellerController::class, 'profileDetailsSettings'])->name('seller.settings.profile-details');
    Route::post('/update-profile', [SellerController::class, 'updateSellerDetails'])->name('update-seller-details');
    Route::delete('/remove-profile-picture', [SellerController::class, 'removeProfilePicture'])->name('remove-seller-profile-picture');
});


/****** ADMIN ROUTES ******/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'admin'
])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/manage-agents', [AdminController::class, 'manage_agents'])->name('admin.agents.manage');
    Route::get('/manage-agents/register', [AdminController::class, 'show_agent_form'])->name('admin.agents.register');
    Route::post('/manage-agents/register', [AdminController::class, 'register_agent'])->name('admin.agents.register-action');
    Route::get('/manage-agents/edit/{id}', [AdminController::class, 'show_agent_form'])->name('admin.agents.edit');
    Route::put('/manage-agents/update/{id}', [AdminController::class, 'update_agent'])->name('admin.agents.update');
    Route::put('/manage-agents/update/{id}/status', [AdminController::class, 'update_agent_status'])->name('admin.agents.status');
    Route::delete('/manage-agents/delete/{id}', [AdminController::class, 'delete_agent'])->name('admin.agents.delete');

    Route::get('/manage-sellers/requests/approved', [AdminController::class, 'showApprovedRequests'])->name('admin.sellers.approved');
    Route::get('/manage-sellers/requests/pending', [AdminController::class, 'showPendingRequests'])->name('admin.sellers.pending');
    Route::get('/manage-sellers/requests/declined', [AdminController::class, 'showDeclinedRequests'])->name('admin.sellers.declined');
    Route::post('/manage-sellers/requests/{sellerRequest}/handle', [AdminController::class, 'handleSellerRequest'])->name('admin.handle.seller.request');
    Route::get('/manage-sellers/requests/review/{id}', [AdminController::class, 'showSellerDetails'])->name('admin.sellers.review');

    Route::put('/manage-sellers/{id}/status', [AdminController::class, 'update_seller_status'])->name('status_seller');
    Route::delete('/manage-sellers/{id}', [AdminController::class, 'delete_seller'])->name('delete_seller');
    Route::get('/sellers-list', [AdminController::class, 'sellers_list'])->name('admin.sellers.list');
    Route::get('/customers-list', [AdminController::class, 'customers_list'])->name('admin.customers.list');
    Route::get('/profile-settings', [AdminController::class, 'profileDetailsSettings'])->name('admin.settings.profile-details');
    Route::post('/update-profile', [AdminController::class, 'updateAdminDetails'])->name('update-admin-details');
    Route::delete('/remove-profile-picture', [AdminController::class, 'removeProfilePicture'])->name('remove-admin-profile-picture');

    // ADMIN PRODUCT APROVAL
    Route::get('admin/products/approval', [AdminController::class, 'productRequestApproval'])->name('admin.products.approval');
    Route::get('products/approval/{id}/review', [AdminController::class, 'reviewProduct'])->name('admin.products.approval.review');
    Route::post('admin/products/approval/{id}/approve', [AdminController::class, 'approve'])->name('admin.products.approval.approve');
    Route::post('admin/products/approval/{id}/reject', [AdminController::class, 'reject'])->name('admin.products.approval.reject');
    Route::get('/admin/rejected-products', [AdminController::class, 'showRejectedProducts'])->name('admin.rejected.products');
    Route::get('admin/products/approved', [AdminController::class, 'viewApprovedProducts'])->name('admin.products.approved');


    //ADMIN SERVICE APPROVAL
    // Admin views pending service requests
    Route::get('/admin/service-requests', [AdminController::class, 'viewPendingService'])->name('admin.service.requests');
    Route::post('/admin/service-requests/{id}/approve', [AdminController::class, 'approveService'])->name('admin.service.requests.approve');
    Route::post('/admin/service-requests/{id}/reject', [AdminController::class, 'rejectService'])->name('admin.service.requests.reject');
    Route::get('/admin/service-requests/{id}/review', [AdminController::class, 'reviewServiceRequest'])->name('admin.service.requests.review');
    Route::get('/admin/approved-services', [AdminController::class, 'viewApprovedServices'])->name('admin.approvedServices');
    Route::get('/admin/declined-services', [AdminController::class, 'viewDeclinedServices'])->name('admin.declinedServices');


    //notifications
    Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notifications');
});


/****** AGENT ROUTES ******/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'agent'
])->prefix('agent')->group(function () {

    //Dashboard
    Route::get('/agent/sellers', [AgentController::class, 'viewSellers'])->name('agent.sellers');

    Route::get('/agent/products', [AgentController::class, 'view_product_service'])->name('agent.products');

    Route::get('/agent/pending-approvals', [AgentController::class, 'viewPendingApprovals'])->name('agent.pending-approvals');

    // home
    Route::get('/dashboard', [AgentController::class, 'index'])->name('agent.dashboard');
    Route::get('/categories', [CategoryController::class, 'index'])->name('agent.categories.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('agent.categories.create');
    Route::post('/add-category', [CategoryController::class, 'store'])->name('agent.categories.store');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('agent.categories.edit');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('agent.categories.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('agent.categories.delete');
    Route::get('/profile-settings', [AgentController::class, 'profileDetailsSettings'])->name('agent.settings.profile-details');
    Route::post('/update-profile', [AgentController::class, 'updateAgentDetails'])->name('update-agent-details');
    Route::delete('/remove-profile-picture', [AdminController::class, 'removeProfilePicture'])->name('remove-agent-profile-picture');


    //PRODUCTS
    //Route::resource('products', ProductController::class);
    Route::get('/products/create/{user_id}', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}/update', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/approved', [ProductController::class, 'viewApprovedProducts'])->name('agent.products.approved');
    Route::get('/agent/rejected-products', [AgentController::class, 'showRejectedProducts'])->name('agent.rejected.products');
    Route::get('agent/products/pending', [AgentController::class, 'productRequestApproval'])->name('agent.products.pending');

    //MANAGING SELLER

    Route::get('/sellers', [AgentController::class, 'manage_sellers'])->name('manage_sellers');
    Route::get('/sellers/new', [AgentController::class, 'create'])->name('create_seller');
    Route::post('/sellers/store', [AgentController::class, 'storeSeller'])->name('store_seller');
    Route::get('/sellers/edit/{id}', [AgentController::class, 'editSeller'])->name('edit_seller');
    Route::put('/sellers/{id}', [AgentController::class, 'updateSeller'])->name('update_seller');
    Route::delete('/sellers/delete/{id}', [AgentController::class, 'deleteSeller'])->name('delete_seller');
    Route::delete('/sellers/delete/{id}/request', [AgentController::class, 'deleteSellerRequest'])->name('delete_seller_request');

    Route::patch('/sellers/update/{id}/cover-images', [AgentController::class, 'updateShopCoverImages'])->name('update_shop_cover_images');

    Route::get('/sellers/approved', [AgentController::class, 'showApprovedRequests'])->name('approved_sellers');
    Route::get('/sellers/pending', [AgentController::class, 'showPendingRequests'])->name('pending_sellers');
    Route::get('/sellers/declined', [AgentController::class, 'showDeclinedRequests'])->name('declined_sellers');
    Route::get('/sellers/requests/view/{id}', [AgentController::class, 'view_seller_request'])->name('view_seller_request');

    Route::get('/sellers/approved/{id}/view', [AgentController::class, 'viewApprovedSeller'])->name('view_seller');

    //services on seller page
    Route::get('/services/home-page', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create/{user_id}', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services/store', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
    Route::get('/agent/service-requests', [ServiceController::class, 'viewPendingService'])->name('agent.service.requests');
    route::get('/agent/approved-services', [ServiceController::class, 'viewApprovedServices'])->name('agent.approvedServices');
    Route::get('/agent/declined-services', [ServiceController::class, 'viewDeclinedServices'])->name('agent.declinedServices');
});



/**************************COMMON ROUTES FOR ADMIN, AGENT & SELLER************************/

Route::group(['middleware' => ['checkRole:0,1,2']], function () {
    //documentation
    Route::get('/documentation', [SellerController::class, 'documentation'])->name('documentation');

    // ALL COMMON ROUTES HERE

});
