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
        echo $plan->name;
        echo $nextPlan->name;
        echo '<br>';
        $organization = auth()->user()->organization()->first();
        $organization_subscription = $organization->subscription('default');
        if ($plan->id == $nextPlan->id) {
            if ($this->id == $plan->id) {
                return new HtmlString('<a class="btn btn-lg btn-secondary">' . __('Current') . '</a>');
            }
            if ($this->price > $plan->price) {   
                if (is_null($organization_subscription) || $organization_subscription->cancelled()) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.subscription.confirmation'))
                        ->withMetadata(['plan_id' => $this->id])
                        ->create(
                            [
                                'prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'custom_message' => __('Monthly Subscription For ') . $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                                'customer_email' => auth()->user()->email,
                            ]
                        );
                    return new HtmlString('<a onclick="gtag(\'event\', \'Purchase\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-lg btn-primary" data-theme="none">' . __('Upgrade') . '</a>');
                } else {
                    return new HtmlString('<a onclick="gtag(\'event\', \'Upgrade\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" name="confirm-item" data-overrirde-message="' . __('Are you sure you want to do this?') . '<br><br>' . __('You will be charged') . ' ' . $this->price . ' ' . $this->currency . '" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-lg btn-primary">' . __('Upgrade') . '</a>');
                }
            }
            if ($this->price < $plan->price) { 
                return new HtmlString('<a onclick="gtag(\'event\', \'Downgrade\', {
                    \'event_category\': \'Payment\',
                    \'event_label\': \'' . $this->name . '\',
                })" name="confirm-item" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-lg btn-danger">' . __('Downgrade') . '</a>');
            }
        } else {
            if ($this->id == $plan->id) {   
                if (is_null($organization_subscription) || $organization_subscription->cancelled()) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.subscription.confirmation'))
                        ->withMetadata(['plan_id' => $this->id])
                        ->create(
                            [
                                'prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'custom_message' => __('Monthly Subscription For ') . $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                                'customer_email' => auth()->user()->email,
                            ]
                        );
                    return new HtmlString('<a onclick="gtag(\'event\', \'Purchase\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-lg btn-success" data-theme="none">' . __('Cancel Downgrade') . '</a>');
                } else {
                    return new HtmlString('<a onclick="gtag(\'event\', \'Cancel Downgrade\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-lg btn-success">' . __('Cancel Downgrade') . '</a>');
                }
            }
            if ($this->id == $nextPlan->id) {   
                return new HtmlString('<a class="btn btn-lg btn-secondary">' . __('Starting on next billing') . '</a>');
            }
            if (($this->price < $nextPlan->price) || ($this->price > $nextPlan->price && $this->price < $plan->price)) {   
                if (is_null($organization_subscription) || $organization_subscription->cancelled()) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.subscription.confirmation'))
                        ->withMetadata(['plan_id' => $this->id])
                        ->create(
                            [
                                'prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'custom_message' => __('Monthly Subscription For ') . $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                                'customer_email' => auth()->user()->email,
                            ]
                        );
                    return new HtmlString('<a onclick="gtag(\'event\', \'Purchase\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-lg btn-danger" data-theme="none">' . __('Downgrade') . '</a>');
                } else {
                    return new HtmlString('<a onclick="gtag(\'event\', \'Downgrade\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" name="confirm-item" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-lg btn-danger">' . __('Downgrade') . '</a>');
                }
            }
            if ($this->price > $plan->price) {  
                if (is_null($organization_subscription) || $organization_subscription->cancelled()) {
                    $paylink = $organization->newSubscription('default', $premium = billingTypeToPaddleId($this->billing_type))
                        ->returnTo(route('frontend.subscription.confirmation'))
                        ->withMetadata(['plan_id' => $this->id])
                        ->create(
                            [
                                'prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'recurring_prices' => [
                                    $this->currency . ':' . $this->price,
                                ],
                                'custom_message' => __('Monthly Subscription For ') . $this->name,
                                'vat_number' => $organization->vat_number,
                                'vat_company_name' => $organization->company_name,
                                'customer_email' => auth()->user()->email,
                            ]
                        );
                    return new HtmlString('<a onclick="gtag(\'event\', \'Purchase\', {
                        \'event_category\': \'Payment\',
                        \'event_label\': \'' . $this->name . '\',
                    })" href="#!" data-override="' . $paylink . '" class="paddle_button btn btn-lg btn-primary" data-theme="none">' . __('Upgrade') . '</a>');
                } 
                return new HtmlString('<a onclick="gtag(\'event\', \'Upgrade\', {
                    \'event_category\': \'Payment\',
                    \'event_label\': \'' . $this->name . '\',
                })" name="confirm-item" data-overrirde-message="' . __('Are you sure you want to do this?') . '<br><br>' . __('You will be charged') . ' ' . $this->price . ' ' . $this->currency . '" href="' . route('frontend.subscription.update', $this) . '" class="btn btn-lg btn-primary">' . __('Upgrade') . '</a>');
            }
        }
    }
}
