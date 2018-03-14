<?php

/* Add custom metadata to the "Issue" term.
 *
 * - Elib URL
 *
 */

// Add "Elib URL" field for "issues" -----------------------------------------//
add_action('issue_add_form_fields', function ($taxonomy) {
    ?><div class="form-field term-group">
        <label for="elib_url"><?php _e('Full Elib URL (legacy)', 'sage'); ?></label>
        <input id="elib_url" name="elib_url" type="text">
        <p class="description">For issues 1-6, paste the full URL of the publication on E-Lib. 
        Ignore this if the issue is not housed in E-Lib.</p>
    </div><?php
}, 100, 2);

// Save the issue "Elib URL"
add_action('created_issue', function ($term_id, $tt_id) {
    if (isset($_POST['elib_url']) && '' !== $_POST['elib_url']) {
        $elib_url = sanitize_text_field($_POST['elib_url']);
        add_term_meta($term_id, 'elib_url', $elib_url, true);
    }
}, 100, 2);

// Edit the issue "Elib URL"
add_action('issue_edit_form_fields', function ($term, $taxonomy) {
    $selected_elib_url = get_term_meta($term->term_id, 'elib_url', true); ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="elib_url"><?php _e('Elib URL (legacy)', 'sage'); ?></label></th>
        <td><div class="form-field term-group">
        <input id="elib_url" name="elib_url" type="text" value="<?php echo $selected_elib_url; ?>">
        <p class="description">For issues 1-6, paste the full URL of the publication on E-Lib. 
        Ignore this if the issue is not housed in E-Lib.</p>
    </div></td>
    </tr><?php
}, 100, 2);

// Save the edited issue "Elib URL"
add_action('edited_issue', function ($term_id, $tt_id) {
    if (isset($_POST['elib_url']) && '' !== $_POST['elib_url']) {
        $elib_url = sanitize_title($_POST['elib_url']);
        update_term_meta($term_id, 'elib_url', $elib_url);
    }
}, 100, 2);
