@extends('layouts.app')

@section('content')
  @include('partials.page-header')
  
  <div class="archive-header-rule"></div>

  @if (!have_posts())
    <div class="alert alert-warning">
      {{ __('Sorry, no results were found.', 'sage') }}
    </div>
    {!! get_search_form(false) !!}
  @endif

  @while (have_posts()) @php(the_post())
    @include('partials.content-index-'.get_post_type())
  @endwhile

  {!! get_the_posts_navigation(array(
            'prev_text'          => __( 'Older articles' ),
            'next_text'          => __( 'Newer articles' ),
            'screen_reader_text' => __( 'Articles navigation' ),
  )) !!}
@endsection
