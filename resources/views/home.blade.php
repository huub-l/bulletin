@extends('layouts.app')

@section('content')

  @php
    $query = App::sbGetFeaturedQuery();
  @endphp

  <div class="row">
  @while ($query->have_posts()) @php($query->the_post())
    @include('partials.home-featured')
  @endwhile
  </div>

  <div class="index-divider home-index-divider">
    <i class="fa fa-paper-plane" aria-hidden="true"></i>
  </div>

  @php
    $query = App::sbGetArticleQuery();
  @endphp

  <div class="row">
  @while ($query->have_posts()) @php($query->the_post())
    @include('partials.home-grid')
  @endwhile
  </div>

@endsection
