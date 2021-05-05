@inject('model', '\App\Models\Plan')
@inject('userModel', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Create Plan'))

@section('content')
    <x-forms.post :action="route('admin.plan.store')">
        <x-backend.card>
            <x-slot name="header">
                @lang('Create Plan')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.plan.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div>
                
                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                        <div class="col-md-10">
                            <input type="text"  name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" maxlength="100" required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="price" class="col-md-2 col-form-label">@lang('Price')</label>

                        <div class="col-md-10">
                            <input type="number" name="price" class="form-control" placeholder="{{ __('Price') }}" value="{{ old('price') }}" step=".01"  required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="currency" class="col-md-2 col-form-label">@lang('Currency')</label>

                        <div class="col-md-10">
                            <input type="text" name="currency" class="form-control" placeholder="{{ __('Currency') }}" value="{{ old('currency') }}" maxlength="3" required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="billing_type" class="col-md-2 col-form-label">@lang('Billing Type')</label>

                        <div class="col-md-10">
                            <select name="billing_type" class="form-control" required>
                                @foreach ($model::BILLING_TYPES as $billing_type)
                                    <option value="{{ $billing_type }}">{{ $billing_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="subusers_quota" class="col-md-2 col-form-label">@lang('Subusers Quota')</label>

                        <div class="col-md-10">
                            <input type="number" name="subusers_quota" class="form-control" placeholder="{{ __('Subusers Quota') }}" value="{{ old('subusers_quota') }}" required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="permissions" class="col-md-2 col-form-label">@lang('Additional Permissions')</label>

                        <div class="col-md-10">
                            @include('backend.auth.role.includes.no-permissions-message')

                            <div>
                                @include('backend.auth.includes.partials.permission-type', ['type' => $userModel::TYPE_USER])
                            </div>
                        </div>
                    </div><!--form-group-->

                </div>
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create Plan')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.post>
@endsection
