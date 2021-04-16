<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;

/**
 * Class SubuserMiddleware.
 */
class SubuserMiddleware
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
        $user = $request->route('user');
        if (is_null($user)) {
            $user = $request->route('deletedUser');
        }
        if ($request->user()->id == $user->organization()->first()->owner_id) {
            return $next($request);
        }
        
        return redirect()->route('frontend.user.subuser.index')->withFlashDanger(__("You don't have access to this User."));
    }
}