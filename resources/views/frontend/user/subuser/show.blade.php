@extends('frontend.layouts.app')

@section('title', __('View User'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('View User')
                    </x-slot>

                    <x-slot name="headerActions">
                        <x-utils.link class="card-header-action" :href="route('frontend.user.subuser.index')" :text="__('Back')" />
                    </x-slot>

                    <x-slot name="body">
                        <table class="table table-hover">
                            <tr>
                                <th>@lang('Avatar')</th>
                                <td><img src="{{ $user->avatar }}" class="user-profile-image" /></td>
                            </tr>

                            <tr>
                                <th>@lang('Name')</th>
                                <td>{{ $user->name }}</td>
                            </tr>

                            <tr>
                                <th>@lang('E-mail Address')</th>
                                <td>{{ $user->email }}</td>
                            </tr>

                            <tr>
                                <th>@lang('Status')</th>
                                <td>@include('frontend.user.subuser.includes.status', ['user' => $user])</td>
                            </tr>

                            <tr>
                                <th>@lang('Verified')</th>
                                <td>@include('frontend.user.subuser.includes.verified', ['user' => $user])</td>
                            </tr>

                            <tr>
                                <th>@lang('2FA')</th>
                                <td>@include('frontend.user.subuser.includes.2fa', ['user' => $user])</td>
                            </tr>

                            <tr>
                                <th>@lang('Timezone')</th>
                                <td>{{ $user->timezone ?? __('N/A') }}</td>
                            </tr>

                            <tr>
                                <th>@lang('Last Login At')</th>
                                <td>
                                    @if($user->last_login_at)
                                        @displayDate($user->last_login_at)
                                    @else
                                        @lang('N/A')
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>@lang('Last Known IP Address')</th>
                                <td>{{ $user->last_login_ip ?? __('N/A') }}</td>
                            </tr>
                        </table>
                    </x-slot>

                    <x-slot name="footer">
                        <small class="float-right text-muted">
                            <strong>@lang('Account Created'):</strong> @displayDate($user->created_at) ({{ $user->created_at->diffForHumans() }}),
                            <strong>@lang('Last Updated'):</strong> @displayDate($user->updated_at) ({{ $user->updated_at->diffForHumans() }})

                            @if($user->trashed())
                                <strong>@lang('Account Deleted'):</strong> @displayDate($user->deleted_at) ({{ $user->deleted_at->diffForHumans() }})
                            @endif
                        </small>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
