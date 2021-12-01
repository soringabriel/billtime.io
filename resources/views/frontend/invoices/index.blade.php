@extends('frontend.layouts.app')

@section('title', __('Invoices'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Invoices')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            class="btn btn-outline-primary"
                            :href="route('frontend.invoices.create')"
                            :text="__('Add Invoice')"
                            permission="user.access.invoices.create"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.invoices-table />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
