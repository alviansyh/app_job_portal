@if (session('warning-dashboard'))
  <div class="alert warning" style="color: #664d03; background-color: #f5dd00;">
    {!! session('warning-dashboard') !!}
  </div>
@endif

@if (session('info-dashboard'))
  <div class="alert alert-info">
    {!! session('info-dashboard') !!}
  </div>
@endif

@if (session('error-dashboard'))
  <div class="alert alert-danger">
    {!! session('error-dashboard') !!}
  </div>
@endif

@if (session('warning-mandatory'))
  <div class="alert warning" style="color: #664d03; background-color: #f5dd00;">
    {!! session('warning-mandatory') !!}
  </div>
@endif
