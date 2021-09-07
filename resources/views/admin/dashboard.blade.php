@extends('layouts.theme')


@section('content')

    @if(auth()->user()->is_sysadmin())
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@lang('app.users')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-friends la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">@lang('app.employer')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employerCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-building la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">@lang('app.admin')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$adminCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-alt la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">@lang('app.payments') (@lang('app.success'))</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{!! get_amount($totalPayments) !!}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-wallet la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">@lang('app.applied_jobs')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalApplicants}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="la la-list-alt la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('app.jobs_ads_active')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$activeJobs}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-bullhorn la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">@lang('app.total_jobs_ads')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalJobs}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="la la-briefcase la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->is_admin())
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@lang('app.users')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usersCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-user-friends la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">@lang('app.employer')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$employerCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-building la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">@lang('app.applied_jobs')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalApplicants}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="la la-list-alt la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('app.jobs_ads_active')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$activeJobs}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-bullhorn la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">@lang('app.total_jobs_ads')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalJobs}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="la la-briefcase la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->is_employer())
        @include('admin.dashboard_msg')
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">@lang('app.applied_jobs')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalApplicants}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="la la-list-alt la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('app.jobs_ads_active')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$activeJobs}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="las la-bullhorn la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">@lang('app.total_jobs_ads')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalJobs}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="la la-briefcase la-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="no data-wrap py-5 my-5 text-center">
                    <h1 class="display-1"><i class="la la-frown-o"></i> </h1>
                    <h1>No Data available here</h1>
                </div>
            </div>
        </div>
    @endif

@endsection