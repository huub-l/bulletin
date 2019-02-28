<?php 
use App\Controllers\Article;

$article = new Article(get_the_ID());
?>

<?php if ( function_exists( 'coauthors_posts_links' ) ) : ?>

  <p class="byline author vcard">
    {{ __('By', 'sage') }} 
    {!! $article->getCoauthorsLinks() !!}
  </p>

<?php else: ?>

  <p class="byline author vcard">
    {{ __('By', 'sage') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
      {{ get_the_author() }}
    </a>
  </p>

<?php endif; ?>

<div class="article-meta-date">
  <?php if(is_singular('article')): ?>
    <span class="article-date-title">{{ __('First published online:', 'sage') }}</span>
    <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>

  <?php else: ?>
    <time class="updated article-date" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
  <?php endif; ?>
</div>
