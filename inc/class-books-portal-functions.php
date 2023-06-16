<?php
if ( ! class_exists( 'Books_Portal_Functions' ) ) {
	class Books_Portal_Functions {
		public function register() {
			add_action( 'init', [
				$this,
				'custom_post_type',
			] );

			add_action( 'init', [
				$this,
				'register_taxonomy',
			] );

			// Register the meta box
			add_action( 'add_meta_boxes', [
				$this,
				'add_book_status_meta_box',
			] );

			// Save the meta box data
			add_action( 'save_post', [
				$this,
				'save_book_status_meta_box',
			] );
		}

		public function custom_post_type() {
			register_post_type( 'books',
				array(
					'public'       => true,
					'has_archive'  => true,
					'rewrite'      => array( 'slug' => 'books' ),
					'labels'       => array(
						'name'               => esc_html__( 'Books', 'books-portal' ),
						'singular_name'      => esc_html__( 'Book', 'books-portal' ),
						'menu_name'          => esc_html__( 'Books', 'books-portal' ),
						'name_admin_bar'     => esc_html__( 'Book', 'books-portal' ),
						'add_new'            => esc_html__( 'Add New', 'books-portal' ),
						'add_new_item'       => esc_html__( 'Add New Book', 'books-portal' ),
						'new_item'           => esc_html__( 'New Book', 'books-portal' ),
						'edit_item'          => esc_html__( 'Edit Book', 'books-portal' ),
						'view_item'          => esc_html__( 'View Book', 'books-portal' ),
						'all_items'          => esc_html__( 'All Books', 'books-portal' ),
						'search_items'       => esc_html__( 'Search Books', 'books-portal' ),
						'parent_item_colon'  => esc_html__( 'Parent Books:', 'books-portal' ),
						'not_found'          => esc_html__( 'No books found.', 'books-portal' ),
						'not_found_in_trash' => esc_html__( 'No books found in Trash.', 'books-portal' ),
					),
					'supports'     => array(
						'title',
						'editor',
						'thumbnail',
					),
					'show_in_menu' => true,
					'taxonomies'   => array( 'author' ),
				)
			);
		}

		public function register_taxonomy() {
			register_taxonomy( 'author', 'books', array(
				'label'        => esc_html__( 'Author', 'books-portal' ),
				'rewrite'      => array( 'slug' => 'author' ),
				'hierarchical' => true,
			) );
		}

		// Add meta box for 'book' post type
		public function add_book_status_meta_box() {
			add_meta_box(
				'book-status',
				'Book Status',
				[$this, 'render_book_status_meta_box'],
				'books',
				'side',
				'default'
			);
		}

		// Render the meta box content
		public function render_book_status_meta_box($post) {
			// Create nonce field
			wp_nonce_field( 'book_status_nonce', 'book_status_nonce_field' );

			// Retrieve the current value of the 'book_status' meta field
			$book_status = get_post_meta($post->ID, 'book_status', true);

			// Set the default value if no value exists
			if (empty($book_status)) {
				$book_status = 'unread';
			}
			?>

			<label for="book-status"><?php esc_html_e( 'Status:', 'books-portal' ); ?></label>
			<select name="book_status" id="book-status">
				<option value="unread" <?php selected($book_status, 'unread'); ?>><?php esc_html_e( 'Unread', 'books-portal' ); ?></option>
				<option value="read" <?php selected($book_status, 'read'); ?>><?php esc_html_e( 'Read', 'books-portal' ); ?></option>
			</select>

			<?php
		}

		// Save the meta box data
		public function save_book_status_meta_box($post_id) {
			// Check if the meta box data should be saved
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}

			// Check if the current user has permission to edit the post
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}

			// Verify nonce
			if ( ! isset( $_POST['book_status_nonce_field'] ) || ! wp_verify_nonce( $_POST['book_status_nonce_field'], 'book_status_nonce' ) ) {
				return $post_id;
			}

			// Save the 'book_status' meta field
			if (isset($_POST['book_status'])) {
				update_post_meta($post_id, 'book_status', sanitize_text_field($_POST['book_status']));
			}
		}
	}
}

if ( class_exists( 'Books_Portal_Functions' ) ) {
	$Books_Portal_Functions = new Books_Portal_Functions();
	$Books_Portal_Functions->register();
}
