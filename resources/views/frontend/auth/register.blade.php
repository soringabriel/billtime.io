@extends('frontend.layouts.app')

@section('title', __('Register'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 pt-3 d-flex flex-column justify-content-center align-items-center">
                <h1 class="text-center">@lang('Get Started')</h1>
                <div class="text-center">
                    <h5 class="mt-4 mb-4 d-none d-md-block">@lang('Sign up for free, and you will have access to the full features of our service. No payment info necessary')</h5>
                    <h6 class="mb-3">@lang('No payment info necessary')</h6>
                    <img class="m-auto w-50 d-none d-md-block" src="{{ asset('img/presentation/signup.png#full') }}" alt="Sign Up">
                </div>
            </div>
            <div class="col-md-6 col-lg-4 pt-3">
                <x-frontend.card class="transparent-header">
                    <x-slot name="header">
                        <h4 class="pt-1 pb-1 m-auto">@lang('Sign Up')</h4>
                    </x-slot>

                    <x-slot name="body">
                        <div class="text-center mb-4">
                            @include('frontend.auth.includes.social')
                            <div class="row mt-3 justify-content-center">
                                <span class="mr-1">@lang('Already have an account?')</span>
                                <x-utils.link
                                    :href="route('frontend.auth.login')"
                                    :text="__('Login')" />
                            </div>
                        </div>

                        <x-forms.post :action="route('frontend.auth.register')">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Name') }}" maxlength="100" required autofocus autocomplete="name" />
                            </div><!--form-group-->

                            <div class="form-group">
                                <label for="name">@lang('E-mail Address')</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required autocomplete="email" />
                            </div><!--form-group-->

                            <div class="form-group">
                                <label for="name">@lang('Password')</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />
                            </div><!--form-group-->

                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" name="terms" value="1" id="terms" class="form-check-input" required>
                                    <label class="form-check-label" for="terms">
                                        @lang('I agree to the') <a href="{{ route('frontend.pages.terms') }}" target="_blank">@lang('Terms & Conditions')</a>
                                    </label>
                                </div>
                            </div><!--form-group-->

                            @if(config('boilerplate.access.captcha.registration'))
                                <div class="row">
                                    <div class="col">
                                        @captcha
                                        <input type="hidden" name="captcha_status" value="true" />
                                    </div><!--col-->
                                </div><!--row-->
                            @endif

                            <div class="form-group mb-0">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">@lang('Register')</button>
                            </div><!--form-group-->
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div>
        </div><!--row-->
    </div><!--container-->
@endsection
