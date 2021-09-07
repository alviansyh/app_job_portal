@extends('layouts.user_dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    @include('layouts.flash_msg')
                    
                    <!-- Change Password Form -->
                    <form action="" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>@lang('app.old_password')</label>
                            <input id="old_password" type="password" name="old_password" class="form-control {{ $errors->has('old_password')? 'is-invalid' : '' }}" autocomplete="off" autofocus>
                            {!! e_form_error('old_password', $errors) !!}
                        </div>
                        <div class="form-group">
                            <label>@lang('app.new_password')</label>
                            <input id="new_password" type="password" name="new_password" class="form-control {{ $errors->has('new_password')? 'is-invalid' : '' }}" autocomplete="off">
                            {!! e_form_error('new_password', $errors) !!}
                        </div>
                        <div class="form-group">
                            <label>@lang('app.confirm_password')</label>
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation" class="form-control {{ $errors->has('new_password_confirmation')? 'is-invalid' : '' }}" autocomplete="off">
                            {!! e_form_error('new_password_confirmation', $errors) !!}
                        </div>
                        <div class="submit-section">
                            <button type="submit" class="btn btn-primary submit-btn">@lang('app.save_changes')</button>
                        </div>
                    </form>
                    <!-- /Change Password Form -->

                </div>
            </div>
        </div>
    </div>
@endsection
