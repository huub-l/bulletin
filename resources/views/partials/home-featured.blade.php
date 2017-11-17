<div class="col-lg-6">
   
   <a href="{{get_permalink()}}">
      @if(has_post_thumbnail())
        <img class="sb-fade" src="@php(the_post_thumbnail_url( 'home-featured' ))" alt="{{get_the_title()}}" width="100%">
      @else
        <img class="sb-fade"  src="//via.placeholder.com/255x100?text=Science+Bulletin" alt="{{get_the_title()}}">
      @endif
    </a>

</div>

<div class="col-lg-6">
    <h1 class="home-featured-h1">{{get_the_title()}}</h1>
</div>