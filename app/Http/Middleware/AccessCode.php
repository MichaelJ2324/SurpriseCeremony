<?php

namespace App\Http\Middleware;

use Closure;

class AccessCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $code = $request->session()->get('accessCode');
        if (!isset($code) || strtoupper($code) !== 'RUSSELL2017') {
            return redirect('/');

        }
        return $next($request);
    }
}
