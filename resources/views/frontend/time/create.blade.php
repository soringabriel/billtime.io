@inject('model', '\App\Models\Time')

@extends('frontend.layouts.app')

@section('title', __('Add Time'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.post :action="route('frontend.time.store')">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Add Time')
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="start_time" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Start Time')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The time when you started working') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="datetime" class="datetimepicker form-control" name="start_time" placeholder="{{ __('Start Time') }}" value="{{ old('start_time') ?? ($lastTime ? stringDateFormat($lastTime->end_time, 'Y-m-d H:i') : '') }}" autocomplete="off" required />
                                        <span class="btn btn-link datetimepicker-action">@lang('Now')</span>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="end_time" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('End Time')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The time when you ended working') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="datetime" class="datetimepicker form-control" name="end_time" placeholder="{{ __('End Time') }}" value="{{ old('end_time') }}" autocomplete="off" required />
                                        <span class="btn btn-link datetimepicker-action">@lang('Now')</span>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="project_id" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Project')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The project you\'ve been working on') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <select name="project_id" class="form-control select2-project mb-2">
                                            @foreach ($projects as $project) 
                                                <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'checked' : '' }}>{{ $project->name }}</option>    
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
                                    <label for="task" class="col-md-2 col-form-label">
                                        @lang('Task')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The task you\'ve been working on') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="task" class="form-control" placeholder="{{ __('Task') }}" maxlength="255" value="{{ old('task') }}" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="details" class="col-md-2 col-form-label">
                                        @lang('Details')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('A few comments about your work') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <textarea name="details" class="form-control" placeholder="{{ __('Details') }}" maxlength="255" />{{ old('details') }}</textarea>
                                    </div>
                                </div><!--form-group-->

                                <div class="alert alert-dark" role="alert">
                                    @lang('You can always track your time easier by starting the counter at the top of the page')
                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-primary float-right" type="submit">@lang('Create Time')</button>
                            <x-utils.link class="btn btn-danger float-right mr-3" :href="route('frontend.time.index')" :text="__('Cancel')" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
