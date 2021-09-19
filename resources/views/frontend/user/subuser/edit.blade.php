@inject('model', '\App\Domains\Auth\Models\User')

@extends('frontend.layouts.app')

@section('title', __('Update User'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.patch :action="route('frontend.user.subuser.update', $user)">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Update User')
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-3 col-form-label">
                                        <span class="required-field">@lang('Name')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of your team member') }}"></i>
                                    </label>

                                    <div class="col-md-9">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" value="{{ old('name') ?? $user->name }}" maxlength="100" required />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="email" class="col-md-3 col-form-label">
                                        <span class="required-field">@lang('E-mail Address')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The e-mail address of your team member') }}"></i>
                                    </label>

                                    <div class="col-md-9">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('E-mail Address') }}" value="{{ old('email') ?? $user->email }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->

                                @include('frontend.user.subuser.includes.permissions')
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Update User')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.user.subuser.index')" :text="__('Cancel')" permission="user.access.users.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
