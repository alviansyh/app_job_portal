@extends('layouts.theme')

@section('content')
  <section class="section section-search" style="">
    <div class="container-fluid">
      <div class="banner-wrapper">
        <div class="banner-header text-center">
          <h2>@lang('app.slogan')</h2>
          <p>@lang('app.home_captions')</p>
        </div>

        <!-- Search -->
        <div class="search-box">
          <form action="" method="get">
            <div class="form-group search-info">
              <input type="text" class="form-control" placeholder="@lang('app.job_title_placeholder')">
            </div>
            <div class="form-group search-location">
              <input type="text" class="form-control" placeholder="@lang('app.job_location_placeholder')">
            </div>
            <button type="submit" class="btn btn-primary search-btn"><i class="fas fa-search"></i> <span>@lang('app.search')</span></button>
          </form>
        </div>
        <!-- /Search -->

      </div>
    </div>
  </section>

  @if ($categories->count())
    <div class="home-categories-wrap bg-white pb-5 pt-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h4 class="mb-4">@lang('app.browse_category')</h4>
          </div>
        </div>

        <div class="row">

          @foreach ($categories as $category)
            <div class="col-md-4">

              <p>
                <a href="" class="category-link"><i class="fas fa-briefcase"></i> {{ $category->category_name }} <span class="text-muted">({{ $category->job_count }})</span> </a>
              </p>

            </div>

          @endforeach

        </div>

      </div>
    </div>
  @endif


@endsection
