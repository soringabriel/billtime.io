@extends('frontend.layouts.app')

@section('title', __('User Management'))

@section('breadcrumb-links')
    @include('frontend.user.subuser.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('User Management')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            class="card-header-action mr-3"
                            :href="route('frontend.user.subuser.deleted')"
                            :text="__('Deleted Users')"
                        />
                        <x-utils.link
                            class="card-header-action"
                            :href="route('frontend.user.subuser.create')"
                            :text="__('Create User')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.subusers-table />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
