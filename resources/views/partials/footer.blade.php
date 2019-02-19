<footer class="content-info">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        @php(dynamic_sidebar('sidebar-footer-1'))
      </div>
      <div class="col-md-5">
        @php(dynamic_sidebar('sidebar-footer-2'))
      </div>
    </div>
  </div>
</footer>
<pre>{{print_r(_get_cron_array())}}</pre>
<?php $citation = new App\Controllers\Citation('', '10.30852/sb.2018.436'); ?>
<pre>{{$citation->getFormattedCitation() }}</pre>
<pre>{{ $citation->getCitedBy() }}</pre>
<pre>{{ $citation->getCitedByCount() }}</pre>