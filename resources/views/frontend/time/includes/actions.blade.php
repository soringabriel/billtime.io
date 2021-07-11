<div class="action-buttons">
    @php 
        /*
        @if (($logged_in_user->can('user.access.invoices.show-all') && $model->invoices()->count()))
            <button class="btn btn-secondary" data-toggle="modal" data-target="#{{ $model->id }}-invoices-modal">@lang('Invoices')</button>
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
            <button class="btn btn-secondary" data-toggle="modal" data-target="#{{ $model->id }}-invoices-modal">@lang('Invoices')</button>
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
            button-class="btn btn-warning btn-sm"
            icon="fas fa-dollar-sign"
            name="confirm-item"
            permission="user.access.times.mark-billed"
        >
            @lang('Mark as not billed')
        </x-utils.form-button>
    @else 
        <x-utils.form-button
            :action="route('frontend.time.toggleBilled', $model)"
            method="patch"
            button-class="btn btn-success btn-sm"
            icon="fas fa-dollar-sign"
            name="confirm-item"
            permission="user.access.times.mark-billed"
        >
            @lang('Mark as billed')
        </x-utils.form-button>
    @endif
    @if ($model->user()->first()->id == $logged_in_user->id)
        <x-utils.edit-button :href="route('frontend.time.edit', $model)" />
        <x-utils.delete-button :href="route('frontend.time.destroy', $model)" />
    @else
        <x-utils.edit-button :href="route('frontend.time.edit', $model)" permission="user.access.times.edit-all" />
        <x-utils.delete-button :href="route('frontend.time.destroy', $model)" permission="user.access.times.delete-all" />
    @endif
</div>
