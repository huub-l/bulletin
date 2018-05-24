@extends('layouts.app-narrow')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.page-header')
    <div class="archive-header-rule"></div>
    @include('partials.content-page')
  @endwhile
@endsection
