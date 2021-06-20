@extends('frontend.layouts.app')

@section('title', __('Your password has expired.'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <x-frontend.card class="transparent-header">
                    <x-slot name="header">
                        <h4 class="pt-3 m-auto">@lang('Your password has expired.')</h4>
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.patch :action="route('frontend.auth.password.expired.update')">
                            <div class="form-group">
                                <label for="current_password">@lang('Current Password')</label>
                                <input type="password" name="current_password" class="form-control" placeholder="{{ __('Current Password') }}" maxlength="100" required autofocus />
                            </div><!--form-group-->

                            <div class="form-group">
                                <label for="password">@lang('New Password')</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('New Password') }}" maxlength="100" required autocomplete="password" />
                            </div><!--form-group-->

                            <div class="form-group">
                                <label for="password_confirmation">@lang('Password Confirmation')</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" maxlength="100" placeholder="{{ __('Password Confirmation') }}" required autocomplete="new-password" />
                            </div><!--form-group-->

                            <div class="form-group mt-4 mb-0">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">@lang('Update Password')</button>
                            </div><!--form-group-->
                        </x-forms.patch>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
