<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class UserIsNotOrganizationOwner.
 */
class UserIsNotOrganizationOwner
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
        if (!$request->route('user')->isOrganizationOwner()) {
            return $next($request);
        }
        
        return redirect()->route(homeRoute())->withFlashDanger(__("You don't have access to this model."));
    }
}