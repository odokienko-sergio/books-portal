<?php
if ( ! class_exists( 'Books_Functions' ) ) {
	class Books_Functions {
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

		public function add_book_status_meta_box() {
			add_meta_box(
				'book-status-meta-box',
				esc_html__( 'Book Status', 'books-portal' ),
				[
					$this,
					'render_book_status_meta_box',
				],
				'books',
				'side',
				'default'
			);
		}

		public function render_book_status_meta_box( $post ) {
			// Create nonce field
			wp_nonce_field( 'book_status_nonce', 'book_status_nonce_field' );

			// Retrieve the current value of the 'status' meta field
			$status = get_post_meta( $post->ID, 'book_status', true );

			// Set the default value if no value exists
			if ( empty( $status ) ) {
				$status = 'unread';
			}

			// Display the meta box content
			?>
			<label for="book-status"><?php esc_html_e( 'Status:', 'books-portal' ); ?></label>
			<select name="book_status" id="book-status">
				<option
					value="unread" <?php selected( $status, 'unread' ); ?>><?php esc_html_e( 'Unread', 'books-portal' ); ?></option>
				<option
					value="read" <?php selected( $status, 'read' ); ?>><?php esc_html_e( 'Read', 'books-portal' ); ?></option>
			</select>
			<?php
		}

		public function save_book_status_meta_box( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			if ( array_key_exists( 'book_status', $_POST ) ) {
				update_post_meta( $post_id, 'book_status', sanitize_text_field( $_POST['book_status'] ) );
			}

			$post_type = get_post_type( $post_id );
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}

			// Verify nonce
			if ( ! isset( $_POST['book_status_nonce_field'] ) || ! wp_verify_nonce( $_POST['book_status_nonce_field'], 'book_status_nonce' ) ) {
				return $post_id;
			}

			if ( isset( $_POST['book_status'] ) ) {
				if ( is_null( $_POST['book_status'] ) ) {
					// Null value, delete the meta field
					delete_post_meta( $post_id, 'book_status' );
				} else {
					$book_status = sanitize_text_field( $_POST['book_status'] );

					// Additional validation checks
					if ( ! in_array( $book_status, array(
						'unread',
						'read',
					) ) ) {
						// Invalid value, delete the meta field
						delete_post_meta( $post_id, 'book_status' );
					} else {
						// Valid value, update the meta field
						update_post_meta( $post_id, 'book_status', $book_status );
					}
				}
			} else {
				// Book status not set, delete the meta field
				delete_post_meta( $post_id, 'book_status' );
			}
		}
	}
}
if ( class_exists( 'Books_Functions' ) ) {
	$Books_Functions = new Books_Functions();
	$Books_Functions->register();
}
