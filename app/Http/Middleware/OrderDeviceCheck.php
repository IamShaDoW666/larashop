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
        // Grant for restaurant owner
        if ($request->user()->hasRole('Owner')) {
            return $next($request);
        }

        //Abort if no token
        if (!session('order_token')) {
            return abort(403, 'Access Denied');
        }

        // Grant for ordered customer
        $arr = explode('/', $request->url());
        if (Crypt::decrypt(session('order_token')) == end($arr)) {
            return $next($request);
        }
        return abort(403, 'Access Denied');
    }
}
