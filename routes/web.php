<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

//Controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RestorantController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;

//Models
use App\Models\User;
use App\Models\Product;
use App\Models\Restorant;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function() {
  if (auth()->user()) {
    if (auth()->user()->hasRole('Owner')) {
      return redirect(route('admin.dashboard'));
    } else {
      return redirect(route('guest.index'));
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

//Public Routes
Route::get('/products/filter/{id}', [ProductController::class, 'filter'])
  ->name('products.filter');
Route::get('/restorants/{restorant:slug}', [RestorantController::class, 'show'])
  ->name('restorants.show'); //restorantS.show for public
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order', [OrderController::class, 'checkin'])->name('orders.checkin');

// Guest routes
Route::group(['middleware' => ['auth', 'role:Guest'], 'prefix' => 'guest'], function () {
  Route::get('/dashboard', function() {
    return Inertia::render('views/guest/Dashboard');
  })->name('guest.dashboard');
  Route::get('/restorant', [RestorantController::class, 'index'])->name('guest.index');
  Route::post('/restorant', [RestorantController::class, 'store'])->name('restorant.store');
  Route::get('/settings', function() {
    return Inertia::render('views/guest/Settings');
  })->name('guest.settings');
  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('guest.user.update');

});



// DEBUGS
Route::get('/debug', function() {
  return Inertia::render('Debug');
})->name('debug');

Route::post('/debug/test', [DebugController::class, 'test'])->name('debug.test');

Route::post('/debug/upload', function(Request $request) {
  $path = $request->file('product_image')->store('imgs/product', 'public');
  return $path;
  // $url = Storage::url('public/imgs/product/default.png');
  return back();
});

Route::post('/debug', function() {
  $user = User::find(1);
  Auth::login($user);
  return redirect('/admin/dashboard');
})->name('debug.login');

//

//Owner Routes
Route::group(['middleware' => ['auth', 'role:Owner'], 'prefix' => 'admin'], function() {
  Route::resource('/products', ProductController::class);
  Route::resource('/categories', CategoryController::class);
  Route::resource('/areas', AreaController::class);
  Route::get('/dashboard', function() {
    if (auth()->user()->restorant) {
      return Inertia::render('views/admin/Dashboard');
    } else {
      return abort(403);
    }
  })->name('admin.dashboard');

  Route::get('/settings', function() {
    return Inertia::render('views/admin/Settings');
  })->name('admin.settings');

  Route::get('/restorant', [RestorantController::class, 'index'])->name('restorant.index');
  Route::get('/restorant/{restorant:uuid}', [RestorantController::class, 'show'])->name('restorant.show');
  Route::patch('/restorant/{restorant}', [RestorantController::class, 'update'])->name('restorant.update');


  Route::patch('/user/{user}', [RegisteredUserController::class, 'update'])->name('user.update');

});
