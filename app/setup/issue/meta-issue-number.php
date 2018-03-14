<?php

/* Add custom metadata to the "Issue" term.
 *
 * - Issue number
 *
 */

// Add "Issue" field for "issues" ----------------------------------//
add_action('issue_add_form_fields', function ($taxonomy) {
    ?><div class="form-field term-group">
        <label for="issue"><?php _e('Issue number', 'sage'); ?></label>
        <input id="issue" name="issue" type="text" value="1">
        <p class="description">Unless there's a special issue, use 1.</p>
    </div><?php
}, 100, 2);

// Save the issue "issue number"
add_action('created_issue', function ($term_id, $tt_id) {
    if (isset($_POST['issue']) && '' !== $_POST['issue']) {
        $issue = sanitize_text_field($_POST['issue']);
        add_term_meta($term_id, 'issue', $issue, true);
    }
}, 100, 2);

// Edit the issue "issue number"
add_action('issue_edit_form_fields', function ($term, $taxonomy) {
    $selected_issue = get_term_meta($term->term_id, 'issue', true); ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="issue"><?php _e('Issue number', 'sage'); ?></label></th>
        <td><div class="form-field term-group">
        <input id="issue" name="issue" type="text" value="<?php echo $selected_issue; ?>">
        <p class="description">Unless there's a special issue, use 1.</p>
    </div></td>
    </tr><?php
}, 100, 2);

// Save the edited issue "issue number"
add_action('edited_issue', function ($term_id, $tt_id) {
    if (isset($_POST['issue']) && '' !== $_POST['issue']) {
        $issue = sanitize_title($_POST['issue']);
        update_term_meta($term_id, 'issue', $issue);
    }
}, 100, 2);
