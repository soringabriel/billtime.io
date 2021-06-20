<div id="navsWrapper">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm main-navbar" style="min-height: 75px">
        <div class="container-fluid">
            @auth
                <button class="c-header-toggler c-class-toggler d-block d-lg-none mfe-auto navbar-toggler" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                    <i class="c-icon c-icon-lg cil-menu"></i>
                </button>
            @endauth

            <x-utils.link
                :href="route(homeRoute())"
                class="navbar-brand d-none d-lg-block">
                <img src="{{ asset('img/presentation/logo-small.svg#full') }}" alt="Logo">
            </x-utils.link>

            <div id="navbarSupportedContent" class="ml-auto">
                <ul class="navbar-nav ml-auto align-items-center flex-row justify-content-between">
                    @auth
                        @if (!is_null($logged_in_user->organization()->first()) && !$logged_in_user->plan()->first()->isBiggest() && $logged_in_user->isOrganizationOwner())
                            <li class="nav-item mr-3">
                                <x-utils.link
                                    :href="route('frontend.plan')"
                                    :text="__('Upgrade')"
                                    class="btn btn-success d-none d-md-block" />
                            </li>
                        @endif
                    @endauth

                    @php 
                        /*
                            @if(config('boilerplate.locale.status') && count(config('boilerplate.locale.languages')) > 1)
                                <li class="nav-item dropdown">
                                    <x-utils.link
                                        :text="__(getLocaleName(app()->getLocale()))"
                                        class="nav-link dropdown-toggle"
                                        id="navbarDropdownLanguageLink"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false" />

                                    @include('includes.partials.lang')
                                </li>
                            @endif
                        */
                    @endphp

                    @guest
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('frontend.auth.login')"
                                :active="activeClass(Route::is('frontend.auth.login'))"
                                :text="__('Login')"
                                class="nav-link mr-3" />
                        </li>

                        @if (config('boilerplate.access.user.registration'))
                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.auth.register')"
                                    :active="activeClass(Route::is('frontend.auth.register'))"
                                    :text="__('Sign Up')"
                                    class="nav-link" />

                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <x-utils.link
                                href="#"
                                id="navbarDropdown"
                                class="nav-link dropdown-toggle"
                                role="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                                v-pre
                            >
                                <x-slot name="text">
                                    <img class="rounded-circle" style="max-height: 20px" src="{{ $logged_in_user->avatar }}" />
                                    {{ $logged_in_user->name }} <span class="caret"></span>
                                </x-slot>
                            </x-utils.link>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if ($logged_in_user->isAdmin())
                                    <x-utils.link
                                        :href="route('admin.dashboard')"
                                        :text="__('Administration')"
                                        class="dropdown-item" />
                                @endif

                                @if ($logged_in_user->isOrganizationOwner())
                                    <x-utils.link
                                        :href="route('frontend.plan')"
                                        :active="activeClass(Route::is('frontend.plan'))"
                                        :text="__('Plan')"
                                        class="dropdown-item" />

                                    <x-utils.link
                                        :href="route('frontend.receipts')"
                                        :active="activeClass(Route::is('frontend.receipts'))"
                                        :text="__('Receipts')"
                                        class="dropdown-item" />
                                @endif

                                <x-utils.link
                                    :href="route('frontend.user.account')"
                                    :active="activeClass(Route::is('frontend.user.account'))"
                                    :text="__('My Account')"
                                    class="dropdown-item" />

                                <x-utils.link
                                    :text="__('Logout')"
                                    class="dropdown-item"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <x-slot name="text">
                                        @lang('Logout')
                                        <x-forms.post :action="route('frontend.auth.logout')" id="logout-form" class="d-none" />
                                    </x-slot>
                                </x-utils.link>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div><!--navbar-collapse-->
        </div><!--container-->
    </nav>
</div>

@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif

@auth
    @if ($logged_in_user->can('user.access.times.automatic-time') && $logged_in_user->isVerified())
        @include('frontend.includes.partials.counter')
    @endif
@endauth
