@extends('backend.layouts.app')

@section('title', __('Plans'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Plans')
        </x-slot>

        <x-slot name="headerActions">
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :href="route('admin.plan.create')"
                :text="__('Create Plan')"
            />
        </x-slot>

        <x-slot name="body">
            <livewire:backend.plans-table />
        </x-slot>
    </x-backend.card>
@endsection
