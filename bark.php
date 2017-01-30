<?php
/**
 * Plugin Name: Bark
 * Version: 0.1
 * Description: Supercharged WordPress error logging and reporting utility.
 * Author: Codivated
 * Author URI: https://www.codivated.com/
 * Text Domain: bark
 * Domain Path: languages
 * License: GPL
 *
 * @package bark
 */

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/inc/activation.php';
require_once __DIR__ . '/inc/class-bark.php';

$bark = new \Bark\Bark();
$bark->register_hooks();
