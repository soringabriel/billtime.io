<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use App\Models\Invoice;

/**
 * Class InvoiceBelongsToUserMiddleware.
 */
class InvoiceBelongsToUserMiddleware
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
        $invoice = Invoice::find($request->input('invoice_id'));
        if (!is_null($invoice)) {
            if ($invoice->user()->first()->id != $request->user()->id) {
                return redirect()->route('frontend.time.index')->withFlashDanger(__("You don't have access to the selected Invoice."));
            }
        }

        return $next($request);
    }
}