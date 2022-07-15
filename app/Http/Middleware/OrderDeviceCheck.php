<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class OrderDeviceCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('order_token')) {
            return abort(403, 'Access Denied');
        }
        $arr = explode('/', $request->url());
        if (Crypt::decrypt(session('order_token')) == end($arr)) {
            return $next($request);
        }
        return abort(403, 'Access Denied');
    }
}
