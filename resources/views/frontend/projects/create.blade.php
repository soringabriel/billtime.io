@inject('model', '\App\Models\Project')

@extends('frontend.layouts.app')

@section('title', __('Add Project'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.post :action="route('frontend.projects.store')">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Add Project')
                        </x-slot>

                        <x-slot name="headerActions">
                            <x-utils.link class="card-header-action" :href="route('frontend.projects.index')" :text="__('Cancel')" />
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="company_name" class="col-md-2 col-form-label">@lang('Company Name')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="company_name" class="form-control" placeholder="{{ __('Company Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="tax_number" class="col-md-2 col-form-label">@lang('Tax Number')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="tax_number" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="vat_number" class="col-md-2 col-form-label">@lang('Vat Number')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="vat_number" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="address" class="col-md-2 col-form-label">@lang('Address')</label>

                                    <div class="col-md-10">
                                        <textarea name="address" class="form-control" placeholder="{{ __('Address') }}" /></textarea>
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Project')</button>
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
