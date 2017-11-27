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

@endsection

@section('home-section-2')
  <div class="home-about jumbotron" id="home-section-about">
    @include('partials.home-page-about')
  </div>

  <div class="container">
    <div class="index-divider home-index-divider">
      <i class="fa fa-paper-plane" aria-hidden="true"></i>
    </div>
    <div class="row" style="margin:100px auto;">
      @php
        $query = App::sbGetArticleQuery();
      @endphp
      @while ($query->have_posts()) @php($query->the_post())
        @include('partials.home-grid')
      @endwhile
    </div>
  </div>

  <div class="jumbotron" style="width:100%; background:#eee; padding:100px 0; margin-bottom:0;">
      @include('partials.home-keywords')
  </div>

@endsection