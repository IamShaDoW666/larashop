<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
//Controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GroceryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TableController;
use App\Http\Resources\GroceryResource;
use App\Models\Grocery;
use App\Http\Controllers\VariantController;
use App\Http\Resources\OrderResource;
use App\Models\User;
use App\Models\Order;

Route::get('/', [FrontEndController::class, 'index'])->name('front');
//Language Routes
Route::get('language/{locale}', function ($locale) {
  app()->setlocale($locale);
  session()->put('locale', $locale);
  return back();
})->name('lang')->middleware('inertia');
require __DIR__ . '/auth.php';
Route::middleware('inertia')->group(function () {
  Route::post('/demo/login', function () {
    Auth::login(User::findOrFail(1));
    return back();
  })->name('demo.login');
  Route::get('/products/filter/{id}', [ProductController::class, 'filter'])->name('products.filter');
  Route::get('/grocerys/{grocery:slug}', [FrontEndController::class, 'grocery'])->name('grocerys.show'); //groceryS.show for public
  Route::get('/order/{grocery}', [OrderController::class, 'checkin'])->name('orders.checkin');
  Route::get('/order/status/{order}', [OrderController::class, 'orderStatus'])->middleware('order_device_check')->name('order.status');
  Route::post('/checkout/{grocery:uuid}', [OrderController::class, 'store'])->name('orders.store');
  Route::get('/terms-and-conditions', function () {
    return inertia('Terms');
  })->name('terms');
  Route::post('/pay/razorpay', [PaymentController::class, 'payWithRazorpay'])->name('pay.razorpay');
  Route::get('/getSession', [PaymentController::class, 'getSession']);
});
// Guest route's
Route::group(['middleware' => ['impersonate', 'auth', 'role:Guest', 'inertia'], 'prefix' => 'guest'], function () {
  Route::inertia('/dashboard', 'views/guest/Dashboard')->name('guest.dashboard');
  Route::inertia('/settings', 'views/guest/Settings')->name('guest.settings');
  Route::get('/grocery', [groceryController::class, 'create'])->name('guest.grocery.create');
  Route::post('/grocery', [groceryController::class, 'store'])->name('guest.grocery.store');
  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('guest.user.update');
});
// DEBUGS
Route::get('/layout', function () {
  $store = groceryResource::make(grocery::find(1));
  return inertia('Landing', compact('store'));
});
Route::get('/debug/test', [DebugController::class, 'test'])->name('test');
Route::post('/debug/post', [DebugController::class, 'post'])->name('debug.post');
Route::get('/debug', function () {
  $store = groceryResource::make(grocery::find(1));
  return inertia('Debug', compact('store'));
});
Route::post('/debug', function () {
  $user = User::find();
  dd($user);
  Auth::login($user);
  return redirect('/admin/dashboard');
})->name('debug.login');

// Owner Routes
Route::group(['middleware' => ['impersonate', 'auth', 'role:Owner', 'inertia'], 'prefix' => 'admin'], function () {
  Route::inertia('/dashboard', 'views/admin/Dashboard')->name('admin.dashboard');
  Route::inertia('/settings', 'views/admin/Settings')->name('admin.settings');
  Route::resource('/products', ProductController::class);
  Route::resource('/categories', CategoryController::class);
  Route::resource('/areas', AreaController::class);
  Route::resource('/tables', TableController::class);
  Route::get('/tables/qrcode/{table}', [TableController::class, 'qrcode'])->name('tables.qrcode');
  Route::post('/variant/{product}', [VariantController::class, 'store'])->name('variant.store');
  Route::patch('/variant/{variant}', [VariantController::class, 'update'])->name('variant.update');
  Route::delete('/variant/{variant}', [VariantController::class, 'destroy'])->name('variant.destroy');
  Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
  Route::get('/order/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
  Route::post('/orders/update-status/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
  Route::post('/products/import', [ProductController::class, 'import'])->name('owner.products.import');
  Route::get('/grocery', [groceryController::class, 'index'])->name('owner.grocery.index');
  Route::get('/grocery/share', [groceryController::class, 'share'])->name('owner.grocery.share');
  Route::get('/grocery/location', [groceryController::class, 'location'])->name('owner.grocery.location');
  Route::get('/grocery/apps', [groceryController::class, 'apps'])->name('owner.grocery.apps');
  Route::get('/grocery/plan', [groceryController::class, 'plan'])->name('owner.grocery.plan.show');
  Route::post('/grocery/plan/pay/razorpay', [PaymentController::class, 'payPlanWithRazorpay'])->name('owner.grocery.plan.pay.razorpay');
  Route::post('/grocery/plan/buy/{grocery}', [PaymentController::class, 'buyPlan'])->name('owner.grocery.plan.buy');
  Route::get('/grocery/payments', [groceryController::class, 'payments'])->name('owner.grocery.payments');
  Route::get('/grocery/smtp', [groceryController::class, 'smtp'])->name('owner.grocery.smtp');
  Route::patch('/grocery/apps/update/{grocery}', [groceryController::class, 'updateApps'])->name('owner.grocery.apps.update');
  Route::patch('/grocery/payments/update/{config}', [PaymentController::class, 'update'])->name('owner.grocery.payment.update');
  Route::patch('/grocery/smtp/update/{grocery}', [groceryController::class, 'updateSmtp'])->name('owner.grocery.smtp.update');
  Route::get('/grocery/working-hours', [groceryController::class, 'workingHours'])->name('owner.grocery.working-hours');
  Route::post('/grocery/update-working-hours/{grocery}', [groceryController::class, 'updateWorkingHours'])->name('owner.grocery.update-working-hours');
  Route::post('/grocery/update-location/{grocery}', [groceryController::class, 'setLocation'])->name('owner.grocery.update-location');
  Route::patch('/grocery/{grocery}', [groceryController::class, 'update'])->name('owner.grocery.update');
  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('owner.user.update');
  Route::post('/site/google-maps', [SiteController::class, 'setGoogleMapsApi'])->name('site.set-google-maps-api');
  Route::post('/stop-impersonate', [GroceryController::class, 'stopImpersonate'])->name('stopimpersonate');
});

// SuperAdmin Routes      coming soon...
Route::group(['middleware' => ['auth', 'role:SuperAdmin', 'inertia'], 'prefix' => 'super'], function () {
  Route::name('super.')->group(function () {
    Route::get('/dashboard', function () {
      $groceries = Grocery::all();

      return inertia('views/super/Dashboard', compact('groceries'));
    })->name('dashboard');
    Route::inertia('/settings', 'views/super/Settings')->name('settings');
    Route::resource('/groceries', GroceryController::class);
    Route::post('/groceries/assign-plan/{grocery}', [GroceryController::class, 'assignPlan'])->name('groceries.assignPlan');
    Route::post('/groceries/remove-plan/{grocery}', [GroceryController::class, 'removePlan'])->name('groceries.removePlan');
    Route::post('/loginShow', [GroceryController::class, 'loginShow'])->name('loginShow');
    Route::get('/orders', [OrderController::class, 'orderShow'])->name('orderShow');
    Route::resource('/plans', PlanController::class);
  });
});

Route::get('/ses', function () {
  dd(session()->all(), auth()->user());
})->middleware('impersonate');
