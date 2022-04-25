@if(config('boilerplate.google_analytics') && config('boilerplate.google_analytics') !== 'UA-XXXXX-X')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('boilerplate.google_analytics') }}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ config('boilerplate.google_analytics') }}');
    gtag('config', 'AW-848044905');
    </script>
@endif
