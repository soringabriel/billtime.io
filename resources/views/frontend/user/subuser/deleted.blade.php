@extends('frontend.layouts.app')

@section('title', __('Deleted Users'))

@section('breadcrumb-links')
    @include('frontend.user.subuser.includes.breadcrumb-links')
@endsection

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Deleted Users')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            class="card-header-action"
                            :href="route('frontend.user.subuser.index')"
                            :text="__('Active Users')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.subusers-table status="deleted" />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
