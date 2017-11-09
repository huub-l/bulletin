<article @php(post_class())>
  <header>
    <?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail('medium_large', ['class' => 'sb-article-feature-img img-responsive']); ?>
    <?php endif; ?>
    
    <?php App::sbPrintProjectRef(get_the_ID()); ?>
    
    <h1 class="entry-title">{{ get_the_title() }}</h1>
    @include('partials/entry-meta')
  </header>
  <div class="entry-content">

    <div id="single-article-exerpt">{{get_the_excerpt()}}</div>

    <div id="article-keywords">
      <h1 id="h2-keywords">Keywords</h1>
      {!! App::sbKeywords() !!}
    </div>

    <div class="index-divider">
      <i class="fa fa-leaf" aria-hidden="true"></i>
    </div>

    @php(the_content())

  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php(comments_template('/partials/comments.blade.php'))
</article>