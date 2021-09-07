<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{!! !empty($title) ? $title : 'Job Portal' !!}</title>

    <!-- Favicons -->
    <link type="image/x-icon" href="" rel="icon">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" {{ !request()->is('payment*') ? 'defer' : '' }}></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Script -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/slick.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */

    </script>

</head>

<body
    class="{{ request()->routeIs('home') ? ' home ' : '' }} {{ request()->routeIs('job_view') ? ' job-view-page ' : '' }}">
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-light navbar-laravel transparent-navbar">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        App Job Portal
                    </a>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}"><i class="la la-home"></i>
                                @lang('app.home')</a> </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item">
                            <a class="nav-link btn btn-main text-white" href=""><i class="las la-bullhorn"></i>
                                {{ __('app.post_new_job') }} </a>
                        </li>

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}"><i class="la la-sign-in"></i>
                                    {{ __('app.login') }}</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="registerDropdown" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-user-plus"></i> {{ __('app.register') }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="registerDropdown">
                                    <a class="dropdown-item" href="{{ route('register_job_seeker') }}"><i
                                            class="la la-user-tie"></i> @lang('app.job_seeker')</a>
                                    <hr class="dropdown-divider">
                                    <a class="dropdown-item" href="{{ route('register_employer') }}"><i
                                            class="la la-building"></i> @lang('app.employer')</a>
                                </div>
                            </li>

                        @else
                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="la la-user"></i> {{ Auth::user()->name }}
                                    <span class="badge badge-warning"><i class="la la-briefcase"></i>
                                        {{ auth()->user()->premium_jobs_balance }}</span>
                                    <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('app.dashboard') }}
                                    </a>


                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <div class="main-container">
            @yield('content')
        </div>

        <div id="main-footer" class="main-footer bg-gray py-5">

            <div class="container">
                <div class="row">
                    <div class="col-md-4">

                        <div class="footer-logo-wrap mb-4">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                @lang('app.about') {!! get_option('site_name') !!}
                            </a>
                        </div>

                        <div class="footer-menu-wrap">
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="">@lang('app.about_us')</a> </li>
                                <li class="mb-2"><a href="">@lang('app.terms_and_condition')</a> </li>
                                <li class="mb-2"><a href="">@lang('app.contact_us')</a> </li>
                            </ul>
                        </div>

                    </div>


                    <div class="col-md-4">

                        <div class="footer-menu-wrap">
                            <h4 class="mb-4 text-secondary">@lang('app.job_seeker')</h4>

                            <ul class="list-unstyled">
                                <li class="mb-2"><a
                                        href="{{ route('register_job_seeker') }}">@lang('app.create_account')</a> </li>
                                <li class="mb-2"><a href="">@lang('app.search_jobs')</a> </li>
                                <li class="mb-2"><a href="">@lang('app.applied_jobs')</a> </li>
                            </ul>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="footer-menu-wrap">
                            <h4 class="mb-4 text-secondary">@lang('app.employer')</h4>

                            <ul class="list-unstyled">
                                <li class="mb-2"><a
                                        href="{{ route('register_employer') }}">@lang('app.create_account')</a> </li>
                                <li class="mb-2"><a href="">@lang('app.post_new_job')</a> </li>
                            </ul>

                        </div>

                    </div>


                </div>

            </div>

        </div>

        <footer class="container d-flex justify-content-end">

            <p class><a href="">@lang('app.terms_and_condition')</a> · {!! get_text_tpl(get_option('copyright_text')) !!}</p>

        </footer>


    </div>

    <!-- Scripts -->
    @yield('page-js')
</body>

</html>
