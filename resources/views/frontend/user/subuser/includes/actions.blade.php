<div class="action-buttons">
    @if ($user->trashed())
        <x-utils.form-button
            :action="route('frontend.user.subuser.restore', $user)"
            method="patch"
            button-class="btn btn-outline-info btn-sm"
            icon="fas fa-sync-alt"
            name="confirm-item"
            permission="user.access.users.delete"
        >
            @lang('Restore')
        </x-utils.form-button>

        @if (config('boilerplate.access.user.permanently_delete'))
            <x-utils.delete-button
                :href="route('frontend.user.subuser.permanently-delete', $user)"
                :text="__('Permanently Delete')"
                permission="user.access.users.delete" />
        @endif
    @elseif (!$user->isOrganizationOwner())
        <x-utils.view-button :href="route('frontend.user.subuser.show', $user)" permission="user.access.users.access" />
        <x-utils.edit-button :href="route('frontend.user.subuser.edit', $user)" permission="user.access.users.edit" />

        @if (! $user->isActive())
            <x-utils.form-button
                :action="route('frontend.user.subuser.mark', [$user, 1])"
                method="patch"
                button-class="btn btn-outline-primary btn-sm"
                icon="fas fa-sync-alt"
                name="confirm-item"
                permission="user.access.users.delete"
            >
                @lang('Reactivate')
            </x-utils.form-button>
        @endif

        <x-utils.delete-button :href="route('frontend.user.subuser.destroy', $user)" permission="user.access.users.delete" />
    @endif
</div>