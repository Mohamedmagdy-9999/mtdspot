<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Supplier
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('supplier')->user()) {
            return $next($request);
        }
        if ($request->ajax()) {
            abort(403, 'Unauthorized.');
        } else {
            return redirect()->route('signin');
        }
    }
}
