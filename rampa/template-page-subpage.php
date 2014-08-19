<?php
/*
Template Name: Página e subpáginas
*/
get_header(); ?>
			<?php if (have_posts()): the_post(); ?>
			<header class="block-title">
				<?php
				$has_parent = (bool)($post->post_parent);
				
				if ($has_parent):
					$query = new WP_Query(array(
						'p' => $post->post_parent,
						'post_type' => 'page',
						));
					if ($query->have_posts()):
						$query->the_post();
						$parent_title = get_the_title();
						$subtitle = get_post_meta(get_the_ID(), 'subtitle_subtitle', true);
					endif;
					wp_reset_postdata();
				endif;
				?>
				<h1 class="title"><?php the_title(); ?></h1>
				<?php
				$tmp_subtitle = get_post_meta(get_the_ID(), 'subtitle_subtitle', true);
				if (!empty($tmp_subtitle)):
					$subtitle = $tmp_subtitle;
				endif;
				if (!empty($subtitle)): ?>
					<div class="subtitle"><?php echo $subtitle; ?></div>
				<?php endif; ?>
			</header>
			<div class="yui3-u-1-4">
				<aside id="sb" class="aside">
					<section class="subpage-menu">
						<h2 class="title">Páginas</h2>
						<ul class="page-list"><?php wp_list_pages( array(
							'depth'        => 1,
							'show_date'    => '',
							'child_of'     => ($has_parent ? $post->post_parent : get_the_ID()),
							'exclude'      => '',
							'include'      => '',
							'title_li'     => '',
							'echo'         => 1,
							'authors'      => '',
							'sort_column'  => 'menu_order, post_title',
							'link_before'  => '',
							'link_after'   => '',
							'walker' => '' ) );
						?></ul>
					</section>
					<section class="schedule">
						<p><a href="<?php bloginfo( 'url' ); ?>/index.php/horarios-da-rampa/"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/media/images/class-schedule.png" alt="Horário das aulas" /></a></p>
						<?php if (!is_page('workshops-e-eventos-passados')): ?>
						<p><a href="<?php bloginfo( 'url' ); ?>/index.php/workshops-e-eventos-passados/"><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/media/images/class-schedule-archive.png" alt="Workshops e Eventos Passados" /></a></p>
						<?php endif; ?>
					</section>
				</aside>
			</div><div class="yui3-u-3-4">
				<article <?php post_class('entry entry-subpage'); ?>>
					<?php if (has_post_thumbnail()): ?>
					<figure>
						<?php the_post_thumbnail(); ?>
					</figure>
					<?php endif; ?>
					<?php the_content(); ?>
					<aside class="share">
						<h2>Compartilhe essa Página</h2>
						<?php include dirname(__FILE__) . '/includes/share-page.php'; ?>
					</aside>
				</article>
			</div>
			<?php else: ?>
			<?php endif; ?>
<?php get_footer(); ?>