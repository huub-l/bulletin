<h3 class="sb-aside-h3">Issue</h3>
{!!App::sbGetIssue()!!}

<h3 class="sb-aside-h3">Contents</h3>
<ul>
  <li>Chapter 1</li>
  <li>Chapter 2</li>
  <li>Chapter 3</li>
</ul>

@if(App::sbGetPartners())
<h3 class="sb-aside-h3">Partners</h3>
{!!App::sbGetPartners()!!}
@endif

<h3 class="sb-aside-h3">Share</h3>
<div class="addthis_inline_share_toolbox"></div>