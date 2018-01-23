<div class="col-sm-6 col-md-3">
  <div class="thumbnail home-grid-single home-article-grid__thumbnail">
    <a href="{{get_permalink()}}">
      @if(has_post_thumbnail())
        <img class="sb-fade" src="@php(the_post_thumbnail_url( 'home-small' ))" alt="{{get_the_title()}}" width="100%">
      @else
        <img class="sb-fade" src="//via.placeholder.com/255x100?text=Science+Bulletin" alt="{{get_the_title()}}" width="100%">
      @endif
    </a>
    <div class="home-thumbnail-caption home-article-grid__caption">
      <span class="home-meta-programme">
        {{App::sbGetProgrammeString()}}
      </span>
      <p><a class="home-grid-title" href="{{get_permalink()}}">{{get_the_title()}}</a></p>
    </div>
  </div>
</div>