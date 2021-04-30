<?php

namespace App\Models\Traits\Method;

use App\Models\Plan;
use Illuminate\Support\HtmlString;

/**
 * Trait PlanMethod.
 */
trait PlanMethod
{
    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->id == env('DEFAULT_PLAN');
    }

    /**
     * @return bool
     */
    public function isBiggest(): bool
    {
        return is_null(Plan::where('price', '>', $this->price)->first());
    }

    /**
     * @return HtmlString
     */
    public function getButton(Plan $plan, Plan $nextPlan): HtmlString
    {
        $organization = auth()->user()->organization()->first();
        if ($plan->id == $nextPlan->id) {
            if ($this->id == $plan->id) {
                return new HtmlString('<a class="btn btn-secondary">' . __('Current') . '</a>');
            }
            if ($this->price > $plan->price) {   
                // To do either paylink either upgrade link based on if the plan is default or not
                if ($plan->isDefault()) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.dashboard')) // Todo - Congratulations page
                        ->withMetadata(['plan_id' => $this->id])
                        ->trialDays($this->trial_days)
                        ->create(
                            [
                                'prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'title' => $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                            ]
                        );
                    return new HtmlString('<a href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-primary" data-theme="none">' . __('Upgrade') . '</a>');
                } else {
                    return new HtmlString('<a class="btn btn-primary">' . __('Upgrade') . '</a>');
                }
            }
            if ($this->price < $plan->price) { 
                // To do downgrade link  
                return new HtmlString('<a class="btn btn-danger">' . __('Downgrade') . '</a>');
            }
        } else {
            if ($this->id == $plan->id) {   
                return new HtmlString('<a class="btn btn-success">' . __('Cancel Downgrade') . '</a>');
            }
            if ($this->id == $nextPlan->id) {   
                return new HtmlString('<a class="btn btn-secondary">' . __('Starting on next billing') . '</a>');
            }
            if (($this->price < $nextPlan->price) || ($this->price > $nextPlan->price && $this->price < $plan->price)) {   
                // To do downgrade link  
                return new HtmlString('<a class="btn btn-primary">' . __('Downgrade') . '</a>');
            }
            if ($this->price > $plan->price) {   
                // To do upgrade link
                return new HtmlString('<a class="btn btn-primary">' . __('Upgrade') . '</a>');
            }
        }
    }
}
