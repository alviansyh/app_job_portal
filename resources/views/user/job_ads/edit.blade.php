@extends('layouts.user_dashboard')

@section('page-css')
  <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/tagify/dist/tagify.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/richtexteditor/rte_theme_default.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}" rel="stylesheet">
@endsection

@section('content')
  @include('layouts.flash_msg')
  <form method="POST" action="{{ route('update_job_ads', [$job_ads->job_id]) }}">
    @csrf
    @method('PUT')
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('app.vacancy_details') }}</h4>
        <div class="row form-row">

          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.job_title') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control {{ $errors->has('job_title') ? ' is-invalid' : '' }}" id="job_title" name="job_title" value="{{ old('job_title', $job_ads->job_title) }}"
                autofocus>
              @if ($errors->has('job_title'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('job_title') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.position') }}</label>
              <input type="text" class="form-control {{ $errors->has('position') ? ' is-invalid' : '' }}" id="position" name="position" value="{{ old('position', $job_ads->position) }}">
              @if ($errors->has('position'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('position') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>{{ __('app.skills') }} <span class="text-danger">*</span></label>
              <input type="text" data-role="tagsinput" class="input-tags form-control {{ $errors->has('skills') ? ' is-invalid' : '' }}" id="skills" name="skills"
                value="{{ old('skills', $job_ads->skills) }}">
              <small class="form-text text-info ">@lang('app.skills_info_text')</small>
              @if ($errors->has('skills'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('skills') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">{{ __('app.category') }} <span class="text-danger">*</span></label>
              <select class="form-control {{ $errors->has('category') ? ' is-invalid' : '' }}" id="category" name="category">
                <option value="">@lang('app.select_a_category')</option>
                @foreach ($categories as $category)
                  <option value="{!! $category->id !!}" {{ selected($category->id, old('category', $job_ads->category_id)) }}>
                    {!! $category->category_name !!}</option>
                @endforeach
              </select>
              @if ($errors->has('category'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('category') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.job_type') }} </label>
              <select class="form-control select {{ $errors->has('job_type') ? ' is-invalid' : '' }}" id="job_type" name="job_type">
                <option value="">@lang('app.select_a_type')</option>
                @foreach (job_types() as $job_type_id => $job_type)
                  <option value="{{ $job_type_id }}" {{ selected($job_type_id, old('job_type', $job_ads->job_type)) }}>
                    {{ $job_type }}</option>
                @endforeach
              </select>
              @if ($errors->has('job_type'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('job_type') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.gender') }}</label>
              <select class="form-control select {{ $errors->has('gender') ? ' is-invalid' : '' }}" id="gender" name="gender">
                <option value="">&nbsp;</option>
                @foreach (gender() as $gender_id => $gender)
                  <option value="{{ $gender_id }}" {{ selected($gender_id, old('gender', $job_ads->gender)) }}>
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
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.exp_level') }}</label>
              <select class="form-control select {{ $errors->has('exp_level') ? ' is-invalid' : '' }}" id="exp_level" name="exp_level">
                <option value="">&nbsp;</option>
                @foreach (exp_levels() as $level_id => $level)
                  <option value="{{ $level_id }}" {{ selected($level_id, old('exp_level', $job_ads->exp_level)) }}>
                    {{ $level }}</option>
                @endforeach
              </select>
              @if ($errors->has('exp_level'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('exp_level') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.experience_required') }}</label>
              <div class="input-group">
                <input type="number" class="form-control {{ $errors->has('experience_required_years') ? ' is-invalid' : '' }}" id="experience_required_years" name="experience_required_years"
                  value="{{ old('experience_required_years', $job_ads->experience_required_years) }}">
                <span class="input-group-text">@lang('app.in_years')</span>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="min_experience" name="min_experience" value="1" {{ checked('1', old('min_experience', $job_ads->min_experience)) }}>
                <label class="form-check-label">
                  @lang('app.min')
                </label>
              </div>
              @if ($errors->has('experience_required_years'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('experience_required_years') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.deadline') }} <span class="text-danger">*</span></label>
              <input type="text" class="form-control {{ $errors->has('deadline') ? ' is-invalid' : '' }}" id="deadline" name="deadline"
                value="{{ old('deadline', $job_ads->deadline->format(get_option('date_format'))) }}">
              @if ($errors->has('deadline'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('deadline') }}</strong>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('app.vacancy_descriptions') }}</h4>
        <div class="row form-row">
          <div class="col-md-12">
            <div class="form-group">
              <label>{{ __('app.job_descriptions') }} <span class="text-danger">*</span></label>
              <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" rows="12" id="description"
                name="description">{{ old('description', $job_ads->description) }}</textarea>
              @if ($errors->has('description'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('description') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>{{ __('app.qualification') }}</label>
              <textarea class="form-control {{ $errors->has('qualification') ? ' is-invalid' : '' }}" rows="12" id="qualification"
                name="qualification">{{ old('qualification', $job_ads->qualification) }}</textarea>
              <small class="form-text text-info ">@lang('app.qualification_info_text')</small>
              @if ($errors->has('qualification'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('qualification') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label>{{ __('app.benefits') }}</label>
              <textarea class="form-control {{ $errors->has('benefits') ? ' is-invalid' : '' }}" rows="12" id="benefits" name="benefits">{{ old('benefits', $job_ads->benefits) }}</textarea>
              <small class="form-text text-info ">@lang('app.benefits_info_text')</small>
              @if ($errors->has('benefits'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('benefits') }}</strong>
                </div>
              @endif
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('app.work_locations') }}</h4>
        <div class="row form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label">{{ __('app.country') }} <span class="text-danger">*</span></label>
              <select class="form-control {{ $errors->has('country') ? ' is-invalid' : '' }} select" id="country" name="country">
                <option value="">@lang('app.select_a_country')</option>
                @foreach ($countries as $country)
                  <option value="{!! $country->id !!}" {{ selected($country->id, $job_ads->country_id) }}>
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
              <label class="control-label">{{ __('app.area') }} <span class="text-danger">*</span></label>
              <select class="form-control {{ $errors->has('area') ? ' is-invalid' : '' }} select" id="area" name="area">
                <option value="">@lang('app.select_a_area')</option>
                @if ($old_country)
                  @foreach ($old_country->area as $area)
                    <option value="{{ $area->id }}" {{ selected($area->id, old('area_id', $job_ads->area_id)) }}>
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
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label">{{ __('app.city') }}</label>
              <input type="text" class="form-control {{ $errors->has('city_name') ? ' is-invalid' : '' }}" id="city_name" name="city_name" value="{{ old('city_name', $job_ads->city_name) }}">
              @if ($errors->has('city_name'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('city_name') }}</strong>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('app.budget') }}</h4>
        <div class="row form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.vacancy') }}</label>
              <div class="input-group">
                <input type="number" class="form-control {{ $errors->has('vacancy') ? ' is-invalid' : '' }}" id="vacancy" name="vacancy" value="{{ old('vacancy', $job_ads->vacancy) }}">
                <span class="input-group-text">@lang('app.person')</span>
              </div>
              @if ($errors->has('vacancy'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('vacancy') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.salary_cycle') }}</label>
              <select class="form-control select {{ $errors->has('salary_cycle') ? ' is-invalid' : '' }}" id="salary_cycle" name="salary_cycle">
                <option value="">&nbsp;</option>
                @foreach (salary_cycle() as $level_id => $level)
                  <option value="{{ $level_id }}" {{ selected($level_id, old('salary_cycle', $job_ads->salary_cycle)) }}>
                    {{ $level }}</option>
                @endforeach
              </select>
              @if ($errors->has('salary_cycle'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('salary_cycle') }}</strong>
                </div>
              @endif
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.salary') }}</label>
              <input type="text" class="form-control {{ $errors->has('salary') ? ' is-invalid' : '' }}" id="experience_required_years" name="salary" value="{{ old('salary', $job_ads->salary) }}">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_negotiable" name="is_negotiable" value="1" {{ checked('1', old('is_negotiable', $job_ads->is_negotiable)) }}>
                <label class="form-check-label">
                  @lang('app.is_negotiable')
                </label>
              </div>
              @if ($errors->has('experience_required_years'))
                <div class="invalid-feedback">
                  <strong>{{ $errors->first('experience_required_years') }}</strong>
                </div>
              @endif
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>{{ __('app.salary_upto') }}</label>
              <input type="text" class="form-control {{ $errors->has('salary_upto') ? ' is-invalid' : '' }}" id="salary_upto" name="salary_upto"
                value="{{ old('salary_upto', $job_ads->salary_upto) }}">
              <small class="form-text text-info ">@lang('app.salary_upto_desc')</small>
            </div>
            @if ($errors->has('salary_upto'))
              <div class="invalid-feedback">
                <strong>{{ $errors->first('salary_upto') }}</strong>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="submit-section submit-btn-bottom">
      <button type="submit" class="btn btn-primary submit-btn">@lang('app.save_changes')</button>
    </div>
  </form>
@endsection

@section('page-js')
  <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/richtexteditor/rte.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/tagify/dist/jQuery.tagify.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/tagify/dist/tagify.min.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/richtexteditor/plugins/all_plugins.js') }}" defer></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}" defer></script>
  <script>
    $(document).ready(function() {
      var $inputSkills = $('input[id=skills]').tagify({
        originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(','),
        delimiters              : ",| ",
        backspace               : "edit",
        editTags                : {clicks: 1}
      });

      $('#deadline').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        clearBtn: true,
        todayBtn: true,
        todayHighlight: true,
        autoclose: true
      });

      $('#category').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#job_type').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#gender').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#exp_level').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#country').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#area').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      $('#salary_cycle').select2({
        theme: "bootstrap-5",
        width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
      });

      var editorcfg = {}
      editorcfg.toolbar = "mytoolbar";
      editorcfg.skin = "rounded-corner";
      editorcfg.editorResizeMode = "height";
      editorcfg.enterKeyTag = "div";
      editorcfg.paragraphClass = "paragraph";
      editorcfg.toolbar_mytoolbar =
        "{paste}|{bold,italic}|{paragraphs,fontsize,forecolor,backcolor}|{insertunorderedlist}|{justifyfull}|{lineheight}|{removeformat}" +
        "#{undo,redo,find,fullscreenenter,fullscreenexit}";

      var editor1 = new RichTextEditor("#description", editorcfg);
      var editor2 = new RichTextEditor("#qualification", editorcfg);
      var editor6 = new RichTextEditor("#benefits", editorcfg);

    });
  </script>
@endsection
