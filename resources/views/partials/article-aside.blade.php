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

@if($article->getCitation())
  <h3 class="sb-aside-h3">Citation</h3>
  <p class="article-citation">{!! $article->getCitation() !!}</p>
@endif

@if($article->getCitedByCount())
  <h3 class="sb-aside-h3">Cited by</h3>

  <button type="button" class="btn btn-default btn-sm cited-by-btn" data-toggle="modal" data-target="#citedByModal">
    {{ $article->getCitedByCount() }}
  </button >

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

@if($article->getProgrammeString())
  <h3 class="sb-aside-h3">Programme</h3>
  <p class="keywords_list">{{$article->getProgrammeString()}}</p>
@endif

<div id="article-aside-wrap">
    <h3 class="sb-aside-h3"><i class="fa fa-list"></i> Contents</h3>
    <div id="sb-toc-wrap"></div>

    @if(!empty($article->getPdfUrl()))
        <h3 class="sb-aside-h3"><i class="fa fa-file-pdf-o"></i>  
          <a href="{{$article->getPdfUrl()}}">View PDF</a>
        </h3>
        <p class="article-citation"></p>
    @endif

    <h3 class="sb-aside-h3"><i class="fa fa-share-alt"></i> Share</h3>
    <div class="addthis_inline_share_toolbox"></div>
</div>