@extends('frontend.layouts.app')

@push('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
@endpush

@section('title', __('Dashboard'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center pb-5">
                <div class="d-flex flex-column flex-md-row justify-content-between">
                    <div class="shorcuts card w-md-25 mr-3 p-4">
                        <h3 class="text-left mb-3">@lang('Shorcuts')</h3>
                        <div class="list-group">
                            <x-utils.link
                                :href="route('frontend.time.create')"
                                :text="__('Add a time record')"
                                class="list-group-item list-group-item-action font-weight-bold"
                                permission="user.access.times"
                            />
                            <x-utils.link
                                :href="route('frontend.invoices.create')"
                                :text="__('Generate an invoice')"
                                class="list-group-item list-group-item-action font-weight-bold"
                                permission="user.access.invoices.create"
                            />
                            <x-utils.link
                                :href="route('frontend.clients.create')"
                                :text="__('Add a client')"
                                class="list-group-item list-group-item-action font-weight-bold"
                                permission="user.access.clients.create"
                            />
                            <x-utils.link
                                :href="route('frontend.projects.create')"
                                :text="__('Add a project')"
                                class="list-group-item list-group-item-action font-weight-bold"
                                permission="user.access.projects.create"
                            />
                            @if ($logged_in_user->isOrganizationOwner())
                                <x-utils.link
                                    class="list-group-item list-group-item-action font-weight-bold"
                                    :href="route('frontend.user.account') . '#organization'"
                                    :text="__('Update organization details')" />
                            @endif
                        </div>
                    </div>
                    <div class="card w-md-25 mr-3">
                        <div class="card-header bg-white p-4">
                            <h5 class="card-title w-100 mb-0">@lang('Step 1')</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">@lang('Start tracking your times. To do so you can choose either to use the automatic time tracking present at the top of each page, or to add manual time tracking records.')</p>
                        </div>
                        <div class="card-footer bg-white p-4">
                            <x-utils.link
                                :href="route('frontend.time.create')"
                                :text="__('Add a time record')"
                                class="btn btn-block btn-outline-primary"
                                permission="user.access.times"
                            />
                        </div>
                    </div>
                    <div class="card w-md-25 mr-3">
                        <div class="card-header bg-white p-4">
                            <h5 class="card-title w-100 mb-0">@lang('Step 2')</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">@lang('Bill the times you recorded and easily generate invoices for your clients which can be downloaded in multiple languages')</p>
                        </div>
                        <div class="card-footer bg-white p-4">
                            <x-utils.link
                                :href="route('frontend.invoices.create')"
                                :text="__('Generate an invoice')"
                                class="btn btn-block btn-outline-primary"
                                permission="user.access.invoices.create"
                            />
                        </div>
                    </div>
                    <div class="card w-md-25">
                        <div class="card-header bg-white p-4">
                            <h5 class="card-title w-100 mb-0">@lang('Step 3')</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text">@lang('Check out the documentation anytime you encounter a problem')</p>
                        </div>
                        <div class="card-footer bg-white p-4">
                            <x-utils.link
                                :href="route('frontend.pages.faq')"
                                :text="__('Documentation & FAQ')"
                                class="btn btn-block btn-outline-primary"
                            />
                        </div>
                    </div>
                </div>
                @if ($logged_in_user->can('user.access.times.access'))
                    @if ($logged_in_user->times()->count())
                        <div id="userTimesChart" class="card p-4">
                            <h1 class="mb-3 text-left">@lang('Personal Reports')</h1>

                            <div class="row">
                                <div class="tabs col-12" x-data="{tab: 'daily'}">
                                    <div class="tab-buttons text-left">
                                        <button class="btn btn-outline-primary mr-2" @click="tab = 'daily'" :class="{'active': tab == 'daily'}">@lang('Daily')</button>
                                        <button class="btn btn-outline-primary" @click="tab = 'monthly'" :class="{'active': tab == 'monthly'}">@lang('Monthly')</button>
                                    </div>
                                    <div class="charts mt-3">
                                        <canvas x-show="tab == 'daily'" id="userTimePerDay" class="w-100" width="400" height="150"></canvas>
                                        <canvas x-show="tab == 'monthly'" id="userTimePerMonth" class="w-100" width="400" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <h3 class="mt-5">@lang('You don\'t have any tracked times yet!')</h3>
                    @endif
                    @if ($logged_in_user->can('user.access.times.show-all') && $logged_in_user->organization()->first()->times()->count())
                        <div id="organizationTimesChart" class="card p-4">
                            <h1 class="mb-3 text-left">@lang('Team Reports')</h1>

                            <div class="row">
                                <div class="tabs col-12" x-data="{tab: 'daily'}">
                                    <div class="tab-buttons text-left">
                                        <button class="btn btn-outline-primary mr-2" @click="tab = 'daily'" :class="{'active': tab == 'daily'}">@lang('Daily')</button>
                                        <button class="btn btn-outline-primary" @click="tab = 'monthly'" :class="{'active': tab == 'monthly'}">@lang('Monthly')</button>
                                    </div>
                                    <div class="charts mt-3">
                                        <canvas x-show="tab == 'daily'" id="organizationTimePerDay" class="w-100" width="400" height="150"></canvas>
                                        <canvas x-show="tab == 'monthly'" id="organizationTimePerMonth" class="w-100" width="400" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                min: 0,
                            },
                        }]
                    }
                }
            };

            var userTimePerDay = document.getElementById('userTimePerDay');
            if (userTimePerDay !== null) {
                var ctx = document.getElementById('userTimePerDay').getContext('2d');
                window.myLine = new Chart(ctx, configDaily);
            }

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
                },
                options: {
                    scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                min: 0,
                            },
                        }]
                    }
                }
            };

            var userTimePerMonth = document.getElementById('userTimePerMonth');
            if (userTimePerMonth !== null) {
                var ctx = document.getElementById('userTimePerMonth').getContext('2d');
                window.myLine = new Chart(ctx, configMonthly);
            }

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
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    min: 0,
                                },
                            }]
                        }
                    }
                };

                var organizationTimePerDay = document.getElementById('organizationTimePerDay');
                if (organizationTimePerDay !== null) {
                    var ctx = document.getElementById('organizationTimePerDay').getContext('2d');
                    window.myLine = new Chart(ctx, organizationConfigDaily);
                }

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
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                display: true,
                                ticks: {
                                    min: 0,
                                },
                            }]
                        }
                    }
                };

                var organizationTimePerMonth = document.getElementById('organizationTimePerMonth');
                if (organizationTimePerMonth !== null) {
                    var ctx = organizationTimePerMonth.getContext('2d');
                    window.myLine = new Chart(ctx, organizationConfigMonthly);
                }
            @endif
        })();
    </script>
@endpush