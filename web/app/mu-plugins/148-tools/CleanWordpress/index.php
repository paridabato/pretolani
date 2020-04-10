<?php

/**
 * Remove useless menu & submenu page
 */
function clean_wp_menu()
{
    remove_menu_page('edit-comments.php');
    remove_submenu_page('tools.php', 'edit.php?post_type=acfe-dpt');
    remove_submenu_page('tools.php', 'edit.php?post_type=acfe-dt');
}
add_action('admin_menu', 'clean_wp_menu', 999);
