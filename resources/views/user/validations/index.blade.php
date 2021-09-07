@extends('layouts.user_dashboard')

@section('page-css')
  <link href="{{ asset('assets/plugins/datatables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  @include('layouts.flash_msg')
  @if ($user->company_info->status_validation === 3)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      @lang('app.your_account_validation') {!! $user->company_info->validation_status() !!}: {{ $validation->notes }}.
    </div>
  @endif
  @php
    $validation = is_array($validation) || $validation instanceof Countable ? count($validation) : 0
  @endphp
  @if ($validation == 0)
    <h4 class="card-title d-flex justify-content-end">
      <a class="edit-link" href="{{ route('new_validation') }}"><i class="far fa-plus-square mr-1"></i>@lang('app.add_validation')</a>
    </h4>
  @endif
  <div class="card card-table">
    <div class="card-body">
      <div class="table-responsive">
        <table id="validation" class="table table-hover table-center mb-0">
          <thead>
            <tr>
              <th class="text-left">{{ __('app.nib/siup') }}</th>
              <th class="text-left">{{ __('app.filename') }}</th>
              <th class="text-center">{{ __('app.status') }}</th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <tbody>
            @if ($validation == 0)
              <tr>
                <td class="text-center" colspan="4">@lang('app.no_data')</td>
              </tr>
            @else
              <tr>
                <td class="text-left">{{ $validation->user->company_info->validation_number }}</td>
                <td class="text-left">{{ $validation->filename_origin }}</td>
                <td class="text-center">
                  {!! $validation->user->company_info->validation_context() !!}
                </td>
                <td class="text-center">
                  @if ($validation->user->company_info->status_validation === 3)
                    <div class="table-action">
                      <a href="{{ route('edit_validation', Crypt::encrypt($validation->id, true)) }}" class="btn btn-sm bg-primary-light" data-toggle="tooltip" title="@lang('app.edit')">
                        <i class="far fa-edit"></i>
                      </a>
                    </div>
                  @endif
                </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('page-js')
  <script src="{{ asset('assets/plugins/datatables/DataTables-1.10.25/js/jquery.dataTables.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/datatables/DataTables-1.10.25/js/dataTables.bootstrap4.min.js') }}" defer></script>
  <script>
    $(document).ready(function() {

    });
  </script>
@endsection
