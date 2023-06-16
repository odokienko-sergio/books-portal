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
		// Get the book status meta value
		$book_status = get_post_meta(get_the_ID(), 'book_status', true);

		if (!empty($book_status)) {
			?>
			<span class="status"><?php esc_html_e('Status:', 'books-portal');
				echo " " . esc_html($book_status);
				?>
            </span>
		<?php } ?>
	</div>
	<a href="<?php the_permalink(); ?>">Open This Book</a><br>
</article>