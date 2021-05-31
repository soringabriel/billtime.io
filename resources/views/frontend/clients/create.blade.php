@inject('model', '\App\Models\Client')

@extends('frontend.layouts.app')

@section('title', __('Add Client'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.post :action="route('frontend.clients.store')">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Add Client')
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
                                        <input type="text" name="company_name" class="form-control" placeholder="{{ __('Company Name') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="tax_number" class="col-md-2 col-form-label">@lang('Tax Number')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="tax_number" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="vat_number" class="col-md-2 col-form-label">@lang('Vat Number')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="vat_number" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="address" class="col-md-2 col-form-label">@lang('Address')</label>

                                    <div class="col-md-10">
                                        <textarea name="address" class="form-control" placeholder="{{ __('Address') }}" /></textarea>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="bank_account" class="col-md-2 col-form-label">@lang('Bank Account')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="bank_account" class="form-control" placeholder="{{ __('Bank Account') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-primary float-right" type="submit">@lang('Create Client')</button>
                            <x-utils.link class="btn btn-danger float-right mr-3" :href="route('frontend.clients.index')" :text="__('Cancel')" permission="user.access.clients.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
