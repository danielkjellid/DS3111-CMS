<?php

// Function for creating custom post type
function apt_custom_post_type() {

    // Create UI labels for the post type
    $labels = array(
        'name'                  => _x('Pricing Cards', 'pricing_cards'),
        'singular_name'         => _x('Pricing Card', 'pricing_cards'),
        'menu_name'             => __('Pricing Cards', 'pricing_cards'),
        'parent_item_colon'     => __('Pricing Cards:', 'pricing_cards'),
        'all_items'             => __('All Pricing Cards', 'pricing_cards'),
        'view_item'             => __('View Pricing Card', 'pricing_cards'),
        'add_new_item'          => __('Add New Card', 'pricing_cards'),
        'add_new'               => __('Add New', 'pricing_cards'),
        'edit_item'             => __('Edit Card', 'pricing_cards'),
        'update_item'           => __('Update Card', 'pricing_cards'),
        'search_item'           => __('Search Card', 'pricing_cards'),
        'search_items'          => __('Search Card', 'pricing_cards'),
        'not_found'             => __('Not Found', 'pricing_cards'),
        'not_found_in_trash'    => __('Not Found in Trash', 'pricing_cards'),
    );

    // Set other options for the post type
    $args = array(
        'label'                 => __('pricing_cards', 'pricing_cards'),
        'description'           => __('Cards that show different pricing options and features', 'auditgrowth'),
        'labels'                => $labels,
        // Features supportet in post editor
        'supports'              => array('title', 'revisions', 'custom-fields'),
        'taxnomoies'            => array('post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_in_admin_bar'     => true,
        'menu_position'         => 5,
        'can_export'            => true,
        'has_archive'           => false,
        'menu_icon'             => 'dashicons-media-code',
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'page',
    );

    register_post_type('pricing_cards', $args);
}

// Create taxonomy. Used as featureselect for price cards.
function apt_create_taxonomy() {
    $labels = array(
        'name'                  => _x('Features', 'pricing_cards'),
        'singular_name'         => _x('Feature', 'pricing_cards'),
        'search_items'          => __('Search Features'),
        'all_items'             => __('All Featrues'),
        'parent_item'           => __('Parent'),
        'parent_item_colon'     => __('Parent:'),
        'edit_item'             => __('Edit Feature'),
        'update_item'           => __('Update Feature'),
        'add_new_item'          => __('Add New Feature'),
        'new_item_name'         => __('New Feature Name'),
        'menu_name'             => __('Pricing Features'),
    );

    // Attaches taxonomy to the post type 'pricing_cards'.
    register_taxonomy('features', array('pricing_cards'), array(
        'hierarchical'          => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'feature'),
    ));
}

// Function for generating meta data inside metabox 
function apt_generate_meta_data() {
    // Variable to make wordpress use the data in its template files
    global $post;

    // Variables for getting post inputs
    $price = get_post_meta($post->ID, '_price', true);
    $type_of_billing = get_post_meta($post->ID, '_type_of_billing', true);
    $feature_heading = get_post_meta($post->ID, '_feature_heading', true);
    $most_popular = get_post_meta($post->ID, '_most_popular', true);
    $button_link = get_post_meta($post->ID, '_button_link', true);
    $button_text = get_post_meta($post->ID, '_button_text', true);

    // Function for creating form fields in the admin editor 
    function create_form_field($label, $name, $type, $variable) {
        $html = '<tr>';
        $html .= '  <th><label for="' . $label .'">' . $name .'</label></th>';
        $html .= '  <td>';
        $html .= '      <input name="' . $label . '" id="' . $label . '" type="' . $type . '" value="' . $variable . '"/>';
        $html .= '  </td>';
        $html .= '</tr>';

        return $html;
    }

    // HTML for the pricing card aesthetics
    $html = '<input type="hidden" name="pricing_card_data" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    $html .= '<table class="form-table">';

    // Create form fields for each post input
    $html .= create_form_field('price', 'Price', 'number', $price);
    $html .= create_form_field('type_of_billing', 'Type of Billing', 'text', $type_of_billing);
    $html .= create_form_field('feature_heading', 'Feature Heading', 'text', $feature_heading);
    $html .= create_form_field('most_popular', 'Most Popular (Yes/No)', 'text', $most_popular);
    $html .= create_form_field('button_link', 'Button Link', 'url', $button_link);
    $html .= create_form_field('button_text', 'Button Text', 'text', $button_text);

    $html .= '</table>';

    echo $html;
}

