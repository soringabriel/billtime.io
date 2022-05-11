<x-forms.patch :action="route('frontend.user.profile.updateOrganizationDetails')">
    <div class="form-group row">
        <label for="company_name" class="col-md-3 col-form-label text-md-right">@lang('Company Name')</label>

        <div class="col-md-9">
            <input type="text" name="company_name" class="form-control" placeholder="{{ __('Company Name') }}" value="{{ old('company_name') ?? $organization->company_name }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="tax_number" class="col-md-3 col-form-label text-md-right">@lang('Tax Number')</label>

        <div class="col-md-9">
            <input type="text" name="tax_number" class="form-control" placeholder="{{ __('Tax Number') }}" value="{{ old('tax_number') ?? $organization->tax_number }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="vat_number" class="col-md-3 col-form-label text-md-right">@lang('Vat Number')</label>

        <div class="col-md-9">
            <input type="text" name="vat_number" class="form-control" placeholder="{{ __('Vat Number') }}" value="{{ old('vat_number') ?? $organization->vat_number }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="address" class="col-md-3 col-form-label text-md-right">@lang('Address')</label>

        <div class="col-md-9">
            <textarea name="address" class="form-control" placeholder="{{ __('Address') }}" />{{ old('address') ?? $organization->address }}</textarea>
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="bank_name" class="col-md-3 col-form-label text-md-right">@lang('Bank Name')</label>

        <div class="col-md-9">
            <input type="text" name="bank_name" class="form-control" placeholder="{{ __('Bank Name') }}" value="{{ old('bank_name') ?? $organization->bank_name }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="bank_account" class="col-md-3 col-form-label text-md-right">@lang('Bank Account')</label>

        <div class="col-md-9">
            <input type="text" name="bank_account" class="form-control" placeholder="{{ __('Bank Account') }}" value="{{ old('bank_account') ?? $organization->bank_account }}" maxlength="255" />
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="working_days" class="col-md-3 col-form-label text-md-right">@lang('Working Days')</label>

        @php $selected_working_days = json_decode($organization->working_days); @endphp

        <div class="col-md-9">
            <select name="working_days[]" class="form-control select2" multiple required>
                <option value="1" {{ in_array(1, $selected_working_days) ? 'selected' : '' }}>@lang('Monday')</option>
                <option value="2" {{ in_array(2, $selected_working_days) ? 'selected' : '' }}>@lang('Tuesday')</option>
                <option value="3" {{ in_array(3, $selected_working_days) ? 'selected' : '' }}>@lang('Wednesday')</option>
                <option value="4" {{ in_array(4, $selected_working_days) ? 'selected' : '' }}>@lang('Thursday')</option>
                <option value="5" {{ in_array(5, $selected_working_days) ? 'selected' : '' }}>@lang('Friday')</option>
                <option value="6" {{ in_array(6, $selected_working_days) ? 'selected' : '' }}>@lang('Saturday')</option>
                <option value="0" {{ in_array(0, $selected_working_days) ? 'selected' : '' }}>@lang('Sunday')</option>
            </select>
        </div>
    </div><!--form-group-->

    <div class="form-group row">
        <label for="start_hour" class="col-md-3 col-form-label text-md-right">@lang('Start Hour')</label>

        <div class="col-md-9">
            <input type="number" min="0" max="23" name="start_hour" class="form-control" placeholder="{{ __('Start Hour') }}" value="{{ old('start_hour') ?? $organization->start_hour }}" />
        </div>
    </div><!--form-group-->

    <div class="form-group row mb-0">
        <div class="col-md-12 text-right">
            <button class="btn btn-sm btn-outline-primary float-right" type="submit">@lang('Update')</button>
        </div>
    </div><!--form-group-->
</x-forms.patch>
