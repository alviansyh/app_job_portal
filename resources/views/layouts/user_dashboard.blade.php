<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{!! !empty($title) ? $title . ' | ' . get_option('site_name') : get_option('site_name') !!}</title>

  <!-- Favicons -->
  <link type="image/x-icon" href="" rel="icon">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

  <!-- Fontawesome CSS -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

  <!-- Main CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

  @yield('page-css')
</head>

<body>
  @php
    $user = Auth::user();
  @endphp

  @if ($user->is_user())
    <style>
      .widget-profile .profile-info-widget .booking-doc-img img {
        object-fit: cover !important;
        object-position: 100% 20% !important;
      }

      .user-img>img {
        object-fit: cover !important;
        object-position: 100% 20% !important;
      }

      .avatar>img {
        object-fit: cover !important;
        object-position: 100% 20% !important;
      }

    </style>
  @endif
  <!-- Main Wrapper -->
  <div class="main-wrapper">

    <!-- Header -->
    <header class="header">
      <nav class="navbar navbar-expand-lg header-nav">
        <div class="navbar-header">
          <a id="mobile_btn" href="javascript:void(0);">
            <span class="bar-icon">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </a>
          <a href="{{ url('/') }}" class="navbar-brand logo">
            <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo">
          </a>
        </div>

        <div class="main-menu-wrapper">
          <div class="menu-header">
            <a href="{{ url('/') }}" class="menu-logo">
              <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo">
            </a>
            <a id="menu_close" class="menu-close" href="javascript:void(0);">
              <i class="fas fa-times"></i>
            </a>
          </div>
          <ul class="main-nav">
            <li class="{{ request()->is('/') ? 'active' : null }}">
              <a href="{{ route('home') }}">{{ __('app.home') }}</a>
            </li>
            @guest
              <li
                class="nav-mobile {{ request()->is('login') ? 'active' : null }} {{ request()->is('jobseeker-register') ? 'active' : null }} {{ request()->is('employer-register') ? 'active' : null }}">
                <a href="{{ route('login') }}">{{ __('app.login') }} / {{ __('app.register') }}</a>
              </li>
            @else
              @if ($user->is_user() || $user->is_employer())
                <li class="{{ request()->is('account*') ? 'active' : null }}">
                  <a href="{{ route('user_dashboard') }}">{{ __('app.dashboard') }}</a>
                </li>
                @if ($user->is_employer())
                  <li class="nav-mobile ">
                    <a href="{{ route('new_job_ads') }}">{{ __('app.post_new_job') }}</a>
                  </li>
                @endif
                <li class="nav-mobile has-submenu">
                  <a href="#" class="">{{ __('app.my_account') }} <i class="fas fa-chevron-down"></i></a>
                  <ul class="submenu" style="display: none;">
                    <li><a href="{{ route('profile_settings') }}">{{ __('app.profile_settings') }}</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#logoutModal">@lang('app.logout')</a></li>
                  </ul>
                </li>
              @endif
            @endguest
          </ul>
        </div>

        <ul class="nav header-navbar-rht">
          @guest
            <li class="nav-item">
              <a class="nav-link header-login" href="{{ route('login') }}">{{ __('app.login') }} /
                {{ __('app.register') }} </a>
            </li>
          @else
            @if ($user->is_employer())
              <li class="nav-item">
                <a class="nav-link btn btn-primary" href="{{ route('new_job_ads') }}"><i class="fas fa-bullhorn"></i>
                  {{ __('app.post_new_job') }}</a>
              </li>
            @endif

            <!-- User Menu -->
            <li class="nav-item dropdown has-arrow logged-item">
              <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <span class="user-img">
                  <img class="rounded-circle" src="{{ $path_avatar }}" width="31" alt="">
                </span>
              </a>
              <div class="dropdown-menu dropdown-menu-right">
                <div class="user-header">
                  <div class="avatar avatar-sm">
                    <img src="{{ $path_avatar }}" alt="User Image" class="avatar-img rounded-circle">
                  </div>
                  <div class="user-text">
                    <h6>{{ Auth::user()->name }}</h6>
                  </div>
                </div>
                @if ($user->is_user() || $user->is_employer())
                  <a class="dropdown-item" href="{{ route('user_dashboard') }}">{{ __('app.dashboard') }}</a>
                  <a class="dropdown-item" href="{{ route('profile_settings') }}">{{ __('app.profile_settings') }}</a>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">@lang('app.logout')</a>
                @endif
              </div>
            </li>
            <!-- /User Menu -->
          @endguest
        </ul>
      </nav>
    </header>
    <!-- /Header -->

    <!-- Content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="breadcrumb-bar">
          <div class="container-fluid">
            <div class="row align-items-center">
              <div class="col-md-12 col-12">
                <h2 class="breadcrumb-title">{{ !empty($title) ? $title : __('app.dashboard') }}</h2>
              </div>
            </div>
          </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Page Content -->
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-5 col-lg-4 col-xl-3 theiaStickySidebar">

                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                  <div class="widget-profile pro-widget-content">
                    <div class="profile-info-widget">
                      <div class="booking-doc-img">
                        <img src="{{ $path_avatar }}" alt="User Image">
                      </div>
                      <div class="profile-det-info">
                        @if ($user->is_employer())
                          <h3>{{ $company }}</h3>
                          {{-- <i class="far fa-check-circle" style="color: #084298" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('app.verified')"></i> --}}
                        @elseif ($user->is_user())
                          <h3>{{ $name }}</h3>
                        @endif

                      </div>
                      @if ($user->is_employer())
                        <div class="patient-details">
                          <h5><i class="fas fa-user"></i> {{ $name }}
                          </h5>
                        </div>
                      @elseif ($user->is_user())
                      @endif
                    </div>
                  </div>
                  <div class="dashboard-widget">
                    
                    @if ($user->is_employer())

                      <nav class="dashboard-menu">
                        <ul>
                          <li class="{{ request()->is('account/dashboard') ? 'active' : null }}">
                            <a href="{{ route('user_dashboard') }}">
                              <i class="fas fa-columns"></i>
                              <span>@lang('app.dashboard')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/applied-jobs*') ? 'active' : null }}">
                            <a href="{{ route('applied_jobs') }}">
                              <i class="fas fa-users"></i>
                              <span>@lang('app.applicant')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/job-ads*') ? 'active' : null }}">
                            <a href="{{ route('job_ads') }}">
                              <i class="fas fa-bullhorn"></i>
                              <span>@lang('app.job_ads')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/reviews*') ? 'active' : null }}">
                            <a href="{{ route('reviews') }}">
                              <i class="fas fa-star"></i>
                              <span>@lang('app.reviews')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/notifications*') ? 'active' : null }}">
                            <a href="{{ route('notifications') }}">
                              <i class="fas fa-bell"></i>
                              <span>@lang('app.notifications')</span>
                              <small class="unread-msg">0</small>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/validations*') ? 'active' : null }}">
                            <a href="{{ route('validation') }}">
                              <i class="fas fa-user-check"></i>
                              <span>@lang('app.account_validation')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/profile-settings*') ? 'active' : null }}">
                            <a href="{{ route('profile_settings') }}">
                              <i class="fas fa-user-cog"></i>
                              <span>@lang('app.profile_settings')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/change-password') ? 'active' : null }}">
                            <a href="{{ route('change_password') }}">
                              <i class="fas fa-lock"></i>
                              <span>@lang('app.change_password')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/logout*') ? 'active' : null }}">
                            <a href="#" data-toggle="modal" data-target="#logoutModal">
                              <i class="fas fa-sign-out-alt"></i>
                              <span>@lang('app.logout')</span>
                            </a>
                          </li>
                        </ul>
                      </nav>

                    @elseif($user->is_user())

                      <nav class="dashboard-menu">
                        <ul>
                          <li class="{{ request()->is('account/dashboard') ? 'active' : null }}">
                            <a href="{{ route('user_dashboard') }}">
                              <i class="fas fa-columns"></i>
                              <span>@lang('app.dashboard')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/profile-settings*') ? 'active' : null }}">
                            <a href="{{ route('profile_settings') }}">
                              <i class="fas fa-user-cog"></i>
                              <span>@lang('app.profile_settings')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/change-password') ? 'active' : null }}">
                            <a href="{{ route('change_password') }}">
                              <i class="fas fa-lock"></i>
                              <span>@lang('app.change_password')</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('account/logout*') ? 'active' : null }}">
                            <a href="#" data-toggle="modal" data-target="#logoutModal">
                              <i class="fas fa-sign-out-alt"></i>
                              <span>@lang('app.logout')</span>
                            </a>
                          </li>
                        </ul>
                      </nav>

                    @endif
                  </div>
                </div>
                <!-- /Profile Sidebar -->

              </div>

              <div class="col-md-7 col-lg-8 col-xl-9">
                @yield('content')
              </div>
            </div>
          </div>
        </div>
        <!-- /Page Content -->
      </div>
    </div>
    <!-- /Content -->

    <!-- Footer -->
    <footer class="footer">

      <!-- Footer Top -->
      <div class="footer-top">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-md-6">

              <!-- Footer Widget -->
              <div class="footer-widget footer-menu">
                <div class="footer-logo">
                  <a href="{{ url('/') }}" class="navbar-brand logo mb-4">
                    <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid" alt="Logo">
                  </a>
                  <ul>
                    <li><a href=""><i class="fas fa-angle-double-right"></i>
                        @lang('app.about_us')</a></li>
                    <li><a href=""><i class="fas fa-angle-double-right"></i>
                        @lang('app.terms_and_condition')</a></li>
                    <li><a href=""><i class="fas fa-angle-double-right"></i>
                        @lang('app.send_feedback')</a></li>
                  </ul>
                </div>

                <div class="footer-about-content">
                  <!-- <div class="social-icon">
           <ul>
            <li>
             <a href="#" target="_blank"><i class="fab fa-facebook-f"></i> </a>
            </li>
            <li>
             <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            </li>
            <li>
             <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
            </li>
           </ul>
          </div> -->
                </div>
              </div>
              <!-- /Footer Widget -->

            </div>

            <div class="col-lg-3 col-md-6">

              <!-- Footer Widget -->
              <div class="footer-widget footer-menu">
                <h2 class="footer-title">@lang('app.job_seeker')</h2>
                <ul>
                  <li><a href="{{ route('register_job_seeker') }}"><i class="fas fa-angle-double-right"></i>
                      @lang('app.create_account')</a>
                  </li>
                  <li><a href=""><i class="fas fa-angle-double-right"></i>
                      @lang('app.search_jobs')</a></li>
                  <li><a href="{{ route('applied_jobs') }}"><i class="fas fa-angle-double-right"></i>
                      @lang('app.applied_jobs')</a></li>
                </ul>
              </div>
              <!-- /Footer Widget -->

            </div>

            <div class="col-lg-3 col-md-6">

              <!-- Footer Widget -->
              <div class="footer-widget footer-menu">
                <h2 class="footer-title">@lang('app.employer')</h2>
                <ul>
                  <li><a href="{{ route('register_employer') }}"><i class="fas fa-angle-double-right"></i>
                      @lang('app.create_account')</a>
                  </li>
                  <li><a href="{{ route('new_job_ads') }}"><i class="fas fa-angle-double-right"></i>
                      @lang('app.post_new_job')</a></li>
                </ul>
              </div>
              <!-- /Footer Widget -->

            </div>

            <div class="col-lg-3 col-md-6">

              <!-- Footer Widget -->
              <div class="footer-widget footer-contact">
                <h2 class="footer-title">@lang('app.contact_us')</h2>
                <div class="footer-contact-info">
                  <!-- <div class="footer-address">
           <span><i class="fas fa-map-marker-alt"></i></span>
           <p> 3556  Beech Street, San Francisco,<br> California, CA 94108 </p>
          </div>
          <p>
           <i class="fas fa-phone-alt"></i>
           +1 315 369 5943
          </p> -->
                  <p class="mb-0">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:info@demo.com" style="color:#fff;">info@demo.com</a>

                  </p>
                </div>
              </div>
              <!-- /Footer Widget -->

            </div>

          </div>
        </div>
      </div>
      <!-- /Footer Top -->

      <!-- Footer Bottom -->
      <div class="footer-bottom">
        <div class="container-fluid">

          <!-- Copyright -->
          <div class="copyright text-center">
            <div class="row">

              <div class="col-md-12 col-lg-12">
                <div class="copyright-text">
                  <p class="mb-0">@lang('app.copyright') {!! get_text_tpl(get_option('copyright_text')) !!} · <a href="https://www.templateshub.net/" target="_blank">Templates By Templates
                      Hub</a></p>
                </div>
              </div>

            </div>
          </div>
          <!-- /Copyright -->

        </div>
      </div>
      <!-- /Footer Bottom -->

    </footer>
    <!-- /Footer -->

  </div>
  <!-- /Main Wrapper -->

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@lang('app.header_logout')</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">@lang('app.description_logout')</div>
        <div class="modal-footer">
          <button class="btn btn-link" type="button" data-dismiss="modal">@lang('app.cancel')</button>
          <a class="btn btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('app.logout')</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('assets/js/jquery.min.js') }}"></script>

  <!-- Bootstrap Core JS -->
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

  <!-- Slick JS -->
  <script src="{{ asset('assets/js/slick.js') }}"></script>

  <!-- Sticky Sidebar JS -->
  <script src="{{ asset('assets/plugins/theia-sticky-sidebar/ResizeSensor.js') }}"></script>
  <script src="{{ asset('assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js') }}"></script>

  <!-- Circle Progress JS -->
  <script src="{{ asset('assets/js/circle-progress.min.js') }}"></script>

  <!-- Custom JS -->
  <script src="{{ asset('assets/js/script.js') }}"></script>

  @yield('page-js')
</body>

</html>
