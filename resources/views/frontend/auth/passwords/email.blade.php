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
                        <x-forms.post :action="route('frontend.auth.password.email')">
                            <div class="form-group">
                                <label for="email">@lang('E-mail Address')</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="{{ __('E-mail Address') }}" maxlength="255" required autofocus autocomplete="email" />
                            </div><!--form-group-->

                            <div class="form-group mt-4 mb-0">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">@lang('Send Password Reset Link')</button>
                            </div><!--form-group-->
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
