@extends('layouts.user_dashboard')

@section('content')
  <div class="row">
    <div class="col-md-12">
      @include('layouts.dashboard_msg')

      @if ($user->is_employer())
        <div class="card dash-card">
          <div class="card-body">
            <div class="row">

              <div class="col-md-12 col-lg-4">
                <div class="dash-widget dct-border-rht">
                  <div class="dash-widget-info">
                    <h6>@lang('app.applied_jobs')</h6>
                    <h3>{{ $total_applicants }}</h3>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-lg-4">
                <div class="dash-widget dct-border-rht">
                  <div class="dash-widget-info">
                    <h6>@lang('app.job_ads_active')</h6>
                    <h3>{{ $active_jobs }}</h3>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-lg-4">
                <div class="dash-widget dct-border-rht">
                  <div class="dash-widget-info">
                    <h6>@lang('app.total_jobs_ads')</h6>
                    <h3>{{ $total_jobs }}</h3>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      @elseif($user->is_user())

      @endif

    </div>
  </div>

@endsection
