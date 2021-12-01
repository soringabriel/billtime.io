@props(['href' => '#', 'permission' => false, 'title' => '', 'text' => __('Edit')])

<x-utils.link :href="$href" class="btn btn-outline-primary btn-sm" icon="fas fa-pencil-alt" :text="$text" title="{{ $title }}" permission="{{ $permission }}" />
