@inject('model', '\App\Models\Invoice')

@extends('frontend.layouts.app')

@section('title', __('Add Invoice'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.post :action="route('frontend.invoices.store')">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Add Invoice')
                        </x-slot>

                        <x-slot name="headerActions">
                            <x-utils.link class="card-header-action" :href="route('frontend.invoices.index')" :text="__('Cancel')" />
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="field-group field-group-required">
                                            <label for="number" class="col-form-label">@lang('Invoice Number')</label>
                                            <input type="text" class="form-control" name="number" placeholder="IN0001" value="{{ old('number') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group field-group-required">
                                            <label for="name" class="col-form-label">@lang('Date')</label>
                                            <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                                        </div>
                                        <div class="field-group field-group-required">
                                            <label for="name" class="col-form-label">@lang('Due Date')</label>
                                            <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <h2>@lang('Seller Information')</h2>

                                        <div class="field-group field-group-required">
                                            <label for="sellerCompanyName" class="col-form-label">@lang('Company Name')</label>
                                            <input id="sellerCompanyName" type="text" name="seller_company_name" value="{{ old('seller_company_name') }}" class="form-control" placeholder="{{ __('Company Name') }}" maxlength="255" required />
                                        </div>
                                        
                                        <div class="field-group">
                                            <label for="sellerTaxNumber" class="col-form-label">@lang('Tax Number')</label>
                                            <input id="sellerTaxNumber" type="text" name="seller_tax_number" value="{{ old('seller_tax_number') }}" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" required />
                                        </div>
                                        
                                        <div class="field-group">
                                            <label for="sellerVatNumber" class="col-form-label">@lang('Vat Number')</label>
                                            <input id="sellerVatNumber" type="text" name="seller_vat_number" value="{{ old('seller_vat_number') }}" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" required />
                                        </div>
                                        
                                        <div class="field-group">
                                            <label for="sellerAddress" class="col-form-label">@lang('Address')</label>
                                            <input id="sellerAddress" type="text" name="seller_address" value="{{ old('seller_address') }}" class="form-control" placeholder="{{ __('Address') }}" maxlength="255" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <h2>@lang('Buyer Information')</h2>

                                        <div class="field-group field-group-required">
                                            <label for="buyerCompanyName" class="col-form-label">@lang('Company Name')</label>
                                            <input id="buyerCompanyName" type="text" name="buyer_company_name" value="{{ old('buyer_company_name') }}" class="form-control" placeholder="{{ __('Company Name') }}" maxlength="255" required />
                                        </div>
                                        
                                        <div class="field-group">
                                            <label for="buyerTaxNumber" class="col-form-label">@lang('Tax Number')</label>
                                            <input id="buyerTaxNumber" type="text" name="buyer_tax_number" value="{{ old('buyer_tax_number') }}" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" required />
                                        </div>
                                        
                                        <div class="field-group">
                                            <label for="buyerVatNumber" class="col-form-label">@lang('Vat Number')</label>
                                            <input id="buyerVatNumber" type="text" name="buyer_vat_number" value="{{ old('buyer_vat_number') }}" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" required />
                                        </div>
                                        
                                        <div class="field-group">
                                            <label for="buyerAddress" class="col-form-label">@lang('Address')</label>
                                            <input id="buyerAddress" type="text" name="buyer_address" value="{{ old('buyer_address') }}" class="form-control" placeholder="{{ __('Address') }}" maxlength="255" required />
                                        </div>
                                    </div>
                                </div>

                                @include('frontend.invoices.includes.services-info')

                                <div class="form-group row">
                                    <label for="notes" class="col-md-12 col-form-label">@lang('Notes')</label>

                                    <div class="col-md-6">
                                        <textarea class="form-control" name="notes">{{ old('notes') }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Invoice')</button>
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
