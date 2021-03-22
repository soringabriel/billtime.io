<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\EditInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\UpdateInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\UpdateInvoiceStatusRequest;
use App\Http\Requests\Frontend\Invoice\DeleteInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\DownloadInvoiceRequest;
use App\Services\InvoiceService;
use App\Models\Invoice;
use LaravelDaily\Invoices\Invoice as LaravelInvoice;

/**
 * Class InvoiceController.
 */
class InvoiceController extends Controller
{
    /**
     * @var InvoiceService
     */
    protected $invoiceService;

    /**
     * InvoiceController constructor.
     *
     * @param  InvoiceService  $invoiceService
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.invoices.index');
    }

    /**
     * @return mixed
     */
    public function create()
    {
        return view('frontend.invoices.create')
                    ->withCurrencies(currencyToSymbol())
                    ->withClients(auth()->user()->clients()->get());
    }

    /**
     * @param  StoreInvoiceRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreInvoiceRequest $request)
    {
        $data = $request->validated();

        $laravelInvoice = $this->invoiceService->generateInvoice($data);

        $this->invoiceService->store($data);

        return redirect()->route('frontend.invoices.index')->withFlashSuccess(__('The invoice was successfully created.'));
    }
    
    /**
     * @param  EditInvoiceRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function edit(EditInvoiceRequest $request, Invoice $invoice)
    {
        return view('frontend.invoices.edit')
            ->withCurrencies(currencyToSymbol())
            ->withInvoice($invoice);
    }

    /**
     * @param  UpdateInvoiceRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $laravelInvoice = $this->invoiceService->generateInvoice($data);

        $this->invoiceService->update($invoice, $data);

        return redirect()->route('frontend.invoices.index')->withFlashSuccess(__('The invoice was successfully updated.'));
    }

    /**
     * @param  UpdateInvoiceStatusRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function updateStatus(UpdateInvoiceStatusRequest $request, Invoice $invoice)
    {
        $this->invoiceService->setStatus($invoice, $request->validated()['status']);

        return redirect()->route('frontend.invoices.index')->withFlashSuccess(__('The invoice was successfully updated.'));
    }

    /**
     * @param  DownloadInvoiceRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function download(DownloadInvoiceRequest $request, Invoice $invoice)
    {
        return $this->invoiceService->generateInvoice($invoice->toArray())->download();
    }

    /**
     * @param  DeleteInvoiceRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(DeleteInvoiceRequest $request, Invoice $invoice)
    {
        $this->invoiceService->destroy($invoice);

        return redirect()->route('frontend.invoices.index')->withFlashSuccess(__('The invoice was successfully deleted.'));
    }
}