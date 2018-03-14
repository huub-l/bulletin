<?php

/* Add custom metadata to the "Issue" term.
 *
 * - Imprint page URL
 *
 */

// Add "Imprint page URL" field for "issues" ----------------------------------//
add_action('issue_add_form_fields', function ($taxonomy) {
    ?><div class="form-field term-group">
        <label for="imprint_page_url"><?php _e('URL of the imprint page', 'sage'); ?></label>
        <input id="imprint_page_url" name="imprint_page_url" type="text">
        <p class="description">Full URL of the imprint page for the current issue.</p>
    </div><?php
}, 100, 2);

// Save the issue "Imprint page URL"
add_action('created_issue', function ($term_id, $tt_id) {
    if (isset($_POST['imprint_page_url']) && '' !== $_POST['imprint_page_url']) {
        $imprint_page_url = sanitize_text_field($_POST['imprint_page_url']);
        add_term_meta($term_id, 'imprint_page_url', $imprint_page_url, true);
    }
}, 100, 2);

// Edit the issue "Imprint page URL"
add_action('issue_edit_form_fields', function ($term, $taxonomy) {
    $imprint_page_url = get_term_meta($term->term_id, 'imprint_page_url', true); ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="imprint_page_url"><?php _e('URL of the imprint page', 'sage'); ?></label></th>
        <td><div class="form-field term-group">
        <input id="imprint_page_url" name="imprint_page_url" type="text" value="<?php echo $imprint_page_url; ?>">
        <p class="description">Full URL of the imprint page for the current issue.</p>
    </div></td>
    </tr><?php
}, 100, 2);

// Save the edited issue "Imprint page URL"
add_action('edited_issue', function ($term_id, $tt_id) {
    if (isset($_POST['imprint_page_url']) && '' !== $_POST['imprint_page_url']) {
        $imprint_page_url = sanitize_text_field($_POST['imprint_page_url']);
        update_term_meta($term_id, 'imprint_page_url', $imprint_page_url);
    }
}, 100, 2);
