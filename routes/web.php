<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

//Controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestorantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SiteController;
use App\Http\Resources\RestorantResource;
use App\Models\Restorant;
use App\Http\Controllers\VariantController;
use App\Http\Resources\OrderResource;

//Models
use App\Models\User;
use App\Models\Order;


// Route::get('/', function () {
//   if (auth()->user()) {
//     if (auth()->user()->hasRole('Owner')) {
//       return redirect(route('admin.dashboard'));
//     } else {
//       return redirect(route('guest.restorant.create'));
//     }
//   } else {
//     return redirect(route('login'));
//   }
// });

Route::get('/', [FrontEndController::class, 'index'])->name('front');

//Language Routes
Route::get('language/{locale}', function($locale) {
  app()->setlocale($locale);
  session()->put('locale', $locale);
  return back();
})->name('lang');

require __DIR__ . '/auth.php';



// Public Routes
Route::post('/demo/login', function() {
  Auth::login(User::findOrFail(1));
  return back();
})->name('demo.login');
Route::get('/products/filter/{id}', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/restorants/{restorant:slug}', [FrontEndController::class, 'restorant'])->name('restorants.show'); //restorantS.show for public
Route::get('/order/{restorant}', [OrderController::class, 'checkin'])->name('orders.checkin');
Route::get('/order/status/{order}', [OrderController::class, 'orderStatus'])->middleware('order_device_check')->name('order.status');
Route::post('/checkout/{restorant:uuid}', [OrderController::class, 'store'])->name('orders.store');
Route::get('/terms-and-conditions', function() {
  return inertia('Terms');
})->name('terms');

Route::post('/pay/razorpay', [PaymentController::class, 'payWithRazorpay'])->name('pay.razorpay');
Route::post('/pay/stripelinks', [PaymentController::class, 'payWithStripeLinks'])->name('pay.stripelinks');
Route::get('/getSession',[PaymentController::class,'getSession']);
// Guest route's
Route::group(['middleware' => ['auth', 'role:Guest'], 'prefix' => 'guest'], function () {
  Route::inertia('/dashboard', 'views/guest/Dashboard')->name('guest.dashboard');
  Route::inertia('/settings', 'views/guest/Settings')->name('guest.settings');

  Route::get('/restorant', [RestorantController::class, 'create'])->name('guest.restorant.create');
  Route::post('/restorant', [RestorantController::class, 'store'])->name('guest.restorant.store');
  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('guest.user.update');
});



// DEBUGS
Route::get('/layout', function(){
  $restaurant = RestorantResource::make(Restorant::find(1));
  return inertia('Landing', compact('restaurant'));
});
Route::get('/debug/test', [DebugController::class, 'test'])->name('test');
Route::post('/debug/post', [DebugController::class, 'post'])->name('debug.post');
Route::get('/debug', function(){
  $restaurant = RestorantResource::make(Restorant::find(1));
  return inertia('Debug', compact('restaurant'));
});

Route::post('/debug', function () {
  $user = User::find(1);
  Auth::login($user);
  return redirect('/admin/dashboard');
})->name('debug.login');

//

// Owner Routes
Route::group(['middleware' => ['auth', 'role:Owner'], 'prefix' => 'admin'], function () {
  Route::inertia('/dashboard', 'views/admin/Dashboard')->name('admin.dashboard');
  Route::inertia('/settings', 'views/admin/Settings')->name('admin.settings');

  Route::resource('/products', ProductController::class);
  Route::resource('/categories', CategoryController::class);
  Route::resource('/areas', AreaController::class);
  Route::post('/variant/{product}', [VariantController::class, 'store'])->name('variant.store');
  Route::patch('/variant/{variant}', [VariantController::class, 'update'])->name('variant.update');
  Route::delete('/variant/{variant}', [VariantController::class, 'destroy'])->name('variant.destroy');

  Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
  Route::get('/order/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
  Route::post('/orders/update-status/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
  Route::post('/products/import', [ProductController::class, 'import'])->name('owner.products.import');
  Route::get('/restorant', [RestorantController::class, 'index'])->name('owner.restorant.index');
  Route::get('/restorant/share', [RestorantController::class, 'share'])->name('owner.restorant.share');
  Route::get('/restorant/location', [RestorantController::class, 'location'])->name('owner.restorant.location');
  Route::get('/restorant/apps', [RestorantController::class, 'apps'])->name('owner.restorant.apps');
  Route::get('/restorant/payments', [RestorantController::class, 'payments'])->name('owner.restorant.payments');
  Route::get('/restorant/smtp', [RestorantController::class, 'smtp'])->name('owner.restorant.smtp');
  Route::patch('/restorant/apps/update/{restorant}', [RestorantController::class, 'updateApps'])->name('owner.restorant.apps.update');
  Route::patch('/restorant/payments/update/{config}', [PaymentController::class, 'update'])->name('owner.restorant.payment.update');  
  Route::patch('/restorant/smtp/update/{restorant}', [RestorantController::class, 'updateSmtp'])->name('owner.restorant.smtp.update');  
  Route::get('/restorant/working-hours', [RestorantController::class, 'workingHours'])->name('owner.restorant.working-hours');
  Route::post('/restorant/update-working-hours/{restorant}', [RestorantController::class, 'updateWorkingHours'])->name('owner.restorant.update-working-hours');
  Route::post('/restorant/update-location/{restorant}', [RestorantController::class, 'setLocation'])->name('owner.restorant.update-location');
  Route::patch('/restorant/{restorant}', [RestorantController::class, 'update'])->name('owner.restorant.update');

  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('owner.user.update');

  // Site Routes
  Route::post('/site/google-maps', [SiteController::class, 'setGoogleMapsApi'])->name('site.set-google-maps-api');
});

// SuperAdmin Routes      coming soon...
