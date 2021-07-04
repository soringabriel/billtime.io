<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Http;

class SenderIntegration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sender:integration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates and updates users in sender.net';

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
            if (!is_null($organization)) {
                $times = $user->times()->get();
                $invoices = $user->invoices()->get();
                $plan = $organization->plan()->first();
                $next_plan = $organization->nextPlan()->first();
                $retrieve_sender = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->get('https://api.sender.net/v2/subscribers/by_email/' . $user->email);
                if (!$retrieve_sender->successful() || (isset($retrieve_sender->body()->success) && !$retrieve_sender->body()->success)) {
                    $create_sender = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ])->post('https://api.sender.net/v2/subscribers', [
                        'email' => $user->email,
                        'firstname' => $user->name,
                        'fields' => [
                            '{$organization_id}' => $organization->id,
                            '{$organization_owner}' => $user->id == $organization->owner_id,
                            '{$organization_plan}' => $plan->name,
                            '{$organization_next_plan}' => $next_plan->name,
                            '{$organization_plan_expire}' => $organization->plan_expire,
                            '{$number_of_times}' => count($times),
                            '{$number_of_invoices}' => count($invoices),
                            '{$can_access_times}' => $user->can('user.access.times.access'),
                            '{$can_create_invoice}' => $user->can('user.access.invoices.create'),
                            '{$timezone}' => $user->timezone,
                            '{$is_verified}' => $user->isVerified(),
                            '{$created_at}' => $user->created_at,
                        ]
                    ]);
                } else {
                    $sender_id = json_decode($retrieve_sender->body())->data->id;
                    $update_sender = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $token,
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ])->patch('https://api.sender.net/v2/subscribers/' . $sender_id, [
                        'firstname' => $user->name,
                        'fields' => [
                            '{$organization_id}' => $organization->id,
                            '{$organization_owner}' => $user->id == $organization->owner_id,
                            '{$organization_plan}' => $plan->name,
                            '{$organization_next_plan}' => $next_plan->name,
                            '{$organization_plan_expire}' => $organization->plan_expire,
                            '{$number_of_times}' => count($times),
                            '{$number_of_invoices}' => count($invoices),
                            '{$can_access_times}' => $user->can('user.access.times.access'),
                            '{$can_create_invoice}' => $user->can('user.access.invoices.create'),
                            '{$timezone}' => $user->timezone,
                            '{$is_verified}' => $user->isVerified(),
                            '{$created_at}' => $user->created_at,
                        ]
                    ]);
                }
            }
        }
        return 0;
    }
}