<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @yield('title')</title>
    <meta name="description" content="@yield('meta_description', appName())">
    <meta name="author" content="@yield('meta_author', 'Anthony Rappa')">
    @yield('meta')

    @stack('before-styles')
    <link rel="shortcut icon" href="{{ asset('img/presentation/favicon.png#full') }}" type="image/png">
    <link href="{{ url(mix('css/presentation.css')) }}" rel="stylesheet">
    <livewire:styles />
    @stack('after-styles')

    @include('includes.partials.ga')
</head>
<body>
    @yield('content')
    @stack('before-scripts')
    <script src="{{ url(mix('js/presentation.js')) }}"></script>
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
