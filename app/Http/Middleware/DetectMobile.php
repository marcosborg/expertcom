<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Detection\MobileDetect;

class DetectMobile
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
        $detect = new MobileDetect();
        view()->share('isMobile', $detect->isMobile());
        return $next($request);
    }
}
