@extends('frontend.layouts.app')

@section('title', __('Plans'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            @if ($organization->start_period && $logged_in_user->isOrganizationOwner())
                <div class="col-md-12 text-center mt-3 mb-3">
                    <h5 class="alert alert-success">@lang('As a newly created organization, you benefit of all the features for') <strong>{{ now()->diffInDays($organization->plan_expire) + 1 }}</strong> @lang('more days')</h5>
                </div>
            @endif
            <h1 class="mt-3 mb-3">@lang('Select Your Plan')</h1>
            @if (!is_null($updateUrl) || !is_null($cancelUrl))
            <div class="col-md-12 text-center mt-3 mb-3">
                @if (!is_null($updateUrl))
                    <x-paddle-button :url="$updateUrl" class="px-8 py-4 h5" data-theme="none">
                        @lang('Update Card Information')
                    </x-paddle-button>
                @endif
                @if (!is_null($cancelUrl))
                    <x-utils.link
                        class="px-8 py-4 h5 ml-5"
                        :href="$cancelUrl"
                        name="confirm-item"
                        :data-overrirde-message="__('Are you sure you want to do this?') . '<br><br>' . __('Your billing information will be deleted!')"
                        :text="__('Cancel Subscription')" />
                @endif
            </div>
            @endif
            @if (!is_null($nextPayment))
                <div class="col-md-12 text-center mt-3 mb-3 h5">
                    @lang('Your next payment is on') {{ $nextPayment->date()->format('F j, Y')}} @lang('when you will be charged') {{ $nextPayment->amount() }}
                </div>
            @endif
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Freelancer')</h5>
                                <span class="price">@lang('Free')</span>
                                <p class="year">@lang('of costs')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Manual Time Tracking')</li>
                                    <li><i class="fas fa-times"></i> @lang('No Data Exports')</li>
                                    <li><i class="fas fa-times"></i> @lang('No Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('One user only')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                <p class="mb-4 text-secondary">@lang('Least amount of benefits')</p>
                                {{ $associatedPlans['Freelancer']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>

                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Freelancer Pro')</h5>
                                <span class="price">$ 4,99</span>
                                <p class="year">@lang('per user, per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('One user only')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                <p class="mb-4 text-secondary">@lang('$4,99 in total, per month')</p>
                                {{ $associatedPlans['Freelancer Pro']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>

                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Startup')</h5>
                                <span class="price">$ 3,33</span>
                                <p class="year">@lang('per user, per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Up to 3 users')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                <p class="mb-4 text-secondary">@lang('$9,99 in total, per month')</p>
                                {{ $associatedPlans['Startup']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>

                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Small Team')</h5>
                                <span class="price">$ 2,49</span>
                                <p class="year">@lang('per user, per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Up to 10 users')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                <p class="mb-4 text-secondary">@lang('$24,99 in total, per month')</p>
                                {{ $associatedPlans['Small Team']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>
                    
                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Regular')</h5>
                                <span class="price">$ 0,99</span>
                                <p class="year">@lang('per user, per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Up to 50 users')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                <p class="mb-4 text-secondary">@lang('$49,99 in total, per month')</p>
                                {{ $associatedPlans['Regular']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>
                    
                    <div class="col-xl-4 col-lg-5 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Unlimited')</h5>
                                <span class="price">~$ 0,01</span>
                                <p class="year">@lang('per user, per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> <strong>@lang('Unlimited users')</strong></li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                <p class="mb-4 text-secondary">@lang('$99,99 in total, per month')</p>
                                {{ $associatedPlans['Unlimited']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>
                </div> <!-- row -->
            </div><!--col-md-10-->
            <div class="col-md-12">
                <div class="alert alert-info mt-5">
                    @lang('Subscriptions flow information:')
                    <ul class="mt-3">
                        <li>@lang('The first month free trial is available only for the first charge of the user')</li>
                        <li>@lang('Users can change/cancel their plan at any time')</li>
                        <li>@lang('Cancelling a subscription leads to immediately losing your plan. It is recommended to downgrade to the Freelancer plan instead as this downgrade will happen at the end of the billing period.')</li>
                        <li>@lang('If a subscription invoice goes past due, you still get to use the current plan with all it\'s features, untill the subscription is cancelled')</li>
                        <li>@lang('If you downgrade to a plan that offers less features, the downgrade will take place at the end of the current billing period, and until then you will still be able to use all of the features of your current plan')</li>
                        <li>@lang('If you downgrade to a plan that offers less features, all of your users will lose the permissions from the previous plan as well')</li>
                        <li>@lang('If you downgrade to a plan that offers less users and you currently have more users than the limit of the new plan, when the downgrade occurs, some of your users will be deactivated so that the limit will be matched.')</li>
                        <li>@lang('The deactivated users from a downgrade are still gonna appear on the')
                            <x-utils.link
                                class="card-header-action"
                                :href="route('frontend.user.subuser.deleted')"
                                :text="__('Deleted Users Page')"
                                permission="user.access.users.delete"/>. 
                            @lang('You can choose to deactivate some other users in order to get below your plan\'s limit and then reactivate the users that were deactivated on the downgrade')
                        </li>
                    </ul>
                </div>
            </div>
        </div><!--row-->
    </div><!--container-->
@endsection
