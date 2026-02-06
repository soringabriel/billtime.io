<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BillTime | @lang('Time tracking and billing software')</title>
    <meta name="description" content="{{ __('Easy to use software, that allows you and your employees to track and bill your working hours easily.') }}">
    <meta name="author" content="@yield('meta_author', 'Sorin-Gabriel Marica')">
    <meta name="theme-color" content="#1B99A9">
    <meta name="keywords" content="timetracker,time tracking,time tracker,business managment,invoice creator,billing tool,invoice tool,invoicing tool">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="BillTime | @lang('Time tracking and billing software')" />
    <meta name="twitter:title" content="BillTime | @lang('Time tracking and billing software')" />
    <meta name="twitter:description" content="{{ __('Easy to use software, that allows you and your employees to track and bill your working hours easily.') }}">
    <meta name="twitter:site" content="{{ env('APP_URL') }}">
    <meta name="twitter:image" content="{{ asset('img/presentation/social-image.png#full') }}">
    <meta property="og:description" content="{{ __('Easy to use software, that allows you and your employees to track and bill your working hours easily.') }}" />
    <meta property="og:image" content="{{ asset('img/presentation/social-image.png#full') }}" />
    <meta property="og:url" content="{{ env('APP_URL') }}" />
    <meta property="fb:app_id" content="579550796341146" />
    <link rel="apple-touch-icon" href="{{ asset('img/presentation/logo-square.png#full') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/presentation/logo-square.png#full') }}">
    <link rel="alternate" href="{{ env('APP_URL') }}" hreflang="en-US" />

    @yield('meta')

    @stack('before-styles')
    <link rel="shortcut icon" href="{{ asset('img/presentation/favicon.png#full') }}" type="image/png">
    <link href="{{ url(mix('css/presentation.css')) }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('cookie-banner/consent-manager.css') }}">
    <script src="{{ asset('cookie-banner/consent-manager.js') }}"></script>
    <livewire:styles />
    @stack('after-styles')

    <script>
        silktideCookieBannerManager.updateCookieBannerConfig({
        background: {
            showBackground: true
        },
        cookieIcon: {
            position: "bottomLeft"
        },
        cookieTypes: [
            {
            id: "necessary",
            name: "Necessary",
            description: "<p>These cookies are necessary for the website to function properly and cannot be switched off. They help with things like logging in and setting your privacy preferences.</p>",
            required: true,
            onAccept: function() {
                console.log('Add logic for the required Necessary here');
            }
            },
            {
            id: "analytics",
            name: "Analytics",
            description: "<p>These cookies help us improve the site by tracking which pages are most popular and how visitors move around the site.</p>",
            required: false,
            onAccept: function() {
                gtag('consent', 'update', {
                analytics_storage: 'granted',
                });
                dataLayer.push({
                'event': 'consent_accepted_analytics',
                });
            },
            onReject: function() {
                gtag('consent', 'update', {
                analytics_storage: 'denied',
                });
            }
            },
            {
            id: "advertising",
            name: "Advertising",
            description: "<p>These cookies provide extra features and personalization to improve your experience. They may be set by us or by partners whose services we use.</p>",
            required: false,
            onAccept: function() {
                gtag('consent', 'update', {
                ad_storage: 'granted',
                ad_user_data: 'granted',
                ad_personalization: 'granted',
                });
                dataLayer.push({
                'event': 'consent_accepted_advertising',
                });
            },
            onReject: function() {
                gtag('consent', 'update', {
                ad_storage: 'denied',
                ad_user_data: 'denied',
                ad_personalization: 'denied',
                });
            }
            }
        ],
        text: {
            banner: {
            description: "<p>We use cookies on our site to enhance your user experience, provide personalized content, and analyze our traffic.</p>",
            acceptAllButtonText: "Accept all",
            acceptAllButtonAccessibleLabel: "Accept all cookies",
            rejectNonEssentialButtonText: "Reject non-essential",
            rejectNonEssentialButtonAccessibleLabel: "Reject non-essential",
            preferencesButtonText: "Preferences",
            preferencesButtonAccessibleLabel: "Toggle preferences"
            },
            preferences: {
            title: "Customize your cookie preferences",
            description: "<p>We respect your right to privacy. You can choose not to allow some types of cookies. Your cookie preferences will apply across our website.</p>"
            },
        },
        position: {
            banner: "bottomCenter"
        }
        });
    </script>

    @include('includes.partials.ga')

    @include('includes.partials.gtm-head')

    @crisp

    @if ($logged_in_user) 
        <script>
            $crisp.push(["set", "user:email", "{{ $logged_in_user->email }}"]);
            $crisp.push(["set", "user:nickname", "{{ $logged_in_user->name }}"]);
        </script>
    @endif
