<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
  /**
  * The root template that is loaded on the first page visit.
  *
  * @var string
  */
  protected $rootView = 'app';

  /**
  * Determine the current asset version.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return string|null
  */
  public function version(Request $request)
  {
    return parent::version($request);
  }

  /**
  * Define the props that are shared by default.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return array
  */
  public function share(Request $request)
  {
    return array_merge(parent::share($request), [
      'flash' => [
        'message' => session('message')
      ],

      'app' => [
        'locale' => config('app.locale'),
        'faker_locale' => config('app.faker_locale')
      ],

      'auth' => [
        'user' => $request->user() ?? '',
        'restorant' => $request->user() ? $request->user()->restorant->load('config') : null,
        'role' => $request->user() ? $request->user()->roles()->first()->name : null,
      ],

      'ziggy' => function () {
        return (new Ziggy)->toArray();
      },

    ]);
  }
}
