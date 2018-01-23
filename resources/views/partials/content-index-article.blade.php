<article @php(post_class())>
  <h3 class="index-entry-title">
    <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
  </h3>
  <div class="entry-summary">
    {{wp_trim_words(get_the_excerpt(), 55, '...')}}
  </div>
  <p class="archive-entry-citation__p">
    <i class="fa fa-share-alt"></i> {!! App::sbGetCitation(get_the_id()) !!}
  </p>
</article>

<div class="index-divider">
  <i class="fa fa-leaf" aria-hidden="true"></i>
</div>