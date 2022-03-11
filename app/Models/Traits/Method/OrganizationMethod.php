<?php

namespace App\Models\Traits\Method;

use App\Models\Time;
use App\Models\Invoice;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\View\ComponentAttributeBag;

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
    public function getInvoicesChartData(): array
    {
        $invoices = Invoice::whereIn('user_id', $this->users()->pluck('id'))->get();
        $daily = [];
        $monthly = [];
        $all_labels_daily = [];
        $all_labels_monthly = [];
        foreach ($invoices as $invoice) {
            $date = Carbon::createFromFormat('Y-m-d', $invoice->date);
            $currency = $invoice->currency;

            $all_labels_daily[] = $date->format('M j');
            $all_labels_monthly[] = $date->format('M Y');
            
            if (isset($daily[$currency]) && isset($daily[$currency][$date->format('M j')])) {
                $daily[$currency][$date->format('M j')] += $invoice->price;
            } else {
                if (!isset($daily[$currency])) {
                    $daily[$currency] = [];
                }
                $daily[$currency][$date->format('M j')] = $invoice->price;
            }
            if (isset($monthly[$currency]) && isset($monthly[$currency][$date->format('M Y')])) {
                $monthly[$currency][$date->format('M Y')] += $invoice->price;
            } else {
                if (!isset($monthly[$currency])) {
                    $monthly[$currency] = [];
                }
                $monthly[$currency][$date->format('M Y')] = $invoice->price;
            }
        }

        foreach ($daily as $currency => $dates) {
            $new_val = [];
            foreach ($all_labels_daily as $label) {
                $new_val[$label] = isset($dates[$label]) ? $dates[$label] : 0;
            }
            $daily[$currency] = $new_val;
        }

        foreach ($monthly as $currency => $dates) {
            $new_val = [];
            foreach ($all_labels_monthly as $label) {
                $new_val[$label] = isset($dates[$label]) ? $dates[$label] : 0;
            }
            $monthly[$currency] = $new_val;
        }

        return [
            'organizationInvoicesPerDay' => $daily,
            'organizationInvoicesPerMonth' => $monthly,
        ];
    }

    /**
     * @return array
     */
    public function getTimesChartData(): array
    {
        $organization_users = $this->users()->pluck('id')->toArray();        
        $times = Time::whereIn('user_id', $organization_users)->where('start_time', '>=', now()->subYear()->toDateTimeString())->orderBy('start_time')->get();
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
        $users = auth()->user()->can('user.access.times.show-all') ? $organization_users : [auth()->user()];
        foreach ($users as $user) {
            $times = $user->times()->orderBy('start_time')->get();
            $result[$user->email] = [];
            foreach ($times as $time) {
                $result[$user->email][] = [
                    'title' => $time->project()->first()->name . ' - ' . substr($time->details, 0, 50) . (strlen($time->details) > 50 ? '...' : ''),
                    'start' => $time->start_time,
                    'end' => $time->end_time,
                    'color' => $time->billed ? '#ffed4a' : '#38c172',
                    'extendedProps' => [
                        'start' => $time->start_time,
                        'end' => $time->end_time,
                        'timezone' => auth()->user()->timezone,
                        'project' => $time->project()->first()->name,
                        'task' => $time->task,
                        'details' => $time->details,
                        'billed' => $time->billed,
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
