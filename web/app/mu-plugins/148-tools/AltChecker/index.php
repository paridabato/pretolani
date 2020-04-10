<?php 

function image_alt_checker_menu()
{
    add_submenu_page('tools.php', 'Image Alt Checker', 'Image Alt Checker', 'manage_options', '148-tools', 'render_page');
}
add_action('admin_menu', 'image_alt_checker_menu');

function render_page()
{
    $attachments = new WP_Query(array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => - 1,
    ));

    
    $images = [];
    foreach ($attachments->posts as $image) {
        if (empty(get_metadata('post', $image->ID, '_wp_attachment_image_alt', true))) {
            $images[] = $image->ID;
        }
    }

    echo '<h1>'. __('List of image without alt', '148-tools') .'</h1>';

    if (empty($images)) {
        echo '<p>'. __('No Result', '148-tools') .'</p>';
    } else {
        echo '<p>'. sprintf(_n(
            '%s image found',
            '%s images found',
            count($images),
            'my-plugin'
        ), count($images)).'</p>';
        echo '<div style="display:flex;flex-wrap:wrap;">';

        foreach ($images as $id) {
            echo sprintf('<a style="margin:5px;width:100px;height:100px;display:flex;align-items:center;justify-content:center" href="%s"target="_blank" title="Edit image">%s</a>', get_edit_post_link($id), wp_get_attachment_image($id, [100,100]));
        }

        echo '</div>';
    }
}
