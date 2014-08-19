<?php get_header(); ?>
			<?php if (have_posts()): ?>
				<article <?php post_class('entry'); ?>>
				<?php while (have_posts()): the_post(); ?>
					<header class="block-title">
						<h1 class="title"><?php echo my_block_title(get_the_title()); ?></h1>
						<?php
						$subtitle = get_post_meta(get_the_ID(), 'subtitle_subtitle', true);
						if (!empty($subtitle)): ?>
							<div class="subtitle"><?php echo $subtitle; ?></div>
						<?php endif; ?>
					</header>
					<section class="entry-content">
						<?php the_content(); ?>
						<aside class="share">
							<h2>Compartilhe essa Página</h2>
							<?php include dirname(__FILE__) . '/includes/share-page.php'; ?>
						</aside>
					</section>
				<?php endwhile;?>
				</article>
			<?php else: ?>
			<?php endif; ?>
<?php get_footer(); ?>