<?php

use App\Controllers\Article;

$article = new Article(get_the_ID());

?>

<h3 class="sb-aside-h3">Issue</h3>

{!! $article->getIssueLink() !!}

@if(!empty($article->getDoi()))
  <h3 class="sb-aside-h3">DOI</h3>
  <p class="article-aside-doi">
    <a href="https://doi.org/{{ $article->getDoi() }}">
      https://doi.org/{{ $article->getDoi() }}
    </a>
  </p>
@endif

@if(!empty($article->getPdfUrl()))
  <a id="article-get-pdf-link" href="{{$article->getPdfUrl()}}">
    <h3 class="article-get-pdf-h3"><i class="fa fa-file-pdf-o"></i>  
      View PDF
    </h3>
  </a>
@endif

  <h3 class="sb-aside-h3">Licence information</h3>
  <p class="article-citation">
    <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">
      <img alt="Creative Commons License" style="border-width:0" 
      src="https://i.creativecommons.org/l/by-nc/4.0/80x15.png" /></a>
      <br />This work is licensed under a 
      <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">
      Creative Commons Attribution-NonCommercial 4.0 International License</a>.
  </p>

<h3 class="sb-aside-h3">Article metrics</h3>

@if($article->getCitedByCount())

  <div class="metric__block">
    <a class="cited-by-btn" 
      data-toggle="modal" 
      data-target="#citedByModal" 
      href="#">
      <img class="citation-count__img" 
        src="{{get_template_directory_uri()}}/images/crossref-logo-landscape-200.svg" 
        alt="Crossref logo" width="60px">

      @if($article->getCitedByCount() ==1 )
        Cited by {{ $article->getCitedByCount() }} article
      @else
        Cited by {{ $article->getCitedByCount() }} articles
      @endif
    </a >
  </div>

  <div class="modal fade" id="citedByModal" tabindex="-1" role="dialog" aria-labelledby="citedByModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="citedByModalLabel" style="margin-top:8px;"><strong>This article is cited by:</strong></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @foreach($article->getForwardLinks() as $link)
            <p class="citedby-articles">{{ $link }}</p>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endif

<div data-badge-popover="bottom" 
  data-hide-no-mentions="true"
  data-doi="{!! $article->getDoi(); !!}" 
  class="altmetric-embed metric__block">
</div>

<div class="plumx-embed__wrap">
  <a href="https://plu.mx/plum/a/?doi={!! $article->getDoi(); !!}" 
    data-popup="bottom" 
    data-badge="true" 
    class="plumx-plum-print-popup plum-bigben-theme" 
    data-site="plum" 
    data-hide-when-empty="true">
  </a>
</div>

@if($article->getCitation())
  <h3 class="sb-aside-h3">Citation</h3>
  <p class="article-citation">{!! $article->getCitation() !!}</p>
@endif

<div id="article-aside-wrap">

    <h3 class="sb-aside-h3"><i class="fa fa-list"></i> Contents</h3>
    <div id="sb-toc-wrap"></div>

    <h3 class="sb-aside-h3"><i class="fa fa-share-alt"></i> Share</h3>
    <div class="addthis_inline_share_toolbox"></div>


</div>