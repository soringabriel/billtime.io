@inject('model', '\App\Models\Project')

@extends('frontend.layouts.app')

@section('title', __('Add Project'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-forms.post :action="route('frontend.projects.store')">
                    <x-frontend.card>
                        <x-slot name="header">
                            @lang('Add Project')
                        </x-slot>

                        <x-slot name="body">
                            <div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Name')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the project you want to add') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" placeholder="{{ __('Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->
                                
                                <div class="form-group row">
                                    <label for="client_id" class="col-md-2 col-form-label">
                                        <span class="required-field">@lang('Client')</span>
                                        <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The client you want to associate the project to') }}"></i>
                                    </label>

                                    <div class="col-md-10">
                                        <select name="client_id" class="form-control select2 mb-2">
                                            @foreach ($clients as $client) 
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'checked' : '' }}>{{ $client->name }}</option>    
                                            @endforeach
                                        </select>
                                        <x-utils.link
                                            icon="c-icon cil-plus"
                                            class="card-header-action"
                                            :href="route('frontend.clients.create')"
                                            :text="__('Add Client')"
                                            permission="user.access.clients.create"
                                        />
                                    </div>
                                </div><!--form-group-->
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <button class="btn btn-primary float-right" type="submit">@lang('Create Project')</button>
                            <x-utils.link class="btn btn-danger mr-3 float-right" :href="route('frontend.projects.index')" :text="__('Cancel')" permission="user.access.projects.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.post>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
