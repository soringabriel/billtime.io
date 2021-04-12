@extends('frontend.layouts.app')

@section('title', __('Clients'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Clients')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            icon="c-icon cil-plus"
                            class="card-header-action"
                            :href="route('frontend.clients.create')"
                            :text="__('Add Client')"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.clients-table />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
