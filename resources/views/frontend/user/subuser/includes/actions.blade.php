<div class="action-buttons">
    @if ($user->trashed())
        <x-utils.form-button
            :action="route('frontend.user.subuser.restore', $user)"
            method="patch"
            button-class="btn btn-info btn-sm"
            icon="fas fa-sync-alt"
            name="confirm-item"
        >
            @lang('Restore')
        </x-utils.form-button>

        @if (config('boilerplate.access.user.permanently_delete'))
            <x-utils.delete-button
                :href="route('frontend.user.subuser.permanently-delete', $user)"
                :text="__('Permanently Delete')" />
        @endif
    @else
        <x-utils.view-button :href="route('frontend.user.subuser.show', $user)" />
        <x-utils.edit-button :href="route('frontend.user.subuser.edit', $user)" />

        @if (! $user->isActive())
            <x-utils.form-button
                :action="route('frontend.user.subuser.mark', [$user, 1])"
                method="patch"
                button-class="btn btn-primary btn-sm"
                icon="fas fa-sync-alt"
                name="confirm-item"
                permission="admin.access.user.reactivate"
            >
                @lang('Reactivate')
            </x-utils.form-button>
        @endif

        <x-utils.delete-button :href="route('frontend.user.subuser.destroy', $user)" />
    @endif
</div>