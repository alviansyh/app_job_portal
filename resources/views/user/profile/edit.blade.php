@extends('layouts.user_dashboard')

@section('page-css')
  <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/uppy/css/uppy.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/richtexteditor/rte_theme_default.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" rel="stylesheet">
@endsection

@section('content')
  @include('layouts.flash_msg')
  <form method="POST" action="">
    @csrf

    @if ($is_employer)
      <!-- Company Information -->
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">@lang('app.company_information')</h4>
          <div class="row form-row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="change-avatar">
                  <div class="profile-img">
                    <img src="{{ $path_avatar }}" alt="User Image">
                  </div>

                  <div class="upload-img">
                    <div class="change-photo-btn" id="upload-image">
                      <span><i class="fas fa-upload"></i> @lang('app.upload')</span>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.company')</label>
                <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $company_info->company) }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.user_name') </label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $user->name) }}">
                @if ($errors->has('user_name'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('user_name') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.website') </label>
                <input type="text" class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }}" id="website" name="website" value="{{ old('website', $company_info->website) }}">
                @if ($errors->has('website'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('website') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.company_size') <span class="text-danger">*</span></label>
                <select class="form-control select {{ $errors->has('company_size') ? ' is-invalid' : '' }}" id="company_size" name="company_size">
                  <option value="">@lang('app.select_a_company_size')</option>
                  @foreach (company_size() as $size => $size_name)
                    <option value="{{ $size }}" {{ selected($size, old('company_size', $company_info->company_size)) }}>
                      {{ $size_name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('company_size'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('company_size') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.address') <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" value="{{ old('address', $company_info->address) }}">
                @if ($errors->has('address'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.address_2')</label>
                <input type="text" class="form-control {{ $errors->has('address_2') ? ' is-invalid' : '' }}" id="address_2" name="address_2"
                  value="{{ old('address_2', $company_info->address_2) }}">
                @if ($errors->has('address_2'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('address_2') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.city')</label>
                <input type="text" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" id="city" name="city" value="{{ old('city', $company_info->city) }}">
                @if ($errors->has('city'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('city') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.postal_code')</label>
                <input type="text" class="form-control {{ $errors->has('postal_code') ? ' is-invalid' : '' }}" id="postal_code" name="postal_code"
                  value="{{ old('postal_code', $company_info->postal_code) }}">
                @if ($errors->has('postal_code'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('postal_code') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.country') <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }} select" id="country" name="country">
                  <option value="">@lang('app.select_a_country')</option>
                  @foreach ($countries as $country)
                    <option value="{!! $country->id !!}" {{ selected($country->id, !empty($company_info->country_id) ? $company_info->country_id : 1) }}>
                      {!! $country->country_name !!}</option>
                  @endforeach
                </select>
                @if ($errors->has('country'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('country') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.area') <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('area') ? ' is-invalid' : '' }} select" id="area" name="area">
                  <option value="">@lang('app.select_a_area')</option>
                  @if ($old_country)
                    @foreach ($old_country->areas as $area)
                      <option value="{{ $area->id }}" {{ selected($area->id, old('area_id', $company_info->area_id)) }}>
                        {!! $area->area_name !!}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->has('area'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('area') }}</strong>
                  </div>
                @endif

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.email_address')</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.phone')</label>
                <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $company_info->phone) }}">
                @if ($errors->has('phone'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </div>
                @endif
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group mb-0">
                <label>@lang('app.about_company')</label>
                <textarea class="form-control {{ $errors->has('about_company') ? ' is-invalid' : '' }}" rows="12" id="about_company"
                  name="about_company">{{ old('about_company', $company_info->about_company) }}</textarea>
                @if ($errors->has('about_company'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('about_company') }}</strong>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /Company Information -->
    @elseif ($is_user)
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">@lang('app.user_information')</h4>
          <div class="row form-row">

            <div class="col-md-12">
              <div class="form-group">
                <div class="change-avatar">
                  <div class="profile-img">
                    <img src="{{ $path_avatar }}" alt="User Image">
                  </div>
                  <div class="upload-img">
                    <div class="change-photo-btn" id="upload-image">
                      <span><i class="fas fa-upload"></i> @lang('app.upload')</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.identity_number') </label>
                <input type="text" class="form-control {{ $errors->has('identity_number') ? ' is-invalid' : '' }}" id="identity_number" name="identity_number"
                  value="{{ old('identity_number', $user_info->identity_number) }}">
                @if ($errors->has('identity_number'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('identity_number') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.user_name')  <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" value="{{ old('name', $user->name) }}">
                @if ($errors->has('user_name'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('user_name') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>{{ __('app.gender') }} <span class="text-danger">*</span></label>
                <select class="form-control select {{ $errors->has('gender') ? ' is-invalid' : '' }}" id="gender" name="gender">
                  <option value="">&nbsp;</option>
                  @foreach (gender() as $gender_id => $gender)
                    <option value="{{ $gender_id }}" {{ selected($gender_id, old('gender', $user_info->gender)) }}>
                      {{ $gender }}</option>
                  @endforeach
                </select>
                @if ($errors->has('gender'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('gender') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            @php
              $date_birthday = null;
              if ($user_info->date_birthday !== null) {
                  $date_birthday = $user_info->date_birthday->format(get_option('date_format'));
              }
            @endphp

            <div class="col-md-6">
              <div class="form-group">
                <label>{{ __('app.date_birthday') }} <span class="text-danger">*</span></label>
                <input type="text" class="form-control {{ $errors->has('date_birthday') ? ' is-date_birthday' : '' }}" id="date_birthday" name="date_birthday"
                  value="{{ old('date_birthday', $date_birthday) }}">
                @if ($errors->has('date_birthday'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('date_birthday') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.address')</label>
                <input type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" id="address" name="address" value="{{ old('address', $user_info->address) }}">
                @if ($errors->has('address'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.address_2')</label>
                <input type="text" class="form-control {{ $errors->has('address_2') ? ' is-invalid' : '' }}" id="address_2" name="address_2" value="{{ old('address_2', $user_info->address_2) }}">
                @if ($errors->has('address_2'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('address_2') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.city')</label>
                <input type="text" class="form-control {{ $errors->has('city') ? ' is-invalid' : '' }}" id="city" name="city" value="{{ old('city', $user_info->city) }}">
                @if ($errors->has('city'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('city') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.postal_code')</label>
                <input type="text" class="form-control {{ $errors->has('postal_code') ? ' is-invalid' : '' }}" id="postal_code" name="postal_code"
                  value="{{ old('postal_code', $user_info->postal_code) }}">
                @if ($errors->has('postal_code'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('postal_code') }}</strong>
                  </div>
                @endif
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.area') <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('area') ? ' is-invalid' : '' }} select" id="area" name="area">
                  <option value="">@lang('app.select_a_area')</option>
                  @if ($old_country)
                    @foreach ($old_country->areas as $area)
                      <option value="{{ $area->id }}" {{ selected($area->id, old('area_id', $user_info->area_id)) }}>
                        {!! $area->area_name !!}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->has('area'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('area') }}</strong>
                  </div>
                @endif

              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="control-label">@lang('app.country') <span class="text-danger">*</span></label>
                <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }} select" id="country" name="country">
                  <option value="">@lang('app.select_a_country')</option>
                  @foreach ($countries as $country)
                    <option value="{!! $country->id !!}" {{ selected($country->id, !empty($user_info->country_id) ? $user_info->country_id : 1) }}>
                      {!! $country->country_name !!}</option>
                  @endforeach
                </select>
                @if ($errors->has('country'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('country') }}</strong>
                  </div>
                @endif
              </div>
            </div>



          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h4 class="card-title">@lang('app.contact')</h4>
          <div class="row form-row">

            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.email_address')</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>@lang('app.phone')</label>
                <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" id="phone" name="phone" value="{{ old('phone', $user_info->phone) }}">
                @if ($errors->has('phone'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                  </div>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h4 class="card-title">@lang('app.about_me')</h4>
          <div class="row form-row">

            <div class="col-md-12">
              <div class="form-group">
                <label></label>
                <textarea class="form-control {{ $errors->has('about_me') ? ' is-invalid' : '' }}" rows="12" id="about_me" name="about_me">{{ old('about_me', $user_info->about_me) }}</textarea>
                @if ($errors->has('about_me'))
                  <div class="invalid-feedback">
                    <strong>{{ $errors->first('about_me') }}</strong>
                  </div>
                @endif
              </div>
            </div>

          </div>
        </div>
      </div>
    @endif

    <div class="submit-section submit-btn-bottom">
      <button type="submit" class="btn btn-primary submit-btn">@lang('app.save_changes')</button>
    </div>
  </form>
@endsection

@section('page-js')
  <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/uppy/js/uppy.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/richtexteditor/rte.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/richtexteditor/plugins/all_plugins.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" defer></script>
  <script>
    $(document).ready(function() {
      $('#date_birthday').datepicker({
        format: 'yyyy-mm-dd',
        clearBtn: true,
        todayHighlight: true,
        autoclose: true,
      });

      $('#country').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#area').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#gender').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#upload-image').on('click', function() {
        upload_image();
      })

      function upload_image() {
        const uppy = Uppy.Core({
          debug: false,
          autoProceed: false,
          restrictions: {
            maxFileSize: 2000000,
            maxNumberOfFiles: 1,
            minNumberOfFiles: 0,
            allowedFileTypes: ['image/*']
          }
        })
        uppy.use(Uppy.Dashboard, {
          showProgressDetails: true,
          proudlyDisplayPoweredByUppy: false,
          animateOpenClose: true,
          closeModalOnClickOutside: false,
          note: '{{ __('app.format_photo_msg') }}',
        })

        uppy.use(Uppy.XHRUpload, {
          endpoint: '{{ route('upload_image') }}',
          fieldName: 'file_upload',
          fromData: true,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
        })

        uppy.on('upload-success', (file, response) => {
          console.log(response.status) // HTTP status code
          console.log(response.body) // extracted response data
          if (response.status == 200) {
            uppy.getPlugin('Dashboard').closeModal()
            setTimeout(function() {
              location.reload()
            }, 50)
          }
        })

        uppy.on('upload-error', (file, error, response) => {
          console.log('error s with file:', file.id)
          console.log('error message:', error)
        })

        uppy.getPlugin('Dashboard').openModal()
      }

      var editorcfg = {}
      editorcfg.toolbar = "mytoolbar";
      editorcfg.skin = "rounded-corner";
      editorcfg.editorResizeMode = "height";
      editorcfg.enterKeyTag = "div";
      editorcfg.paragraphClass = "paragraph";
      editorcfg.toolbar_mytoolbar =
        "{paste}|{bold,italic}|{paragraphs,fontsize,forecolor,backcolor}|{insertblockquote,insertorderedlist,insertunorderedlist}|{justifyfull,justifyleft}|{lineheight}|{removeformat,insertlink,insertchars}" +
        "#{undo,redo,find,fullscreenenter,fullscreenexit}";

      var editor = new RichTextEditor("#about_me", editorcfg);

    });
  </script>
@endsection
