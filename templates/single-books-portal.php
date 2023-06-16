<?php
get_header();
?>
	<div class="wrapper single_books-portal">
		<?php
		if (have_posts()) {
			// Load posts loop.
			while (have_posts()) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if (get_the_post_thumbnail(get_the_ID(), 'large')) {
						echo get_the_post_thumbnail(get_the_ID(), 'large');
					} ?>

					<h2><?php the_title(); ?></h2>
					<div class="description"><?php the_excerpt(); ?></div>

					<div class="book_info">
						<?php
						$authors = get_the_terms(get_the_ID(), 'author');

						if (!empty($authors)) {
							?>
							<span class="author"><?php esc_html_e('Author:', 'books-portal');

								foreach ($authors as $author) {
									echo " " . $author->name;
								} ?>
                        </span>
						<?php } ?>

						<?php
						// Retrieve the current value of the 'book_status' meta field
						$book_status = get_post_meta(get_the_ID(), 'book_status', true);

						if (!empty($book_status)) {
							?>
							<span class="status"><?php esc_html_e('Status:', 'books-portal');
								echo " " . esc_html($book_status); ?>
                        </span>
						<?php } ?>
					</div>
				</article>
			<?php }
		}
		?>
	</div>

<?php
get_footer();