</head>
<body>

    @include('includes.partials.gtm-body')

    @include('includes.partials.messages')
    
    <!--====== HEADER PART START ======-->

    <header class="header-area">
        <div class="navgition navgition-transparent">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="#">
                                <img src="{{ asset('img/presentation/logo.svg#full') }}" loading="lazy" alt="Logo">
                            </a>

                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarOne" aria-controls="navbarOne" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarOne">
                                <ul class="navbar-nav m-auto">
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="#home">@lang('Home')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#service">@lang('Services')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#pricing">@lang('Pricing')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">@lang('About')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll open-chat" href="#">@lang('Contact')</a>
                                    </li>
                                </ul>
                                <ul class="navbar-nav m-auto">
                                    @auth
                                        @if ($logged_in_user->isUser())
                                            <li class="nav-item">
                                                <a href="{{ route('frontend.time.index') }}">@lang('Track Time')</a>
                                            <li>
                                        @endif
                                        
                                        <li class="nav-item">
                                            <a href="{{ route('frontend.user.account') }}">@lang('Account')</a>
                                        </li>
                                    @else
                                        <li class="nav-item">
                                            <a href="{{ route('frontend.auth.login') }}">@lang('Login')</a>
                                        </li>

                                        @if (config('boilerplate.access.user.registration'))
                                            <li class="nav-item register-btn-wrapper">
                                                <a class="register-btn" href="{{ route('frontend.auth.register') }}">@lang('Sign Up')</a>
                                            </li>
                                        @endif
                                    @endauth
                                </ul>
                            </div>
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- navgition -->

        <div id="home" class="header-hero bg_cover" style="background-image: url('{{ asset('img/presentation/header-bg.jpg#full') }}'); background-image: -webkit-image-set(url('{{ asset('img/presentation/header-bg.webp#full') }}') 1x);">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="header-content text-center">
                            <h2 class="header-title">@lang('Bill Your Company\'s Time')</h2>
                            <h1 class="text font-weight-normal">@lang('Time tracking and invoicing software')</h1>
                            <ul class="header-btn">
                                <li><a class="main-btn btn-one page-scroll" rel="nofollow" href="{{ route('frontend.auth.register') }}">@lang('Try now for free')</a></li>
                                <li><a class="main-btn btn-two page-scroll" href="#about">@lang('Read more about us')</a></li>
                            </ul>
                        </div> <!-- header content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div class="header-shape">
                <img src="{{ asset('img/presentation/header-shape.svg#full') }}" loading="lazy" alt="shape">
            </div>
        </div> <!-- header content -->
    </header>

    <!--====== HEADER PART ENDS ======-->

    <!--====== COMPANIES PART START ======-->

    <!-- <section id="companies" class="companies-area">
        <div class="container">
            <div class="d-flex companies-images">
                <img loading="lazy"  class="w-80" src="{{ asset('img/presentation/companies/hootsuite.png#full') }}" alt="hootsuite">
                <img loading="lazy"  class="w-80" src="{{ asset('img/presentation/companies/meta.png#full') }}" alt="meta">
                <img loading="lazy"  class="w-80" src="{{ asset('img/presentation/companies/palantir.png#full') }}" alt="palantir">
                <img loading="lazy"  class="w-80" src="{{ asset('img/presentation/companies/pwc.png#full') }}" alt="pwc">
            </div>
        </div>
    </section> -->
    
    <!--====== COMPANIES PART ENDS ======-->

    <!--====== SERVICES PART START ======-->

    <section id="service" class="services-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-10">
                        <h4 class="title">@lang('Our Services')</h4>
                        <h3 class="text font-weight-normal">@lang('Start tracking and billing time without worries')</h3>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-alarm-clock"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">@lang('Time Tracking')</h4>
                                    <h3 class="text font-weight-normal">@lang('Track time for you and your employees, and associate it to projects and tasks.')</h3>
                                </div>
                            </div> <!-- services content -->
                        </div>
                        <div class="col-md-6">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-files"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">@lang('Invoicing')</h4>
                                    <h3 class="text font-weight-normal">@lang('Start invoicing your clients in a matter of seconds')</h3>
                                </div>
                            </div> <!-- services content -->
                        </div>
                        <div class="col-md-6">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-code-alt"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">@lang('Auotmation')</h4>
                                    <h3 class="text font-weight-normal">@lang('Use our vast API endpoints, or schedule new invoices as you need')</h3>
                                </div>
                            </div> <!-- services content -->
                        </div>
                        <div class="col-md-6">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni lni-support"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">@lang('Support')</h4>
                                    <h3 class="text font-weight-normal">@lang('Continuous support for all our users and developing our platform according to your feedback')</h3>
                                </div>
                            </div> <!-- services content -->
                        </div>
                    </div> <!-- row -->
                </div> <!-- row -->
            </div> <!-- row -->
        </div> <!-- conteiner -->
        <div class="services-image d-lg-flex align-items-center">
            <div class="image">
                <picture>
                    <source type="image/webp" srcset="{{ asset('img/presentation/services.webp#full') }}">
                    <source type="image/jpg" srcset="{{ asset('img/presentation/services.jpg#full') }}">
                    <img loading="lazy"  src="{{ asset('img/presentation/services.jpg#full') }}" alt="Services">
                </picture>
            </div>
        </div> <!-- services image -->
    </section>

    <!--====== SERVICES PART ENDS ======-->

    <div class="container align-items-center mb-5">
        <div class="row">
            <div class="offset-md-2 col-md-8 mb-5">
                <a class="btn btn-lg btn-block text-center btn-primary" href="{{ route('frontend.auth.register') }}">@lang('Start now, it\'s free!')</a>
            </div>
        </div>
    </div>

    <!--====== SCREENSHOTS PART START ======-->

    <section id="screenshots" class="screenshots-area mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div class="section-title w-100 mt-5">
                    <h4 class="title text-center mb-5 w-100">@lang('A glance in our software')</h3>
                </div>
                <div id="screenshotsCarousel" class="carousel slide mb-5" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <p class="text-center mb-5 lead">@lang('Sign up for your free account, no credit card required')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/register.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/register.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/register.png#full') }}" alt="{{ __('Register') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('After activation, check out your dashboard, which will lead you through your first steps on BillTime.io')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/dashboard.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/dashboard.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/dashboard.png#full') }}" alt="{{ __('Dasbhoard') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('Start adding your times, either by starting the counter or adding manual times')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/add-time.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/add-time.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/add-time.png#full') }}" alt="{{ __('Add Time') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('Bill your clients in a matter of seconds while keeping track of the times you bill')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/add-invoice.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/add-invoice.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/add-invoice.png#full') }}" alt="{{ __('Add Invoice') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('Download your first invoice created, as a PDF')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/invoice-example.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/invoice-example.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/invoice-example.png#full') }}" alt="{{ __('Invoice Example') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('Add team members to your organization')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/team-members.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/team-members.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/team-members.png#full') }}" alt="{{ __('Team Members') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('Schedule Invoices')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/add-schedule.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/add-schedule.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/add-schedule.png#full') }}" alt="{{ __('Add Schedule') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <p class="text-center mb-5 lead">@lang('Use our API to automate your team processes')</p>
                            <picture class="d-block w-100 border border-dark">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/api.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/api.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/api.png#full') }}" alt="{{ __('API') }}">
                            </picture>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#screenshotsCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon carousel-controller" aria-hidden="true"></span>
                        <span class="sr-only">@lang('Previous')</span>
                    </a>
                    <a class="carousel-control-next" href="#screenshotsCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon carousel-controller" aria-hidden="true"></span>
                        <span class="sr-only">@lang('Next')</span>
                    </a>
                </div>
            </div>
        </div> <!-- conteiner -->
    </section>

    <!--====== SCREENSHOTS PART ENDS ======-->

    <!--====== PRICING PART START ======-->

    <section id="pricing" class="pricing-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center pb-10">
                        <h4 class="title">@lang('Pricing')</h4>
                        <p class="text">@lang('Check out our plans and choose according to your needs')</p>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row justify-content-center">
                <div class="col-xxl-3 col-lg-5 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Free')</h5>
                            <span class="price">@lang('Free')</span>
                            <p class="year">@lang('of costs')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni lni-ban"></i> @lang('No Invoicing')</li>
                                <li><i class="lni lni-ban"></i> @lang('No Automation/API')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('One user only')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <p class="mb-4 text-secondary">@lang('Least amount of benefits')</p>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>

                <div class="col-xxl-3 col-lg-5 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Freelancer')</h5>
                            <span class="price">$ 3,99</span>
                            <p class="year">@lang('per user, per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni lni-ban"></i> @lang('No Automation/API')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('One user only')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <p class="mb-4 text-secondary">@lang('$3,99 in total, per month')</p>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>

                <div class="col-xxl-3 col-lg-5 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Startup')</h5>
                            <span class="price">$ 2,49</span>
                            <p class="year">@lang('per user, per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Automation & API')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Up to 20 users')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <p class="mb-4 text-secondary">@lang('$49,99 in total, per month')</p>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
                
                <div class="col-xxl-3 col-lg-5 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Company')</h5>
                            <span class="price">$ 0,01</span>
                            <p class="year">@lang('per user, per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Automation & API')</li>
                                <li><i class="lni-check-mark-circle"></i> <strong>@lang('Unlimited users')</strong></li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <p class="mb-4 text-secondary">@lang('$149,99 in total, per month')</p>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
            </div> <!-- row -->
        </div> <!-- conteiner -->
    </section>

    <!--====== PRICING PART ENDS ======-->

    <!--====== ABOUT US START ======-->

    <section id="about" class="about-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center pb-10">
                        <h4 class="title">@lang('About Us')</h4>
                    </div> 
                </div>
            </div> 
            <div class="row text-center paragraphs">
                <p>@lang('BillTime.io it\'s a tool that wants to take away all the troubles and discomfort that comes from time tracking and invoicing, so that you can focus on other things more important for your company.')</p>
                <p>@lang('We\'re constantly looking for ways to improve our features and to make our user\'s life easier.')</p>
                <p>@lang('Your feedback and sugestions are very important to us, as we believe this is vital for our product to acheive its goals')</p>
            </div> 
        </div> 
    </section>

    <!--====== ABOUT US ENDS ======-->

    <!--====== FOOTER PART START ======-->

    <footer id="footer" class="footer-area">
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <div class="footer-link">
                            <h6 class="footer-title">@lang('Links')</h6>
                            <ul>
                                <li><a href="{{ route('frontend.pages.faq') }}">@lang('FAQ')</a></li>
                                <li><a class="page-scroll" href="#" class="open-chat">@lang('Contact')</a></li>

                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-link">
                            <h6 class="footer-title">@lang('Services')</h6>
                            <ul>
                                <li><a class="page-scroll" href="#service">@lang('Our Services')</a></li>
                                <li><a href="{{ route('frontend.auth.register') }}">@lang('Register For Free')</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-link">
                            <h6 class="footer-title">@lang('Other Details')</h6>
                            <ul>
                                <li><a href="https://blog.billtime.io/">@lang('Blog')</a></li>
                                <li><a class="page-scroll" href="mailto:info@billtime.io">@lang('Send Us An Email')</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-7">
                        <div class="footer-logo-support d-md-flex align-items-end justify-content-between">
                            <div class="footer-logo d-flex align-items-end">
                                <a class="mt-30" href="#"><img loading="lazy"  src="{{ asset('img/presentation/logo.svg#full') }}" alt="Logo"></a>
                            </div> <!-- footer logo -->
                            
                        </div> <!-- footer logo support -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer widget -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->

    @include('includes.partials.schemas')

    @stack('before-scripts')
    @include('frontend.includes.presentation-js')
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
