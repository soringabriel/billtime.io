<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class ProjectMiddleware.
 */
class ProjectMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->id == $request->route('project')->user()->first()->id) {
            return $next($request);
        }
        
        return redirect()->route('frontend.project.index')->withFlashDanger(__("You don't have access to this Project."));
    }
}