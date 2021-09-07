<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? $title : __('app.dashboard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('assets/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/plugins/sb-admin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    @yield('page-css')

    <script type='text/javascript'>
        /* <![CDATA[ */
        var page_data = {!! pageJsonData() !!};
        /* ]]> */

    </script>

</head>

<body id="page-top">
    @php
        $pendingJobCount = \App\Models\Job::pending()->count();
        $approvedJobCount = \App\Models\Job::approved()->count();
        $blockedJobCount = \App\Models\Job::blocked()->count();
        $user = Auth::user();
    @endphp

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-icon">
                    App Job Portal
                </div>
                <div class="sidebar-brand-text mx-3"></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->is('dashboard') ? 'active' : null }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><i class="las la-home"
                        style="font-size: 1em;"></i> <span>@lang('app.dashboard')</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if ($user->is_admin() || $user->is_sysadmin())
                <li class="nav-item {{ request()->is('dashboard/siup_validation*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="lar la-file-alt" style="font-size: 1em;"></i>
                        <span>@lang('app.siup_validation')</span></a>
                </li>
            @endif

            @if (!$user->is_admin())
                <li class="nav-item {{ request()->is('dashboard/u/applied-jobs*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="la la-list-alt" style="font-size: 1em;"></i>
                        <span>@lang('app.applied_jobs')</span></a>
                </li>
            @endif

            @if ($user->is_admin() || $user->is_sysadmin())
                <li class="nav-item {{ request()->is('dashboard/u/categories*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="la la-briefcase" style="font-size: 1em;"></i>
                        <span>@lang('app.categories')</span></a>
                </li>
            @endif

            @if (!$user->is_user())
                <li class="nav-item {{ request()->is('dashboard/employer*') ? 'active' : null }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmployer"
                        aria-expanded="true" aria-controls="collapseEmployer">
                        <i class="la la-black-tie" style="font-size: 1em;"></i> <span>@lang('app.employer')</span>
                    </a>
                    <div id="collapseEmployer" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="">@lang('app.post_new_job_menu')</a>
                            <a class="collapse-item" href="">@lang('app.posted_jobs')</a>
                            @if ($user->is_employer())
                                <a class="collapse-item" href="">@lang('app.applicants')</a>
                                <a class="collapse-item" href="">@lang('app.shortlist')</a>
                                <a class="collapse-item" href="">@lang('app.profile')</a>
                            @endif
                        </div>
                    </div>
                </li>
            @endif

            @if ($user->is_admin() || $user->is_sysadmin())
                <li class="nav-item {{ request()->is('dashboard/jobs*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJobs"
                        aria-expanded="true" aria-controls="collapseJobs">
                        <i class="las la-bullhorn" style="font-size: 1em;"></i> <span>@lang('app.jobs_ads')</span>
                    </a>
                    <div id="collapseJobs" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="">@lang('app.pending') <span
                                    class="badge badge-primary float-right">{{ $pendingJobCount }}</span></a>
                            <a class="collapse-item" href="">@lang('app.approved') <span
                                    class="badge badge-primary float-right">{{ $approvedJobCount }}</span></a>
                            <a class="collapse-item" href="">@lang('app.blocked') <span
                                    class="badge badge-primary float-right">{{ $blockedJobCount }}</span></a>
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ request()->is('dashboard/flagged*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="la la-flag-o" style="font-size: 1em;"></i>
                        <span>@lang('app.flagged_jobs')</span></a>
                </li>

                <li class="nav-item {{ request()->is('dashboard/cms*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCms"
                        aria-expanded="true" aria-controls="collapseCms">
                        <i class="las la-cogs" style="font-size: 1em;"></i> <span>@lang('app.cms')</span>
                    </a>
                    <div id="collapseCms" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="">@lang('app.pages')</a>
                            <a class="collapse-item" href="">@lang('app.posts')</a>
                        </div>
                    </div>
                </li>
            @endif

            @if ($user->is_admin())
                <li class="nav-item {{ request()->is('dashboard/u/users*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="la la-users"></i> <span>@lang('app.users')</span></a>
                </li>
            @endif

            @if ($user->is_sysadmin())
                <li class="nav-item {{ request()->is('dashboard/settings*') ? 'active' : '' }}">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting"
                        aria-expanded="true" aria-controls="collapseSetting">
                        <i class="las la-cog" style="font-size: 1em;"></i> <span>@lang('app.settings')</span>
                    </a>
                    <div id="collapseSetting" class="collapse" aria-labelledby="headingTwo"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="">@lang('app.general_settings')</a>
                            <a class="collapse-item" href="">@lang('app.pricing')</a>
                            <a class="collapse-item" href="">@lang('app.gateways')</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item {{ request()->is('dashboard/payments*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="la la-money" style="font-size: 1em;"></i>
                        <span>@lang('app.payments')</span></a>
                </li>

                <li class="nav-item {{ request()->is('dashboard/u/user-accounts*') ? 'active' : null }}">
                    <a class="nav-link" href=""><i class="las la-users-cog" style="font-size: 1em;"></i>
                        <span>@lang('app.user_accounts')</span></a>
                </li>
            @endif

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="las la-bars" style="font-size: 1em;"></i>
                    </button>

                    <div class="mr-auto">
                        <a href="{{ route('home') }}" class="nav-item nav-link d-none d-lg-inline text-gray-600"
                            target="_blank"><i class="las la-globe"></i> @lang('app.view_site')</a>
                        <ul class="navbar-nav d-lg-none">
                            <li class="nav-item dropdown no-arrow">
                                <a href="{{ route('home') }}" class="nav-item nav-link text-gray-600"
                                    target="_blank"><i class="las la-globe"
                                        style="color: #d1d3e2; font-size: 1.2em;"></i></a>
                            </li>
                        </ul>
                    </div>

                    <!-- Topbar Posting -->
                    <div class="ml-auto">
                        <button type="button" class="btn btn-primary d-none d-sm-block"
                            style="border-radius: 0; padding: 0.5rem 1rem;"><i class="las la-bullhorn"
                                style="font-size: 1em;"></i> @lang('app.post_new_job')</button>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="las la-bullhorn" style="font-size: 1.2em;"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <button type="button" class="btn btn-primary mr-auto w-100"
                                    style="border-radius: 0; padding: 0.5rem 1rem;"><i class="las la-bullhorn"
                                        style="font-size: 1em;"></i> @lang('app.post_new_job')</button>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="las la-bell d-none d-sm-block" style="font-size: 1.5em;"></i>
                                <i class="las la-bell d-sm-none" style="font-size: 1.2em;"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-primary badge-counter">1</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notification Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60"
                                            alt="">
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                    Notifications</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <!-- <span class="badge mr-1" style="color: #212529; background-color: #ffed4a; font-size: 1em;">
                                        <i class="la la-briefcase"></i> {{ auth()->user()->premium_jobs_balance }}
                                    </span> -->
                                    {{ Auth::user()->name }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="https://source.unsplash.com/fn_BT9fwg_E/60x60">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-item d-lg-none">
                                    <span class="mr-2 d-lg-inline text-gray-600 small">
                                        <span class="badge"
                                            style="color: #212529; background-color: #ffed4a; font-size: 1.2em;">
                                            <i class="la la-briefcase"></i> {{ auth()->user()->premium_jobs_balance }}
                                        </span>
                                        {{ Auth::user()->name }}
                                    </span>
                                </div>
                                <div class="dropdown-divider d-lg-none"></div>

                                <a class="dropdown-item" href="">
                                    <i class="la la-user mr-2" style="font-size: 1.2em;"></i> @lang('app.profile')
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="la la-lock mr-2" style="font-size: 1.2em;"></i>
                                    @lang('app.change_password')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="la la-sign-out mr-2" style="font-size: 1.2em;"></i> @lang('app.logout')
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- <h1 class="h3 mb-2 text-gray-800">{!! !empty($title) ? $title : __('app.dashboard') !!}</h1> -->

                    @include('admin.flash_msg')

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <a href="">@lang('app.terms_and_condition')</a> ·
                        <span>{!! get_text_tpl(get_option('copyright_text')) !!}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="las la-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">@lang('app.logout')</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sb-admin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/plugins/sb-admin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/plugins/sb-admin2/js/sb-admin-2.min.js') }}"></script>

    @yield('page-js')
</body>

</html>
