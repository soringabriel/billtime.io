@props(['href' => '#', 'text' => __('Delete'), 'permission' => false, 'title' => ''])

<x-utils.form-button
    :action="$href"
    method="delete"
    name="delete-item"
    button-class="btn btn-danger btn-sm"
    permission="{{ $permission }}"
    hiddenData="{!! ($attributes['hiddenData'] ?? '[]') !!}"
    title="{{ $title }}"
>
    <i class="fas fa-trash"></i> {{ $text }}
</x-utils.form-button>
