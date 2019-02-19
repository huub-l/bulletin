<?php

add_filter( 'cron_schedules', function($schedules) {
    $schedules['minute'] = array(
        'interval' => 60,
        'display'  => esc_html__( 'Every Minute' ),
    );
    return $schedules;
  }
);
 
/**
 * Update cited_by count regularly
 */
if ( ! wp_next_scheduled( 'update_cited_by_count' ) ) {
  wp_schedule_event( time(), 'minute', 'update_cited_by_count' );
}

add_action( 'update_cited_by_count', function() {
  echo '<pre>'; print_r( _get_cron_array() ); echo '</pre>';
});
