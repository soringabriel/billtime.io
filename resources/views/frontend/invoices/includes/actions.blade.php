<div class="action-buttons">
    <x-utils.view-button :href="route('frontend.invoices.download', $model)" />
    <x-utils.edit-button :href="route('frontend.invoices.edit', $model)" />
    <x-utils.delete-button :href="route('frontend.invoices.destroy', $model)" />
</div>