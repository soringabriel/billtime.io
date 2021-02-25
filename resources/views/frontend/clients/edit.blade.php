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

                        <x-slot name="headerActions">
                            <x-utils.link class="card-header-action" :href="route('frontend.clients.index')" :text="__('Cancel')" />
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') ?? $client->name }}" placeholder="{{ __('Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="company_name" class="col-md-2 col-form-label">@lang('Company Name')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') ?? $client->company_name }}" placeholder="{{ __('Company Name') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="tax_number" class="col-md-2 col-form-label">@lang('Tax Number')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="tax_number" class="form-control" value="{{ old('tax_number') ?? $client->tax_number }}" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="vat_number" class="col-md-2 col-form-label">@lang('Vat Number')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="vat_number" class="form-control" value="{{ old('vat_number') ?? $client->vat_number }}" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="address" class="col-md-2 col-form-label">@lang('Address')</label>

                                    <div class="col-md-10">
                                        <textarea name="address" class="form-control" placeholder="{{ __('Address') }}" />{{ old('address') ?? $client->address }}</textarea>
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
                            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Client')</button>
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
