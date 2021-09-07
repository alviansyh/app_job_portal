@extends('layouts.theme')

@section('content')
  <div class="row">
    <div class="col-md-8 offset-md-2">

      <!-- Register Content -->
      <div class="account-content py-5">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7 col-lg-6 login-left">
            <img src="{{ asset('assets/img/app/businessman-banner.svg') }}" class="img-fluid" alt="Doccure Register">
          </div>
          <div class="col-md-12 col-lg-6 login-right">
            <div class="login-header">
              <h3>{{ __('app.register') }} <a class="text-primary" href="{{ route('register_employer') }}">{{ __('app.register_employer') }}?</a></h3>
            </div>

            <!-- Register Form -->
            <form method="POST" action="">
              @csrf

              <div class="form-group form-focus">
                <input id="name" type="text" class="form-control floating {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                <label class="focus-label">{{ __('app.name') }}</label>

                @if ($errors->has('name'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                  </div>
                @endif
              </div>

              <div class="form-group form-focus @if ($errors->has('name')) mt-4 @endif">
                <input id="email" type="email" class="form-control floating @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <label class="focus-label">{{ __('app.email_address') }}</label>

                @if ($errors->has('email'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                  </div>
                @endif
              </div>

              <div class="form-group form-focus  @if ($errors->has('email')) mt-4 @endif">
                <input id="password" type="password" class="form-control floating @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                <label class="focus-label">{{ __('app.password') }}</label>

                @if ($errors->has('password'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                  </div>
                @endif
              </div>

              <div class="form-group form-focus  @if ($errors->has('password')) mt-4 @endif">
                <input id="password-confirm" type="password" class="form-control floating" name="password_confirmation" required>
                <label class="focus-label">{{ __('app.confirm_password') }}</label>
              </div>


              <div class="text-right">
                <a class="forgot-link" href="{{ route('login') }}">{{ __('app.have_account_msg') }}</a>
              </div>

              <button class="btn btn-primary btn-block btn-lg login-btn" type="submit">{{ __('app.register') }}</button>
            </form>
            <!-- /Register Form -->

          </div>
        </div>
      </div>
      <!-- /Register Content -->

    </div>
  </div>
@endsection
