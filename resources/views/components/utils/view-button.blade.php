@props(['href' => '#', 'permission' => false])

<x-utils.link :href="$href" class="btn btn-outline-info btn-sm" icon="fas fa-search" :text="__('View')" permission="{{ $permission }}" />
