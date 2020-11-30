@inject('model', '\App\Domains\Auth\Models\User')

@extends('frontend.layouts.app')

@section('title', __('Create User'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.post :action="route('frontend.user.subuser.store')">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Create User')
                        </x-slot>

                        <x-slot name="headerActions">
                            <x-utils.link class="card-header-action" :href="route('frontend.user.subuser.index')" :text="__('Cancel')" />
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" maxlength="100" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="email" class="col-md-2 col-form-label">@lang('E-mail Address')</label>

                                    <div class="col-md-10">
                                        <input type="email" name="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="password" class="col-md-2 col-form-label">@lang('Password')</label>

                                    <div class="col-md-10">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-md-2 col-form-label">@lang('Password Confirmation')</label>

                                    <div class="col-md-10">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Create User')</button>
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
