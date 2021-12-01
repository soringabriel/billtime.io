<div class="action-buttons time-action-buttons">
    @php 
        /*
        @if (($logged_in_user->can('user.access.invoices.show-all') && $model->invoices()->count()))
            <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#{{ $model->id }}-invoices-modal">@lang('Invoices')</button>
            <div class="modal fade" id="{{ $model->id }}-invoices-modal" tabindex="-1" role="dialog" aria-labelledby="{{ $model->id }}-invoices-modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ $model->id }}-invoices-modalLabel">@lang('Associated Invoices')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($model->invoices()->get() as $invoice) 
                                <x-utils.link :href="route('frontend.invoices.download', $invoice)" class="btn btn-link":text="__('$invoice->number')" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($logged_in_user->can('user.access.invoices.access') && $model->invoices()->where('invoices.user_id', $logged_in_user->id)->count())
            <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#{{ $model->id }}-invoices-modal">@lang('Invoices')</button>
            <div class="modal fade" id="{{ $model->id }}-invoices-modal" tabindex="-1" role="dialog" aria-labelledby="{{ $model->id }}-invoices-modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="{{ $model->id }}-invoices-modalLabel">@lang('Associated Invoices')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @foreach ($model->invoices()->where('invoices.user_id', $logged_in_user->id)->get() as $invoice) 
                                <x-utils.link :href="route('frontend.invoices.download', $invoice)" class="btn btn-link":text="__('$invoice->number')" />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
        */
    @endphp
    @if ($model->billed)
        <x-utils.form-button
            :action="route('frontend.time.toggleBilled', $model)"
            method="patch"
            button-class="btn btn-outline-warning btn-sm"
            icon="fas fa-dollar-sign"
            name="confirm-item"
            :title="__('Mark as not billed')"
            permission="user.access.times.mark-billed"
        />
    @else 
        <x-utils.form-button
            :action="route('frontend.time.toggleBilled', $model)"
            :title="__('Mark as billed')"
            method="patch"
            button-class="btn btn-outline-success btn-sm"
            icon="fas fa-dollar-sign"
            name="confirm-item"
            permission="user.access.times.mark-billed"
        />
    @endif
    @if ($model->user()->first()->id == $logged_in_user->id)
        <x-utils.edit-button :href="route('frontend.time.edit', $model)" :title="__('Edit')" text="" />
        <x-utils.delete-button :href="route('frontend.time.destroy', $model)" :title="__('Delete')" text="" />
    @else
        <x-utils.edit-button :href="route('frontend.time.edit', $model)" permission="user.access.times.edit-all" :title="__('Edit')" text="" />
        <x-utils.delete-button :href="route('frontend.time.destroy', $model)" permission="user.access.times.delete-all" :title="__('Delete')" text="" />
    @endif
</div>
