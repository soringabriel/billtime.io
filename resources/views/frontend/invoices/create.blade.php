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

                            <div class="tab-content" id="invoice-tabsContent">
                                <div class="tab-pane fade pt-3 show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                    <div>
                                        <div class="form-group row invoice-row">
                                            <div class="col-md-6">
                                                <div class="field-group field-group-required">
                                                    <label for="number" class="col-form-label">
                                                        <span class="required-field">@lang('Invoice Number')</span>
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The unqiue number identifier of the invoice') }}"></i>
                                                    </label>
                                                    <input type="text" class="form-control" name="number" placeholder="IN0001" value="{{ old('number') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="field-group field-group-required">
                                                    <label for="name" class="col-form-label">
                                                        <span class="required-field">@lang('Date')</span>
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The date of the invoice') }}"></i>
                                                    </label>
                                                    <input type="date" class="form-control" name="date" value="{{ old('date') ?? date('Y-m-d') }}" required>
                                                </div>
                                                <div class="field-group">
                                                    <label for="name" class="col-form-label">
                                                        @lang('Due Date')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The due date of the invoice. This represents the deadline for the buyer to pay the invoice') }}"></i>
                                                    </label>
                                                    <input type="date" class="form-control" name="due_date" value="{{ old('due_date') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row invoice-row">
                                            <div class="col-md-6">
                                                <h2>
                                                    @lang('Seller Information')
                                                    <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The seller is the entity that sells a service or a product. In general it should be your organization') }}"></i>
                                                </h2>

                                                <div class="field-group field-group-required">
                                                    <label for="sellerCompanyName" class="col-form-label">
                                                        <span class="required-field">@lang('Seller Name')</span>
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name/company name of the seller') }}"></i>
                                                    </label>
                                                    <input id="sellerCompanyName" type="text" name="seller_company_name" value="{{ old('seller_company_name') ?? $organization->company_name }}" class="form-control" placeholder="{{ __('Seller Name') }}" maxlength="255" required />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="sellerTaxNumber" class="col-form-label">
                                                        @lang('Tax Number')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The tax number of the seller') }}"></i>
                                                    </label>
                                                    <input id="sellerTaxNumber" type="text" name="seller_tax_number" value="{{ old('seller_tax_number') ?? $organization->tax_number }}" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="sellerVatNumber" class="col-form-label">
                                                        @lang('Vat Number')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The vat number of the seller') }}"></i>
                                                    </label>
                                                    <input id="sellerVatNumber" type="text" name="seller_vat_number" value="{{ old('seller_vat_number') ?? $organization->vat_number }}" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="sellerAddress" class="col-form-label">
                                                        @lang('Address')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The address of the seller') }}"></i>
                                                    </label>
                                                    <input id="sellerAddress" type="text" name="seller_address" value="{{ old('seller_address') ?? $organization->address }}" class="form-control" placeholder="{{ __('Address') }}" maxlength="255" />
                                                </div>

                                                <div class="field-group">
                                                    <label for="sellerBankName" class="col-form-label">
                                                        @lang('Bank Name')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The bank name of the seller') }}"></i>
                                                    </label>
                                                    <input id="sellerBankName" type="text" name="seller_bank_name" value="{{ old('seller_bank_name') ?? $organization->bank_name }}" class="form-control" placeholder="{{ __('Bank Name') }}" maxlength="255" />
                                                </div>

                                                <div class="field-group">
                                                    <label for="sellerBankAccount" class="col-form-label">
                                                        @lang('Bank Account')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The bank account of the seller. This is where the buyer should send the payment') }}"></i>
                                                    </label>
                                                    <input id="sellerBankAccount" type="text" name="seller_bank_account" value="{{ old('seller_bank_account') ?? $organization->bank_account }}" class="form-control" placeholder="{{ __('Bank Account') }}" maxlength="255" />
                                                </div>
                                            </div>

                                            <div class="col-md-6" x-data="initBuyer()">
                                                <h2>
                                                    @lang('Buyer Information')
                                                    <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The seller is the entity that buys a service or a product. In general it should be one of your clients') }}"></i>
                                                </h2>

                                                <div class="field-group field-group-required">
                                                    <label for="buyerClient" class="col-form-label">
                                                        @lang('Select Info From Clients')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Prefill the buyer information with the ones from one of your clients') }}"></i>
                                                    </label>
                                                    <select x-model="buyerClient" x-on:change="updateBuyer()" class="form-control">
                                                        @foreach ($clients as $client)
                                                            <option value="{{ json_encode($client) }}">{{ $client->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="field-group field-group-required">
                                                    <label for="buyerCompanyName" class="col-form-label">
                                                        <span class="required-field">@lang('Buyer Name')</span>
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name/company name of the buyer') }}"></i>
                                                    </label>
                                                    <input id="buyerCompanyName" x-model="buyerCompanyName" type="text" name="buyer_company_name" value="{{ old('buyer_company_name') }}" class="form-control" placeholder="{{ __('Buyer Name') }}" maxlength="255" required />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="buyerTaxNumber" class="col-form-label">
                                                        @lang('Tax Number')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The tax number of the buyer') }}"></i>
                                                    </label>
                                                    <input id="buyerTaxNumber" x-model="buyerTaxNumber" type="text" name="buyer_tax_number" value="{{ old('buyer_tax_number') }}" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="buyerVatNumber" class="col-form-label">
                                                        @lang('Vat Number')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The vat number of the buyer') }}"></i>
                                                    </label>
                                                    <input id="buyerVatNumber" x-model="buyerVatNumber" type="text" name="buyer_vat_number" value="{{ old('buyer_vat_number') }}" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" />
                                                </div>
                                                
                                                <div class="field-group">
                                                    <label for="buyerAddress" class="col-form-label">
                                                        @lang('Address')
                                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The address of the buyer') }}"></i>
                                                    </label>
                                                    <input id="buyerAddress" x-model="buyerAddress" type="text" name="buyer_address" value="{{ old('buyer_address') }}" class="form-control" placeholder="{{ __('Address') }}" maxlength="255" />
                                                </div>
                                            </div>
                                        </div>

                                        @include('frontend.invoices.includes.services-info')

                                        <div class="form-group row invoice-row">
                                            <label for="notes" class="col-md-12 col-form-label">
                                                @lang('Notes')
                                                <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Add a few notes that will show up at the bottom of the invoice. For example you could write the exchange rate, if you receive the money in a different currency than the one on the invoice') }}"></i>
                                            </label>

                                            <div class="col-md-6">
                                                <textarea class="form-control" name="notes">{{ old('notes') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--tab-invoice-->

                                <div class="tab-pane fade pt-3 show" id="times" role="tabpanel" aria-labelledby="times-tab">
                                    <div class="form-group">
                                        <h4>@lang('Associated times')</h4>
                                        <div class="alert alert-info" role="alert">
                                            @lang('If you want to create a link between your invoice and the time records added by your organization, you can create that link by checking the times from this table.')
                                            @lang('Each invoice can have associated multiple times and each time can have associated multiple invoices.')
                                            @lang('Associating a time to an invoice will automatically mark the time as billed.')
                                        </div>
                                        <livewire:frontend.time-table 
                                            filtersEnabled="1" 
                                            isInvoice="1"
                                            customFiltersEnabled="1" 
                                            bulkActions="0"
                                            bulk="1"
                                            exports="0"
                                            preCheckedValues="{{ json_encode(old('times')) }}"
                                         />
                                    </div>
                                </div><!--tab-times-->
                            </div>

                            <div class="alert alert-info">@lang('Once you create the invoice you can download it in multiple languages. For any translation mistakes or any other translation needed please contact us and we will add them as soon as possible.')</div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Create Invoice')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.invoices.index')" :text="__('Cancel')" permission="user.access.invoices.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->

    <script>
        function initBuyer() {
            return {
                buyerClient: [],
                buyerCompanyName: "{{ old('buyer_company_name') }}",
                buyerTaxNumber: "{{ old('buyerTaxNumber') }}",
                buyerVatNumber: "{{ old('buyerVatNumber') }}",
                buyerAddress: "{{ old('buyerAddress') }}",
                updateBuyer() {
                    var buyerDetails = JSON.parse(this.buyerClient);
                    this.buyerCompanyName = (buyerDetails.company_name ?? buyerDetails.name ?? '');
                    this.buyerTaxNumber = (buyerDetails.tax_number ?? '');
                    this.buyerVatNumber = (buyerDetails.vat_number ?? '');
                    this.buyerAddress = (buyerDetails.address ?? '');
                },
            };
        }
    </script>
@endsection
