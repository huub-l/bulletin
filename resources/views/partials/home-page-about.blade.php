<?php $page = get_page_by_path('about')?>

<div class="col-md-5">
  <h1 class="home-section-title">{{$page->post_title}}</h1>
  <div class="home-section-title-rule"></div>
</div>
<div class="col-md-7">
  {{ $page->post_content}}
</div>