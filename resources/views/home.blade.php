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
    <div class="row">
      @php
        $query = App::sbGetArticleQuery();
      @endphp
      @while ($query->have_posts()) @php($query->the_post())
        @include('partials.home-grid')
      @endwhile
      <div class="col-md-12">
        <a class="home-grid__button btn btn-success" href="<?php echo get_post_type_archive_link('article'); ?>">All</a>
      </div>
    </div>
  </div>

  <div class="jumbotron" style="width:100%; background:#eee; padding:100px 0; margin-bottom:0;">
      @include('partials.home-keywords')
  </div>

  <div class="jumbotron" style="width:100%; background:#fff; padding:100px 0; margin-bottom:0;">
      @include('partials.home-back-issues')
  </div>

@endsection