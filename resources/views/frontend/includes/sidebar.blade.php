<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand pt-3 pb-3">
        <img class="c-sidebar-brand-full w-50" src="{{ asset('img/presentation/logo-small.svg#full') }}" alt="Logo">
        <img class="c-sidebar-brand-minimized w-50" src="{{ asset('img/presentation/logo-square.png#full') }}" alt="Logo">
    </div><!--c-sidebar-brand-->

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <x-utils.link
                class="c-sidebar-nav-link"
                :href="route('frontend.dashboard')"
                :active="activeClass(Route::is('frontend.dashboard'), 'c-active')"
                icon="c-sidebar-nav-icon cil-speedometer"
                :text="__('Dashboard')" />
        </li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('frontend.time.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                :active="activeClass(Route::is('frontend.time.index'), 'c-active')"
                :text="__('Time Records')"
                icon="c-sidebar-nav-icon cil-clock"
                class="c-sidebar-nav-dropdown-toggle"
                permission="user.access.times.access" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.time.index')"
                        :active="activeClass(Route::is('frontend.time.index'), 'c-active')"
                        :text="__('Time Records List')"
                        icon="c-sidebar-nav-icon cil-list"
                        class="c-sidebar-nav-link"
                        permission="user.access.times.access" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.time.calendar')"
                        :active="activeClass(Route::is('frontend.time.calendar'), 'c-active')"
                        :text="__('Calendar View')"
                        icon="c-sidebar-nav-icon cil-calendar"
                        class="c-sidebar-nav-link"
                        permission="user.access.times.access" />
                </li>    
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.time.create')"
                        :active="activeClass(Route::is('frontend.time.create'), 'c-active')"
                        :text="__('Add Manual Time')"
                        icon="c-sidebar-nav-icon cil-plus"
                        class="c-sidebar-nav-link" />
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('frontend.invoices.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                :active="activeClass(Route::is('frontend.invoices.index'), 'c-active')"
                :text="__('Invoices')"
                icon="c-sidebar-nav-icon fas fa-file-invoice-dollar"
                class="c-sidebar-nav-dropdown-toggle"
                permission="user.access.invoices.access" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.invoices.index')"
                        :active="activeClass(Route::is('frontend.invoices.index'), 'c-active')"
                        :text="__('Invoices List')"
                        icon="c-sidebar-nav-icon cil-list"
                        class="c-sidebar-nav-link"
                        permission="user.access.invoices.access" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.invoices.emails')"
                        :active="activeClass(Route::is('frontend.invoices.emails'), 'c-active')"
                        :text="__('Emails Sent List')"
                        icon="c-sidebar-nav-icon cil-list"
                        class="c-sidebar-nav-link"
                        permission="user.access.invoices.emails" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.invoices.create')"
                        :active="activeClass(Route::is('frontend.invoices.create'), 'c-active')"
                        :text="__('Create Invoice')"
                        icon="c-sidebar-nav-icon cil-plus"
                        class="c-sidebar-nav-link"
                        permission="user.access.invoices.create" />
                </li>
            </ul>
        </li>
        
        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('frontend.user.subuser.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                :active="activeClass(Route::is('frontend.user.subuser.index'), 'c-active')"
                :text="__('Team')"
                icon="c-sidebar-nav-icon fas fa-users"
                class="c-sidebar-nav-dropdown-toggle"
                permission="user.access.users.access" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.user.subuser.index')"
                        :active="activeClass(Route::is('frontend.user.subuser.index'), 'c-active')"
                        :text="__('Team Members')"
                        icon="c-sidebar-nav-icon cil-list"
                        class="c-sidebar-nav-link"
                        permission="user.access.users.access" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.user.subuser.create')"
                        :active="activeClass(Route::is('frontend.user.subuser.create'), 'c-active')"
                        :text="__('Add Team Member')"
                        icon="c-sidebar-nav-icon cil-plus"
                        class="c-sidebar-nav-link"
                        permission="user.access.users.create" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.user.subuser.deleted')"
                        :active="activeClass(Route::is('frontend.user.subuser.deleted'), 'c-active')"
                        :text="__('Deleted Team Members')"
                        icon="c-sidebar-nav-icon cil-trash"
                        class="c-sidebar-nav-link"
                        permission="user.access.users.delete" />
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('frontend.clients.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                :active="activeClass(Route::is('frontend.clients.index'), 'c-active')"
                :text="__('Clients')"
                icon="c-sidebar-nav-icon fas fa-briefcase"
                class="c-sidebar-nav-dropdown-toggle"
                permission="user.access.clients.access" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.clients.index')"
                        :active="activeClass(Route::is('frontend.clients.index'), 'c-active')"
                        :text="__('Clients List')"
                        icon="c-sidebar-nav-icon cil-list"
                        class="c-sidebar-nav-link"
                        permission="user.access.clients.access" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.clients.create')"
                        :active="activeClass(Route::is('frontend.clients.create'), 'c-active')"
                        :text="__('Add Client')"
                        icon="c-sidebar-nav-icon cil-plus"
                        class="c-sidebar-nav-link"
                        permission="user.access.clients.create" />
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('frontend.projects.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                :active="activeClass(Route::is('frontend.projects.index'), 'c-active')"
                :text="__('Projects')"
                icon="c-sidebar-nav-icon fas fa-tasks"
                class="c-sidebar-nav-dropdown-toggle"
                permission="user.access.projects.access" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.projects.index')"
                        :active="activeClass(Route::is('frontend.projects.index'), 'c-active')"
                        :text="__('Projects List')"
                        icon="c-sidebar-nav-icon cil-list"
                        class="c-sidebar-nav-link"
                        permission="user.access.projects.access" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        :href="route('frontend.projects.create')"
                        :active="activeClass(Route::is('frontend.projects.create'), 'c-active')"
                        :text="__('Add Project')"
                        icon="c-sidebar-nav-icon cil-plus"
                        class="c-sidebar-nav-link"
                        permission="user.access.projects.create" />
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-dropdown {{ activeClass(Route::is('frontend.api-docs') || Route::is('frontend.schedules.*'), 'c-open c-show') }}">
            <x-utils.link
                href="#"
                :active="activeClass(Route::is('frontend.api-docs') || Route::is('frontend.schedules.*'), 'c-active')"
                :text="__('Automation')"
                icon="c-sidebar-nav-icon fas fa-code"
                class="c-sidebar-nav-dropdown-toggle"
                permission="user.access.users.schedule" />

            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        class="c-sidebar-nav-link"
                        :href="route('frontend.schedules.index')"
                        :active="activeClass(Route::is('frontend.schedules.*'), 'c-active')"
                        icon="c-sidebar-nav-icon fas fa-clipboard-list"
                        :text="__('Schedules')" />
                </li>
                <li class="c-sidebar-nav-item">
                    <x-utils.link
                        class="c-sidebar-nav-link"
                        :href="route('frontend.api-docs')"
                        :active="activeClass(Route::is('frontend.api-docs'), 'c-active')"
                        icon="c-sidebar-nav-icon fas fa-code"
                        :text="__('API')"
                        permission="user.access.users.api" />
                </li>
            </ul>
        </li>

        <li class="c-sidebar-nav-item">
            <x-utils.link
                class="c-sidebar-nav-link"
                :href="route('frontend.pages.faq')"
                :active="activeClass(Route::is('frontend.pages.faq'), 'c-active')"
                icon="c-sidebar-nav-icon fas fa-question-circle"
                :text="__('Documentation & FAQ')" />
        </li>

    </ul>

    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="#sidebar" data-class="c-sidebar-minimized"></button>
</div><!--sidebar-->
