<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class ModelBelongsToUserOrganization.
 */
class ModelBelongsToUserOrganization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $parameter)
    {
        if ($request->user()->organization()->first()->id == $request->route($parameter)->organization()->first()->id) {
            return $next($request);
        }
        
        return redirect()->route(homeRoute())->withFlashDanger(__("You don't have access to this model."));
    }
}