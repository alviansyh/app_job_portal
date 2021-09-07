@extends('layouts.theme')

@section('content')
  <div class="container">

    <div class="card">
      <div class="card-body">
        <div class="doctor-widget">
          <div class="doc-info-left">
            <div class="doctor-img">
              <img src="{{ $path_avatar }}" class="img-fluid" alt="User Image">
            </div>
            <div class="doc-info-cont">
              <h3 class="text-primary">{{ $job->job_title }}</h3>
              <h5 class="text-muted">{{ $job->position }}</h5>
              <div class="clinic-services pt-3">
                @if ($job->skills != '')
                  @foreach (explode(',', $job->skills) as $skill)
                    <span>{{ $skill }}</span>
                  @endforeach
                @endif
              </div>
            </div>
          </div>
          <div class="doc-info-right">
            <div class="clini-infos">
              <ul>
                <li><i class="fas fa-briefcase"></i>@lang('app.'.$job->job_type)</li>
                <li><i class="fas fa-building"></i>{{ $company }}</li>
                <li><i class="fas fa-map-marker-alt"></i>{{ $location }}</li>
                <li><i class="far fa-money-bill-alt"></i>{!! get_amount($job->salary, $job->salary_currency) !!} @if ($job->salary_upto) - {!! get_amount($job->salary_upto, $job->salary_currency) !!} @endif /
                  @lang('app.'.$job->salary_cycle)
                </li>
              </ul>
            </div>
            <div class="clinic-booking pb-2">
              <a class="btn-outline-primary" href="#"><i class="far fa-bookmark"></i> @lang('app.bookmarks')</a>
            </div>
            <div class="clinic-booking">
              <a class="apt-btn" href="#">@lang('app.apply_to_this_job')</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body pt-0">

        <nav class="user-tabs mb-4">
          <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
            <li class="nav-item">
              <a class="nav-link active" href="#tab_details" data-toggle="tab">{{ __('app.vacancy_details') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#tab_overview" data-toggle="tab">{{ __('app.company_overview') }}</a>
            </li>
          </ul>
        </nav>

        <div class="tab-content pt-0">

          <div role="tabpanel" id="tab_details" class="tab-pane fade show active">
            <div class="row">
              <div class="col-md-12">

                @if ($job->description != '')
                <div class="widget">
                  <h4 class="widget-title">{{ __('app.job_descriptions') }}</h4>
                  {!! $job->description !!}
                </div>
                @endif

                @if ($job->qualification != '')
                <div class="widget">
                  <h4 class="widget-title">{{ __('app.qualification') }}</h4>
                  {!! $job->qualification !!}
                </div>
                @endif
                
                @if ($job->benefits != '')
                <div class="widget">
                  <h4 class="widget-title">{{ __('app.benefits') }}</h4>
                  {!! $job->benefits !!}
                </div>
                @endif

                @if ($job->notes != '')
                <div class="widget">
                  <h4 class="widget-title">{{ __('app.notes') }}</h4>
                  {!! $job->notes !!}
                </div>
                @endif
              </div>
            </div>
          </div>

          <div role="tabpanel" id="tab_overview" class="tab-pane fade">

            <div class="row">
              <div class="col-md-12">

                @if ($company_info->about_company != '')
                <div class="widget">
                  <h4 class="widget-title">{{ __('app.about_company') }}</h4>
                  {!! $company_info->about_company !!}
                </div>
                @endif

              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
@endsection
