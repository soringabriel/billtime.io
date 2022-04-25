@inject('model', '\App\Models\Schedule')

@extends('frontend.layouts.app')

@section('title', __('Update Schedule'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.patch :action="route('frontend.schedules.update', $schedule)">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Update Schedule')
                        </x-slot>

                        <x-slot name="body">
                            <div x-data="{price: {{ $schedule->price_per_hour }}, currency: {{ $schedule->price_currency }}}">
                                <div class="alert alert-info" role="alert">
                                    @lang('With schedules you can schedule recurrent monthly invoices for each project on a specific date of the month.')
                                    @lang('On the specifed date our systems will take all the non billed times for that specific project, and generate an invoice using them.')
                                    @lang('This invoice with the associated times excel will be send to your email and to the organization owner\'s email.')
                                </div>
                                <div class="form-group row">
                                    <label for="project_id" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Project')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The project you\'ll generate the invoices for.') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <select name="project_id" @change="price = $event.target.getAttribute('data-price'); currency = $event.target.getAttribute('data-currency');" class="form-control select2-project mb-2">
                                            @foreach ($projects as $project) 
                                                <option data-price="{{ $project->price }}" data-currency="{{ $project->price_currency }}" value="{{ $project->id }}" {{ old('project_id') ? (old('project_id') == $project->id ? 'checked' : '') : ($schedule->project_id == $project->id ? 'checked' : '') }}>{{ $project->name }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="schedule_trigger" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Day Of The Month')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The day of the month when the new invoice will be generated') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="schedule_trigger" class="form-control" value="{{ old('schedule_trigger') ?? $schedule->schedule_trigger }}" placeholder="{{ __('Day of the month') }}" min="1" max="31" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="price_per_hour" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Price per hour')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Price per hour that the client pays for the project, used for invoices.') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="price_per_hour" x-model="price" class="form-control" value="{{ old('price_per_hour') ?? $schedule->price_per_hour }}" placeholder="{{ __('Price per hour') }}" step=".01" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="price_currency" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Price Currency')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Currency for the price per hour') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <select name="price_currency" class="form-control select2" x-model="currency" required>
                                            @foreach ($currencies as $currency => $symbol)
                                                <option value="{{ currencyCode($currency) }}">{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="discount" class="col-md-2 col-form-label">
                                        <span>@lang('Discount')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Discount for each invoice') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="discount" class="form-control" value="{{ old('discount') ?? $schedule->discount }}" placeholder="{{ __('Discount') }}" min="0" step=".01" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="tax" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Tax Percentage')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The tax percentage for the invoice. Must be a percentage between 0 to 100') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="tax" class="form-control" min="0" max="100" value="{{ old('tax') ?? $schedule->tax }}" placeholder="{{ __('Tax') }}" step=".01" />
                                    </div>
                                </div><!--form-group-->
                                
                                <div class="form-group row">
                                    <label for="shipping" class="col-md-2 col-form-label">
                                        <span>@lang('Shipping')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The cost for shipping. This sum will be added to the total amount of the invoice') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="shipping" class="form-control" min="0" value="{{ old('shipping') ?? $schedule->shipping }}" placeholder="{{ __('Shipping') }}" step=".01" />
                                    </div>
                                </div><!--form-group-->
                                
                                <div class="form-group row">
                                    <label for="service_fee" class="col-md-2 col-form-label">
                                        <span>@lang('Service Fee')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The service fee. This sum will be added to the total amount of the invoice but it will not be taxed.') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="service_fee" class="form-control" min="0" value="{{ old('service_fee') ?? $schedule->service_fee }}" placeholder="{{ __('Service Fee') }}" step=".01" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="notes" class="col-md-2 col-form-label">
                                        <span>@lang('Notes')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Add a few notes that will show up at the bottom of each invoice.') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <textarea class="form-control" name="notes">{{ old('notes') ?? $schedule->notes }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Update Schedule')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.schedules.index')" :text="__('Cancel')" permission="user.access.users.schedule" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
