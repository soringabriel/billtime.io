<div class="action-buttons">
    @if ($model->user()->first()->id == $logged_in_user->id)
        @if (!$model->isPastDue())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-past-due"
                icon="fas fa-file-invoice-dollar"
                button-class="btn btn-outline-danger btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAST_DUE]]) !!}"
            >
                @lang('Mark as Past Due')
            </x-utils.form-button>
        @endif
        @if (!$model->isPaid())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-paid"
                icon="fas fa-file-invoice-dollar"
                button-class="btn btn-outline-success btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAID]]) !!}"
            >
                @lang('Mark as Paid')
            </x-utils.form-button>
        @endif
        @if (!$model->isPending())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-pending"
                icon="fas fa-file-invoice-dollar"
                button-class="btn btn-outline-dark btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PENDING]]) !!}"
            >
                @lang('Mark as Pending')
            </x-utils.form-button>
        @endif
        <!-- <x-utils.link :href="route('frontend.invoices.download', $model)" class="btn btn-outline-info btn-sm" icon="fas fa-download" :text="__('Download')" /> -->
        <!-- <button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#invoiceModal{{ $model->id }}">@lang('Download')</button> -->
        <x-utils.link class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#invoiceModal{{ $model->id }}" icon="fas fa-download" :text="__('Download')" />
        <div class="modal fade" id="invoiceModal{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="invoiceModal{{ $model->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document" x-data="{locale:'en'}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModal{{ $model->id }}Label">@lang('Download Invoice')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="language{{ $model->id }}">@lang('Select Language')</label>

                        <select x-model="locale" class="form-control" id="language{{ $model->id }}">
                            @foreach (config('boilerplate.locale.invoices_languages') as $locale => $language)
                                <option value="{{ $locale }}">{{ $language }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary w-auto" data-dismiss="modal">@lang('Close')</button>
                        <x-utils.link x-bind:href="'{{ route('frontend.invoices.download', $model) }}' + '?locale=' + locale" class="btn btn-outline-primary w-auto" icon="fas fa-download" :text="__('Download')" />
                    </div>
                </div>
            </div>
        </div>
        <x-utils.link class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#emailInvoiceModal{{ $model->id }}" icon="far fa-envelope" :text="__('Send Via Email')" />
        <div class="modal fade" id="emailInvoiceModal{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="emailInvoiceModal{{ $model->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <x-forms.post :action="route('frontend.invoices.sendEmail', $model)">
                        <div class="modal-header">
                            <h5 class="modal-title" id="emailInvoiceModal{{ $model->id }}Label">@lang('Send Invoice Via Email')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="field-group field-group-required">
                                <label for="emailFrom{{ $model->id }}">@lang('From')</label>
                                <input type="email" name="from" placeholder="youremail@email.com" class="form-control" id="emailFrom{{ $model->id }}">
                            </div>
                            <div class="field-group field-group-required">
                            <label for="emailTo{{ $model->id }}">@lang('To')</label>
                                <input type="email" name="to" placeholder="theiremail@email.com" class="form-control" id="emailTo{{ $model->id }}">
                            </div>
                            <div class="field-group field-group-required">
                                <label for="emailLanguage{{ $model->id }}">@lang('Select Language')</label>

                                <select class="form-control" name="locale" id="emailLanguage{{ $model->id }}">
                                    @foreach (config('boilerplate.locale.invoices_languages') as $locale => $language)
                                        <option value="{{ $locale }}">{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="field-group field-group-required mt-3">
                                <label class="font-weight-bold">
                                    <input type="checkbox" name="attach_xls" value="true" class="mr-1">
                                    @lang('Attach XLS file with associated times of the invoice')
                                </label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary w-auto" data-dismiss="modal">@lang('Close')</button>
                            <button class="btn btn-outline-primary w-auto" type="submit">@lang('Send Email')</button>
                        </div>
                    </x-forms.post>
                </div>
            </div>
        </div>
        <x-utils.link :href="route('frontend.invoices.clone', $model)" class="btn btn-outline-info btn-sm" icon="fas fa-clone" :text="__('Clone')" permission="user.access.invoices.create"/>
        <x-utils.edit-button :href="route('frontend.invoices.edit', $model)" />
        <x-utils.delete-button :href="route('frontend.invoices.destroy', $model)" />
    @else
        @if (!$model->isPastDue())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-past-due"
                icon="fas fa-file-invoice-dollar"
                button-class="btn btn-outline-danger btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAST_DUE]]) !!}"
                permission="user.access.invoices.update-status-all"
            >
                @lang('Mark as Past Due')
            </x-utils.form-button>
        @endif
        @if (!$model->isPaid())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-paid"
                icon="fas fa-file-invoice-dollar"
                button-class="btn btn-outline-success btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PAID]]) !!}"
                permission="user.access.invoices.update-status-all"
            >
                @lang('Mark as Paid')
            </x-utils.form-button>
        @endif
        @if (!$model->isPending())
            <x-utils.form-button
                :action="route('frontend.invoices.updateStatus', $model)"
                method="patch"
                name="set-status-pending"
                icon="fas fa-file-invoice-dollar"
                button-class="btn btn-outline-dark btn-sm"
                hiddenData="{!! json_encode([['name' => 'status', 'value' => $model::STATUS_PENDING]]) !!}"
                permission="user.access.invoices.update-status-all"
            >
                @lang('Mark as Pending')
            </x-utils.form-button>
        @endif
        <x-utils.link class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#invoiceModal{{ $model->id }}" icon="fas fa-download" :text="__('Download')" permission="user.access.invoices.show-all" />
        <div class="modal fade" id="invoiceModal{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="invoiceModal{{ $model->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document" x-data="{locale:'en'}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="invoiceModal{{ $model->id }}Label">@lang('Download Invoice')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="language{{ $model->id }}">@lang('Select Language')</label>

                        <select x-model="locale" class="form-control" id="language{{ $model->id }}">
                            @foreach (config('boilerplate.locale.invoices_languages') as $locale => $language)
                                <option value="{{ $locale }}">{{ $language }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary w-auto" data-dismiss="modal">@lang('Close')</button>
                        <x-utils.link x-bind:href="'{{ route('frontend.invoices.download', $model) }}' + '?locale=' + locale" class="btn btn-outline-primary w-auto" icon="fas fa-download" :text="__('Download')" />
                    </div>
                </div>
            </div>
        </div>
        <x-utils.link class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#emailInvoiceModal{{ $model->id }}" icon="far fa-envelope" :text="__('Send Via Email')" />
        <div class="modal fade" id="emailInvoiceModal{{ $model->id }}" tabindex="-1" role="dialog" aria-labelledby="emailInvoiceModal{{ $model->id }}Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <x-forms.post :action="route('frontend.invoices.sendEmail', $model)">
                        <div class="modal-header">
                            <h5 class="modal-title" id="emailInvoiceModal{{ $model->id }}Label">@lang('Send Invoice Via Email')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="field-group field-group-required">
                                <label for="emailFrom{{ $model->id }}">@lang('From')</label>
                                <input type="email" name="from" placeholder="youremail@email.com" class="form-control" id="emailFrom{{ $model->id }}">
                            </div>
                            <div class="field-group field-group-required">
                            <label for="emailTo{{ $model->id }}">@lang('To')</label>
                                <input type="email" name="to" placeholder="theiremail@email.com" class="form-control" id="emailTo{{ $model->id }}">
                            </div>
                            <div class="field-group field-group-required">
                                <label for="emailLanguage{{ $model->id }}">@lang('Select Language')</label>

                                <select class="form-control" name="locale" id="emailLanguage{{ $model->id }}">
                                    @foreach (config('boilerplate.locale.invoices_languages') as $locale => $language)
                                        <option value="{{ $locale }}">{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary w-auto" data-dismiss="modal">@lang('Close')</button>
                            <button class="btn btn-outline-primary w-auto" type="submit">@lang('Send Email')</button>
                        </div>
                    </x-forms.post>
                </div>
            </div>
        </div>
        <x-utils.link :href="route('frontend.invoices.clone', $model)" class="btn btn-outline-info btn-sm" icon="fas fa-clone" :text="__('Clone')" permission="user.access.invoices.create"/>
        <x-utils.edit-button :href="route('frontend.invoices.edit', $model)" permission="user.access.invoices.edit-all" />
        <x-utils.delete-button :href="route('frontend.invoices.destroy', $model)" permission="user.access.invoices.delete-all" />
    @endif
</div>