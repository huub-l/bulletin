<div class="col-sm-6 col-md-3">
  <div class="thumbnail">
    <a href="{{get_permalink()}}">
      @if(has_post_thumbnail())
        <img class="fade" src="@php(the_post_thumbnail_url( 'home-small' ))" alt="{{get_the_title()}}" width="100%">
      @else
        <img class="fade" src="http://via.placeholder.com/255x100?text=Science+Bulletin" alt="{{get_the_title()}}" width="100%">
      @endif
    </a>
    
    <div class="home-meta-programme">
      {{App::sbProgramme()}}
    </div>
    <div class="home-thumbnail-caption">
      <p>{{get_the_title()}}</p>
    </div>
  </div>
</div>