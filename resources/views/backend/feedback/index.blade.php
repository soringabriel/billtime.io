@extends('backend.layouts.app')

@section('title', __('Feedbacks'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Feedbacks')
        </x-slot>

        <x-slot name="body">
            <livewire:backend.feedbacks-table />
        </x-slot>
    </x-backend.card>
@endsection
