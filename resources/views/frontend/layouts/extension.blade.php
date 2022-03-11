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
</head>
<body class="c-app {{ Request::segment(count(Request::segments())) }}">
    <div class="c-wrapper c-fixed-components">
        <div id="app" class="c-body">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @stack('before-scripts')
    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/frontend.js')) }}"></script>
    <script src="{{ asset('vendor/kustomer/js/kustomer.js') }}" defer></script>
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
