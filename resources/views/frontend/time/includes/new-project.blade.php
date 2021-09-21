<div class="card p-3">
    <h4>@lang('Add New Project')</h4>
    <div class="form-group row">
        <label for="project_name" class="col-md-2 col-form-label">
            <span class="required-field">@lang('Name')</span>
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the project you want to add') }}"></i>
        </label>

        <div class="col-md-10">
            <input type="text" name="project_name" class="form-control" placeholder="{{ __('Name') }}" maxlength="255" required />
        </div>
    </div><!--form-group-->

    <div class="form-group row" x-data="{new_client: false}">
        <label for="project_client_id" class="col-md-2 col-form-label">
            <span class="required-field">@lang('Client')</span>
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The client you want to associate the project to') }}"></i>
        </label>

        <div class="col-md-10">
            <select name="project_client_id" class="form-control select2 mb-2">
                @foreach ($clients as $client) 
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'checked' : '' }}>{{ $client->name }}</option>    
                @endforeach
            </select>
            <x-utils.link
                icon="c-icon cil-plus"
                class="card-header-action"
                :text="__('Add Client')"
                @click="new_client = !new_client"
                permission="user.access.clients.create"
            />
        </div>

        <div class="col-md-12 mt-2" x-show="new_client">
            @include('frontend.time.includes.new-client')
        </div>
    </div><!--form-group-->
</div>