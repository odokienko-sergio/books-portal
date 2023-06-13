<?php
/*
Plugin Name: Books Portal
Description: A WordPress plugin for managing books.
Version: 1.0
Author: Serhii Odokiienko
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: books-portal
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	die;
}
// Constants
define( 'BOOKS_PORTAL_VERSION', '1.0' );
define( 'BOOKS_PORTAL_PATH', plugin_dir_path( __FILE__ ) );

// Include the class file
require BOOKS_PORTAL_PATH . 'inc/class-books-functions.php';

class books_portal {
	static function activation() {
		flush_rewrite_rules();
	}

	static function deactivation() {
		flush_rewrite_rules();
	}
}

if ( class_exists( 'books_portal' ) ) {
	$books_portal = new books_portal();
}

register_activation_hook( __FILE__, array(
	$books_portal,
	'activation',
) );
register_deactivation_hook( __FILE__, array(
	$books_portal,
	'deactivation',
) );
