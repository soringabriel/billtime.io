@inject('model', '\App\Models\Plan')
@inject('userModel', '\App\Domains\Auth\Models\User')

@extends('backend.layouts.app')

@section('title', __('Update Plan'))

@section('content')
    <x-forms.patch :action="route('admin.plan.update', $plan)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Update Plan')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.plan.index')" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div>

                    <div class="form-group row">
                        <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                        <div class="col-md-10">
                            <input type="text"  name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $plan->name }}" maxlength="100" required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="price" class="col-md-2 col-form-label">@lang('Price')</label>

                        <div class="col-md-10">
                            <input type="number" name="price" class="form-control" placeholder="{{ __('Price') }}" value="{{ old('price') ?? $plan->price }}" step=".01"  required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="currency" class="col-md-2 col-form-label">@lang('Currency')</label>

                        <div class="col-md-10">
                            <input type="text" name="currency" class="form-control" placeholder="{{ __('Currency') }}" value="{{ old('currency') ?? $plan->currency }}" maxlength="3" required />
                        </div>
                    </div><!--form-group-->

                    <div class="form-group row">
                        <label for="currency" class="col-md-2 col-form-label">@lang('Subusers Quota')</label>

                        <div class="col-md-10">
                            <input type="number" name="subusers_quota" class="form-control" placeholder="{{ __('Subusers Quota') }}" value="{{ old('subusers_quota') ?? $plan->subusers_quota }}" required />
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
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update Plan')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection
