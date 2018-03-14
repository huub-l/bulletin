<?php

/* Add custom metadata to the "Issue" term.
 *
 * - Cover image MD5
 *
 */

// Add "Cover image md5" field for "issues" ----------------------------------//
add_action('issue_add_form_fields', function ($taxonomy) {
    ?><div class="form-field term-group">
        <label for="cover_image_md5"><?php _e('Cover image md5 (legacy)', 'sage'); ?></label>
        <input id="cover_image_md5" name="cover_image_md5" type="text">
        <p class="description">For issues 1-6, paste the "md5" part from the cover image URL. 
        This is used to construct the cover image from print issues housed in E-Lib. Ignore
        this for new issues. Example: 6dc710544598a0ad8d8b9bf13a1d7e6a for issue 6.</p>
    </div><?php
}, 100, 2);

// Save the issue "Cover image md5"
add_action('created_issue', function ($term_id, $tt_id) {
    if (isset($_POST['cover_image_md5']) && '' !== $_POST['cover_image_md5']) {
        $cover_image_md5 = sanitize_text_field($_POST['cover_image_md5']);
        add_term_meta($term_id, 'cover_image_md5', $cover_image_md5, true);
    }
}, 100, 2);

// Edit the issue "Cover image md5"
add_action('issue_edit_form_fields', function ($term, $taxonomy) {
    $selected_md5 = get_term_meta($term->term_id, 'cover_image_md5', true); ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="cover_image_md5"><?php _e('Cover image md5 (legacy)', 'sage'); ?></label></th>
        <td><div class="form-field term-group">
        <input id="cover_image_md5" name="cover_image_md5" type="text" value="<?php echo $selected_md5; ?>">
        <p class="description">For issues 1-6, paste the "md5" part from the cover image URL. 
        This is used to construct the cover image from print issues housed in E-Lib. Ignore
        this for new issues. Example: 6dc710544598a0ad8d8b9bf13a1d7e6a for issue 6.</p>
    </div></td>
    </tr><?php
}, 100, 2);

// Save the edited issue "Cover image md5"
add_action('edited_issue', function ($term_id, $tt_id) {
    if (isset($_POST['cover_image_md5']) && '' !== $_POST['cover_image_md5']) {
        $cover_image_md5 = sanitize_title($_POST['cover_image_md5']);
        update_term_meta($term_id, 'cover_image_md5', $cover_image_md5);
    }
}, 100, 2);