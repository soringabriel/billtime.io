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

    @crisp

    @if ($logged_in_user) 
        <script>
            $crisp.push(["set", "user:email", "{{ $logged_in_user->email }}"]);
            $crisp.push(["set", "user:nickname", "{{ $logged_in_user->name }}"]);
        </script>
    @endif
</head>
<body>

    <!--====== HEADER PART START ======-->

    <header class="header-area">
        <div class="navgition navgition-transparent">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="#">
                                <img src="{{ asset('img/presentation/logo.svg#full') }}" alt="Logo">
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
                                            <li class="nav-item">
                                                <a href="{{ route('frontend.auth.register') }}">@lang('Register')</a>
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

        <div id="home" class="header-hero bg_cover" style="background-image: url('{{ asset('img/presentation/header-bg.jpg#full') }}')">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-8 col-lg-10">
                        <div class="header-content text-center">
                            <h3 class="header-title">@lang('TimoTrack')</h3>
                            <p class="text">@lang('Time tracking and invoicing solution for your business')</p>
                            <ul class="header-btn">
                                <li><a class="main-btn btn-one page-scroll" rel="nofollow" href="#pricing">@lang('Free 14 days trial')</a></li>
                                <li><a class="main-btn btn-two page-scroll" href="#about">@lang('Read more about us')</a></li>
                            </ul>
                        </div> <!-- header content -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
            <div class="header-shape">
                <img src="{{ asset('img/presentation/header-shape.svg#full') }}" alt="shape">
            </div>
        </div> <!-- header content -->
    </header>

    <!--====== HEADER PART ENDS ======-->

    <!--====== SERVICES PART START ======-->

    <section id="service" class="services-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-10">
                        <h4 class="title">@lang('Our Services')</h4>
                        <p class="text">@lang('Start tracking and billing time without worries')</p>
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
                                    <p class="text">@lang('Track time for you and your employees, and associate it to projects and tasks.')</p>
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
                                    <p class="text">@lang('Start invoicing your clients in a matter of just a few seconds')</p>
                                </div>
                            </div> <!-- services content -->
                        </div>
                        <div class="col-md-6">
                            <div class="services-content mt-40 d-sm-flex">
                                <div class="services-icon">
                                    <i class="lni-users"></i>
                                </div>
                                <div class="services-content media-body">
                                    <h4 class="services-title">@lang('Employees')</h4>
                                    <p class="text">@lang('Create and edit multiple employees accounts according to your plan')</p>
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
                                    <p class="text">@lang('Continuous support for all our users and developing our platform according to your feedback')</p>
                                </div>
                            </div> <!-- services content -->
                        </div>
                    </div> <!-- row -->
                </div> <!-- row -->
            </div> <!-- row -->
        </div> <!-- conteiner -->
        <div class="services-image d-lg-flex align-items-center">
            <div class="image">
                <img src="{{ asset('img/presentation/services.jpg#full') }}" alt="Services">
            </div>
        </div> <!-- services image -->
    </section>

    <!--====== SERVICES PART ENDS ======-->

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
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Freelancer')</h5>
                            <span class="price">@lang('Free')</span>
                            <p class="year">@lang('of costs')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Manual Time Tracking')</li>
                                <li><i class="lni lni-ban"></i> @lang('No Data Exports')</li>
                                <li><i class="lni lni-ban"></i> @lang('No Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('One user only')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Customer Support')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="{{ route('frontend.auth.register') }}">@lang('TRY NOW FOR FREE')</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>

                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Freelancer Pro')</h5>
                            <span class="price">$ 2,99</span>
                            <p class="year">@lang('per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('One user only')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Customer Support')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="{{ route('frontend.auth.register') }}">@lang('TRY NOW')</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>

                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Startup')</h5>
                            <span class="price">$ 6,99</span>
                            <p class="year">@lang('per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Up to 3 users')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Customer Support')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="{{ route('frontend.auth.register') }}">@lang('TRY NOW')</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>

                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Small Team')</h5>
                            <span class="price">$ 19,99</span>
                            <p class="year">@lang('per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Up to 10 users')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Customer Support')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="{{ route('frontend.auth.register') }}">@lang('TRY NOW')</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
                
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Regular')</h5>
                            <span class="price">$ 49,99</span>
                            <p class="year">@lang('per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Up to 50 users')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Customer Support')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="{{ route('frontend.auth.register') }}">@lang('TRY NOW')</a>
                        </div>
                        <div class="buttom-shape">
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 350 112.35"><defs><style>.color-3{fill:#4da422;isolation:isolate;}.cls-1{opacity:0.1;}.cls-2{opacity:0.2;}.cls-3{opacity:0.4;}.cls-4{opacity:0.6;}</style></defs><title>bottom-part1</title><g id="bottom-part"><g id="Group_747" data-name="Group 747"><path id="Path_294" data-name="Path 294" class="cls-1 color-3" d="M0,24.21c120-55.74,214.32,2.57,267,0S349.18,7.4,349.18,7.4V82.35H0Z" transform="translate(0 0)"/><path id="Path_297" data-name="Path 297" class="cls-2 color-3" d="M350,34.21c-120-55.74-214.32,2.57-267,0S.82,17.4.82,17.4V92.35H350Z" transform="translate(0 0)"/><path id="Path_296" data-name="Path 296" class="cls-3 color-3" d="M0,44.21c120-55.74,214.32,2.57,267,0S349.18,27.4,349.18,27.4v74.95H0Z" transform="translate(0 0)"/><path id="Path_295" data-name="Path 295" class="cls-4 color-3" d="M349.17,54.21c-120-55.74-214.32,2.57-267,0S0,37.4,0,37.4v74.95H349.17Z" transform="translate(0 0)"/></g></g></svg>
                        </div>
                    </div> <!-- single pricing -->
                </div>
                
                <div class="col-lg-4 col-md-7 col-sm-9">
                    <div class="single-pricing mt-40">
                        <div class="pricing-header text-center">
                            <h5 class="sub-title">@lang('Unlimited')</h5>
                            <span class="price">$ 99,99</span>
                            <p class="year">@lang('per month')</p>
                        </div>
                        <div class="pricing-list">
                            <ul>
                                <li><i class="lni-check-mark-circle"></i> @lang('Time Tracking')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Data Exports')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Invoicing')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Unlimited users')</li>
                                <li><i class="lni-check-mark-circle"></i> @lang('Customer Support')</li>
                            </ul>
                        </div>
                        <div class="pricing-btn text-center">
                            <a class="main-btn" href="{{ route('frontend.auth.register') }}">@lang('TRY NOW')</a>
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

    <section id="about" class="about-area" style="background-image: url('{{ asset('img/presentation/about-us.png#full') }}')">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center pb-10">
                        <h4 class="title">@lang('About Us')</h4>
                    </div> 
                </div>
            </div> 
            <div class="row text-center paragraphs">
                <p>@lang('TimoTrack it\'s a tool that wants to come to the help of all businesses, small or large, and provide them a platform to manage their business')</p>
                <p style="display: none">@lang('Our product it\'s in continous development and we seek to improve our services all the time')</p>
                <p style="display: none">@lang('Any sugestions will be welcomed and we will always put customer experience at the top of our priorities!')</p>
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
                                <li><a class="page-scroll" href="#about">@lang('About')</a></li>
                                <li><a class="page-scroll" href="#" class="open-chat">@lang('Contact')</a></li>

                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-link">
                            <h6 class="footer-title">@lang('Product & Services')</h6>
                            <ul>
                                <li><a class="page-scroll" href="#pricing">Products</a></li>
                                <li><a class="page-scroll" href="#service">Services</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-link">
                            <h6 class="footer-title">@lang('Company Details')</h6>
                            <ul>
                                <li><a class="page-scroll">@lang('Marica Sorin-Gabriel PFA')</a></li>
                                <li><a class="page-scroll" href="mailto:sorinmarica4@gmail.com">Send us an email</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-7">
                        <div class="footer-logo-support d-md-flex align-items-end justify-content-between">
                            <div class="footer-logo d-flex align-items-end">
                                <a class="mt-30" href="index.html"><img src="{{ asset('img/presentation/logo.svg#full') }}" alt="Logo"></a>
                            </div> <!-- footer logo -->
                            
                        </div> <!-- footer logo support -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- footer widget -->
    </footer>

    <!--====== FOOTER PART ENDS ======-->

    <!--====== BACK TO TOP PART START ======-->

    <a class="back-to-top" href="#"><i class="lni-chevron-up"></i></a>

    <!--====== BACK TO TOP PART ENDS ======-->

    @stack('before-scripts')
    @include('frontend.includes.presentation-js')
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
