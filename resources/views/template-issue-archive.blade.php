{{--
  Template Name: Issue archive
--}}

@extends('layouts.app-narrow')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    <div class="archive-header-rule"></div>
    @include('partials.content-page')
    @include('partials.home-back-issues-content')
  @endwhile
@endsection
