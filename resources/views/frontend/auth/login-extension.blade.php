@extends('frontend.layouts.extension')

@section('title', __('Login'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <x-frontend.card class="transparent-header rounded-0">
                <x-slot name="header">
                    <h4 class="pt-3 m-auto">@lang('Login')</h4>
                </x-slot>
                <x-slot name="body">
                    <x-forms.post :action="route('frontend.auth.login')">
                        <div class="form-group">
                            <label for="email">@lang('E-mail Address')</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required autofocus autocomplete="email" />
                        </div><!--form-group-->

                        <div class="form-group">
                            <label for="password">@lang('Password')</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="current-password" />
                        </div><!--form-group-->

                            <input name="remember" id="remember" class="form-check-input d-none" type="checkbox" checked />

                        <div class="form-group mb-0 text-center">
                            <button class="btn btn-primary btn-lg btn-block mt-4 mb-4" type="submit">@lang('Login')</button>
                        </div><!--form-group-->
                    </x-forms.post>
                    <div class="text-center mb-4">
                        @include('frontend.auth.includes.social')
                    </div>
                </x-slot>
            </x-frontend.card>
        </div><!--col-md-8-->
    </div><!--row-->
@endsection
