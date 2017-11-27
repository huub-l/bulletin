<div class="col-lg-12">
   
   <a href="{{get_permalink()}}">
      @if(has_post_thumbnail())
        <img class="sb-fade" src="{{the_post_thumbnail_url( 'home-featured' )}}" alt="{{get_the_title()}}" width="100%"
            srcset="{{wp_get_attachment_image_srcset( get_post_thumbnail_id(), 'home-featured' )}}"
            sizes="{{wp_get_attachment_image_sizes(get_post_thumbnail_id(), 'home-featured' )}}" />
      @else
        <img class="sb-fade"  src="//via.placeholder.com/1110x400?text=Science+Bulletin" alt="{{get_the_title()}}">
      @endif
    </a>

</div>

<div class="col-lg-12">
    <h1 class="home-featured-h1 text-center"><a href="{{get_permalink()}}">{{get_the_title()}}</a></h1>
    <p class="byline author vcard">
      {{ __('By', 'sage') }} 
      <?php coauthors_posts_links(); ?>
    </p>
</div>