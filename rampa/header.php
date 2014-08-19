<?php

// theme url path
$theme_directory = parse_url(get_bloginfo( 'stylesheet_directory' ));
$theme_directory = $theme_directory['path'];

if ( is_home() ):
	wp_enqueue_script( 'jquery-slides' );
endif;

wp_enqueue_style( 'jquery-fancybox' );
wp_enqueue_script( 'jquery-fancybox' );
wp_enqueue_style( 'jquery-nivo' );
wp_enqueue_script( 'jquery-nivo' );

?><!doctype html>
<!--[if lt IE 7 ]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title><?php bloginfo( 'name' ); wp_title( '-', true, 'left' ); ?></title>
<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="<?php echo $theme_directory; ?>/media/base.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $theme_directory; ?>/media/style.css?<?php echo date("YmdHis", filemtime(dirname(__FILE__) . "/media/style.css")); ?>" type="text/css" media="screen" />
<!--[if IE ]>
<link rel="stylesheet" href="<?php echo $theme_directory; ?>/media/fix-ie.css" type="text/css" media="screen" />
<![endif]-->

<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<meta name="author" content="<?php bloginfo( 'name' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<link rel="profile" href="http://microformats.org/profile/hcard">

<!--[if lte IE 6]>
<script src="<?php echo $theme_directory; ?>/libs/ie6-warning/warning.js"></script>
<script>window.onload=function(){e("<?php echo $theme_directory; ?>/libs/ie6-warning/")}</script>
<![endif]-->
<!--[if (gt IE 6)|!(IE)]><!-->
<script src="<?php echo $theme_directory; ?>/libs/modernizr-1.7.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script>!window.jQuery && document.write(unescape('%3Cscript src="<?php echo $theme_directory; ?>/libs/jquery/jquery-1.6.1.min.js"%3E%3C/script%3E'))</script>
<!--<![endif]-->
<?php wp_head(); ?>
</head>
<?php
$body_id = '';
if ( is_page() )
{
	$body_id = 'page-' . $post->post_name;
}
?>
<body id="<?php echo $body_id; ?>" <?php body_class(); ?>>
<div id="doc" class="yui3-g">
	<header id="hd">
		<div id="hd-content">
			<div class="yui3-u-1-4">
			<section id="hd-title" class="vcard">
				<h1 class="title"><a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?>" class="url"><span class="fn org"><?php bloginfo( 'name' ); ?></span></a></h1>
				<?php if ( '' != get_bloginfo( 'description' ) ) :
				?><p class="description"><span class="note"><?php bloginfo( 'description' ); ?></span></p><?php
				endif; ?>
			</section>
			</div>

			<div class="yui3-u-3-4">
			<?php wp_nav_menu( array(
				'theme_location'	=> 'hd-menu',
				'container'			=> 'nav',
				'container_id'		=> 'hd-menu',
				'fallback_cb'		=> false,
				'link_before'		=> '<span class="menu-text">',
				'link_after'		=> '</span>',
				'depth'				=> 1,
				)); ?>
			</div>
		</div>
		<hr />
	</header>
	<div id="bd" role="main">
		<div id="bd-content">
			<div class="yui3-u-1">
