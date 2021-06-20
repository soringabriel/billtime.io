@extends('frontend.layouts.app')

@section('title', __('Reset Password'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <x-frontend.card class="transparent-header">
                    <x-slot name="header">
                        <h4 class="pt-3 m-auto">@lang('Reset Password')</h4>
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.password.update')">
                            <input type="hidden" name="token" value="{{ $token }}" />

                            <div class="form-group">
                                <label for="email">@lang('E-mail Address')</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ $email ?? old('email') }}" maxlength="255" required autofocus autocomplete="email" />
                            </div><!--form-group-->

                            <div class="form-group">
                                <label for="password">@lang('Password')</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="password" />
                            </div><!--form-group-->

                            <div class="form-group">
                                <label for="password_confirmation">@lang('Password Confirmation')</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />
                            </div><!--form-group-->

                            <div class="form-group mt-4 mb-0">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">@lang('Reset Password')</button>
                            </div><!--form-group-->
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
