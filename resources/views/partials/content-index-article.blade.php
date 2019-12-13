<?php
  use App\Controllers\Article;
  $article = new Article(get_the_ID());
?>
<article @php(post_class())>
  <div class="row">
    <div class="col-md-4">
      <a href="{{ get_permalink() }}">
        @if(has_post_thumbnail())
          <img class="sb-fade archive-block__img" src="@php(the_post_thumbnail_url( 'home-small' ))" alt="{{get_the_title()}}" width="100%">
        @else
          <img class="sb-fade archive-block__img" src="{{get_template_directory_uri()}}/images/asb-dummy.png" alt="{{get_the_title()}}" width="100%">
        @endif
      </a>
      @if( $article->getKeywordsList() !== false )
        <div class="archive-keywords__div"><strong><i class="fa fa-key"></i> Keywords:</strong> {!! $article->getKeywordsList() !!}</div>
      @endif
    </div><!--col-->
    <div class="col-md-8">
      <h3 class="index-entry-title archive-block__h3">
        <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
      </h3>
      <div class="entry-summary">
        {{wp_trim_words(get_the_excerpt(), 55, '...')}}
      </div>
      <p class="archive-entry-citation__p">
        @if( $article->getCitation()  !== false)
          <i class="fa fa-share-alt"></i> {!! $article->getCitation() !!}
        @endif
      </p>
    </div><!--col-->
  </div><!--row-->
</article>

<div class="index-divider">
  <i class="fa fa-leaf" aria-hidden="true"></i>
</div>