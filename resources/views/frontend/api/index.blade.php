@extends('frontend.layouts.app')

@section('title', __('API'))

@section('content')
    <div>
        <div class="container row justify-content-center">
            <div class="col-12">
                <div class="api-docs" x-data="init()">
                    <div class="row flex-reverse-mobile">
                        <div class="col-md-6">
                            <div class="endpoints-picker">
                                <h3>@lang('Choose Endpoint')</h3>
                                <select class="select2" x-model="endpoint">
                                    @if (!$logged_in_user->can('user.access.times.access') &&
                                        !$logged_in_user->can('user.access.clients.access') &&
                                        !$logged_in_user->can('user.access.projects.access') &&
                                        !$logged_in_user->can('user.access.invoices.access'))
                                        <optgroup label="@lang('No permissions')">
                                            <option value="no-permissions">@lang('No permissions')</option>
                                        </optgroup>
                                    @endif
                                    @if ($logged_in_user->can('user.access.times.access'))
                                        <optgroup label="@lang('Times')">
                                            <option value="get-times">@lang('Get Times')</option>
                                            <option value="store-time">@lang('Store Time')</option>
                                            <option value="get-time">@lang('Get Time')</option>
                                            <option value="update-time">@lang('Update Time')</option>
                                            <option value="toggleBilled-time">@lang('Toggle Billed Time')</option>
                                            <option value="delete-time">@lang('Delete Time')</option>
                                        </optgroup>
                                    @endif
                                    @if ($logged_in_user->can('user.access.clients.access'))
                                        <optgroup label="@lang('Clients')">
                                            <option value="get-clients">@lang('Get Clients')</option>
                                            <option value="store-client">@lang('Store Client')</option>
                                            <option value="get-client">@lang('Get Client')</option>
                                            <option value="update-client">@lang('Update Client')</option>
                                            <option value="delete-client">@lang('Delete Client')</option>
                                        </optgroup>
                                    @endif
                                    @if ($logged_in_user->can('user.access.projects.access'))
                                        <optgroup label="@lang('Projects')">
                                            <option value="get-projects">@lang('Get Projects')</option>
                                            <option value="store-project">@lang('Store Project')</option>
                                            <option value="get-project">@lang('Get Project')</option>
                                            <option value="update-project">@lang('Update Project')</option>
                                            <option value="delete-project">@lang('Delete Project')</option>
                                        </optgroup>
                                    @endif
                                    @if ($logged_in_user->can('user.access.invoices.access'))
                                        <optgroup label="@lang('Invoices')">
                                            <option value="get-invoices">@lang('Get Invoices')</option>
                                            <option value="store-invoice">@lang('Store Invoice')</option>
                                            <option value="get-invoice">@lang('Get Invoice')</option>
                                            <!-- <option value="download-invoice">@lang('Download Invoice')</option> -->
                                            <option value="update-invoice">@lang('Update Invoice')</option>
                                            <option value="update-invoice-status">@lang('Update Invoice Status')</option>
                                            <option value="delete-invoice">@lang('Delete Invoice')</option>
                                        </optgroup>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="token">
                                <h3>@lang('Api Token')</h3>
                                <input class="api-token form-control" type="text" disabled="disabled" value="{{ $logged_in_user->api_token }}">
                            </div>
                        </div>
                    </div>

                    <div class="endpoints">
                        <div class="endpoint" x-show="endpoint == 'no-permissions'">@include('frontend.api.endpoints.no-permissions')</div>
                        @if ($logged_in_user->can('user.access.times.access'))
                            <div class="endpoint" x-show="endpoint == 'get-times'">@include('frontend.api.endpoints.get-times')</div>
                            <div class="endpoint" x-show="endpoint == 'store-time'">@include('frontend.api.endpoints.store-time')</div>
                            <div class="endpoint" x-show="endpoint == 'get-time'">@include('frontend.api.endpoints.get-time')</div>
                            <div class="endpoint" x-show="endpoint == 'update-time'">@include('frontend.api.endpoints.update-time')</div>
                            <div class="endpoint" x-show="endpoint == 'toggleBilled-time'">@include('frontend.api.endpoints.toggleBilled-time')</div>
                            <div class="endpoint" x-show="endpoint == 'delete-time'">@include('frontend.api.endpoints.delete-time')</div>
                        @endif
                        @if ($logged_in_user->can('user.access.clients.access'))
                            <div class="endpoint" x-show="endpoint == 'get-clients'">@include('frontend.api.endpoints.get-clients')</div>
                            <div class="endpoint" x-show="endpoint == 'store-client'">@include('frontend.api.endpoints.store-client')</div>
                            <div class="endpoint" x-show="endpoint == 'get-client'">@include('frontend.api.endpoints.get-client')</div>
                            <div class="endpoint" x-show="endpoint == 'update-client'">@include('frontend.api.endpoints.update-client')</div>
                            <div class="endpoint" x-show="endpoint == 'delete-client'">@include('frontend.api.endpoints.delete-client')</div>
                        @endif
                        @if ($logged_in_user->can('user.access.projects.access'))
                            <div class="endpoint" x-show="endpoint == 'get-projects'">@include('frontend.api.endpoints.get-projects')</div>
                            <div class="endpoint" x-show="endpoint == 'store-project'">@include('frontend.api.endpoints.store-project')</div>
                            <div class="endpoint" x-show="endpoint == 'get-project'">@include('frontend.api.endpoints.get-project')</div>
                            <div class="endpoint" x-show="endpoint == 'update-project'">@include('frontend.api.endpoints.update-project')</div>
                            <div class="endpoint" x-show="endpoint == 'delete-project'">@include('frontend.api.endpoints.delete-project')</div>
                        @endif
                        @if ($logged_in_user->can('user.access.invoices.access'))
                            <div class="endpoint" x-show="endpoint == 'get-invoices'">@include('frontend.api.endpoints.get-invoices')</div>
                            <div class="endpoint" x-show="endpoint == 'store-invoice'">@include('frontend.api.endpoints.store-invoice')</div>
                            <div class="endpoint" x-show="endpoint == 'get-invoice'">@include('frontend.api.endpoints.get-invoice')</div>
                            <!-- <div class="endpoint" x-show="endpoint == 'download-invoice'">@include('frontend.api.endpoints.download-invoice')</div> -->
                            <div class="endpoint" x-show="endpoint == 'update-invoice'">@include('frontend.api.endpoints.update-invoice')</div>
                            <div class="endpoint" x-show="endpoint == 'update-invoice-status'">@include('frontend.api.endpoints.update-invoice-status')</div>
                            <div class="endpoint" x-show="endpoint == 'delete-invoice'">@include('frontend.api.endpoints.delete-invoice')</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let defaultEndpoint = 'no-permissions'
        @if ($logged_in_user->can('user.access.invoices.access'))
            defaultEndpoint = 'get-invoices'
        @endif
        @if ($logged_in_user->can('user.access.projects.access'))
            defaultEndpoint = 'get-projects'
        @endif
        @if ($logged_in_user->can('user.access.clients.access'))
            defaultEndpoint = 'get-clients'
        @endif
        @if ($logged_in_user->can('user.access.times.access'))
            defaultEndpoint = 'get-times'
        @endif
        function init() {
            return {
                endpoint: defaultEndpoint
            };
        }
    </script>
@endsection