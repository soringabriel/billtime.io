<?php

namespace App\Services;

use LaravelDaily\Invoices\Invoice as LaravelInvoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use App\Events\Invoice\InvoiceCreated;
use App\Events\Invoice\InvoiceDeleted;
use App\Events\Invoice\InvoiceUpdated;
use App\Models\Invoice;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

/**
 * Class InvoiceService.
 */
class InvoiceService extends BaseService
{
    /**
     * InvoiceService constructor.
     *
     * @param  Invoice  $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    /**
     * @param  array  $data
     *
     * @return Invoice
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): Invoice
    {
        DB::beginTransaction();

        try {
            $invoice = $this->model::create(
                [
                    'user_id' => ($data['user_id'] ?? auth()->id()),
                    'number' => $data['number'],
                    'buyer_company_name' => $data['buyer_company_name'],
                    'buyer_tax_number' => $data['buyer_tax_number'],
                    'buyer_vat_number' => $data['buyer_vat_number'],
                    'buyer_address' => $data['buyer_address'],
                    'seller_company_name' => $data['seller_company_name'],
                    'seller_tax_number' => $data['seller_tax_number'],
                    'seller_vat_number' => $data['seller_vat_number'],
                    'seller_address' => $data['seller_address'],
                    'services' => $data['services'],
                    'tax' => $data['tax'],
                    'shipping' => $data['shipping'],
                    'currency' => $data['currency'],
                    'price' => $data['price'],
                    'date' => $data['date'],
                    'due_date' => $data['due_date'],
                    'notes' => $data['notes'],
                ]
            );
            $time->times()->sync($data['times'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem creating the Invoice.'));
        }

        event(new InvoiceCreated($invoice));

        DB::commit();

        return $invoice;
    }

    /**
     * @param  Invoice  $invoice
     * @param  array  $data
     *
     * @return Invoice
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update(Invoice $invoice, array $data = []): Invoice
    {
        DB::beginTransaction();

        try {
            $invoice->update(
                [
                    'user_id' => ($data['user_id'] ?? auth()->id()),
                    'number' => $data['number'],
                    'buyer_company_name' => $data['buyer_company_name'],
                    'buyer_tax_number' => $data['buyer_tax_number'],
                    'buyer_vat_number' => $data['buyer_vat_number'],
                    'buyer_address' => $data['buyer_address'],
                    'seller_company_name' => $data['seller_company_name'],
                    'seller_tax_number' => $data['seller_tax_number'],
                    'seller_vat_number' => $data['seller_vat_number'],
                    'seller_address' => $data['seller_address'],
                    'services' => $data['services'],
                    'tax' => $data['tax'],
                    'shipping' => $data['shipping'],
                    'currency' => $data['currency'],
                    'price' => $data['price'],
                    'date' => $data['date'],
                    'due_date' => $data['due_date'],
                    'notes' => $data['notes'],
                ]
            );
            $time->times()->sync($data['times'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Invoice.'));
        }

        event(new InvoiceUpdated($invoice));

        DB::commit();

        return $invoice;
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return bool
     * @throws GeneralException
     */
    public function destroy(Invoice $invoice): bool
    {
        if ($this->deleteById($invoice->id)) {
            event(new InvoiceDeleted($invoice));

            return true;
        }

        throw new GeneralException(__('There was a problem deleting the Invoice.'));
    }
    
    /**
     * @param  array  $invoice_data
     *
     * @return LaravelInvoice
     * @throws GeneralException
     */
    public function generateInvoice(array $invoice_data): LaravelInvoice
    {
        $buyer = new Party([
            'name' => $invoice_data['buyer_company_name'],
            'address' => $invoice_data['buyer_address'],
            'custom_fields' => [
                'tax number' => $invoice_data['buyer_tax_number'],
                'vat number' => $invoice_data['buyer_vat_number'],
            ],
        ]);
        $seller = new Party([
            'name' => $invoice_data['seller_company_name'],
            'address' => $invoice_data['seller_address'],
            'custom_fields' => [
                'tax number' => $invoice_data['seller_tax_number'],
                'vat number' => $invoice_data['seller_vat_number'],
            ],
        ]);

        $items = [];
        $services = json_decode($invoice_data['services']);
        foreach ($services as $service) {
            $items[] = (new InvoiceItem())
                            ->title($service['name'])
                            ->pricePerUnit($service['price'])
                            ->quantity($service['quantity'])
                            ->discount($service['discount'])
                            ->units($service['units']);
        }

        $notes = implode("<br>", explode("\r\n", $invoice_data['notes']));

        $sequence = (int) filter_var($data['number'], FILTER_SANITIZE_NUMBER_INT);
        $series = str_replace($sequence, "", $data['number']);

        return LaravelInvoice::make()
            ->series($series)
            ->sequence($sequence)
            ->serialNumberFormat('{SERIES}{SEQUENCE}')
            ->seller($seller)
            ->buyer($buyer)
            ->date($data['date'])
            ->dateFormat('M j, Y')
            ->payUntilDays(Carbon::createFromFormat('Y-m-d', $data['due_date'])->diffInDays(Carbon::createFromFormat('Y-m-d', $data['date'])))
            ->currencySymbol(currencyToSymbol($data['currency']))
            ->currencyCode($data['currency'])
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator('.')
            ->currencyDecimalPoint(',')
            ->taxRate($data['tax'])
            ->shipping($data['shipping'])
            ->addItems($items)
            ->notes($notes);
    }
}