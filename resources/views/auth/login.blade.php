@extends('layouts.theme')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">

            <!-- Login Tab Content -->
            <div class="account-content py-5">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 col-lg-6 login-left">
                        <img src="{{ asset('assets/img/app/login-banner.svg') }}" class="img-fluid" alt="Login">
                    </div>
                    <div class="col-md-12 col-lg-6 login-right">
                        <div class="login-header">
                            <h3>{{ __('app.login') }}</h3>
                        </div>

                        @include('layouts.flash_msg')

                        <form method="POST" action="{{ route('login') }}">
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

                            <div class="form-group form-focus @error('email') mt-4 @enderror">
                                <input id="password" type="password"
                                    class="form-control floating @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                <label class="focus-label">{{ __('app.password') }}</label>

                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-right">
                                    <a class="forgot-link"
                                        href="{{ route('password.request') }}">{{ __('app.forgot_password_msg') }}</a>
                                </div>
                            @endif

                            <button class="btn btn-primary btn-block btn-lg login-btn"
                                type="submit">{{ __('app.login') }}</button>

                            <div class="text-center dont-have">{{ __('app.no_account_msg') }} <a
                                    href="{{ route('register_job_seeker') }}">{{ __('app.register_now') }}</a></div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Login Tab Content -->

        </div>
    </div>
@endsection
