@extends('layouts.app')

@section('content')

  @php
    $query = App::sbGetArticleQuery();
  @endphp

  @if (!$query->have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  <div class="row">
  @while ($query->have_posts()) @php($query->the_post())
    @include('partials.home-grid')
  @endwhile
  </div>

@endsection
