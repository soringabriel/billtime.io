@inject('model', '\App\Models\Project')

@extends('frontend.layouts.app')

@section('title', __('Update Project Record'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.patch :action="route('frontend.projects.update', $project)">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Update Project')
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Name')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the project you want to add') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') ?? $project->name }}" placeholder="{{ __('Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->
                                
                                <div class="form-group row" x-data="{new_client: false}">
                                    <label for="client_id" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Client')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The client you want to associate the project to') }}"></i>
                                    </label>
                                    
                                    <div class="col-md-10">
                                        <span x-show="!new_client">
                                            <select name="client_id" class="form-control select2 mb-2">
                                                @foreach ($clients as $client) 
                                                    <option value="{{ $client->id }}" {{ ($client->id == $project->client_id ? 'selected' : '') }}>{{ $client->name }}</option>    
                                                @endforeach
                                            </select>
                                        </span>
                                        <x-utils.link
                                            icon="c-icon cil-plus"
                                            class="card-header-action"
                                            href="javascript:void(0);"
                                            :text="__('Add Client')"
                                            @click="new_client = !new_client"
                                            permission="user.access.clients.create"
                                            x-show="!new_client"
                                        />
                                        <x-utils.link
                                            icon="c-icon cil-minus"
                                            class="card-header-action"
                                            href="javascript:void(0);"
                                            :text="__('Choose From Existing Clients')"
                                            @click="new_client = !new_client"
                                            permission="user.access.clients.create"
                                            x-show="new_client"
                                        />
                                    </div>
                                    
                                    <div class="col-md-12 mt-2" x-show="new_client">
                                        <input type="hidden" name="new_client" x-bind:value="new_client ? 1 : 0">
                                        @include('frontend.includes.partials.new-client')
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="price" class="col-md-2 col-form-label">
                                        <span>@lang('Price per hour')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Price per hour that the client pays for the project') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="number" name="price" class="form-control" placeholder="{{ __('Price per hour') }}" value="{{ old('price') ?? $project->price }}" step=".01" />
                                    </div>
                                </div><!--form-group-->

                                <div class="form-group row">
                                    <label for="price_currency" class="col-md-2 col-form-label">
                                        <span>@lang('Currency for price')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('Currency for the price per hour, if any is set') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <select name="price_currency" class="form-control select2" required>
                                            @foreach ($currencies as $currency => $symbol)
                                                <option value="{{ currencyCode($currency) }}" {{ old('price_currency') ? (old('price_currency') == currencyCode($currency) ? 'checked' : '') : ($project->price_currency == currencyCode($currency) ? 'checked' : '') }}>{{ $currency }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-outline-primary float-right" type="submit">@lang('Update Project')</button>
                            <x-utils.link class="btn btn-outline-danger float-right mr-3" :href="route('frontend.projects.index')" :text="__('Cancel')" permission="user.access.projects.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
