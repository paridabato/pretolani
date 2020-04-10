<?php

/*
Plugin Name: 148 Tools
Plugin URI: https://148.fr
Description: Multi packages de plugins 148
Author: 148 Team
Version: 1.0.0
Author URI: https://148.fr
*/

/**
 * Autoload plugin files
 *
 * Directories structure to follow:
 * 148-tools/          → this directory
 *   Feature/
 *     src/            → all {Feature}/src/ directories are autoloaded under Tools\{Feature} namespace
 *       Folder/
 *         Class.php   → FQCN: Tools\Feature\Folder\Class
 *     views/
 *     assets/
 *     index.php       → all {Feature}/index.php are required (useful for hooks)
 */
spl_autoload_register(function ($class) {
    $parts  = explode('/', str_replace('Tools/', '', str_replace('\\', '/', $class)));
    $prefix = array_shift($parts);
    $file = sprintf('%s/%s/src/%s.php', __DIR__, $prefix, implode('/', $parts));
    if (file_exists($file)) {
        require $file;
    }
});

foreach (glob(__DIR__  . '/*/index.php') as $filename) {
    require $filename;
}
