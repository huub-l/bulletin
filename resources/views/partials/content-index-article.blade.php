<article @php(post_class())>
  <h3 class="index-entry-title">
    <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
  </h3>
  <div class="entry-summary">
    @php(the_excerpt())
  </div>
</article>

<div class="index-divider">
  <i class="fa fa-leaf" aria-hidden="true"></i>
</div>