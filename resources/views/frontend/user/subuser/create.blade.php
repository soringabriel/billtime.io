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

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-3 col-form-label">
                                        <span class="required-field">@lang('Name')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of your team member') }}"></i>
                                    </label>

                                    <div class="col-md-9">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') }}" maxlength="100" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="email" class="col-md-3 col-form-label">
                                        <span class="required-field">@lang('E-mail Address')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The e-mail address of your team member') }}"></i>
                                    </label>

                                    <div class="col-md-9">
                                        <input type="email" name="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="password" class="col-md-3 col-form-label">
                                        <span class="required-field">@lang('Password')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The password of your team member. He will be able to change it after he activates his account') }}"></i>
                                    </label>

                                    <div class="col-md-9">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-md-3 col-form-label">
                                        <span class="required-field">@lang('Password Confirmation')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Re-type the password to make sure that you wrote it correctly') }}"></i>
                                    </label>

                                    <div class="col-md-9">
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100" required autocomplete="new-password" />
                                    </div>
                                </div><!--form-group-->

                                @include('frontend.user.subuser.includes.permissions')
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Create User')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.user.subuser.index')" :text="__('Cancel')" permission="user.access.users.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
