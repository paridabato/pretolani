<?php

function hide_updates()
{
    global $wp_version;
    return (object) array(
        'last_checked'=> time(),
        'version_checked'=> $wp_version
    );
}

$options = get_option('hide_updates');
if ($options) {
    if (isset($options['core'])) {
        add_filter('pre_site_transient_update_core', 'hide_updates');
    }
    if (isset($options['plugins'])) {
        add_filter('pre_site_transient_update_plugins', 'hide_updates');
    }
    if (isset($options['themes'])) {
        add_filter('pre_site_transient_update_themes', 'hide_updates');
    }
}

function hide_updates_admin_init()
{
    register_setting('hide_updates', 'hide_updates');
}

function hide_updates_admin_menu()
{
    add_options_page(
        'Hide Updates',
        'Hide Updates',
        'manage_options',
        'hide-updates',
        'hide_updates_admin_page'
    );
}

add_action('admin_init', 'hide_updates_admin_init');
add_action('admin_menu', 'hide_updates_admin_menu');

function hide_updates_admin_page()
{
    if (!isset($_REQUEST['updated'])) {
        $_REQUEST['updated'] = false;
    }
    
    global $color_scheme;
    ?>
    <div>
    <form method="post" action="options.php">
    <h2>Hide Updates Settings</h2>
    <?php settings_fields('hide_updates'); ?>
    <?php $options = get_option('hide_updates'); ?>
    <i>Please choose what kind of update notices you don't want to see anymore:</i>
    <p>
    <label>
    <input type="checkbox" name="hide_updates[core]" <?php echo isset($options['core']) ? 'checked' : ''; ?>>
    Hide Core Updates
    </label>
    </p>
    <p>
    <label>
    <input type="checkbox" name="hide_updates[plugins]" <?php echo isset($options['plugins']) ? 'checked' : ''; ?>>
    Hide Plugins Updates
    </label>
    </p>
    <p>
    <label>
    <input type="checkbox" name="hide_updates[themes]" <?php echo isset($options['themes']) ? 'checked' : ''; ?>>
    Hide Themes Updates
    </label>
    </p>
    <?php submit_button(); ?>
    </form>
    </div>
    <?php
}
