<h3 class="sb-aside-h3">Issue</h3>
{!!App::sbGetIssue()!!}

@if(App::sbGetPartners())
<h3 class="sb-aside-h3">Partners</h3>
{!!App::sbGetPartners()!!}
@endif

@if(App::sbGetProgramme())
<h3 class="sb-aside-h3">Programme</h3>
{!!App::sbGetProgramme()!!}
@endif

<h3 class="sb-aside-h3">Contents</h3>
<div id="sb-toc-wrap"></div>

<h3 class="sb-aside-h3">Share</h3>
<div class="addthis_inline_share_toolbox"></div>