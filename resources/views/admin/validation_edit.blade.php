@extends('layouts.dashboard')

@section('page-css')
    <link href="{{asset('assets/plugins/uppy/css/uppy.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{!! ! empty($title) ? $title : __('app.dashboard') !!}</h6>
                </div>

                <div class="card-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-3 {{ $errors->has('nib')? 'has-error':'' }}">
                            <label for="nib" class="col-sm-2 col-form-label">@lang('app.nib')</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control {{e_form_invalid_class('nib', $errors)}}" id="nib" value="{{$validation->nib}}" name="nib" placeholder="@lang('app.nib_placeholder')">

                                {!! e_form_error('nib', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('npwp')? 'has-error':'' }}">
                            <label for="npwp" class="col-sm-2 col-form-label">@lang('app.npwp')</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control {{e_form_invalid_class('npwp', $errors)}}" id="npwp" value="{{$validation->npwp}}" name="npwp" placeholder="@lang('app.npwp_placeholder')">
                                <small class="form-text text-muted font-italic">Format: 00.000.000.0-000.001</small>
                                {!! e_form_error('npwp', $errors) !!}
                            </div>
                        </div>
                        <!-- <div class="form-group row mb-3 {{ $errors->has('file_attachment')? 'has-error':'' }}">
                            <label for="file_attachment" class="col-sm-2 col-form-label">@lang('app.file_attachment')</label>
                            <div class="col-sm-6">
                                <div id="drag-drop-area"></div>
                            </div>
                        </div> -->
                        <div class="form-group row mt-5">
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-primary">@lang('app.save_changes')</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{asset('assets/plugins/uppy/js/uppy.min.js')}}"></script>
    <script>
        var uppy = Uppy.Core({ autoProceed: false })
        uppy.use(Uppy.Dashboard, {
            target: '#drag-drop-area',
            inline: true,
            height: 200,
        })
        uppy.use(Uppy.XHRUpload, { endpoint: '' })
    </script>
@endsection