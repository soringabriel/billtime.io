@inject('model', '\App\Models\Client')

@extends('frontend.layouts.app')

@section('title', __('Update Client Record'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.patch :action="route('frontend.clients.update', $client)">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Update Client')
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Name')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the client that you\'re working with') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') ?? $client->name }}" placeholder="{{ __('Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="company_name" class="col-md-2 col-form-label">
                                        @lang('Company Name')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the company of your client') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') ?? $client->company_name }}" placeholder="{{ __('Company Name') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="tax_number" class="col-md-2 col-form-label">
                                        @lang('Tax Number')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The tax number identifier of your client\'s company') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="tax_number" class="form-control" value="{{ old('tax_number') ?? $client->tax_number }}" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="vat_number" class="col-md-2 col-form-label">
                                        @lang('Vat Number')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The vat number of your client\'s company') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="vat_number" class="form-control" value="{{ old('vat_number') ?? $client->vat_number }}" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="address" class="col-md-2 col-form-label">
                                        @lang('Address')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The address of your client\'s company') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <textarea name="address" class="form-control" placeholder="{{ __('Address') }}" />{{ old('address') ?? $client->address }}</textarea>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="bank_account" class="col-md-2 col-form-label">
                                        @lang('Bank Account')
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The bank account of your client\'s company. This will be useful for invoicing.') }}"></i>
                                    </label>
                                    
                                    <div class="col-md-10">
                                        <input type="text" name="bank_account" class="form-control" value="{{ old('bank_account') ?? $client->bank_account }}" placeholder="{{ __('Bank Account') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Update Client')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.clients.index')" :text="__('Cancel')" permission="user.access.clients.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
