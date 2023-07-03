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

// Include the class files
if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
	require BOOKS_PORTAL_PATH . 'inc/class-gamajo-template-loader.php';
}
require BOOKS_PORTAL_PATH . 'inc/class-books-portal-functions.php';
require BOOKS_PORTAL_PATH . 'inc/class-books-portal-template-loader.php';

class books_portal {
	public function get_terms_hierarchical($tax_name,$current_term){

		$taxonomy_terms = get_terms($tax_name,['hide_empty'=>'false','parent'=>0]);

		$html = '';
		if(!empty($taxonomy_terms)){
			foreach($taxonomy_terms as $term){
				if($current_term == $term->term_id){
					$html .= '<option value="'.$term->term_id.'" selected >'.$term->name.'</option>';
				} else {
					$html .= '<option value="'.$term->term_id.'" >'.$term->name.'</option>';
				}

				$child_terms = get_terms($tax_name, ['hide_empty'=>false, 'parent'=>$term->term_id]);

				if(!empty($child_terms)){
					foreach($child_terms as $child){
						if($current_term == $child->term_id){
							$html .= '<option value="'.$child->term_id.'" selected > - '.$child->name.'</option>';
						} else {
							$html .= '<option value="'.$child->term_id.'" > - '.$child->name.'</option>';
						}
					}
				}

			}
		}
		return $html;
	}

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
