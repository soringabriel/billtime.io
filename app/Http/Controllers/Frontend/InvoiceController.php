<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\EditInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\UpdateInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\DeleteInvoiceRequest;
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
        return view('frontend.invoices.create');
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

        $data['price'] = $laravelInvoice->total_amount;

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

        $data['price'] = $laravelInvoice->total_amount;

        $this->invoiceService->update($invoice, $data);

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
        return $this->invoiceService->generateInvoice($invoice)->download();
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