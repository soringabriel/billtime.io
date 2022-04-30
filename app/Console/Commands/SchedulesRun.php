<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use App\Models\Schedule;
use App\Domains\Auth\Models\User;
use App\Services\InvoiceService;
use App\Domains\Auth\Notifications\Frontend\ScheduleEmail;
use Notification;
use App\Http\Livewire\Frontend\TimeTable;
use Maatwebsite\Excel\Excel;

class SchedulesRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedules:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoices based on schedules';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $schedules = Schedule::where('schedule_trigger', Carbon::now()->day)->get();
        foreach ($schedules as $schedule) {
            $user = $schedule->user()->first();
            $project = $schedule->project()->first();

            $times = $project->times()->where('billed', 0)->orderBy('start_time')->get();
            $times_ids = $project->times()->where('billed', 0)->orderBy('start_time')->pluck('id')->toArray();
            $start_time = count($times_ids) > 0 ? Carbon::createFromFormat('Y-m-d H:i:s', $times[0]->start_time) : now();
            CarbonInterval::setCascadeFactors([
                'minute' => [60, 'seconds'],
                'hour' => [60, 'minutes'],
            ]);
            $total_time = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
            foreach ($times as $time) {
                $total_time->add(Carbon::createFromFormat('Y-m-d H:i:s', $time->end_time)->diffAsCarbonInterval(Carbon::createFromFormat('Y-m-d H:i:s', $time->start_time)));
            }
            $total_hours = $total_time->cascade()->hours + ($total_time->cascade()->minutes > 0 ? 1 : 0);

            $client = $project->client()->first();
            $organization = $schedule->organization()->first();
            $organization_owner = $organization->owner()->first();
            $previous_invoice = $organization->invoices()->orderBy('created_at', 'desc')->limit(1)->first();

            $time_xls = new TimeTable();
            $time_xls->mount(
                $filtersEnabled = true, 
                $customFiltersEnabled = true, 
                $customFilters = json_encode([
                    'start' => $start_time,
                    'billed' => 0
                ]),
                $filters = json_encode([
                    'Project' => $project->name,
                ]),
                $isInvoice = false, 
                $bulkActions = true,
                $bulk = true,
                $exports = true,
                $preCheckedValues = "[]",
                $user = $organization_owner
            );

            $class = config('laravel-livewire-tables.exports');
            $time_xls = (new $class(
                $time_xls->models(),
                $time_xls->columns(),
                $time_xls->exportCustomCells(),
                $time_xls->exportColumnFormats(),
                $time_xls->exportStyles(),
            ))->raw(Excel::XLS);

            $invoice = $this->invoiceService->store([
                'user_id' => $schedule->user_id,
                'number' => generateInvoiceNumber(is_null($previous_invoice) ? '0' : $previous_invoice->number),
                'buyer_company_name' => $client->company_name ?? 'Unknown',
                'buyer_tax_number' => $client->tax_number,
                'buyer_vat_number' => $client->vat_number,
                'buyer_address' => $client->address,
                'seller_company_name' => $organization->company_name ?? 'Unknown',
                'seller_tax_number' => $organization->tax_number,
                'seller_vat_number' => $organization->vat_number,
                'seller_address' => $organization->address,
                'seller_bank_name' => $organization->bank_name,
                'seller_bank_account' => $organization->bank_account,
                'services' => json_encode([
                    [
                        'name' => 'Services during ' . $start_time->format('d F Y') . ' - ' . now()->format('d F Y'),
                        'price' => $schedule->price_per_hour,
                        'total' => $total_hours * $schedule->price_per_hour - $schedule->discount,
                        'units' => 'Hours',
                        'discount' => $schedule->discount ?? 0,
                        'quantity' => $total_hours,
                    ]
                ]),
                'tax' => $schedule->tax,
                'shipping' => $schedule->shipping,
                'currency' => $schedule->price_currency,
                'price' => $total_hours * $schedule->price_per_hour - $schedule->discount,
                'date' => Carbon::now()->format('Y-m-d'),
                'notes' => $schedule->notes,
                'times' => json_encode($times_ids),
            ]);

            Notification::route('mail', [
                $organization_owner->email => $organization_owner->name,
                $user->email => $user->name
            ])->notify(new ScheduleEmail($this->invoiceService, $invoice, $time_xls, [
                'from' => 'info@billtime.io',
                'locale' => 'en',
                'name' => 'BillTime.io',
            ]));
        }
        return 0;
    }
}