<article @php(post_class())>
  <header>
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{{ get_the_title() }}</a></h2>
    @include('partials/entry-meta')
  </header>
  <div class="entry-summary">
    {!! strip_tags(get_the_excerpt(), '<sub>,<sup>,<i>') !!}
  </div>
</article>
