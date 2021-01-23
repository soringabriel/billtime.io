<?php

namespace App\Listeners;

use App\Events\Invoice\InvoiceCreated;
use App\Events\Invoice\InvoiceDeleted;
use App\Events\Invoice\InvoiceUpdated;

/**
 * Class InvoiceEventListener.
 */
class InvoiceEventListener
{
    /**
     * @param $event
     */
    public function onCreated($event)
    {
        activity('invoice')
            ->performedOn($event->invoice)
            ->withProperties([
                'invoice' => [
                    'number' => $event->invoice->number,
                    'buyer_company_name' => $event->invoice->buyer_company_name,
                    'buyer_tax_number' => $event->invoice->buyer_tax_number,
                    'buyer_vat_number' => $event->invoice->buyer_vat_number,
                    'buyer_address' => $event->invoice->buyer_address,
                    'seller_company_name' => $event->invoice->seller_company_name,
                    'seller_tax_number' => $event->invoice->seller_tax_number,
                    'seller_vat_number' => $event->invoice->seller_vat_number,
                    'seller_address' => $event->invoice->seller_address,
                    'services' => $event->invoice->services,
                    'tax' => $event->invoice->tax,
                    'currency' => $event->invoice->currency,
                    'price' => $event->invoice->price,
                    'date' => $event->invoice->date,
                    'due_date' => $event->invoice->due_date,
                    'notes' => $event->invoice->notes,
                ],
            ])
            ->log(':causer.name created invoice :subject.number');
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        activity('invoice')
            ->performedOn($event->invoice)
            ->withProperties([
                'invoice' => [
                    'number' => $event->invoice->number,
                    'buyer_company_name' => $event->invoice->buyer_company_name,
                    'buyer_tax_number' => $event->invoice->buyer_tax_number,
                    'buyer_vat_number' => $event->invoice->buyer_vat_number,
                    'buyer_address' => $event->invoice->buyer_address,
                    'seller_company_name' => $event->invoice->seller_company_name,
                    'seller_tax_number' => $event->invoice->seller_tax_number,
                    'seller_vat_number' => $event->invoice->seller_vat_number,
                    'seller_address' => $event->invoice->seller_address,
                    'services' => $event->invoice->services,
                    'tax' => $event->invoice->tax,
                    'currency' => $event->invoice->currency,
                    'price' => $event->invoice->price,
                    'date' => $event->invoice->date,
                    'due_date' => $event->invoice->due_date,
                    'notes' => $event->invoice->notes,
                ],
            ])
            ->log(':causer.name updated invoice :subject.number');
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        activity('invoice')
            ->performedOn($event->invoice)
            ->log(':causer.name deleted invoice :subject.number');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            InvoiceCreated::class,
            'App\Listeners\InvoiceEventListener@onCreated'
        );

        $events->listen(
            InvoiceUpdated::class,
            'App\Listeners\InvoiceEventListener@onUpdated'
        );

        $events->listen(
            InvoiceDeleted::class,
            'App\Listeners\InvoiceEventListener@onDeleted'
        );
    }
}