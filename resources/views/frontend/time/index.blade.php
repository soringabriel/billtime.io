@extends('frontend.layouts.app')

@section('title', __('Time Records'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Time Tracking')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            icon="c-icon cil-plus"
                            class="card-header-action"
                            :href="route('frontend.time.create')"
                            :text="__('Add Manual Time')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.time-table />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
