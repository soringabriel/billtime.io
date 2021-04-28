<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class SubusersQuotaMiddleware.
 */
class SubusersQuotaMiddleware
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
        $organization = auth()->user()->organization()->first();
        if ($organization->subusers_quota == -1 || $organization->subusers_quota > $organization->users()->where('id', '<>', $organization->owner_id)->get()->count()) {
            return $next($request);
        }
        
        return redirect()->route('frontend.user.subuser.index')->withFlashDanger(__("You organization reached the subusers quota limit."));
    }
}