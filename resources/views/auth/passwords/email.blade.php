@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <!-- Account Content -->
            <div class="account-content py-5">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-6 login-left">
                        <img src="{{ asset('assets/img/app/reset-banner.svg') }}" class="img-fluid" alt="Reset Banner">
                    </div>
                    <div class="col-md-12 col-lg-6 login-right">
                        <div class="login-header">
                            <h3>{{ __('app.forgot_password_msg') }}</h3>
                            <p class="small text-muted">{{ __('app.reset_password_msg') }}</p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        @endif

                        <!-- Forgot Password Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group form-focus">
                                <input id="email" type="email"
                                    class="form-control floating @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label class="focus-label">{{ __('app.email_address') }}</label>

                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="text-right">
                                <a class="forgot-link"
                                    href="{{ route('login') }}">{{ __('app.remember_password_msg') }}</a>
                            </div>

                            <button class="btn btn-primary btn-block btn-lg login-btn"
                                type="submit">{{ __('app.reset_password') }}</button>
                        </form>
                        <!-- /Forgot Password Form -->

                    </div>
                </div>
            </div>
            <!-- /Account Content -->

        </div>
    </div>
@endsection
