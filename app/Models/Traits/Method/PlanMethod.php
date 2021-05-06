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
        $organization_subscription = $organization->subscription('default');
        if ($plan->id == $nextPlan->id) {
            if ($this->id == $plan->id) {
                return new HtmlString('<a class="btn btn-secondary">' . __('Current') . '</a>');
            }
            if ($this->price > $plan->price) {   
                if ($plan->isDefault() || is_null($organization_subscription)) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.subscription.confirmation'))
                        ->withMetadata(['plan_id' => $this->id])
                        ->create(
                            [
                                'prices' => [
                                    is_null($organization->subscription('default')) ? 'USD:0' : $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'title' => $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                                'customer_email' => auth()->user()->email,
                            ]
                        );
                    return new HtmlString('<a href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-primary" data-theme="none">' . __('Upgrade') . '</a>');
                } else {
                    return new HtmlString('<a name="confirm-item" data-overrirde-message="' . __('Are you sure you want to do this?') . '<br><br>' . __('You will be charged') . ' ' . $this->price . ' ' . $this->currency . '" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-primary">' . __('Upgrade') . '</a>');
                }
            }
            if ($this->price < $plan->price) { 
                return new HtmlString('<a name="confirm-item" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-danger">' . __('Downgrade') . '</a>');
            }
        } else {
            if ($this->id == $plan->id) {   
                return new HtmlString('<a href="' . route('frontend.subscription.update', $this) . '" class="btn btn-success">' . __('Cancel Downgrade') . '</a>');
            }
            if ($this->id == $nextPlan->id) {   
                return new HtmlString('<a class="btn btn-secondary">' . __('Starting on next billing') . '</a>');
            }
            if (($this->price < $nextPlan->price) || ($this->price > $nextPlan->price && $this->price < $plan->price)) {   
                return new HtmlString('<a name="confirm-item" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-danger">' . __('Downgrade') . '</a>');
            }
            if ($this->price > $plan->price) {  
                if (is_null($organization_subscription)) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.subscription.confirmation'))
                        ->withMetadata(['plan_id' => $this->id])
                        ->create(
                            [
                                'prices' => [
                                    is_null($organization->subscription('default')) ? 'USD:0' : $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'title' => $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                                'customer_email' => auth()->user()->email,
                            ]
                        );
                    return new HtmlString('<a href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-primary" data-theme="none">' . __('Upgrade') . '</a>');
                } 
                return new HtmlString('<a name="confirm-item" data-overrirde-message="' . __('Are you sure you want to do this?') . '<br><br>' . __('You will be charged') . ' ' . $this->price . ' ' . $this->currency . '" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-primary">' . __('Upgrade') . '</a>');
            }
        }
    }
}
