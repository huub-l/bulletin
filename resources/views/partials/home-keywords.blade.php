<?php use App\Controllers\App as SbApp; ?>
<div class="container">
  <div class="row">
    <div class="col-md-5">
      <h1 class="home-section-title">Keywords</h1>
      <div class="home-section-title-rule"></div>
    </div>
    <div id="home-keyword-list__div" class="col-md-7 home-keyword-list__div--short">
      <p class="keywords_list" class="home-keyword-list__p">
      {!! SbApp::sbGetAllKeywords() !!}
      </p>
    </div>
    <div class="col-md-5">
    </div>
    <div col-md-7">
      <p>
        <a id="home-keywords__more" class="home-keywords__button btn btn-primary btn-square" href="#">Show more</a>
        <a id="home-keywords__more" class="home-keywords__button hidden btn btn-primary btn-square" href="#">Show less</a>
      </p>
    </div>
  </div>
</div>