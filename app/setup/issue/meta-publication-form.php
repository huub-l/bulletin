<?php

/* Add custom metadata to the "Issue" term.
 *
 * - **Form of publication (print, online, both)**
 *
 */

// Add "publication form" field for "issues"
add_action('issue_add_form_fields', function ($taxonomy) {
    $issue_types = [
        'onlineprint' => __('Online & print', 'sage'),
        'online'      => __('Online', 'sage'),
        'print'       => __('Print', 'sage'),
    ]; ?><div class="form-field term-group">
        <label for="issue_type"><?php _e('Publication form', 'sage'); ?></label>
        <select class="postform" id="issue_type" name="issue_type">
            <?php foreach ($issue_types as $key => $issue_type) : ?>
                <option value="<?php echo $key; ?>" class=""><?php echo $issue_type; ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div><?php
}, 100, 2);

// Save the issue "publication form"
add_action('created_issue', function ($term_id, $tt_id) {
    if (isset($_POST['issue_type']) && '' !== $_POST['issue_type']) {
        $issue_type = sanitize_title($_POST['issue_type']);
        add_term_meta($term_id, 'issue_type', $issue_type, true);
    }
}, 100, 2);

// Edit the issue "publication form"
add_action('issue_edit_form_fields', function ($term, $taxonomy) {
    $issue_types = [
        'onlineprint' => __('Online & print', 'sage'),
        'online'      => __('Online', 'sage'),
        'print'       => __('Print', 'sage'),
    ];

    $selected_issue_type = get_term_meta($term->term_id, 'issue_type', true); ?><tr class="form-field term-group-wrap">
        <th scope="row"><label for="issue_type"><?php _e('Publication form', 'sage'); ?></label></th>
        <td><select class="postform" id="issue_type" name="issue_type">
            <?php foreach ($issue_types as $key => $issue_type) : ?>
                <option value="<?php echo $key; ?>" <?php selected($selected_issue_type, $key); ?>><?php echo $issue_type; ?></option>
            <?php endforeach; ?>
        </select></td>
    </tr><?php
}, 100, 2);

// Save the edited issue "publication form"
add_action('edited_issue', function ($term_id, $tt_id) {
    if (isset($_POST['issue_type']) && '' !== $_POST['issue_type']) {
        $issue_type = sanitize_title($_POST['issue_type']);
        update_term_meta($term_id, 'issue_type', $issue_type);
    }
}, 100, 2);

// Show "publication form" column in the term list
add_filter('manage_edit-issue_columns', function ($columns) {
    $columns['issue_type'] = __('Publication form', 'sage');

    return $columns;
});

// Add "publication form" text to column in term list
add_filter('manage_issue_custom_column', function ($content, $column_name, $term_id) {
    $issue_types = [
        'onlineprint' => __('Online & print', 'sage'),
        'online'      => __('Online', 'sage'),
        'print'       => __('Print', 'sage'),
    ];

    if ($column_name !== 'issue_type') {
        return $content;
    }

    $term_id = absint($term_id);
    $issue_type = get_term_meta($term_id, 'issue_type', true);

    if (!empty($issue_type)) {
        $content .= esc_attr($issue_types[$issue_type]);
    }

    return $content;
}, 100, 3);
