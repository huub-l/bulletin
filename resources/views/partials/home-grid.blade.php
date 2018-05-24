<div class="col-sm-6 col-md-4 col-lg-3">
  <a href="{{get_permalink()}}" class="home-grid-title">
    <div class="thumbnail home-grid-single home-article-grid__thumbnail">
      @if(has_post_thumbnail())
        <img class="sb-fade" src="@php(the_post_thumbnail_url( 'home-small' ))" alt="{{get_the_title()}}" width="100%">
      @else
        <img class="sb-fade" src="//via.placeholder.com/255x100?text=Science+Bulletin" alt="{{get_the_title()}}" width="100%">
      @endif
      <div class="home-thumbnail-caption home-article-grid__caption">
        <span class="home-meta-programme">
          {{App::sbGetProgrammeString()}}
        </span>
        <p>{{get_the_title()}}</p>
      </div>
    </div>
  </a>
</div>