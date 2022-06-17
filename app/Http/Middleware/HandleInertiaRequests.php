<?php

namespace App\Http\Middleware;

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
    if (str_contains($request->fullUrl(), config('app.url') . '/admin')) {
      $authArray = !$request->user() ? [] : [
        'auth' => [
          'user' => $request->user(),
          'restorant' => $request->user()->restorant ? $request->user()->restorant->load('config') : null,
          'role' => $request->user()->roles()->first()->name,
        ],
      ];

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
