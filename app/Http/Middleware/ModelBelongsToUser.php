<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class ModelBelongsToUser.
 */
class ModelBelongsToUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $parameter, $permission = null)
    {
        if (!is_null($permission) && $request->user()->can($permission)) {
            return $next($request);
        }
        
        if ($request->user()->id == $request->route($parameter)->user()->first()->id) {
            return $next($request);
        }
        
        return redirect()->route(homeRoute())->withFlashDanger(__("You don't have access to this model."));
    }
}