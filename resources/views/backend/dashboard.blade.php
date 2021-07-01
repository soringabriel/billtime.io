@inject('userModel', '\App\Domains\Auth\Models\User')
@inject('timeModel', '\App\Models\Time')
@inject('invoiceModel', '\App\Models\Invoice')
@inject('clientModel', '\App\Models\Client')
@inject('projectModel', '\App\Models\Project')


@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Welcome :Name', ['name' => $logged_in_user->name])
        </x-slot>

        <x-slot name="body">
            <h2 class="mb-5">@lang('Welcome to the Dashboard')</h2>
            <div class="row">
                <div class="col-md-6">
                    <h3>@lang('All Time Stats')</h3>
                    <ul>
                        <li class="p-2">@lang('Total Users:') {{ count($userModel::all()) }}</li>
                        <li class="p-2">@lang('Total Times:') {{ count($timeModel::all()) }}</li>
                        <li class="p-2">@lang('Total Invoices:') {{ count($invoiceModel::all()) }}</li>
                        <li class="p-2">@lang('Total Clients:') {{ count($clientModel::all()) }}</li>
                        <li class="p-2">@lang('Total Projects:') {{ count($projectModel::all()) }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>@lang('Today Stats')</h3>
                    <ul>
                        <li class="p-2">@lang('Today Users:') {{ count($userModel::whereDate('created_at', today())->get()) }}</li>
                        <li class="p-2">@lang('Today Times:') {{ count($timeModel::whereDate('created_at', today())->get()) }}</li>
                        <li class="p-2">@lang('Today Invoices:') {{ count($invoiceModel::whereDate('created_at', today())->get()) }}</li>
                        <li class="p-2">@lang('Today Clients:') {{ count($clientModel::whereDate('created_at', today())->get()) }}</li>
                        <li class="p-2">@lang('Today Projects:') {{ count($projectModel::whereDate('created_at', today())->get()) }}</li>
                    </ul>
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection
