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

                        <x-slot name="headerActions">
                            <x-utils.link class="card-header-action" :href="route('frontend.time.index')" :text="__('Cancel')" />
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="start_time" class="col-md-2 col-form-label">@lang('Start Time')</label>

                                    <div class="col-md-10">
                                        <input type="datetime" name="start_time" class="form-control" placeholder="{{ __('Start Time') }}" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="end_time" class="col-md-2 col-form-label">@lang('End Time')</label>

                                    <div class="col-md-10">
                                        <input type="datetime" name="end_time" class="form-control" placeholder="{{ __('End Time') }}" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="task" class="col-md-2 col-form-label">@lang('Task')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="task" class="form-control" placeholder="{{ __('Task') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="details" class="col-md-2 col-form-label">@lang('Details')</label>

                                    <div class="col-md-10">
                                        <textarea name="details" class="form-control" placeholder="{{ __('Details') }}" /></textarea>
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Time')</button>
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
