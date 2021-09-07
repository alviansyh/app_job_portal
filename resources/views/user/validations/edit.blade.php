@extends('layouts.user_dashboard')

@section('page-css')
  <link href="{{ asset('assets/plugins/filepond/dist/filepond.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    @lang('app.your_account_validation') {!! $validation->user->company_info->validation_status() !!}: {{ $validation->notes }}. @lang('app.warning_validation_upload')
  </div>
  @include('layouts.flash_msg')
  <form method="POST" action="{{ route('update_validation', [Crypt::encrypt($validation->id, true)]) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">@lang('app.add_validation')</h4>
        <div class="row form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label>@lang('app.nib/siup') <span class="text-danger">*</span></label>
              <input type="text" class="form-control  {{ $errors->has('validation_number') ? ' is-invalid' : '' }}" id="validation_number" name="validation_number"
                value="{{ old('validation_number', $validation_number) }}" autofocus>
              @if ($errors->has('validation_number'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('validation_number') }}</strong>
                </div>
              @endif
            </div>
          </div>
        </div>
        <div class="row form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label>@lang('app.file')</label>
              <input type="file" name="file_upload" value="{{ old('file_upload') }}">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="submit-section submit-btn-bottom">
      <button type="submit" class="btn btn-primary submit-btn">@lang('app.add_validation')</button>
    </div>
  </form>
@endsection

@section('page-js')
  <script src="{{ asset('assets/plugins/filepond/dist/filepond.js') }}" crossorigin></script>
  <script src="{{ asset('assets/plugins/filepond/dist/formvalidate.js') }}" crossorigin></script>
  <script src="{{ asset('assets/plugins/filepond/dist/validatesize.js') }}" crossorigin></script>
  <script>
    const inputElement = document.querySelector('input[name="file_upload"]');
    FilePond.registerPlugin(FilePondPluginFileValidateType);
    FilePond.registerPlugin(FilePondPluginFileValidateSize);
    FilePond.create(inputElement, {
      acceptedFileTypes: ['image/*', 'application/pdf'],
      storeAsFile: true,
      maxFiles: 1,
      maxFileSize: '2MB',
      forceRevert: true,
      credits: {}
    });
  </script>
@endsection
