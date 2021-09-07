@extends('layouts.dashboard')

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
                                <input type="text" class="form-control {{e_form_invalid_class('nib', $errors)}}" id="nib" value="{{ old('nib') }}" name="nib" placeholder="@lang('app.nib_placeholder')">

                                {!! e_form_error('nib', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('npwp')? 'has-error':'' }}">
                            <label for="npwp" class="col-sm-2 col-form-label">@lang('app.npwp')</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control {{e_form_invalid_class('npwp', $errors)}}" id="npwp" value="{{ old('npwp') }}" name="npwp" placeholder="@lang('app.npwp_placeholder')">
                                <small class="form-text text-muted font-italic">Format: 00.000.000.0-000.000</small>
                                {!! e_form_error('npwp', $errors) !!}
                            </div>
                        </div>
                        <div class="form-group row mb-3 {{ $errors->has('file_attachment')? 'has-error':'' }}">
                            <label for="file_attachment" class="col-sm-2 col-form-label">@lang('app.file_attachment')</label>
                            <div class="col-sm-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file_attachment" name="file_attachment[]" multiple>
                                    <label class="custom-file-label" for="file_attachment">Choose file</label>
                                </div>
                            </div>
                        </div>
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
    <script>
        $('input[type="file"]').on("change", function() {
            let filenames = [];
            let files = document.getElementById("file_attachment").files;
            if (files.length > 1) {
                filenames.push("Total Files (" + files.length + ")");
            } else {
                for (let i in files) {
                    if (files.hasOwnProperty(i)) {
                        filenames.push(files[i].name);
                    }
                }
            }
            $(this).next(".custom-file-label").html(filenames.join(","));
        });
    </script>
@endsection