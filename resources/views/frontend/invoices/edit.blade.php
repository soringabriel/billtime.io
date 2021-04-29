@inject('model', '\App\Models\Invoice')

@extends('frontend.layouts.app')

@section('title', __('Update Invoice Record'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.patch :action="route('frontend.invoices.update', $invoice)">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Update Invoice')
                        </x-slot>

                        <x-slot name="headerActions">
                            <x-utils.link class="card-header-action" :href="route('frontend.invoices.index')" :text="__('Cancel')" permission="user.access.invoices.access" />
                        </x-slot>

                        <x-slot name="body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <x-utils.link
                                        :text="__('Invoice')"
                                        class="nav-link active"
                                        id="invoice-tab"
                                        data-toggle="pill"
                                        href="#invoice"
                                        role="tab"
                                        aria-controls="invoice"
                                        aria-selected="true" />

                                    <x-utils.link
                                        :text="__('Associated Times (optional)')"
                                        class="nav-link"
                                        id="times-tab"
                                        data-toggle="pill"
                                        href="#times"
                                        role="tab"
                                        aria-controls="times"
                                        aria-selected="false"/>
                                </div>
                            </nav>

                            <div>
                            <div class="tab-content" id="invoice-tabsContent">
                                <div class="tab-pane fade pt-3 show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                    <div>
                                        <div class="form-group row invoice-row">
                                            <div class="col-md-6">
                                                <div class="field-group field-group-required">
                                                    <label for="number" class="col-form-label">@lang('Invoice Number')</label>
                                                    <input type="text" class="form-control" name="number" placeholder="IN0001" value="{{ old('number') ?? $invoice->number }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field-group field-group-required">
                                                    <label for="name" class="col-form-label">@lang('Date')</label>
                                                    <input type="date" class="form-control" name="date" value="{{ old('date') ?? $invoice->date }}" required>
                                                </div>
                                                <div class="field-group">
                                                    <label for="name" class="col-form-label">@lang('Due Date')</label>
                                                    <input type="date" class="form-control" name="due_date" value="{{ old('due_date') ?? $invoice->due_date }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row invoice-row">
                                            <div class="col-md-6">
                                                <h2>@lang('Seller Information')</h2>

                                                <div class="field-group field-group-required">
                                                    <label for="sellerCompanyName" class="col-form-label">@lang('Seller Name')</label>
                                                    <input id="sellerCompanyName" type="text" name="seller_company_name" value="{{ old('seller_company_name') ?? $invoice->seller_company_name }}" class="form-control" placeholder="{{ __('Seller Name') }}" maxlength="255" required />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="sellerTaxNumber" class="col-form-label">@lang('Tax Number')</label>
                                                    <input id="sellerTaxNumber" type="text" name="seller_tax_number" value="{{ old('seller_tax_number') ?? $invoice->seller_tax_number }}" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="sellerVatNumber" class="col-form-label">@lang('Vat Number')</label>
                                                    <input id="sellerVatNumber" type="text" name="seller_vat_number" value="{{ old('seller_vat_number') ?? $invoice->seller_vat_number }}" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="sellerAddress" class="col-form-label">@lang('Address')</label>
                                                    <input id="sellerAddress" type="text" name="seller_address" value="{{ old('seller_address') ?? $invoice->seller_address }}" class="form-control" placeholder="{{ __('Address') }}" maxlength="255" />
                                                </div>

                                                <div class="field-group">
                                                    <label for="sellerBankName" class="col-form-label">@lang('Bank Name')</label>
                                                    <input id="sellerBankName" type="text" name="seller_bank_name" value="{{ old('seller_bank_name') ?? $invoice->seller_bank_name }}" class="form-control" placeholder="{{ __('Bank Name') }}" maxlength="255" />
                                                </div>

                                                <div class="field-group">
                                                    <label for="sellerBankAccount" class="col-form-label">@lang('Bank Account')</label>
                                                    <input id="sellerBankAccount" type="text" name="seller_bank_account" value="{{ old('seller_bank_account') ?? $invoice->seller_bank_account }}" class="form-control" placeholder="{{ __('Bank Account') }}" maxlength="255" />
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <h2>@lang('Buyer Information')</h2>

                                                <div class="field-group field-group-required">
                                                    <label for="buyerCompanyName" class="col-form-label">@lang('Buyer Name')</label>
                                                    <input id="buyerCompanyName" type="text" name="buyer_company_name" value="{{ old('buyer_company_name') ?? $invoice->buyer_company_name }}" class="form-control" placeholder="{{ __('Buyer Name') }}" maxlength="255" required />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="buyerTaxNumber" class="col-form-label">@lang('Tax Number')</label>
                                                    <input id="buyerTaxNumber" type="text" name="buyer_tax_number" value="{{ old('buyer_tax_number') ?? $invoice->buyer_tax_number }}" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="buyerVatNumber" class="col-form-label">@lang('Vat Number')</label>
                                                    <input id="buyerVatNumber" type="text" name="buyer_vat_number" value="{{ old('buyer_vat_number') ?? $invoice->buyer_vat_number }}" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="buyerAddress" class="col-form-label">@lang('Address')</label>
                                                    <input id="buyerAddress" type="text" name="buyer_address" value="{{ old('buyer_address') ?? $invoice->buyer_address }}" class="form-control" placeholder="{{ __('Address') }}" maxlength="255" />
                                                </div>
                                            </div>
                                        </div>

                                        @include('frontend.invoices.includes.services-info')

                                        <div class="form-group row invoice-row">
                                            <label for="notes" class="col-md-2 col-form-label">@lang('Notes')</label>

                                            <div class="col-md-12">
                                                <textarea class="form-control" name="notes">{{ old('notes') ?? $invoice->notes }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade pt-3 show" id="times" role="tabpanel" aria-labelledby="times-tab">
                                    <div class="form-group">
                                        <h4>@lang('Associated times')</h4>
                                        <livewire:frontend.time-table 
                                            filtersEnabled="1" 
                                            isInvoice="1"
                                            customFiltersEnabled="1" 
                                            bulkActions="0"
                                            bulk="1"
                                            exports="0"
                                            preCheckedValues="{{ json_encode($invoice->times()->pluck('id')->toArray()) }}"
                                        />
                                    </div>
                                </div><!--tab-times-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Invoice')</button>
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
