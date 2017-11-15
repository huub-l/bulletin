<div class="article-meta-date">
  <?php if(is_singular('article')): ?>
    <span class="article-date-title">{{ __('First published online:', 'sage') }}</span>
    <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>

  <?php else: ?>
    <time class="updated article-date" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
  <?php endif; ?>
</div>

<?php if ( function_exists( 'coauthors_posts_links' ) ) : ?>

  <p class="byline author vcard">
    {{ __('By', 'sage') }} 
    <?php coauthors_posts_links(); ?>
  </p>

<?php else: ?>

  <p class="byline author vcard">
    {{ __('By', 'sage') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">
      {{ get_the_author() }}
    </a>
  </p>

<?php endif; ?>