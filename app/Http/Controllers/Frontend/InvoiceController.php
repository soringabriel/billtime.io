<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Invoice\StoreInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\EditInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\UpdateInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\UpdateInvoiceStatusRequest;
use App\Http\Requests\Frontend\Invoice\DeleteInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\DownloadInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\CloneInvoiceRequest;
use App\Http\Requests\Frontend\Invoice\SendEmailRequest;
use App\Services\InvoiceService;
use App\Services\EmailService;
use App\Models\Invoice;
use LaravelDaily\Invoices\Invoice as LaravelInvoice;
use Illuminate\Support\Facades\Auth;
use Notification;
use App\Domains\Auth\Notifications\Frontend\InvoiceEmail;
use App\Http\Livewire\Frontend\TimeTable;
use Maatwebsite\Excel\Excel;

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
     * @var EmailService
     */
    protected $emailService;

    /**
     * InvoiceController constructor.
     *
     * @param  InvoiceService  $invoiceService
     * @param  EmailService    $emailService
     */
    public function __construct(InvoiceService $invoiceService, EmailService $emailService)
    {
        $this->invoiceService = $invoiceService;
        $this->emailService = $emailService;
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
                    ->withOrganization(auth()->user()->organization()->first());
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

        $result = $this->invoiceService->store($data);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

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

        $result = $this->invoiceService->update($invoice, $data);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

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
        $result = $this->invoiceService->setStatus($invoice, $request->validated()['status']);

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
                'model' => $result->apiProperties(),
            ]);
        }

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
        return $this->invoiceService->generateInvoice($invoice->toArray(), $request->validated()['locale'])->download();
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

        if (Auth::guard('api')->check()) {
            return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->route('frontend.invoices.index')->withFlashSuccess(__('The invoice was successfully deleted.'));
    }

    /**
     * @param  CloneInvoiceRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function clone(CloneInvoiceRequest $request, Invoice $invoice)
    {
        return view('frontend.invoices.clone')
            ->withCurrencies(currencyToSymbol())
            ->withOrganization(auth()->user()->organization()->first())
            ->withInvoice($invoice);
    }

    /**
     * @return mixed
     */
    public function getInvoices()
    {
        $invoices = [];
        if (auth()->user()->can('user.access.invoices.show-all')) {
            $invoices = Invoice::query()->whereIn('user_id', auth()->user()->organization()->first()->users()->pluck('id'))->get();
        } else {
            $invoices = Invoice::query()->where('user_id', auth()->user()->id)->get();
        }
        $result = [];
        foreach ($invoices as $invoice) {
            $result[] = $invoice->apiProperties();
        }
        return $result;
    }

    /**
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function get(Invoice $invoice)
    {
        return $invoice->apiProperties();
    }

    
    /**
     * @return \Illuminate\View\View
     */
    public function emails()
    {
        return view('frontend.invoices.emails');
    }

    /**
     * @param  SendEmailRequest  $request
     * @param  Invoice  $invoice
     *
     * @return mixed
     */
    public function sendEmail(SendEmailRequest $request, Invoice $invoice)
    {
        $data = $request->validated();

        $user = auth()->user();
        $organization = $user->organization()->first();
        $data['name'] = $organization->company_name ?? $user->name;
        $data['invoice_id'] = $invoice->id;
        $data['locale'] = $data['locale'] ?? config('app.locale');
        if (isset($data['attach_xls']) && $data['attach_xls']) {
            $time_xls = new TimeTable();
            $time_xls->mount(
                $filtersEnabled = true, 
                $customFiltersEnabled = true, 
                $customFilters = json_encode([
                    'invoice' => $invoice->id,
                ]),
                $filters = "[]",
                $isInvoice = false, 
                $bulkActions = true,
                $bulk = true,
                $exports = true,
                $preCheckedValues = "[]",
                $user = auth()->user(),
            );
    
            $class = config('laravel-livewire-tables.exports');
            $data['xls'] = (new $class(
                $time_xls->models(),
                $time_xls->columns(),
                $time_xls->exportCustomCells(),
                $time_xls->exportColumnFormats(),
                $time_xls->exportStyles(),
            ))->raw(Excel::XLS);
        }

        Notification::route('mail', $data['to'])->notify(new InvoiceEmail($this->invoiceService, $invoice, $data));

        $this->emailService->store($data);

        return view('frontend.invoices.emails');
    }
}