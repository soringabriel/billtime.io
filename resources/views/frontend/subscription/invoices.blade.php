@extends('frontend.layouts.app')

@push('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
@endpush

@section('title', __('Terms & Conditions'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                @if ($logged_in_user->clients()->count() == 0 || $logged_in_user->projects()->count() == 0 || $organization->created_at == $organization->updated_at)
                    <div id="onboarding">
                        <h1 class="mt-3 mb-5">@lang('Welcome to TimoTrack')</h1>
                        <h4 class="mb-5">@lang('Before you can start tracking your time there are a few more steps that you need to complete!')</h4>

                        <ol class="stepper">
                            @if ($logged_in_user->clients()->count() == 0)
                                <li>
                                    <x-utils.link
                                        :href="route('frontend.clients.create')"
                                        :text="__('Add your first client')"
                                        permission="user.access.clients.create"
                                    />
                                </li>
                            @endif
                            @if ($logged_in_user->projects()->count() == 0)
                                <li>
                                    <x-utils.link
                                        :href="route('frontend.projects.create')"
                                        :text="__('Add your first project')"
                                        permission="user.access.projects.create"
                                    />
                                </li>
                            @endif
                            @if ($organization->created_at == $organization->updated_at)
                                <li>
                                    <x-utils.link
                                        :href="route('frontend.user.account') . '#organization'"
                                        :text="__('Update organization details')" />
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
                @if (!$logged_in_user->plan()->first()->isBiggest() && $logged_in_user->isOrganizationOwner())
                    <h2 class="mt-5">
                        <x-utils.link
                            :href="route('frontend.plan')"
                            :text="__('Upgrade Your Plan')" />
                        @lang('To Receive Extra Features')
                    </h2>
                @endif
                @if ($logged_in_user->times()->count())
                    <div id="userTimesChart">
                        <h1 class="mt-5 mb-5">@lang('Your Times')</h1>

                        <div class="row">
                            <div class="col-md-6 pl-5 pr-5"><canvas id="userTimePerDay" width="400" height="300"></canvas></div>
                            <div class="col-md-6 pl-5 pr-5"><canvas id="userTimePerMonth" width="400" height="300"></canvas></div>
                        </div>
                    </div>
                @else
                    <h3 class="mt-5">@lang('You don\'t have any tracked times yet!')</h3>
                @endif
                @if ($logged_in_user->can('user.access.times.show-all'))
                    <div id="organizationTimesChart">
                        <h1 class="mt-5 mb-5">@lang('Organization Times')</h1>

                        <div class="row">
                            <div class="col-md-6 pl-5 pr-5"><canvas id="organizationTimePerDay" width="400" height="300"></canvas></div>
                            <div class="col-md-6 pl-5 pr-5"><canvas id="organizationTimePerMonth" width="400" height="300"></canvas></div>
                        </div>
                    </div>
                @endif
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection

@push('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
    <script>
        (function(){
            const labelsDaily = {!! json_encode(array_keys($timesChartData['daily'])) !!};
            const labelsMonthly = {!! json_encode(array_keys($timesChartData['monthly'])) !!};
            const valuesDaily = {!! json_encode(array_values($timesChartData['daily'])) !!};
            const valuesMonthly = {!! json_encode(array_values($timesChartData['monthly'])) !!};
            const configDaily = {
                type: 'bar',
                data: {
                    labels: labelsDaily,
                    datasets: [{
                        label: "{{ __('Daily Tracked Time') }}",
                        data: valuesDaily,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgb(153, 102, 255)',
                        borderWidth: 1
                    }]
                }
            };

            var ctx = document.getElementById('userTimePerDay').getContext('2d');
            window.myLine = new Chart(ctx, configDaily);

            const configMonthly = {
                type: 'bar',
                data: {
                    labels: labelsMonthly,
                    datasets: [{
                        label: "{{ __('Monthly Tracked Time') }}",
                        data: valuesMonthly,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                }
            };

            var ctx = document.getElementById('userTimePerMonth').getContext('2d');
            window.myLine = new Chart(ctx, configMonthly);

            @if ($logged_in_user->can('user.access.times.show-all'))
                const organizationLabelsDaily = {!! json_encode(array_keys($organizationTimesChartData['daily'])) !!};
                const organizationLabelsMonthly = {!! json_encode(array_keys($organizationTimesChartData['monthly'])) !!};
                const organizationValuesDaily = {!! json_encode(array_values($organizationTimesChartData['daily'])) !!};
                const organizationValuesMonthly = {!! json_encode(array_values($organizationTimesChartData['monthly'])) !!};
                const organizationConfigDaily = {
                    type: 'bar',
                    data: {
                        labels: organizationLabelsDaily,
                        datasets: [{
                            label: "{{ __('Daily Tracked Time') }}",
                            data: organizationValuesDaily,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgb(153, 102, 255)',
                            borderWidth: 1
                        }]
                    }
                };

                var ctx = document.getElementById('organizationTimePerDay').getContext('2d');
                window.myLine = new Chart(ctx, organizationConfigDaily);

                const organizationConfigMonthly = {
                    type: 'bar',
                    data: {
                        labels: organizationLabelsMonthly,
                        datasets: [{
                            label: "{{ __('Monthly Tracked Time') }}",
                            data: organizationValuesMonthly,
                            backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                            ],
                            borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                            ],
                            borderWidth: 1
                        }]
                    }
                };

                var ctx = document.getElementById('organizationTimePerMonth').getContext('2d');
                window.myLine = new Chart(ctx, organizationConfigMonthly);
            @endif
        })();
    </script>
@endpush