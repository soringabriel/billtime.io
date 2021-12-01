<?php

namespace App\Models\Traits\Method;

use App\Models\Time;
use Carbon\Carbon;
use Carbon\CarbonInterval;

/**
 * Trait OrganizationMethod.
 */
trait OrganizationMethod
{
    /**
     * @return bool
     */
    public function hasCompanyDetails(): bool
    {
        return !is_null($this->company_name) ||
            !is_null($this->tax_number) ||
            !is_null($this->vat_number) ||
            !is_null($this->address) ||
            !is_null($this->bank_name) ||
            !is_null($this->bank_account);
    }

    /**
     * @return array
     */
    public function getTimesChartData(): array
    {
        $organization_users = $this->users()->pluck('id')->toArray();        
        $times = Time::whereIn('user_id', $organization_users)->orderBy('start_time')->get();
        $daily = [];
        $monthly = [];
        CarbonInterval::setCascadeFactors([
            'minute' => [60, 'seconds'],
            'hour' => [60, 'minutes'],
        ]);
        foreach ($times as $time) {
            $start_time_carbon = Carbon::createFromFormat('Y-m-d H:i:s', $time->start_time);
            $end_time_carbon = Carbon::createFromFormat('Y-m-d H:i:s', $time->end_time);
            if (isset($daily[$start_time_carbon->format('M j')])) {
                $daily[$start_time_carbon->format('M j')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            } else {
                $daily[$start_time_carbon->format('M j')] = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
                $daily[$start_time_carbon->format('M j')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            }
            if (isset($monthly[$start_time_carbon->format('M Y')])) {
                $monthly[$start_time_carbon->format('M Y')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            } else {
                $monthly[$start_time_carbon->format('M Y')] = CarbonInterval::create(0, 0, 0, 0, 0, 0, 0, 0);
                $monthly[$start_time_carbon->format('M Y')]->add($end_time_carbon->diffAsCarbonInterval($start_time_carbon));
            }
        }

        foreach ($daily as $key => $value) {
            $value = $value->cascade();
            $daily[$key] = number_format($value->hours + ($value->minutes / 100), 2);
        }

        foreach ($monthly as $key => $value) {
            $value = $value->cascade();
            $monthly[$key] = number_format($value->hours + ($value->minutes / 100), 2);
        }

        $daily = array_slice($daily, -30, 30);
        $monthly = array_slice($monthly, -12, 12);

        return [
            'daily' => $daily,
            'monthly' => $monthly,
        ];
    }

    /**
     * @return array
     */
    public function getOrganizationTimeSources(): array
    {
        $result = [];
        $organization_users = $this->users()->get();
        foreach ($organization_users as $user) {
            $times = Time::where('user_id', $user->id)->orderBy('start_time')->get();
            $result[$user->email] = [];
            foreach ($times as $time) {
                $result[$user->email][] = [
                    'title' => $time->project()->first()->name . ' - ' . substr($time->details, 0, 50) . (strlen($time->details) > 0 ? '...' : ''),
                    'start' => $time->start_time,
                    'end' => $time->end_time,
                    'color' => $time->billed ? '#ffed4a' : '#38c172',
                    'extendedProps' => [
                        'project' => $time->project()->first()->name,
                        'task' => $time->task,
                        'details' => $time->details,
                        'billed' => $time->billed,
                        'edit_url' => route('frontend.time.edit', $time),
                        'delete_url' => route('frontend.time.destroy', $time),
                    ]
                ];
            }
        }
        return $result;
    }

    /**
     * @return Carbon
     */
    public function getPlanExpireCarbon(): Carbon
    {
        if (!is_null($this->plan_expire)) {
            return Carbon::createFromFormat('Y-m-d H:i:s', $this->plan_expire);
        }
        return null;
    }
}
