<?php

/* Add custom metadata to the "Issue" term.
 *
 * - Volume number
 *
 */

// Add "Volume" field for "issues" ----------------------------------//
add_action('issue_add_form_fields', function ($taxonomy) {
    ?><div class="form-field term-group">
        <label for="volume"><?php _e('Volume number', 'sage'); ?></label>
        <input id="volume" name="volume" type="text">
        <p class="description">To go in line with jounal style terminology,
        use volume number to indicate the number of years the Bulletin has
        been in circulation. Since it started in 2011, then all 2018 articles,
        for example, should be under "Volume 8"</p>
    </div><?php
}, 100, 2);

// Save the issue "Volume number"
add_action('created_issue', function ($term_id, $tt_id) {
    if (isset($_POST['volume']) && '' !== $_POST['volume']) {
        $volume = sanitize_text_field($_POST['volume']);
        add_term_meta($term_id, 'volume', $volume, true);
    }
}, 100, 2);

// Edit the issue "Volume number"
add_action('issue_edit_form_fields', function ($term, $taxonomy) {
    $selected_volume = get_term_meta($term->term_id, 'volume', true); ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="volume"><?php _e('Volume number', 'sage'); ?></label></th>
        <td><div class="form-field term-group">
        <input id="volume" name="volume" type="text" value="<?php echo $selected_volume; ?>">
        <p class="description">To go in line with jounal style terminology,
        use volume number to indicate the number of years the Bulletin has
        been in circulation. Since it started in 2011, then all 2018 articles,
        for example, should be under "Volume 8"</p>
    </div></td>
    </tr><?php
}, 100, 2);

// Save the edited issue "Volume number"
add_action('edited_issue', function ($term_id, $tt_id) {
    if (isset($_POST['volume']) && '' !== $_POST['volume']) {
        $volume = sanitize_title($_POST['volume']);
        update_term_meta($term_id, 'volume', $volume);
    }
}, 100, 2);
