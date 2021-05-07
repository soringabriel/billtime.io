<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\OrganizationService;
use App\Models\Organization;

class PlanExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates plan for organizations that have expired plans';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrganizationService $organizationService)
    {
        $this->organizationService = $organizationService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $organizations = Organization::whereNotNull('plan_expire')->where('plan_expire', '<=', now()->format('Y-m-d H:i:s'))->get();
        foreach ($organizations as $organization) {
            $next_plan = $organization->nextPlan()->first();
            $this->organizationService->update($organization, [
                'plan_id' => $organization->next_plan_id,
                'subusers_quota' => $next_plan->subusers_quota,
                'plan_expire' => null,
                'start_period' => false,
            ]);
        }
        return 0;
    }
}