<article @php(post_class())>
  <div class="row">
    <div class="col-md-4">
      <a href="{{ get_permalink() }}">
        @if(has_post_thumbnail())
          <img class="sb-fade archive-block__img" src="@php(the_post_thumbnail_url( 'home-small' ))" alt="{{get_the_title()}}" width="100%">
        @else
          <img class="sb-fade archive-block__img" src="//via.placeholder.com/255x100?text=Science+Bulletin" alt="{{get_the_title()}}" width="100%">
        @endif
      </a>
      <div class="archive-keywords__div"><strong><i class="fa fa-key"></i> Keywords:</strong> {!!App::sbKeywords()!!}</div>
    </div><!--col-->
    <div class="col-md-8">
      <h3 class="index-entry-title archive-block__h3">
        <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
      </h3>
      <div class="entry-summary">
        {{wp_trim_words(get_the_excerpt(), 55, '...')}}
      </div>
      <p class="archive-entry-citation__p">
        <i class="fa fa-share-alt"></i> {!! App::sbGetCitation(get_the_id()) !!}
      </p>
    </div><!--col-->
  </div><!--row-->
</article>

<div class="index-divider">
  <i class="fa fa-leaf" aria-hidden="true"></i>
</div>