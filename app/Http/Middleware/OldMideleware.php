<?php

namespace App\Http\Middleware;

use Closure;

class OldMideleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $weight, $height)
    {        
        if ($request->input('age') <= 200) {
            return redirect('tasks');
        }
        
        if ($weight == 100 && $height == 100) {
            return redirect('/');
        }
        
        return $next($request);
    }
}
