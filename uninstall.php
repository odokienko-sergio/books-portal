<?php
$books = get_posts( array(
	'post_type'   => 'books',
	'numberposts' => - 1,
) );
foreach ( $books as $book ) {
	wp_delete_post( $book->ID, true );
}