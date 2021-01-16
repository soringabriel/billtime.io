@if ($model->user()->first()->id == $logged_in_user->id)
    <div class="action-buttons">
        <x-utils.edit-button :href="route('frontend.time.edit', $model)" />
        <x-utils.delete-button :href="route('frontend.time.destroy', $model)" />
    </div>
@endif