<?php $page = get_page_by_path('about')?>

<div class="container">
  <div class="row">
    <div class="col-lg-7" id="home-about-text">
      <h1 class="home-section-title">{{$page->post_title}}</h1>
      <div class="home-section-title-rule"></div>
      {!! $page->post_content !!}
    </div>
    <div class="col-lg-3 offset-lg-2">
      @if(has_post_thumbnail($page))
        <img src="{{get_the_post_thumbnail_url($page, 'medium')}}" alt="{{get_the_title()}}" width="100%" />
      @else
        <img src="//via.placeholder.com/248x248?text=Science+Bulletin" alt="{{get_the_title()}}">
      @endif
    </div>
  </div>
</div>