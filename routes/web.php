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
use App\Http\Controllers\SiteController;
//Models
use App\Models\User;
use App\Models\Category;

use Cknow\Money\Currency;
use Cknow\Money\Money;



Route::get('/', function() {
  if (auth()->user()) {
    if (auth()->user()->hasRole('Owner')) {
      return redirect(route('admin.dashboard'));
    } else {
      return redirect(route('guest.restorant.create'));
    }
  } else {
    return redirect(route('login'));
  }
});


require __DIR__.'/auth.php';

// Route::get('/dashboard', function () {
//     $restorants = Restorant::all();
//     return Inertia::render('Dashboard', compact('restorants'));
// })->middleware(['auth', 'verified'])->name('dashboard');

// Public Routes
Route::get('/products/filter/{id}', [ProductController::class, 'filter'])->name('products.filter');
Route::get('/restorants/{restorant:slug}', [RestorantController::class, 'show'])->name('restorants.show'); //restorantS.show for public
Route::get('/order/{restorant}', [OrderController::class, 'checkin'])->name('orders.checkin');
Route::post('/checkout/{restorant:uuid}', [OrderController::class, 'store'])->name('orders.store');

// Guest routes
Route::group(['middleware' => ['auth', 'role:Guest'], 'prefix' => 'guest'], function () {
  Route::inertia('/dashboard', 'views/guest/Dashboard')->name('guest.dashboard');
  Route::inertia('/settings', 'views/guest/Settings')->name('guest.settings');
  
  Route::get('/restorant', [RestorantController::class, 'create'])->name('guest.restorant.create');
  Route::post('/restorant', [RestorantController::class, 'store'])->name('guest.restorant.store');
  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('guest.user.update');

});



// DEBUGS
Route::get('/debug', [DebugController::class, 'debug'])->name('debug');

Route::post('/debug/post', [DebugController::class, 'post'])->name('debug.post');

Route::post('/debug', function() {
  $user = User::find(1);
  Auth::login($user);
  return redirect('/admin/dashboard');
})->name('debug.login');

//

// Owner Routes
Route::group(['middleware' => ['auth', 'role:Owner'], 'prefix' => 'admin'], function() {
  Route::inertia('/dashboard', 'views/admin/Dashboard')->name('admin.dashboard');
  Route::inertia('/settings', 'views/admin/Settings')->name('admin.settings');
  
  Route::resource('/products', ProductController::class);
  Route::resource('/categories', CategoryController::class);
  Route::resource('/areas', AreaController::class);

  Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders');
  Route::post('/orders/update-status/{order}', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

  Route::get('/restorant', [RestorantController::class, 'index'])->name('owner.restorant.index');
  Route::get('/restorant/share', [RestorantController::class, 'share'])->name('owner.restorant.share');
  Route::get('/restorant/location', [RestorantController::class, 'location'])->name('owner.restorant.location');
  Route::get('/restorant/working-hours', [RestorantController::class, 'workingHours'])->name('owner.restorant.working-hours');
  Route::post('/restorant/update-working-hours/{restorant}', [RestorantController::class, 'updateWorkingHours'])->name('owner.restorant.update-working-hours');
  Route::post('/restorant/update-location/{restorant}', [RestorantController::class, 'setLocation'])->name('owner.restorant.update-location');
  Route::patch('/restorant/{restorant}', [RestorantController::class, 'update'])->name('owner.restorant.update');

  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('owner.user.update');

  // Site Routes
  Route::post('/site/google-maps', [SiteController::class, 'setGoogleMapsApi'])->name('site.set-google-maps-api');

});

// SuperAdmin Routes      coming soon...

