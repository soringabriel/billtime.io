<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class ParentUserMiddleware.
 */
class ParentUserMiddleware
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
        if (auth()->user()->isOrganizationOwner()) {
            return $next($request);
        }
        
        return redirect()->route('frontend.index')->withFlashDanger(__("You don't have access to this page."));
    }
}