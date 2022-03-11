@extends('frontend.layouts.extension')

@section('title', __('Extension'))

@section('content')
    @include('frontend.includes.partials.counter')

    <div class="text-center mt-4">
        <x-utils.link
            :text="__('Logout')"
            class="m-auto"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <x-slot name="text">
                @lang('Logout')
                <x-forms.post :action="route('frontend.auth.logout-extension')" id="logout-form" class="d-none" />
            </x-slot>
        </x-utils.link>
    </div>
@endsection