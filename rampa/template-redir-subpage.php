<?php
/*
Template Name: Redirecionar primeira subpágina
*/

if (have_posts()):
	the_post();
	
	$query = new WP_Query(array(
		'post_type'			=> 'page',
		'post_parent'		=> get_the_ID(),
		'posts_per_page'	=> 10,
		'order'				=> 'ASC',
		'orderby'			=> 'menu_order title',
		));
	
	if ($query->have_posts()):
		while ($query->have_posts()):
			$query->the_post();
			header('Location: ' . get_permalink());
			exit();
		endwhile;
	endif;

endif;
?>