@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  {!! nl2br(e(App::sbGetCoauthorDescription())) !!}

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while (have_posts()) @php(the_post())
    @include('partials.content-index-'.get_post_type())
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection
