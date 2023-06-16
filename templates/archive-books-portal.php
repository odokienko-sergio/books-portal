<?php
global $Books_Portal_Template;
get_header(); ?>

	<div class="wrapper archive_books-portal">
		<?php
		if ( ! empty( $_POST['submit'] ) ) {

			$args = array(
				'post_type'      => 'books',
				'posts_per_page' => - 1,
				'meta_query'     => array( 'relation' => 'AND' ),
				'tax_query'      => array( 'relation' => 'AND' ),
			);

			$books_portal = new WP_Query( $args );

			if ( $books_portal->have_posts() ) {

				// Load posts loop.
				while ( $books_portal->have_posts() ) {
					$books_portal->the_post();

					$Books_Portal_Template->get_template_part( 'partials/content' );

				}
			} else {
				echo '<p>' . esc_html__( 'No Books', 'books-portal' ) . '</p>';
			}

		} else {

			if ( have_posts() ) {

				// Load posts loop.
				while ( have_posts() ) {
					the_post();

					$Books_Portal_Template->get_template_part( 'partials/content' );

				}

				//Pagination
				posts_nav_link();


			} else {
				echo '<p>' . esc_html__( 'No Books', 'books-portal' ) . '</p>';
			}
		}
		?>
	</div>

<?php
get_footer();