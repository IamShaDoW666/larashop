<?php
namespace App\Http\Middleware;
use App\Http\Resources\groceryResource;
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
    if(!file_exists(storage_path('installed'))) {
      return [];
    }
    $authArray = !$request->user() ? [] : [
      'auth' => [
        'user' => $request->user(),
        'role' => $request->user()->roles()->first()->name,
      ],
    ];
    $pusherArray = [];
    if (str_contains($request->fullUrl(), config('app.url') . '/admin') || str_contains($request->fullUrl(), config('app.url') . '/order')) {
      if (str_contains($request->fullUrl(), '/dashboard')) {
        $authArray = !$request->user() ? [] : [
          'auth' => [
            'user' => $request->user(),
            'grocery' => $request->user()->grocery ? groceryResource::make($request->user()->grocery->load('config')->append(['counts', 'salesCount'])) : null,
            'role' => $request->user()->roles()->first()->name,
          ],
        ];
      } else {
        $authArray = !$request->user() ? [] : [
          'auth' => [
            'user' => $request->user(),
            'grocery' => $request->user()->grocery ? $request->user()->grocery->load('config') : null,
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
        'available_languages' => config('global.available_lang'),
        'url' => config('app.url'),
        'timezone' => config('app.timezone')
      ],

      'ziggy' => function () {
        return (new Ziggy)->toArray();
      },

      'impersonate' => function () {
        return auth()->user() ? auth()->user()->Impersonating() : false;
      }

    ]);
  }
}
