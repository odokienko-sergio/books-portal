<?php

class Books_Portal_Template_Loader extends Gamajo_Template_Loader {

    protected $filter_prefix = 'books-portal';

    protected $theme_template_directory = 'books-portal';

    protected $plugin_directory = BOOKS_PORTAL_PATH;

    protected $plugin_template_director = 'templates';

    public $templates;

	public function register(){
		add_filter('template_include', [$this,'books_portal_templates']);
	}

	public function books_portal_templates($template){
		if(is_post_type_archive('books')) {
			$theme_files = ['archive-books-portal.php', 'books-portal/archive-books-portal.php'];
			$exist = locate_template($theme_files, false);
			if($exist != ''){
				return $exist;
			} else {
				return plugin_dir_path(__DIR__).'templates/archive-books-portal.php';
			}
		}

		return $template;
	}
}

$Books_Portal_Template = new Books_Portal_Template_Loader();
$Books_Portal_Template->register();