<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Http;

class SenderWorkflows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sender:workflows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calls sender workflows';

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
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiMTllYWQ3YzZkYjZmZDhiODMyMDRkYTU2MmEzMWJiMGM3Nzg1NDA5OGE0OGRhYzUyZGJjY2QwM2M3NWZjNzI3OGIxNzcwNTVhZDAwMzA1OTUiLCJpYXQiOiIxNjI1Mzk4NDUyLjY2NDAxOCIsIm5iZiI6IjE2MjUzOTg0NTIuNjY0MDI0IiwiZXhwIjoiNDc3OTAwMjA1Mi42NjE2ODYiLCJzdWIiOiI5OTk4MSIsInNjb3BlcyI6W119.Gp8lncM5F04ZvqVGJFpm7IctIANJFuxPjQt2Ssg31OTg_iMp0IVX4FysFHNdjcvfj6DmZeMh_QUCr-uLC6FPQQ";
        $users = User::users()->get();
        foreach ($users as $user) {
            $organization = $user->organization()->first();
            $workflows = [];

            $created_at = is_null($user->created_at) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at);
            $last_login_at = is_null($user->last_login_at) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $user->last_login_at);
            $organization_plan_expire = null;
            if (!is_null($organization)) {
                $organization_plan_expire = (is_null($organization->plan_expire) ? null : Carbon::createFromFormat('Y-m-d H:i:s', $organization->plan_expire));
            }

            if (!is_null($created_at) && $created_at->addDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $workflows[] = "epLy2e";
            }
            if (!is_null($created_at) && $created_at->addWeek()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $workflows[] = "egMlYb";
            }
            if (!is_null($last_login_at) && $last_login_at->addMonth()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $workflows[] = "e0DGve";
            }
            if (!is_null($organization_plan_expire) && $organization_plan_expire->subDay()->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $workflows[] = "e5KNBb";
            }
            if (!is_null($organization_plan_expire) && $organization_plan_expire->subDays(3)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $workflows[] = "axLK9a";
            }
            if (!is_null($created_at) && $created_at->addDays(3)->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                $workflows[] = "bqLz2a";
            }
        
            echo json_encode($workflows);
            foreach ($workflows as $workflow) {
                $start_workflow = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->post('https://api.sender.net/v2/workflows/' . $workflow . '/start', [
                    'email' => $user->email,
                ]);
            }
        }
        return 0;
    }
}