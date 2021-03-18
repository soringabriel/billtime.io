<?php

namespace App\Services;

use LaravelDaily\Invoices\Invoice as LaravelInvoice;
use LaravelDaily\Invoices\Classes\Party;
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
        $data['times'] = json_decode($data['times']);

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
                    'seller_bank_account' => $data['seller_bank_account'],
                    'services' => $data['services'],
                    'tax' => $data['tax'],
                    'shipping' => ($data['shipping'] ?? null),
                    'currency' => $data['currency'],
                    'price' => $data['price'],
                    'date' => $data['date'],
                    'due_date' => ($data['due_date'] ?? null),
                    'notes' => $data['notes'],
                ]
            );
            $invoice->times()->sync($data['times'] ?? []);
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException($e->getMessage().__('There was a problem creating the Invoice.'));
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
        $data['times'] = json_decode($data['times']);

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
                    'seller_bank_account' => $data['seller_bank_account'],
                    'services' => $data['services'],
                    'tax' => $data['tax'],
                    'shipping' => ($data['shipping'] ?? null),
                    'currency' => $data['currency'],
                    'price' => $data['price'],
                    'date' => $data['date'],
                    'due_date' => ($data['due_date'] ?? null),
                    'notes' => $data['notes'],
                    'status' => (Carbon::createFromFormat('Y-m-d', $data['due_date'])->isPast() ? Invoice::STATUS_PAST_DUE : Invoice::STATUS_PENDING),
                ]
            );
            $invoice->times()->sync($data['times'] ?? []);
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
     * @param  Invoice  $invoice
     * @param  string  $status
     *
     * @return Invoice
     * @throws GeneralException
     * @throws \Throwable
     */
    public function setStatus(Invoice $invoice, string $status): Invoice
    {
        DB::beginTransaction();

        try {
            $invoice->update(
                [
                    'status' => $status,
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            throw new GeneralException(__('There was a problem updating the Invoice.'));
        }

        event(new InvoiceUpdated($invoice));

        DB::commit();

        return $invoice;
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
                'bank name' => $invoice_data['seller_bank_name'],
                'bank account' => $invoice_data['seller_bank_account'],
            ],
        ]);

        $items = [];
        $services = json_decode($invoice_data['services']);
        foreach ($services as $service) {
            $items[] = (new InvoiceItem())
                            ->title($service->name)
                            ->pricePerUnit($service->price)
                            ->quantity($service->quantity)
                            ->discount($service->discount)
                            ->units($service->units);
        }

        $notes = implode("<br>", explode("\r\n", $invoice_data['notes']));

        $sequence = (int) filter_var($invoice_data['number'], FILTER_SANITIZE_NUMBER_INT);
        $series = str_replace($sequence, "", $invoice_data['number']);

        $invoice = LaravelInvoice::make()
                    ->series($series)
                    ->sequence($sequence)
                    ->serialNumberFormat('{SERIES}{SEQUENCE}')
                    ->seller($seller)
                    ->buyer($buyer)
                    ->date(Carbon::createFromFormat('Y-m-d', $invoice_data['date']))
                    ->dateFormat('M j, Y')
                    ->currencySymbol(currencyToSymbol($invoice_data['currency']))
                    ->currencyCode($invoice_data['currency'])
                    ->currencyFormat('{SYMBOL}{VALUE}')
                    ->currencyThousandsSeparator('.')
                    ->currencyDecimalPoint(',')
                    ->taxRate($invoice_data['tax'])
                    ->addItems($items)
                    ->notes($notes);

        if (isset($invoice_data['due_date']) && !is_null($invoice_data['due_date'])) {
            $invoice->payUntilDays(Carbon::createFromFormat('Y-m-d', $invoice_data['due_date'])->diffInDays(Carbon::createFromFormat('Y-m-d', $invoice_data['date'])));
        }

        if (isset($invoice_data['shipping']) && !is_null($invoice_data['shipping'])) {
            $invoice->shipping($invoice_data['shipping']);
        }

        return $invoice;
    }
}