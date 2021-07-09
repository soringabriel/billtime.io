<!doctype html>
<html lang="{{ htmlLang() }}" @langrtl dir="rtl" @endlangrtl>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ appName() }} | @lang('Business managment tool for time tracking and invoice creation.')</title>
    <meta name="description" content="{{ __('Timo-Track is a business managment tool that allows you and your employees to track and bill your working hours easily. Try out our tool for free and see for yourself how it will improve your business!') }}">
    <meta name="author" content="@yield('meta_author', 'Sorin-Gabriel Marica')">
    <meta name="theme-color" content="#1B99A9">
    <meta name="keywords" content="timetracker,time tracking,time tracker,business managment,invoice creator,billing tool,invoice tool,invoicing tool">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ appName() }} | @lang('Business managment tool for time tracking and invoice creation.')" />
    <meta name="twitter:title" content="{{ appName() }} | @lang('Business managment tool for time tracking and invoice creation.')" />
    <meta name="twitter:description" content="{{ __('Timo-Track is a business managment tool that allows you and your employees to track and bill your working hours easily. Try out our tool for free and see for yourself how it will improve your business!') }}">
    <meta name="twitter:site" content="{{ env('APP_URL') }}">
    <meta name="twitter:image" content="{{ asset('img/presentation/social-image.png#full') }}">
    <meta property="og:description" content="{{ __('Timo-Track is a business managment tool that allows you and your employees to track and bill your working hours easily. Try out our tool for free and see for yourself how it will improve your business!') }}" />
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
    <livewire:styles />
    @stack('after-styles')

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
                            <h1 class="header-title">@lang('Timo-Track')</h1>
                            <p class="text">@lang('Time tracking and invoicing solution for your business')</p>
                            <ul class="header-btn">
                                <li><a class="main-btn btn-one page-scroll" rel="nofollow" href="{{ route('frontend.auth.register') }}">@lang('Try now for free')</a></li>
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
                                    <p class="text">@lang('Create and edit multiple employees accounts and their permissions, according to your plan')</p>
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
                <picture>
                    <source type="image/webp" srcset="{{ asset('img/presentation/services.webp#full') }}">
                    <source type="image/jpg" srcset="{{ asset('img/presentation/services.jpg#full') }}">
                    <img src="{{ asset('img/presentation/services.jpg#full') }}" alt="Services">
                </picture>
            </div>
        </div> <!-- services image -->
    </section>

    <!--====== SERVICES PART ENDS ======-->

    <div class="container align-items-center mb-5">
        <div class="row">
            <div class="offset-md-2 col-md-8 mb-5">
                <a class="btn btn-lg btn-block text-center btn-primary" href="{{ route('frontend.auth.register') }}">@lang('Start now! It\'s free!')</a>
            </div>
        </div>
    </div>

    <!--====== SCREENSHOTS PART START ======-->

    <section id="screenshots" class="screenshots-area mt-5 mb-5">
        <div class="container">
            <div class="row">
                <div id="screenshotsCarousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <picture class="d-block w-100">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/times.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/times.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/times.png#full') }}" alt="{{ __('Times') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <picture class="d-block w-100">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/dashboard.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/dashboard.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/dashboard.png#full') }}" alt="{{ __('Dasbhoard') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <picture class="d-block w-100">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/create-invoice.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/create-invoice.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/create-invoice.png#full') }}" alt="{{ __('Invoice') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <picture class="d-block w-100">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/create-user.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/create-user.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/create-user.png#full') }}" alt="{{ __('Users') }}">
                            </picture>
                        </div>
                        <div class="carousel-item">
                            <picture class="d-block w-100">
                                <source type="image/webp" srcset="{{ asset('img/presentation/screenshots/account.webp#full') }}">
                                <source type="image/png" srcset="{{ asset('img/presentation/screenshots/account.png#full') }}">
                                <img src="{{ asset('img/presentation/screenshots/account.png#full') }}" alt="{{ __('Account') }}">
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

    <!--====== ABOUT US START ======-->

    <section id="about" class="about-area" style="background-image: url('{{ asset('img/presentation/about-us.png#full') }}'); background-image: -webkit-image-set(url('{{ asset('img/presentation/about-us.webp#full') }}') 1x);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section-title text-center pb-10">
                        <h4 class="title">@lang('About Us')</h4>
                    </div> 
                </div>
            </div> 
            <div class="row text-center paragraphs">
                <p>@lang('Timo-Track it\'s a tool that wants to come to the help of all businesses, small or large, and provide them a platform to manage their business')</p>
                <p>@lang('Our product it\'s in continous development and we seek to improve our services all the time')</p>
                <p>@lang('Any sugestions will be welcomed and we will always put customer experience at the top of our priorities!')</p>
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
                                <li><a class="page-scroll" href="#service">@lang('Services')</a></li>
                                <li><a href="{{ route('frontend.auth.register') }}">@lang('Try Now For Free')</a></li>
                            </ul>
                        </div> <!-- footer link -->
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-link">
                            <h6 class="footer-title">@lang('Other Details')</h6>
                            <ul>
                                <li><a href="https://blog.timotrack.com/">@lang('Blog')</a></li>
                                <li><a class="page-scroll" href="mailto:info@timotrack.com">@lang('Send Us An Email')</a></li>
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

    @stack('before-scripts')
    @include('frontend.includes.presentation-js')
    <livewire:scripts />
    @stack('after-scripts')
</body>
</html>
