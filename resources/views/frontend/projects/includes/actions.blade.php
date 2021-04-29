<div class="action-buttons">
    <x-utils.edit-button :href="route('frontend.projects.edit', $model)" permission="user.access.projects.edit" />
    <x-utils.delete-button :href="route('frontend.projects.destroy', $model)" permission="user.access.projects.delete" />
</div>