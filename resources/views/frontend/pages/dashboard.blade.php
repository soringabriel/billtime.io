@extends('frontend.layouts.app')

@section('title', __('Terms & Conditions'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                @if ($logged_in_user->clients()->count() == 0 || $logged_in_user->projects()->count() == 0 || $organization->created_at == $organization->updated_at)
                    <div id="onboarding">
                        <h1 class="mt-3 mb-5">@lang('Welcome to TimoTrack')</h1>
                        <h4 class="mb-5">@lang('Before you can start tracking your time there are a few more steps that you need to complete!')</h4>

                        <ol class="stepper">
                            @if ($logged_in_user->clients()->count() == 0)
                                <li>
                                    <x-utils.link
                                        :href="route('frontend.clients.create')"
                                        :text="__('Add your first client')"
                                        permission="user.access.clients.create"
                                    />
                                </li>
                            @endif
                            @if ($logged_in_user->projects()->count() == 0)
                                <li>
                                    <x-utils.link
                                        :href="route('frontend.projects.create')"
                                        :text="__('Add your first project')"
                                        permission="user.access.projects.create"
                                    />
                                </li>
                            @endif
                            @if ($organization->created_at == $organization->updated_at)
                                <li>
                                    <x-utils.link
                                        :href="route('frontend.user.account') . '#organization'"
                                        :text="__('Update organization details')" />
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
