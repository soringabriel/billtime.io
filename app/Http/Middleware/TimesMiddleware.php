<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;
use App\Models\Time;

/**
 * Class TimesMiddleware.
 */
class TimesMiddleware
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
        $times = json_decode($request->input('times'));
        if (!is_null($times)) {
            foreach ($times as $time) {
                $time_model = Time::find($time);
                if ($time_model->user()->first()->id != $request->user()->id) {
                    return redirect()->route('frontend.time.index')->withFlashDanger(__("You don't have access to one of the Times selected."));
                }
            }
        }

        return $next($request);
    }
}