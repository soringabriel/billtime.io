@extends('frontend.layouts.app')

@section('title', __('Please confirm your password before continuing.'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <x-frontend.card class="transparent-header">
                    <x-slot name="header">
                        <h4 class="pt-3 m-auto">@lang('Please confirm your password before continuing.')</h4>
                    </x-slot>

                    <x-slot name="body">
                        <x-forms.post :action="route('frontend.auth.password.confirm')">
                            <div class="form-group">
                                <label for="password">@lang('Password')</label>
                                <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="current-password" />
                            </div><!--form-group-->

                            <div class="form-group mt-4 mb-0">
                                <button class="btn btn-primary btn-block btn-lg" type="submit">@lang('Confirm Password')</button>
                            </div><!--form-group-->
                        </x-forms.post>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-8-->
        </div><!--row-->
    </div><!--container-->
@endsection
