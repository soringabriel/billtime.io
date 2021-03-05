<x-forms.patch :action="route('frontend.user.profile.updateCompanyDetails')">
    <div class="form-group row">
        <label for="company_name" class="col-md-3 col-form-label text-md-right">@lang('Company Name')</label>

        <div class="col-md-9">
            <input type="text" name="company_name" class="form-control" placeholder="{{ __('Company Name') }}" value="{{ old('company_name') ?? $logged_in_user->company_name }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="tax_number" class="col-md-3 col-form-label text-md-right">@lang('Tax Number')</label>

        <div class="col-md-9">
            <input type="text" name="tax_number" class="form-control" placeholder="{{ __('Tax Number') }}" value="{{ old('tax_number') ?? $logged_in_user->tax_number }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="vat_number" class="col-md-3 col-form-label text-md-right">@lang('Vat Number')</label>

        <div class="col-md-9">
            <input type="text" name="vat_number" class="form-control" placeholder="{{ __('Vat Number') }}" value="{{ old('vat_number') ?? $logged_in_user->vat_number }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="address" class="col-md-3 col-form-label text-md-right">@lang('Address')</label>

        <div class="col-md-9">
            <textarea name="address" class="form-control" placeholder="{{ __('Address') }}" />{{ old('address') ?? $logged_in_user->address }}</textarea>
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="bank_account" class="col-md-3 col-form-label text-md-right">@lang('Bank Account')</label>

        <div class="col-md-9">
            <input type="text" name="bank_account" class="form-control" placeholder="{{ __('Bank Account') }}" value="{{ old('bank_account') ?? $logged_in_user->bank_account }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row mb-0">
        <div class="col-md-12 text-right">
            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
        </div>
    </div><!--form-group-->
</x-forms.patch>
