@extends('frontend.layouts.app')

@section('title', __('Emails'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Emails')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            class="btn btn-outline-primary"
                            :href="route('frontend.invoices.index')"
                            :text="__('See Invoices List')"
                            permission="user.access.invoices.index"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.emails-table />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
