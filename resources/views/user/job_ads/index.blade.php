@extends('layouts.user_dashboard')

@section('page-css')
  <link href="{{ asset('assets/plugins/datatables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  @include('layouts.flash_msg')
  <div class="card">
    <div class="card-body pt-0">

      <!-- Tab Menu -->
      <nav class="user-tabs mb-4">
        <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
          <li class="nav-item">
            <a class="nav-link active" href="#pat_approved" data-toggle="tab">{{ __('app.approved') }} [{{ $approved_jobs->count() }}]</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#pat_pending" data-toggle="tab">{{ __('app.pending') }} [{{ $pending_jobs->count() }}]</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#pat_blocked" data-toggle="tab">{{ __('app.blocked') }} [{{ $blocked_jobs->count() }}]</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#pat_expired" data-toggle="tab">{{ __('app.expired') }} [{{ $expired_jobs->count() }}]</a>
          </li>
        </ul>
      </nav>
      <!-- /Tab Menu -->

      <!-- Tab Content -->
      <div class="tab-content pt-0">

        <div id="pat_approved" class="tab-pane fade show active">
          <div class="card mb-0">
            <div class="card-body">
              <div class="table-responsive">
                <table id="approved" class="table table-hover table-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-left">{{ __('app.job_ads') }}</th>
                      <th class="text-center">{{ __('app.deadline') }}</th>
                      <th class="text-center">{{ __('app.status') }}</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($approved_jobs->count())
                      @foreach ($approved_jobs as $approved_job)
                        <tr>
                          <td class="text-left">
                            {{ $approved_job->job_title }}
                            <span class="d-block text-secondary">
                              {{ $approved_job->position }}
                            </span>
                            <span class="d-block pt-2">
                              <a class="text-info" href="javascript:void(0);">{{ __('app.applicant') }} [{{ $approved_job->application->count() }}]</a>
                            </span>
                          </td>
                          <td class="text-center">{{ $approved_job->deadline->format(get_option('date_format')) }}</td>
                          <td class="text-center">
                            {!! $approved_job->status_context() !!}
                          </td>
                          <td class="text-center">
                            <div class="table-action">
                              <a href="{{ route('view_job_ads', $approved_job->job_slug) }}" target="_blank" class="btn btn-sm bg-info-light" data-toggle="tooltip" title="@lang('app.view_page')">
                                <i class="far fa-eye"></i>
                              </a>
                              <a href="{{ route('edit_job_ads', $approved_job->job_id) }}" class="btn btn-sm bg-primary-light" data-toggle="tooltip" title="@lang('app.edit')">
                                <i class="far fa-edit"></i>
                              </a>
                              <a href="{{ route('delete_job_ads', $approved_job->job_id) }}" class="btn btn-sm bg-danger-light" data-toggle="tooltip" title="@lang('app.delete')">
                                <i class="far fa-trash-alt"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="pat_pending">
          <div class="card mb-0">
            <div class="card-body">
              <div class="table-responsive">
                <table id="pending" class="table table-hover table-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-left">{{ __('app.job_ads') }}</th>
                      <th class="text-center">{{ __('app.deadline') }}</th>
                      <th class="text-center">{{ __('app.status') }}</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($pending_jobs->count())
                      @foreach ($pending_jobs as $pending_job)
                        <tr>
                          <td class="text-left">
                            {{ $pending_job->job_title }}
                            <span class="d-block text-secondary">
                              {{ $pending_job->position }}
                            </span>
                            <span class="d-block pt-2">
                              <a class="text-info" href="javascript:void(0);">{{ __('app.applicant') }} [{{ $pending_job->job_applications->count() }}]</a>
                            </span>
                          </td>
                          <td class="text-center">{{ $pending_job->deadline->format(get_option('date_format')) }}</td>
                          <td class="text-center">
                            {!! $pending_job->status_context() !!}
                          </td>
                          <td class="text-center">
                            <div class="table-action">
                              <a href="{{ route('view_job_ads', $pending_job->job_slug) }}" target="_blank" class="btn btn-sm bg-info-light" data-toggle="tooltip" title="@lang('app.view_page')">
                                <i class="far fa-eye"></i>
                              </a>
                              <a href="{{ route('edit_job_ads', $pending_job->job_id) }}" class="btn btn-sm bg-primary-light" data-toggle="tooltip" title="@lang('app.edit')">
                                <i class="far fa-edit"></i>
                              </a>
                              <a href="{{ route('delete_job_ads', $pending_job->job_id) }}" class="btn btn-sm bg-danger-light" data-toggle="tooltip" title="@lang('app.delete')">
                                <i class="far fa-trash-alt"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div id="pat_blocked" class="tab-pane fade">
          <div class="card mb-0">
            <div class="card-body">
              <div class="table-responsive">
                <table id="blocked" class="table table-hover table-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-left">{{ __('app.job_ads') }}</th>
                      <th class="text-center">{{ __('app.deadline') }}</th>
                      <th class="text-center">{{ __('app.status') }}</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($blocked_jobs->count())
                      @foreach ($blocked_jobs as $blocked_job)
                        <tr>
                          <td class="text-left">
                            {{ $blocked_job->job_title }}
                            <span class="d-block text-secondary">
                              {{ $blocked_job->position }}
                            </span>
                            <span class="d-block pt-2">
                              <a class="text-info" href="javascript:void(0);">{{ __('app.applicant') }} [{{ $blocked_job->application->count() }}]</a>
                            </span>
                          </td>
                          <td class="text-center">{{ $blocked_job->deadline->format(get_option('date_format')) }}</td>
                          <td class="text-center">
                            {!! $blocked_job->status_context() !!}
                          </td>
                          <td class="text-center">
                            <div class="table-action">
                              <a href="{{ route('view_job_ads', $blocked_job->job_slug) }}" target="_blank" class="btn btn-sm bg-info-light" data-toggle="tooltip" title="@lang('app.view_page')">
                                <i class="far fa-eye"></i>
                              </a>
                              <a href="{{ route('edit_job_ads', $blocked_job->job_id) }}" class="btn btn-sm bg-primary-light" data-toggle="tooltip" title="@lang('app.edit')">
                                <i class="far fa-edit"></i>
                              </a>
                              <a href="{{ route('delete_job_ads', $blocked_job->job_id) }}" class="btn btn-sm bg-danger-light" data-toggle="tooltip" title="@lang('app.delete')">
                                <i class="far fa-trash-alt"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div id="pat_expired" class="tab-pane fade">
          <div class="card mb-0">
            <div class="card-body">
              <div class="table-responsive">
                <table id="expired" class="table table-hover table-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-left">{{ __('app.job_ads') }}</th>
                      <th class="text-center">{{ __('app.deadline') }}</th>
                      <th class="text-center">{{ __('app.status') }}</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if ($expired_jobs->count())
                      @foreach ($expired_jobs as $expired_job)
                        <tr>
                          <td class="text-left">
                            {{ $expired_job->job_title }}
                            <span class="d-block text-secondary">
                              {{ $expired_job->position }}
                            </span>
                            <span class="d-block pt-2">
                              <a class="text-info" href="javascript:void(0);">{{ __('app.applicant') }} [{{ $expired_job->application->count() }}]</a>
                            </span>
                          </td>
                          <td class="text-center">{{ $expired_job->deadline->format(get_option('date_format')) }}</td>
                          <td class="text-center">
                            {!! $expired_job->status_context() !!}
                          </td>
                          <td class="text-center">
                            <div class="table-action">
                              <a href="{{ route('view_job_ads', $expired_job->job_slug) }}" target="_blank" class="btn btn-sm bg-info-light" data-toggle="tooltip" title="@lang('app.view_page')">
                                <i class="far fa-eye"></i>
                              </a>
                              <a href="{{ route('edit_job_ads', $expired_job->job_id) }}" class="btn btn-sm bg-primary-light" data-toggle="tooltip" title="@lang('app.edit')">
                                <i class="far fa-edit"></i>
                              </a>
                              <a href="{{ route('delete_job_ads', $expired_job->job_id) }}" class="btn btn-sm bg-danger-light" data-toggle="tooltip" title="@lang('app.delete')">
                                <i class="far fa-trash-alt"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- Tab Content -->

    </div>
  </div>
@endsection

@section('page-js')
  <script src="{{ asset('assets/plugins/datatables/DataTables-1.10.25/js/jquery.dataTables.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/datatables/DataTables-1.10.25/js/dataTables.bootstrap4.min.js') }}" defer></script>
  <script>
    $(document).ready(function() {
      $('#approved').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
      });

      $('#pending').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
      });

      $('#expired').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
      });

      $('#blocked').DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
      });
    });
  </script>
@endsection
