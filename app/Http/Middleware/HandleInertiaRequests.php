<?php

namespace App\Http\Middleware;

use App\Http\Resources\RestorantResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use phpDocumentor\Reflection\Types\Parent_;
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
    $authArray = !$request->user() ? [] : [
      'auth' => [
        'user' => $request->user(),
        'role' => $request->user()->roles()->first()->name,
      ],
    ];
    $pusherArray = [];
    if (str_contains($request->fullUrl(), config('app.url') . '/admin') || str_contains($request->fullUrl(), config('app.url') . '/order')) {
      if (str_contains($request->fullUrl(), '/settings') || str_contains($request->fullUrl(), '/dashboard') || ($request->fullUrl() == config('app.url') . '/admin/restorant')) {
        $authArray = !$request->user() ? [] : [
          'auth' => [
            'user' => $request->user(),
            'restorant' => $request->user()->restorant ? RestorantResource::make($request->user()->restorant->load('config')->append(['counts', 'salesCount'])) : null,
            'role' => $request->user()->roles()->first()->name,
          ],
        ];
      } else {
        $authArray = !$request->user() ? [] : [
          'auth' => [
            'user' => $request->user(),
            'restorant' => $request->user()->restorant ? $request->user()->restorant->load('config') : null,
            'role' => $request->user()->roles()->first()->name,
          ],
        ];
      }

      $pusherArray = !$request->user() ? [] : [
        'pusher' => config('pusher')
      ];
    }


    return array_merge(parent::share($request), $authArray, $pusherArray, [
      'flash' => [
        'message' => session('message')
      ],

      'app' => [
        'locale' => config('app.locale'),
        'faker_locale' => config('app.faker_locale'),
        'url' => config('app.url'),
        'timezone' => config('app.timezone')
      ],

      'ziggy' => function () {
        return (new Ziggy)->toArray();
      },

    ]);
  }
}
