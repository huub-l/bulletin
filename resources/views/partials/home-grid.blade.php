<div class="col-sm-6 col-md-3">
  <div class="thumbnail">
    <a href="{{get_permalink()}}">
      @if(has_post_thumbnail())
        <img src="@php(the_post_thumbnail_url( 'home-small' ))" alt="{{get_the_title()}}">
      @else
        <img src="http://via.placeholder.com/255x100?text=Science+Bulletin" alt="{{get_the_title()}}">
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