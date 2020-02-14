<div class="row">
  <?php $terms = App\Controllers\App::sbGetAllIssues(); ?>

  @foreach($terms as $term)
    <?php
      $termLink = get_term_link( $term );
      $termLegacyCoverMd5 = get_term_meta( $term->term_id, 'cover_image_md5', true );
      $termElibUrl = get_term_meta( $term->term_id, 'elib_url', true );
      $termImprintUrl = get_term_meta( $term->term_id, 'imprint_page_url', true );
    ?>
  

    @if($termLegacyCoverMd5)
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-4 home-grid-single">
        <div class="row">

          <div class="col-lg-5 col-xs-5 back-issue-desc__img">
            <div class="thumbnail">
              @if($term->count != 0)
                <a href="{{ $termLink }}">
              @else
                <a href="{{ $termElibUrl }}">
              @endif
                <img alt="Cover image, {{ $term->name }}" width="100%" class="sb-cover-image__img"
                  src="//www.apn-gcr.org/resources/files/thumbnails/{{ $termLegacyCoverMd5 }}.jpg" />
              </a>
            </div>
          </div>

          <div class="col-lg-7 col-xs-7 back-issue-desc">
              <h5 class="back-issue-desc__h5">{{ $term->name }}</h5>

              @if(trim($termImprintUrl) != '')
                <p><a class="back-issue-link__a"  href="{{ $termImprintUrl }}">
                  Imprint
                </a></p>
              @endif

              @if ($term->count != 0)
                <p><a class="back-issue-link__a" href="{{ $termLink }}">
                  Web version
                </a></p>
              @endif

              @if(trim($termElibUrl) != '')
                <p><a class="back-issue-link__a"  href="{{ $termElibUrl }}">
                  <i class="fa fa-file-pdf-o"></i> PDF version
                </a></p>
              @endif

          </div>
        </div>
      </div><!--col-->
    @endif

  @endforeach
  
</div><!--row-->