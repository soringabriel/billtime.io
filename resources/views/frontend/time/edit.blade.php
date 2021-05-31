@inject('model', '\App\Models\Time')

@extends('frontend.layouts.app')

@section('title', __('Update Time Record'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.patch :action="route('frontend.time.update', $time)">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Update Time Record')
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="start_time" class="col-md-2 col-form-label">@lang('Start Time')</label>

                                    <div class="col-md-10">
                                        <input type="datetime" class="datetimepicker form-control" name="start_time" placeholder="{{ __('Start Time') }}" value="{{ old('start_time') ?? stringDateFormat($time->start_time, 'Y-m-d H:i') }}" autocomplete="off" required />
                                        <span class="btn btn-link datetimepicker-action">@lang('Now')</span>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="end_time" class="col-md-2 col-form-label">@lang('End Time')</label>

                                    <div class="col-md-10">
                                        <input type="datetime" class="datetimepicker form-control" name="end_time" placeholder="{{ __('End Time') }}" value="{{ old('end_time') ?? stringDateFormat($time->end_time, 'Y-m-d H:i') }}" autocomplete="off" required />
                                        <span class="btn btn-link datetimepicker-action">@lang('Now')</span>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="project_id" class="col-md-2 col-form-label">@lang('Project')</label>

                                    <div class="col-md-10">
                                        <select name="project_id" class="form-control select2-project mb-2">
                                            @foreach ($projects as $project) 
                                                <option value="{{ $project->id }}" {{ ($project->id == $time->project_id ? 'selected' : '') }}>{{ $project->name }}</option>    
                                            @endforeach
                                        </select>
                                        <x-utils.link
                                            icon="c-icon cil-plus"
                                            class="card-header-action"
                                            :href="route('frontend.projects.create')"
                                            :text="__('Add New Project')"
                                            permission="user.access.projects.create"
                                        />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="task" class="col-md-2 col-form-label">@lang('Task')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="task" class="form-control" placeholder="{{ __('Task') }}" value="{{ old('task') ?? $time->task }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="details" class="col-md-2 col-form-label">@lang('Details')</label>

                                    <div class="col-md-10">
                                        <textarea name="details" class="form-control" placeholder="{{ __('Details') }}" />{{ old('details') ?? $time->details }}</textarea>
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-primary float-right" type="submit">@lang('Update Time Record')</button>
                            <x-utils.link class="btn btn-danger float-right mr-3" :href="route('frontend.time.index')" :text="__('Cancel')" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
