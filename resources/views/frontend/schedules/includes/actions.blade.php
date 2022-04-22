<div class="action-buttons">
    <x-utils.edit-button :href="route('frontend.schedules.edit', $model)" permission="user.access.schedules.edit" />
    <x-utils.delete-button :href="route('frontend.schedules.destroy', $model)" permission="user.access.schedules.delete" />
</div>