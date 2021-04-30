<div class="sticky-top" id="navsWrapper">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm main-navbar">
        <div class="container">
            <x-utils.link
                :href="route(homeRoute())"
                class="navbar-brand">
                <img src="{{ asset('img/presentation/logo-small.svg#full') }}" alt="Logo">
            </x-utils.link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="@lang('Toggle navigation')">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    <ul class="navbar-nav ml-auto">
                        @if ($logged_in_user->isUser())
                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.time.index')"
                                    :active="activeClass(Route::is('frontend.time.index'))"
                                    :text="__('Track Time')"
                                    class="nav-link"
                                    permission="user.access.times.access" />
                            </li>

                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.invoices.index')"
                                    :active="activeClass(Route::is('frontend.invoices.index'))"
                                    :text="__('Invoices')"
                                    class="nav-link"
                                    permission="user.access.invoices.access" />
                            </li>

                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.clients.index')"
                                    :active="activeClass(Route::is('frontend.clients.index'))"
                                    :text="__('Clients')"
                                    class="nav-link"
                                    permission="user.access.clients.access" />
                            </li>
                                
                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.projects.index')"
                                    :active="activeClass(Route::is('frontend.projects.index'))"
                                    :text="__('Projects')"
                                    class="nav-link"
                                    permission="user.access.projects.access" />
                            </li>

                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.user.subuser.index')"
                                    :active="activeClass(Route::is('frontend.user.subuser.index'))"
                                    :text="__('Users')"
                                    class="nav-link"
                                    permission="user.access.users.access" />
                            </li>
                        @endif
                    </ul>
                @endauth

                <ul class="navbar-nav ml-auto">
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

                    @guest
                        <li class="nav-item">
                            <x-utils.link
                                :href="route('frontend.auth.login')"
                                :active="activeClass(Route::is('frontend.auth.login'))"
                                :text="__('Login')"
                                class="nav-link" />
                        </li>

                        @if (config('boilerplate.access.user.registration'))
                            <li class="nav-item">
                                <x-utils.link
                                    :href="route('frontend.auth.register')"
                                    :active="activeClass(Route::is('frontend.auth.register'))"
                                    :text="__('Register')"
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

    @auth
        @if ($logged_in_user->can('user.access.times.automatic-time'))
            @include('frontend.includes.partials.counter')
        @endif
    @endauth
</div>

@if (config('boilerplate.frontend_breadcrumbs'))
    @include('frontend.includes.partials.breadcrumbs')
@endif
