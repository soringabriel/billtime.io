@extends('frontend.layouts.app')

@section('title', __('Time Records'))

@push('after-styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.8.0/main.min.css" />
@endpush

@php $time_sources = $logged_in_user->organization()->first()->getOrganizationTimeSources(); @endphp

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4">
                <div class="field-group mb-4">
                    <label class="col-form-label">@lang('Team Member')</label>
                    <select class="form-control" id="user">
                        @foreach ($time_sources as $user => $times)
                            <option value="{{ $user }}">{{ $user }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div id="calendar"></div>
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
                eventClick: function(info) {
                    Swal.fire({
                        title: info.event.title,
                        html: 
                            '<div class="row"><div class="col-md-4">@lang("Start Time")</div><div class="col-md-8">' + info.event.start + '</div></div>' + 
                            '<div class="row"><div class="col-md-4">@lang("End Time")</div><div class="col-md-8">' + info.event.end + '</div></div>' + 
                            '<div class="row"><div class="col-md-4">@lang("Project")</div><div class="col-md-8">' + info.event.extendedProps.project + '</div></div>' + 
                            '<div class="row"><div class="col-md-4">@lang("Task")</div><div class="col-md-8">' + info.event.extendedProps.task + '</div></div>' + 
                            '<div class="row"><div class="col-md-4">@lang("Billed")</div><div class="col-md-8">' + 
                                info.event.extendedProps.billed ? '<span class="bg-success text-white text-nowrap rounded p-1">@lang("Billed")' : '<span class="bg-dark text-white text-nowrap rounded p-1">@lang("Not Billed")</span>' + 
                            '</div></div>' + 
                            '<div class="row"><div class="col-12">@lang("Details")</div><div class="col-12>' + info.event.extendedProps.details + '</div></div>',
                        footer: info.event.extendedProps.edit_url + ' ' + info.event.extendedProps.delete_url,
                        showCancelButton: true,
                        cancelButtonText: 'Hide',
                        icon: 'info'
                    }).then((result) => {
                        if (result.value) {
                            this.submit()
                        } else {
                            enableSubmitButtons($(this));
                        }
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
