<?php

namespace Bantenprov\DataAkademik\Http\Middleware;

use Closure;

/**
 * The DataAkademikMiddleware class.
 *
 * @package Bantenprov\DataAkademik
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class DataAkademikMiddleware
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
        return $next($request);
    }
}
