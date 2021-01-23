<?php

namespace App\Events\Invoice;

use App\Models\Invoice;
use Illuminate\Queue\SerializesModels;

/**
 * Class InvoiceCreated.
 */
class InvoiceCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $invoice;

    /**
     * @param $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
}