// Function for generating aestethics data inside metabox
function apt_generate_aesthetics_data() {
    global $post;

    // Variables for getting post inputs
    $title_text_color = get_post_meta($post->ID, '_title_text_color', true);
    $price_text_color = get_post_meta($post->ID, '_price_text_color', true);
    $feature_text_color = get_post_meta($post->ID, '_feature_text_color', true);
    $feature_heading_text_color = get_post_meta($post->ID, '_feature_heading_text_color', true);
    $border_color = get_post_meta($post->ID, '_border_color', true);
    $most_popular_text_color = get_post_meta($post->ID, '_most_popular_text_color', true);
    $button_text_color = get_post_meta($post->ID, '_button_text_color', true);
    $most_popular_bg_color = get_post_meta($post->ID, '_most_popular_bg_color', true);
    $button_bg_color = get_post_meta($post->ID, '_button_bg_color', true);

    // HTML for the pricing card aesthetics inputs
    $html = '<input type="hidden" name="pricing_card_aesthetics_data" value="' . wp_create_nonce(basename(__FILE__)) . '" />';
    $html .= '<table class="form-table">';

    // Create form fields for each post input
    $html .= create_form_field('title_text_color', 'Title Text Color', 'color', $title_text_color);
    $html .= create_form_field('price_text_color', 'Price Text Color', 'color', $price_text_color);
    $html .= create_form_field('feature_heading_text_color', 'Feature Heading Text Color', 'color', $feature_heading_text_color);
    $html .= create_form_field('feature_text_color', 'Feature Text Color', 'color', $feature_text_color);
    $html .= create_form_field('border_color', 'Border Color', 'color', $border_color);
    $html .= create_form_field('most_popular_text_color', 'Most Popular Text Color', 'color', $most_popular_text_color);
    $html .= create_form_field('button_text_color', 'Button Text Color', 'color', $button_text_color);
    $html .= create_form_field('most_popular_bg_color', 'Most Popular Bg Color', 'color', $most_popular_bg_color);
    $html .= create_form_field('button_bg_color', 'Button Bg Color', 'color', $button_bg_color);

    $html .= '</table>';

    echo $html;
}

// Function for adding meta boxes to the post page
function apt_add_meta_boxes() {
    // Generate meta box for meta data
    add_meta_box('pricing-card-meta-data', 'Meta Data', 'apt_generate_meta_data', 'pricing_cards', 'normal', 'high');
    // Generate meta box for aestethics data
    add_meta_box('pricing-card-aesthetics-data', 'Aesthetics Data', 'apt_generate_aesthetics_data', 'pricing_cards', 'normal', 'high');
}

// Function for saving inputs, updating the database
function apt_save_pricing_card($post_id) {
    $post_type = get_post_type($post_id);    

    // Stops save if the site is doing autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // if the post type is correct, update the post meta
    if ($post_type == 'pricing_cards')  {
        // functions for updating/saving each individual field
        update_post_meta($post_id, '_price', $_POST['price']);
        update_post_meta($post_id, '_type_of_billing', $_POST['type_of_billing']);
        update_post_meta($post_id, '_feature_heading', $_POST['feature_heading']);
        update_post_meta($post_id, '_most_popular', $_POST['most_popular']);
        update_post_meta($post_id, '_button_link', $_POST['button_link']);
        update_post_meta($post_id, '_button_text', $_POST['button_text']);

        update_post_meta($post_id, '_title_text_color', $_POST['title_text_color']);
        update_post_meta($post_id, '_price_text_color', $_POST['price_text_color']);
        update_post_meta($post_id, '_feature_text_color', $_POST['feature_text_color']);
        update_post_meta($post_id, '_feature_heading_text_color', $_POST['feature_heading_text_color']);
        update_post_meta($post_id, '_border_color', $_POST['border_color']);
        update_post_meta($post_id, '_most_popular_text_color', $_POST['most_popular_text_color']);
        update_post_meta($post_id, '_button_text_color', $_POST['button_text_color']);
        update_post_meta($post_id, '_most_popular_bg_color', $_POST['most_popular_bg_color']);
        update_post_meta($post_id, '_button_bg_color', $_POST['button_bg_color']);
    }
}

// Hooking up functions to theme setup
add_action('init', 'apt_custom_post_type', 0);
add_action('init', 'apt_create_taxonomy');
add_action('add_meta_boxes', 'apt_add_meta_boxes');
add_action('save_post', 'apt_save_pricing_card', 10, 3);