@extends('frontend.layouts.app')

@section('title', __('Projects'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Projects')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link
                            icon="c-icon cil-plus"
                            class="card-header-action"
                            :href="route('frontend.projects.create')"
                            :text="__('Add Project')"
                            permission="user.access.projects.create"
                        />
                    </x-slot>

                    <x-slot name="body">
                        <livewire:frontend.projects-table />
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
