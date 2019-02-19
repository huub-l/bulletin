<?php

add_filter( 'cron_schedules', function($schedules) {
    $schedules['minute'] = array(
        'interval' => 60,
        'display'  => esc_html__( 'Every Minute' ),
    );
    return $schedules;
  }
);
 
add_filter( 'cron_schedules', function($schedules) {
    $schedules['five_secs'] = array(
        'interval' => 5,
        'display'  => esc_html__( 'Every 5 Seconds' ),
    );
    return $schedules;
  }
);
 
/**
 * Update cited_by count regularly
 */
if ( ! wp_next_scheduled( 'update_cited_by_count' ) ) {
  wp_schedule_event( time(), 'five_secs', 'update_cited_by_count' );
}

add_action( 'update_cited_by_count', function() {
  /**
   * 1. Get all articles
   * 2. Loop through each article
   *    2.1. Get cited_by
   *    2.2. Loop through forward links.
   */
});
