<div class="card p-3">
    <h4>@lang('Add New Project')</h4>
    <div class="form-group row">
        <label for="project_name" class="col-md-4 col-form-label">
            <span class="required-field">@lang('Name')</span>
            <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The name of the project you want to add') }}"></i>
        </label>

        <div class="col-md-8">
            <input type="text" name="project_name" class="form-control" placeholder="{{ __('Name') }}" maxlength="255" x-bind:required="new_project" />
        </div>
    </div><!--form-group-->

    <template x-if="new_project">
        <div class="form-group row" x-data="{new_client: false}">
            <label for="project_client_id" class="col-md-4 col-form-label">
                <span class="required-field">@lang('Client')</span>
                <i class="ml-2 far fa-question-circle" data-toggle="tooltip" data-placement="bottom" title="{{ __('The client you want to associate the project to') }}"></i>
            </label>

            <div class="col-md-8">
                <span x-show="!new_client">
                    <select name="project_client_id" class="form-control select2 mb-2">
                        @foreach ($clients as $client) 
                            <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'checked' : '' }}>{{ $client->name }}</option>    
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
    </template>
</div>