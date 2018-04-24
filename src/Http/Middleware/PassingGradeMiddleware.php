<?php namespace Bantenprov\PassingGrade\Http\Middleware;

use Closure;

/**
 * The PassingGradeMiddleware class.
 *
 * @package Bantenprov\PassingGrade
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PassingGradeMiddleware
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
