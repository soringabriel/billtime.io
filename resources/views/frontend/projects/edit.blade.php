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
                                    <label for="name" class="col-md-2 col-form-label">@lang('Name')</label>

                                    <div class="col-md-10">
                                        <input type="text" name="name" class="form-control" value="{{ old('name') ?? $project->name }}" placeholder="{{ __('Name') }}" maxlength="255" required />
                                    </div>
                                </div><!--form-group-->
                                
                                <div class="form-group row">
                                    <label for="client_id" class="col-md-2 col-form-label">@lang('Client')</label>

                                    <div class="col-md-10">
                                        <select name="client_id" class="form-control select2 mb-2">
                                            @foreach ($clients as $client) 
                                                <option value="{{ $client->id }}" {{ ($client->id == $project->client_id ? 'selected' : '') }}>{{ $client->name }}</option>    
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
                            <button class="btn btn-primary float-right" type="submit">@lang('Update Project')</button>
                            <x-utils.link class="btn btn-danger float-right mr-3" :href="route('frontend.projects.index')" :text="__('Cancel')" permission="user.access.projects.access" />
                        </x-slot>
                    </x-frontend.card>
                </x-forms.patch>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
