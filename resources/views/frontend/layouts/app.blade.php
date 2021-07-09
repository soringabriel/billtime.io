<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ url(mix('css/frontend.css')) }}" rel="stylesheet">
    <livewire:styles />
    @stack('after-styles')

    @include('includes.partials.ga')

    @include('includes.partials.gtm-head')

    @paddleJS
    
    @crisp

    @auth
        <script>
            $crisp.push(["set", "user:email", "{{ $logged_in_user->email }}"]);
            $crisp.push(["set", "user:nickname", "{{ $logged_in_user->name }}"]);
        </script>
    @endauth
</head>
<body class="c-app {{ Request::segment(count(Request::segments())) }}">

    @include('includes.partials.gtm-body')

    @auth
        @include('frontend.includes.sidebar')
    @endauth

    <div class="c-wrapper c-fixed-components">
        @include('includes.partials.read-only')
        @include('includes.partials.logged-in-as')
        @include('includes.partials.announcements')

        <div id="app" class="c-body">
            @include('frontend.includes.nav')
            @include('includes.partials.messages')

            <main class="c-main">
                @yield('content')
            </main>
        </div><!--app-->
    </div>

    @stack('before-scripts')
    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/frontend.js')) }}"></script>
    <script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>
    <livewire:scripts />
    @stack('after-scripts')

    @auth
        <!-- @include('kustomer::kustomer') -->
    @endauth
</body>
</html>
