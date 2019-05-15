<div class="row">
  <?php
    $terms = App\Controllers\App::sbGetAllIssues();
    
    foreach ( $terms as $term ): 
      $termLink = get_term_link( $term );
      $termLegacyCoverMd5 = get_term_meta( $term->term_id, 'cover_image_md5', true );
      $termElibUrl = get_term_meta( $term->term_id, 'elib_url', true );
      $termImprintUrl = get_term_meta( $term->term_id, 'imprint_page_url', true );
  ?>

    <?php if ($termLegacyCoverMd5): ?>
      <div class="col-lg-4 col-md-6 col-sm-6 col-xs-4 home-grid-single">
        <div class="row">

          <div class="col-lg-5 col-xs-5 back-issue-desc__img">
            <div class="thumbnail">
            <?php if ($term->count != 0): ?>
              <a href="<?php echo $termLink; ?>">
            <?php else: ?>
              <a href="<?php echo $termElibUrl; ?>">
            <?php endif; ?>
                <img alt="Cover image, <?php echo $term->name; ?>" width="100%" class="sb-cover-image__img"
                  src="//www.apn-gcr.org/resources/files/thumbnails/<?php echo $termLegacyCoverMd5; ?>.jpg" />
              </a>
            </div>
          </div>

          <div class="col-lg-7 col-xs-7 back-issue-desc">
              <h5 class="back-issue-desc__h5"><?php echo $term->name; ?></h5>

              <?php if (trim($termImprintUrl) != ''): ?>
                <p><a class="back-issue-link__a"  href="<?php echo $termImprintUrl; ?>">
                  Imprint
                </a></p>
              <?php endif; ?>

              <?php if ($term->count != 0): ?>
                <p><a class="back-issue-link__a" href="<?php echo $termLink; ?>">
                  Web version
                </a></p>
              <?php endif; ?>

              <?php if (trim($termElibUrl) != ''): ?>
                <p><a class="back-issue-link__a"  href="<?php echo $termElibUrl; ?>">
                  <i class="fa fa-file-pdf-o"></i> PDF version
                </a></p>
              <?php endif; ?>

          </div>
        </div>
      </div><!--col-->
    <?php endif;?>

  <?php endforeach; ?>
  
</div><!--row-->