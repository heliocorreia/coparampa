<?php
// theme url path
$theme_directory = parse_url(get_bloginfo( 'stylesheet_directory' ));
$theme_directory = $theme_directory['path'];

get_header();
?>
				<?php
				// TODO: have to have a post thumbnail
				$query = new WP_Query(array(
					'post_type'			=> 'slides',
					'posts_per_page'	=> -1,
					'order'				=> 'asc',
					'orderby'			=> 'menu_order',
					));
				if ($query->have_posts()): ?>
				<section id="home-slides" class="slot-wrap">
					<div class="slide-logo"><img src="<?php echo $theme_directory; ?>/media/images/slide-logo-rampa.png" /></div>
					<div class="slides">
					<?php
					while ($query->have_posts()):
						$query->the_post();
						//$title = get_the_title();
						//
						//if ($post_thumbnail = get_posts(array(
						//	'p' => get_post_thumbnail_id( get_the_ID() ),
						//	'post_type' => 'attachment',
						//	))):
						//	$post_thumbnail = reset($post_thumbnail);
						//	if (!empty($post_thumbnail->post_excerpt))
						//		$title = $post_thumbnail->post_excerpt;
						//endif;
						?>
						<div>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
						</div>
					<?php endwhile; ?>
					</div>
				</section>
				<style>
					#home-slides .slide-logo {
						bottom: 0;
						position: absolute;
						text-align: center;
						top: 0;
						width: 100%;
						z-index: 100;
						}
					#home-slides .slide-logo img { visibility: hidden; }
					#home-slides .nivo-caption,
					#home-slides .nivo-directionNav { display: none; }
				</style>
				<script type="text/javascript">
				//<![CDATA[
				if ( window.jQuery ) { jQuery(document).ready(function($){
					var oSliderWrapper = $('#home-slides')
					var oSlider = $('.slides', oSliderWrapper),
						mySliderVars = false;

					oSlider.nivoSlider({
						effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
						animSpeed: 1500, // Slide transition speed
						pauseTime: 5000, // How long each slide will show
						directionNavHide: false, // Only show on hover
						prevText: 'Prev', // Prev directionNav text
						nextText: 'Next', // Next directionNav text
						controlNav: false, // 1,2,3... navigation
						keyboardNav: false, // Use left & right arrows
						captionOpacity: 1,
						afterLoad: function(){
							mySliderVars = oSlider.data('nivo:vars');
							oSlider.data('nivo:vars', false);
							} // Triggers when slider has loaded
						});

					// start logo anim when logo and first slide images are loaded
					var imagesToLoad = $('.slide-logo img, .slides a:first img', oSliderWrapper),
						imagesLoaded = 0,
						logoAnimSpeed = 4000;
					imagesToLoad.load(function(){
						imagesLoaded++;
						if (imagesLoaded == imagesToLoad.length) {
							var logoAnimImg = $('.slide-logo img', oSliderWrapper),
								slideHiddenElements = $('.nivo-caption, .nivo-directionNav', oSliderWrapper);
							slideHiddenElements.hide();
							logoAnimImg
								.css('margin-top', ($(logoAnimImg).parent().height() - $(logoAnimImg).outerHeight()) / 2)
								.css('display', 'none')
								.css('visibility', 'visible')
								.fadeIn(logoAnimSpeed, function(){
									$(this).fadeOut(logoAnimSpeed, function(){
										slideHiddenElements.fadeIn(logoAnimSpeed/2);
										oSlider.data('nivo:vars', mySliderVars);
										$('#home-slides .slide-logo').remove();
										});
									});
						}
						});
				}); }
				//]]>
				</script>
				<?php endif; ?>

				<?php
				$query = new WP_Query(array(
					'post_type' => 'quote',
					'posts_per_page' => 1,
					'orderby' => 'rand',
					));
				if ($query->have_posts()): ?>
				<section id="home-quotes" class="slot-wrap">
					<?php
					while($query->have_posts()):
						$query->the_post();
						$author = get_the_title();
						$profession = get_post_meta(get_the_ID(), 'author_profession', true)
					?>
						<blockquote>
							<div class="content">
								<?php the_content(); ?>
								<?php if (!empty($author)): ?>
								-
								<cite><span class="author"><?php echo $author; ?></span><?php if (!empty($profession)): ?>,
								<span class="profession"><?php echo $profession; ?></span><?php endif; ?></cite>
								<?php endif; ?>
							</div>
						</blockquote>
					<?php endwhile; ?>
				</section>
				<?php endif; ?>

				<?php
				$query = new WP_Query(array(
					'post_type' => 'page',
					'posts_per_page' => 1,
					'tax_query' => array(
						array(
							'taxonomy' => 'slots_home',
							'field' => 'slug',
							'terms' => 'bloco-a',
							),
						),
					));
				if ($query->have_posts()): ?>
				<section id="home-slot-a" class="slot-wrap">
					<?php
					while($query->have_posts()):
						$query->the_post();
						// section
						$section = get_post_meta(get_the_ID(), 'homepage_section', true);
						// title
						$title = get_post_meta(get_the_ID(), 'homepage_title', true);
						if (empty($title))
							$title = get_the_title();
						// subtitle
						$subtitle = get_post_meta(get_the_ID(), 'homepage_subtitle', true);
						if (empty($subtitle))
							$subtitle = get_the_excerpt();
						// seemore
						$seemore = get_post_meta(get_the_ID(), 'homepage_seemore', true);
						if (empty($seemore))
							$seemore = 'Saiba mais';
					?>
					<div class="yui3-u-1-3">
						<div class="slot-entry">
							<?php if (!empty($section)): ?>
							<p class="section"><?php echo $section; ?></p>
							<?php endif; ?>
							<h1 class="title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h1>
							<p class="subtitle"><a href="<?php the_permalink(); ?>"><?php echo $subtitle; ?></a></p>
							<p class="seemore"><a href="<?php the_permalink(); ?>"><?php echo $seemore; ?></a></p>
							<div class="aux"></div>
						</div>
					</div><div class="yui3-u-2-3">
						<?php if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail('page', 'homepage-image')) : ?>
       					<figure>
       						<?php MultiPostThumbnails::the_post_thumbnail('page', 'homepage-image'); ?>
       					</figure>
        				<?php endif; ?>
					</div>
					<?php endwhile; ?>
				</section>
				<?php endif; ?>

				<?php
				$query_b1 = new WP_Query(array(
					'post_type' => 'page',
					'posts_per_page' => 1,
					'tax_query' => array(
						array(
							'taxonomy' => 'slots_home',
							'field' => 'slug',
							'terms' => 'b1',
							),
						),
					));
				$query_b2 = new WP_Query(array(
					'post_type' => 'page',
					'posts_per_page' => 1,
					'tax_query' => array(
						array(
							'taxonomy' => 'slots_home',
							'field' => 'slug',
							'terms' => 'b2',
							),
						),
					));
				if ($query_b1->have_posts() || $query_b2->have_posts()): ?>
				<section id="home-slot-b" class="slot-wrap">
					<div class="yui3-u-2-3">
						<div id="home-slot-b1">
						<?php
						while($query_b1->have_posts()):
							$query_b1->the_post();
							// section
							$section = get_post_meta(get_the_ID(), 'homepage_section', true);
							// title
							$title = get_post_meta(get_the_ID(), 'homepage_title', true);
							if (empty($title))
								$title = get_the_title();
							// subtitle
							$subtitle = get_post_meta(get_the_ID(), 'homepage_subtitle', true);
							if (empty($subtitle))
								$subtitle = get_the_excerpt();
							// seemore
							$seemore = get_post_meta(get_the_ID(), 'homepage_seemore', true);
							if (empty($seemore))
								$seemore = 'Saiba mais';
						?>
						<div class="yui3-u-1-2">
						<?php if (class_exists('MultiPostThumbnails') && MultiPostThumbnails::has_post_thumbnail('page', 'homepage-image')) : ?>
       					<figure>
       						<?php MultiPostThumbnails::the_post_thumbnail('page', 'homepage-image'); ?>
       					</figure>
       					<?php endif; ?>
						</div><div class="yui3-u-1-2">
							<div class="slot-entry">
								<?php if (!empty($section)): ?>
								<p class="section"><?php echo $section; ?></p>
								<?php endif; ?>
								<h1 class="title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h1>
								<p class="subtitle"><a href="<?php the_permalink(); ?>"><?php echo $subtitle; ?></a></p>
								<p class="seemore"><a href="<?php the_permalink(); ?>"><?php echo $seemore; ?></a></p>
								<div class="aux"></div>
							</div>
						</div>
						<?php endwhile; ?>
						</div>
					</div><div class="yui3-u-1-3">
						<div id="home-slot-b2">
						<?php
						while($query_b2->have_posts()):
							$query_b2->the_post();
							// section
							$section = get_post_meta(get_the_ID(), 'homepage_section', true);
							// title
							$title = get_post_meta(get_the_ID(), 'homepage_title', true);
							if (empty($title))
								$title = get_the_title();
							// subtitle
							$subtitle = get_post_meta(get_the_ID(), 'homepage_subtitle', true);
							if (empty($subtitle))
								$subtitle = get_the_excerpt();
							// seemore
							$seemore = get_post_meta(get_the_ID(), 'homepage_seemore', true);
							if (empty($seemore))
								$seemore = 'Saiba mais';
						?>
							<div class="slot-entry">
								<?php if (!empty($section)): ?>
								<p class="section"><?php echo $section; ?></p>
								<?php endif; ?>
								<h1 class="title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h1>
								<p class="subtitle"><a href="<?php the_permalink(); ?>"><?php echo $subtitle; ?></a></p>
								<p class="seemore"><a href="<?php the_permalink(); ?>"><?php echo $seemore; ?></a></p>
							</div>
						<?php endwhile; ?>
						</div>
					</div>
				</section>
				<?php endif; ?>
				<section id="home-schedule">
					<?php
					$count = 4;
					$finished = false;

					$query = new WP_Query(array(
						'post_type' => 'schedule',
						'posts_per_page' => $count,
						'order' => 'desc',
						'orderby' => 'modified',
						));

					$list = array();
					$months = array( 1 => 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez' );

					while($query->have_posts()):
						$query->the_post();
						// get
						$day   = (int)get_post_meta(get_the_ID(), 'schedule_day', true);
						$month = (int)get_post_meta(get_the_ID(), 'schedule_month', true);
						$year  = get_post_meta(get_the_ID(), 'schedule_year', true);
						$link  = get_post_meta(get_the_ID(), 'schedule_link', true);
						// format
						$list[$year][$month][$day] = array(
							'title' => get_the_title(),
							'link' => $link
							);
					endwhile;

					krsort($list, SORT_NUMERIC);

					foreach($list as $year => $m):
						foreach($m as $month => $d):
							foreach($d as $day => $entry):
					?><div class="yui3-u-1-4">
						<div class="entry">
							<?php
							// format
							$title = $list[$year][$month][$day]['title'];
							if (isset($list[$year][$month][$day]['link']))
								$link  = $list[$year][$month][$day]['link'];
							$day = str_pad($day, 2, '0', STR_PAD_LEFT);
							?>
							<p class="date">
								<span class="day"><?php echo $day; ?></span>
								<span class="month"><?php echo $months[$month]; ?></span>
								<span class="year"><?php echo $year; ?></span>
							</p>
							<p class="title-block">
								<?php if ('' != $link): ?><a href="<?php echo htmlentities($link); ?>" class="title"><?php echo $title; ?></a><?php
								else: ?><span class="title"><?php echo $title; ?></span><?php endif; ?>
							</p>
						</div>
					</div><?php
							endforeach;
						endforeach;
					endforeach;
					?>
					</div>
				</section>
				<script>
					if ( window.jQuery) {
						// http://codesnipp.it/code/441
						jQuery.fn.equalHeights = function() {
							return this.height(Math.max.apply(null,
								this.map(function() {
									return jQuery(this).outerHeight();
								}).get()
							));
						}
						jQuery(document).ready(function($){
							$('#home-schedule .entry').equalHeights();
						});
						jQuery(window).load(function(e){
							$('#home-slot-b, #home-slot-b1, #home-slot-b2').equalHeights();
						});
					}
				</script>
<?php get_footer(); ?>