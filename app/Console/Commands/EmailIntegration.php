<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Console\Command;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Http;
use App\Domains\Auth\Notifications\Frontend\Activity;
use App\Domains\Auth\Notifications\Frontend\InitialFeedback;
use App\Domains\Auth\Notifications\Frontend\OneMonthInactivity;
use App\Domains\Auth\Notifications\Frontend\OneWeekFeedback;
use App\Domains\Auth\Notifications\Frontend\TrialCancelation;
use App\Domains\Auth\Notifications\Frontend\TrialCancelationWarning;
use App\Domains\Auth\Notifications\Frontend\TimeReport;
use App\Http\Livewire\Frontend\TimeTable;
use Maatwebsite\Excel\Excel;

class EmailIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send marketing emails to users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = User::users()->get();
        foreach ($users as $user) {
            $organization = $user->organization()->first();
            $created_at = is_null($user->created_at) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
            $last_login_at = is_null($user->last_login_at) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $user->last_login_at);
            $organization_plan_expire = null;
            if (!is_null($organization)) {
                $organization_plan_expire = (is_null($organization->plan_expire) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $organization->plan_expire));
            }

            if (!is_null($created_at) && $created_at->addDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $user->notify(new InitialFeedback());
            }
            if (!is_null($created_at) && $created_at->addWeek()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $user->notify(new OneWeekFeedback());
            }
            if (!is_null($last_login_at) && $last_login_at->addMonth()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $user->notify(new OneMonthInactivity());
            }
            if (!is_null($organization_plan_expire) && $organization_plan_expire->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $user->notify(new TrialCancelation());
            }
            if (!is_null($organization_plan_expire) && $organization_plan_expire->subDays(3)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $user->notify(new TrialCancelationWarning());
            }
            if (!is_null($created_at) && $created_at->addDays(3)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $user->notify(new Activity());
            }
            if (!is_null($created_at) && $created_at->addDays(7)->format('Y-m-d') <= Carbon::now()->format('Y-m-d') && Carbon::now()->dayOfWeek == Carbon::FRIDAY) {
                $times = $user->times()->where('start_time', '>=', Carbon::now()->subDays(7))->orderBy('start_time')->get();
                $total_time = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
                foreach ($times as $time) {
                    $total_time->add(Carbon::createFromFormat('Y-m-d H:i:s', $time->end_time)->diffAsCarbonInterval(Carbon::createFromFormat('Y-m-d H:i:s', $time->start_time)));
                }
                $total_hours = $total_time->cascade()->hours + ($total_time->cascade()->minutes > 0 ? 1 : 0);    
                
                $time_xls = null;
                if ($total_hours > 0) {
                    $time_xls = new TimeTable();
                    $time_xls->mount(
                        $filtersEnabled = true, 
                        $customFiltersEnabled = true, 
                        $customFilters = json_encode([
                            'start' => Carbon::now()->subDays(7)
                        ]),
                        $filters = json_encode([
                            'User' => $user->name,
                        ]),
                        $isInvoice = false, 
                        $bulkActions = true,
                        $bulk = true,
                        $exports = true,
                        $preCheckedValues = "[]",
                        $user = $user
                    );
        
                    $class = config('laravel-livewire-tables.exports');
                    $time_xls = (new $class(
                        $time_xls->models(),
                        $time_xls->columns(),
                        $time_xls->exportCustomCells(),
                        $time_xls->exportColumnFormats(),
                        $time_xls->exportStyles(),
                    ))->raw(Excel::XLS);
                }

                $user->notify(new TimeReport($time_xls, ['total_hours' => $total_hours]));
            }
        }
        return 0;
    }
}