<div class="row">
  <div class="entry-content col-md-12 col-lg-8">
    <article @php(post_class())>
      <header>
        <div class="article-feature-image">
          <div class="image-wrap">
            <?php if ( has_post_thumbnail() ) : ?>
              <?php the_post_thumbnail('medium_large', ['class' => 'sb-article-feature-img img-fluid']); ?>
              <div class="article-feature-image-caption">{{get_post(get_post_thumbnail_id())->post_title}}</div>
            <?php endif; ?>
          </div>
        </div>

        <?php App::sbPrintProjectRef(get_the_ID()); ?>
        
        <h1 id="sb-entry-title">{{ get_the_title() }}</h1>
        @include('partials.entry-meta')
      </header>

      <div id="single-article-exerpt">{{get_the_excerpt()}}</div>

      <div id="article-keywords">
        <h1 id="h2-keywords">Keywords</h1>
        {!! App::sbKeywords() !!}
      </div>

      <div class="index-divider">
        <i class="fa fa-leaf" aria-hidden="true"></i>
      </div>

        @php(the_content())

    </article>
  </div>
  <aside class="col-lg-3 offset-lg-1" id="sb-article-aside">
    @include('partials.article-aside')
  </aside>
</div><!--row-->

<footer>
  {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
</footer>

@php(comments_template('/partials/comments.blade.php'))

<script>
jQuery('figure img').parent().addClass('thickbox').attr('rel', 'page');
</script>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a0d3724dab188db"></script> 