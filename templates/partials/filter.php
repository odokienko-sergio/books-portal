<?php
global $books_portal;
?>
<div class="wrapper filter_form">
	<form method="post" action="<?php echo get_post_type_archive_link('books'); ?>">
		<select name="books_portal_author">
			<option value="">Select Author</option>
			<?php echo $books_portal->get_terms_hierarchical('author', $_POST['books_portal_author']); ?>
		</select>
		<select name="book-status">
			<option value="">Select Status</option>
			<option value="unread" <?php if(isset($_POST['book-status']) and $_POST['book-status'] == 'unread') { echo 'selected'; } ?>><?php esc_html_e( 'Unread', 'books-portal' ); ?></option>
			<option value="read" <?php if(isset($_POST['book-status']) and $_POST['book-status'] == 'read') { echo 'selected'; } ?>><?php esc_html_e( 'Read', 'books-portal' ); ?></option>
		</select>
		<input type="submit" name="submit" value="filter" />
	</form>

</div>