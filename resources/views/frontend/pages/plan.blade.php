@extends('frontend.layouts.app')

@section('title', __('Plans'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <h1 class="mt-5 mb-3">@lang('Select Your Plan')</h1>
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-7 col-sm-9 pl-4 pr-4">
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
                                    <li><i class="fas fa-check"></i> @lang('Customer Support')</li>
                                    <li><i class="fas fa-check"></i> @lang('Free of costs')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                {{ $associatedPlans['Freelancer']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>

                    <div class="col-lg-4 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Freelancer Pro')</h5>
                                <span class="price">$ 3,99</span>
                                <p class="year">@lang('per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('One user only')</li>
                                    <li><i class="fas fa-check"></i> @lang('Customer Support')</li>
                                    <li><i class="fas fa-check"></i> @lang('14 Days Free Trial')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                {{ $associatedPlans['Freelancer Pro']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>

                    <div class="col-lg-4 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Startup')</h5>
                                <span class="price">$ 9,99</span>
                                <p class="year">@lang('per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Up to 3 users')</li>
                                    <li><i class="fas fa-check"></i> @lang('Customer Support')</li>
                                    <li><i class="fas fa-check"></i> @lang('14 Days Free Trial')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                {{ $associatedPlans['Startup']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>

                    <div class="col-lg-4 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Small Team')</h5>
                                <span class="price">$ 24,99</span>
                                <p class="year">@lang('per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Up to 10 users')</li>
                                    <li><i class="fas fa-check"></i> @lang('Customer Support')</li>
                                    <li><i class="fas fa-check"></i> @lang('14 Days Free Trial')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                {{ $associatedPlans['Small Team']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>
                    
                    <div class="col-lg-4 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Regular')</h5>
                                <span class="price">$ 49,99</span>
                                <p class="year">@lang('per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Up to 50 users')</li>
                                    <li><i class="fas fa-check"></i> @lang('Customer Support')</li>
                                    <li><i class="fas fa-check"></i> @lang('14 Days Free Trial')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
                                {{ $associatedPlans['Regular']->getButton($userPlan, $userNextPlan) }}
                            </div>
                            <div class="buttom-shape">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                            </div>
                        </div> <!-- single pricing -->
                    </div>
                    
                    <div class="col-lg-4 col-md-7 col-sm-9 pl-4 pr-4">
                        <div class="single-pricing mt-40">
                            <div class="pricing-header text-center">
                                <h5 class="sub-title">@lang('Unlimited')</h5>
                                <span class="price">$ 99,99</span>
                                <p class="year">@lang('per month')</p>
                            </div>
                            <div class="pricing-list">
                                <ul>
                                    <li><i class="fas fa-check"></i> @lang('Time Tracking')</li>
                                    <li><i class="fas fa-check"></i> @lang('Data Exports')</li>
                                    <li><i class="fas fa-check"></i> @lang('Invoicing')</li>
                                    <li><i class="fas fa-check"></i> @lang('Unlimited users')</li>
                                    <li><i class="fas fa-check"></i> @lang('Customer Support')</li>
                                    <li><i class="fas fa-check"></i> @lang('14 Days Free Trial')</li>
                                </ul>
                            </div>
                            <div class="pricing-btn text-center">
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
                        <li>@lang('If a subscription invoice goes past due, you still get to use the current plan with all it\'s features, untill the subscription is cancelled')</li>
                        <li>@lang('If you downgrade to a plan that offers less features, the downgrade will take place at the end of the current billing period, and until then you will still be able to use all of the features of your current plan')</li>
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
