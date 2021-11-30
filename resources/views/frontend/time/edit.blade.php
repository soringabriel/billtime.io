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
                                    <label for="start_time" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Start Time')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The time when you started working') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="datetime" class="datetimepicker form-control" name="start_time" placeholder="{{ __('Start Time') }}" value="{{ old('start_time') ?? stringDateFormat($time->start_time, 'Y-m-d H:i') }}" autocomplete="off" required />
                                        <span class="btn btn-link datetimepicker-action">@lang('Now')</span>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="end_time" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('End Time')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The time when you ended working') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="datetime" class="datetimepicker form-control" name="end_time" placeholder="{{ __('End Time') }}" value="{{ old('end_time') ?? stringDateFormat($time->end_time, 'Y-m-d H:i') }}" autocomplete="off" required />
                                        <span class="btn btn-link datetimepicker-action">@lang('Now')</span>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row" x-data="{new_project: false}">
                                    <label for="project_id" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Project')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The project you\'ve been working on') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <select name="project_id" class="form-control select2-project mb-2">
                                            @foreach ($projects as $project) 
                                                <option value="{{ $project->id }}" {{ ($project->id == $time->project_id ? 'selected' : '') }}>{{ $project->name }}</option>    
                                            @endforeach
                                        </select>
                                        <x-utils.link
                                            icon="c-icon cil-plus"
                                            class="card-header-action"
                                            role="button"
                                            href="javascript:void(0);"
                                            :text="__('Add New Project')"
                                            @click="new_project = !new_project"
                                            permission="user.access.projects.create"
                                            x-show="!new_project"
                                        />
                                        <x-utils.link
                                            icon="c-icon cil-minus"
                                            class="card-header-action"
                                            role="button"
                                            href="javascript:void(0);"
                                            :text="__('Select From Existing Projects')"
                                            @click="new_project = !new_project"
                                            permission="user.access.projects.create"
                                            x-show="new_project"
                                        />
                                    </div>
                                    
                                    <div class="col-md-12 mt-2" x-show="new_project">
                                        <input type="hidden" name="new_project" x-bind:value="new_project ? 1 : 0">
                                        @include('frontend.includes.partials.new-project')
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="task" class="col-md-2 col-form-label">
                                        @lang('Task')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The task you\'ve been working on') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="task" class="form-control" placeholder="{{ __('Task') }}" value="{{ old('task') ?? $time->task }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="details" class="col-md-2 col-form-label">
                                        @lang('Details')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('A few comments about your work') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <textarea name="details" class="form-control" placeholder="{{ __('Details') }}" />{{ old('details') ?? $time->details }}</textarea>
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Update Time Record')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.time.index')" :text="__('Cancel')" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
