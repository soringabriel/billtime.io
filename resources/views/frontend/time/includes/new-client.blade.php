<div class="card p-3">
    <h4>@lang('Add New Client')</h4>
    <div class="form-group row">
        <label for="client_name" class="col-md-2 col-form-label">
            <span class="required-field">@lang('Name')</span>
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the client that you\'re working with') }}"></i>
        </label>

        <div class="col-md-10">
            <input type="text" name="client_name" class="form-control" placeholder="{{ __('Name') }}" maxlength="255" required />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="client_company_name" class="col-md-2 col-form-label">
            @lang('Company Name')
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the company of your client') }}"></i>
        </label>

        <div class="col-md-10">
            <input type="text" name="client_company_name" class="form-control" placeholder="{{ __('Company Name') }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="client_tax_number" class="col-md-2 col-form-label">
            @lang('Tax Number')
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The tax number identifier of your client\'s company') }}"></i>
        </label>

        <div class="col-md-10">
            <input type="text" name="client_tax_number" class="form-control" placeholder="{{ __('Tax Number') }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="client_vat_number" class="col-md-2 col-form-label">
            @lang('Vat Number')
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The vat number of your client\'s company') }}"></i>
        </label>

        <div class="col-md-10">
            <input type="text" name="client_vat_number" class="form-control" placeholder="{{ __('Vat Number') }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="client_address" class="col-md-2 col-form-label">
            @lang('Address')
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The address of your client\'s company') }}"></i>
        </label>

        <div class="col-md-10">
            <textarea name="client_address" class="form-control" placeholder="{{ __('Address') }}" /></textarea>
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="client_bank_account" class="col-md-2 col-form-label">
            @lang('Bank Account')
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The bank account of your client\'s company. This will be useful for invoicing.') }}"></i>
        </label>

        <div class="col-md-10">
            <input type="text" name="client_bank_account" class="form-control" placeholder="{{ __('Bank Account') }}" maxlength="255" />
        </div>
    </div><!--form-group-->
</div>