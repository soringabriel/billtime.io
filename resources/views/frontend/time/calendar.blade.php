@extends('frontend.layouts.app')

@section('title', __('Time Records'))

@push('after-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.css" />
@endpush

@php $time_sources = $logged_in_user->organization()->first()->getOrganizationTimeSources(); @endphp

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        <div class="field-group float-left">
                            <label>@lang('Team Member')</label>
                            <select class="form-control" id="user">
                                @foreach ($time_sources as $user => $times)
                                    <option value="{{ $user }}">{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            class="btn btn-outline-light"
                            :href="route('frontend.time.create')"
                            :text="__('Add Manual Time')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <div id="calendar"></div>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.js"></script>
    <script>
        var sources = {!! json_encode($time_sources) !!};
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: { center: 'dayGridMonth,timeGridWeek,listWeek' },
                eventSources: [],
                timeZone: '{{ $logged_in_user->timezone }}',
                eventClick: function(info) {
                    var start_time = (info.event.extendedProps.start ? info.event.extendedProps.start.toLocaleString('en-US', { timeZone: info.event.extendedProps.timezone }) : 'Unknown');
                    var end_time = (info.event.extendedProps.end ? info.event.extendedProps.end.toLocaleString('en-US', { timeZone: info.event.extendedProps.timezone }) : start_time)
                    Swal.fire({
                        title: info.event.title,
                        html: '<div class="row align-center pt-1 pb-1 border-bottom"><div class="col-md-4 text-left">@lang("Start Time")</div><div class="col-md-8 text-right">' + start_time + '</div></div>' + 
                            '<div class="row align-center pt-1 pb-1 border-bottom"><div class="col-md-4 text-left">@lang("End Time")</div><div class="col-md-8 text-right">' + end_time + '</div></div>' + 
                            '<div class="row align-center pt-1 pb-1 border-bottom"><div class="col-md-4 text-left">@lang("Project")</div><div class="col-md-8 text-right">' + (info.event.extendedProps.project ?? 'Unknown') + '</div></div>' + 
                            '<div class="row align-center pt-1 pb-1 border-bottom"><div class="col-md-4 text-left">@lang("Task")</div><div class="col-md-8 text-right">' + (info.event.extendedProps.task ? '<a target="_blank" href="' + info.event.extendedProps.task + '">Link</a>' : 'Unknown') + '</div></div>' + 
                            '<div class="row align-center pt-2 pb-2 border-bottom"><div class="col-md-4 text-left">@lang("Billed")</div><div class="col-md-8 text-right">' + 
                                (info.event.extendedProps.billed ? '<span class="bg-success text-white text-nowrap rounded p-1">@lang("Billed")' : '<span class="bg-dark text-white text-nowrap rounded p-1">@lang("Not Billed")</span>') + 
                            '</div></div>' + 
                            '<div class="row align-center pt-1"><div class="col-md-4 text-left">@lang("Details")</div><div class="col-md-8 text-right">' + (info.event.extendedProps.details ?? 'Unknown') + '</div></div></span>',
                        showCloseButton: false,
                        showCancelButton: false,
                        showConfirmButton: true,
                        icon: 'info'
                    });
                }
            });
            calendar.render();
            var userSelector = document.getElementById('user');
            userSelector.addEventListener('change', function() {
                var eventSources = calendar.getEventSources();
                for (let index = 0; index < eventSources.length; index++) {
                    eventSources[index].remove();
                }
                calendar.addEventSource(sources[userSelector.value])
            })
            calendar.addEventSource(sources[userSelector.value])
        });
    </script>
@endpush
