@extends('frontend.layouts.app')

@push('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
@endpush

@section('title', __('Reports'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center pb-5">
                @if ($logged_in_user->organization()->first()->times()->count())
                    <div id="organizationTimesChart" class="card p-4">
                        <h1 class="mb-3 text-left">@lang('Time Tracked Reports')</h1>

                        <div class="row">
                            <div class="tabs col-12" x-data="{tab: 'daily'}">
                                <div class="tab-buttons text-left">
                                    <button class="btn btn-outline-primary mr-2" @click="tab = 'daily'" :class="{'active': tab == 'daily'}">@lang('Daily')</button>
                                    <button class="btn btn-outline-primary" @click="tab = 'monthly'" :class="{'active': tab == 'monthly'}">@lang('Monthly')</button>
                                </div>
                                <div class="info mt-3 text-left">
                                    <p x-show="tab == 'daily'">@lang('Daily tracked time by your entire organization')</p>
                                    <p x-show="tab == 'monthly'">@lang('Monthly tracked time by your entire organization')</p>
                                </div>
                                <div class="charts mt-3">
                                    <canvas x-show="tab == 'daily'" id="organizationTimePerDay" class="w-100" width="400" height="150"></canvas>
                                    <canvas x-show="tab == 'monthly'" id="organizationTimePerMonth" class="w-100" width="400" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="organizationInvoicesChart" class="card p-4">
                        <h1 class="mb-3 text-left">@lang('Invoices Reports')</h1>

                        <div class="row">
                            <div class="tabs col-12" x-data="{tab: 'daily'}">
                                <div class="tab-buttons text-left">
                                    <button class="btn btn-outline-primary mr-2" @click="tab = 'daily'" :class="{'active': tab == 'daily'}">@lang('Daily')</button>
                                    <button class="btn btn-outline-primary" @click="tab = 'monthly'" :class="{'active': tab == 'monthly'}">@lang('Monthly')</button>
                                </div>
                                <div class="info mt-3 text-left">
                                    <p x-show="tab == 'daily'">@lang('Daily amount billed by your entire organization')</p>
                                    <p x-show="tab == 'monthly'">@lang('Monthly amount billed by your entire organization')</p>
                                </div>
                                <div class="charts mt-3">
                                    <canvas x-show="tab == 'daily'" id="organizationInvoicesPerDay" class="w-100" width="400" height="150"></canvas>
                                    <canvas x-show="tab == 'monthly'" id="organizationInvoicesPerMonth" class="w-100" width="400" height="150"></canvas>
                                </div>
                            </div>
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
        function generateChart(chartId, type, labels, datasets){
            const options = {
                type: type,
                data: {
                    labels: labels,
                    datasets: datasets
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

            var chart = document.getElementById(chartId);
            if (chart !== null) {
                var ctx = document.getElementById(chartId).getContext('2d');
                window.myLine = new Chart(ctx, options);
            }
        }

        (function(){
            const charts = {!! json_encode($charts) !!};

            for (let index in charts) {
                generateChart(
                    charts[index].html_id,
                    charts[index].type,
                    charts[index].labels,
                    charts[index].datasets,
                )
            }
        })();
    </script>
@endpush