@if(config('boilerplate.google_analytics') && config('boilerplate.google_analytics') !== 'UA-XXXXX-X')
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('boilerplate.google_analytics') }}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}

    gtag('consent', 'default', {
        'ad_storage': 'denied',
        'analytics_storage': 'denied',
        'functionality_storage': 'denied',
        'personalization_storage': 'denied',
        'security_storage': 'granted',     // strictly necessary
        'ad_user_data': 'denied',
        'ad_personalization': 'denied'
    });
    gtag('js', new Date());

    gtag('config', '{{ config('boilerplate.google_analytics') }}');
    gtag('config', 'AW-848044905');
    </script>
@endif
