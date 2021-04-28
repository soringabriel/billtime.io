<div class="action-buttons">
    <x-utils.edit-button :href="route('frontend.clients.edit', $model)" permission="user.access.clients.edit" />
    <x-utils.delete-button :href="route('frontend.clients.destroy', $model)" permission="user.access.clients.delete" />
</div>