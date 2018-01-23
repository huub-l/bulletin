<?php $terms = App::sbGetAllIssues(); ?>
<div class="row">
  <div class="col-md-12">
    <h3 style="margin-top:0">Web</h3>
    <ul>
      <?php
        foreach ( $terms as $term ): 
          $termLink = get_term_link( $term );
          $termLegacyCoverMd5 = get_term_meta( $term->term_id, 'cover_image_md5', true );
          $termImprintUrl = get_term_meta( $term->term_id, 'imprint_page_url', true );
      ?>
        <?php if (!$termLegacyCoverMd5): ?>
          <li class="home-e-issues__li">
            <strong><?php echo $term->name; ?></strong> &bull; 
            <a href="<?php echo get_term_link($term); ?>">
              Articles
            </a>
            <?php if ($termImprintUrl): ?>
              &bull; <a href="<?php echo $termImprintUrl; ?>">
                Imprint
              </a>
            <?php endif; ?>
          </li>
        <?php endif;?>
      <?php endforeach; ?>
    </ul>
  </div><!--col-->
</div><!--row-->

<div class="row">
  <div class="col-md-12">
    <h3>PDF/Print</h3>
  </div>
  <?php
    foreach ( $terms as $term ): 
      $termLink = get_term_link( $term );
      $termLegacyCoverMd5 = get_term_meta( $term->term_id, 'cover_image_md5', true );
      $termElibUrl = get_term_meta( $term->term_id, 'elib_url', true );
  ?>

    <?php if ($termLegacyCoverMd5): ?>
      <div class="col-md-2">
        <div class="thumbnail home-grid-single">
          <a href="<?php echo $termElibUrl; ?>">
            <img alt="Cover image, <?php echo $term->name; ?>" width="100%" class="sb-cover-image__img"
              src="//www.apn-gcr.org/resources/files/thumbnails/<?php echo $termLegacyCoverMd5; ?>.jpg" />
          </a>
          <div class="caption">
            <p><?php echo $term->name; ?></p>
          </div>
        </div>
      </div>
    <?php endif;?>

  <?php endforeach; ?>
  
</div><!--row-->