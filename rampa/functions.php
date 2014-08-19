<?php

//
// CONFIG DATA

define('CFG_MAIL', 'producao@rampa.art.br');
define('CFG_FACEBOOK_HREF', 'http://pt-br.facebook.com/people/Rampa-Lugar-de-Cria%C3%A7%C3%A3o/100000530663426');

//
// INCLUDES

include dirname(__FILE__) . '/includes/post-type.php';
include dirname(__FILE__) . '/includes/meta-box.php';
include dirname(__FILE__) . '/includes/theme-options.php';

//
// THEME SETUP

if (function_exists('add_theme_support')) :
add_action('after_setup_theme', 'my_after_setup_theme');
function my_after_setup_theme()
{
	// location
	setlocale( LC_TIME, 'pt_BR.utf-8', 'pt_BR.UTF-8', 'pt_BR.utf8' );

	// this theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// add default posts and comments RSS feed links to head
	//add_theme_support( 'automatic-feed-links' );

	// clean up wp_head
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );

	// remove curly quotes
	remove_filter( 'the_content', 'wptexturize' );
	remove_filter( 'comment_text', 'wptexturize' );

	// allow HTML in user profiles
	//remove_filter( 'pre_user_description', 'wp_filter_kses' );

	// disable filters
	//remove_filter('comment_flood_filter', 'wp_throttle_comment_flood');
}
endif;

//
// MENUS

if (function_exists( 'register_nav_menus')) :
register_nav_menus(array(
	'hd-menu' => 'Cabeçalho: menu',
	) );
endif;

//
// ACTIONS

add_action( 'init', 'my_init' );
function my_init()
{
	if ( is_admin() )
		return;

	// jquery-slides
	//wp_deregister_script( 'jquery-slides' );
	//wp_register_script(
	//	'jquery-slides',
	//	get_bloginfo( 'stylesheet_directory' ) . '/libs/jquery/slides.min.jquery.js',
	//	false,
	//	false,
	//	true
	//	);

	// nivo
	wp_deregister_script( 'jquery-nivo' );
	wp_register_script(
		'jquery-nivo',
		get_bloginfo( 'stylesheet_directory' ) . '/libs/jquery/nivo-2.7.1/jquery.nivo.slider.pack.js',
		false,
		false,
		true
		);
	wp_deregister_style( 'jquery-nivo' );
	wp_register_style(
		'jquery-nivo',
		get_bloginfo( 'stylesheet_directory' ) . '/libs/jquery/nivo-2.7.1/nivo-slider.css',
		false,
		false,
		false
		);

	// fancybox
	wp_deregister_script( 'jquery-fancybox' );
	wp_register_script(
		'jquery-fancybox',
		get_bloginfo( 'stylesheet_directory' ) . '/libs/jquery/fancybox-1.3.4/jquery.fancybox-1.3.4.pack.js',
		false,
		false,
		true
		);
	wp_deregister_style( 'jquery-fancybox' );
	wp_register_style(
		'jquery-fancybox',
		get_bloginfo( 'stylesheet_directory' ) . '/libs/jquery/fancybox-1.3.4/jquery.fancybox-1.3.4.css',
		false,
		false,
		false
		);
}

if ( !function_exists( 'my_dashboard_setup' ) ):
function my_dashboard_setup() {
	// Plugins
	//remove_meta_box( 'meandmymac_rss_widget', 'dashboard', 'normal' );

	// Main column
	//remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );

	// Side Column
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	//remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'my_dashboard_setup' );
endif;

//
// FILTERS

// gallery
add_filter('use_default_gallery_style', '__return_false');

if (!function_exists('my_nav_menu_css_class')) :
add_filter( 'nav_menu_css_class', 'my_nav_menu_css_class', 10, 2 );
function my_nav_menu_css_class($classes, $item)
{
	$classes[] = 'text-' . sanitize_title($item->title);

	return $classes;
}
endif;

if (!function_exists('my_excerpt_length')) :
add_filter('excerpt_length','my_excerpt_length');
function my_excerpt_length( $length )
{
	return 30;
}
endif;

if (!function_exists('my_body_class')) :
add_filter('body_class', 'my_body_class');
function my_body_class($classes)
{
	// page-(root/descedent)-*
	global $post;

	if ( is_page() && is_array($post->ancestors))
	{
		if (isset($post->ancestors[0]))
		{
			if ($a = get_post(end($post->ancestors)))
			{
				$classes[] = 'page-descedent-' . $a->post_name;
				unset($a);
			}
		}
		else
		{
			$classes[] = 'page-root-' . $post->post_name;
		}
	}

	// single with category
	if ( is_single() )
	{
		$cats = (array)get_the_category();
		foreach($cats as $category)
		{
			$classes[] = 'cat-' . $category->category_nicename;
		}
	}

	// add date
	$classes[] = 'dt' . date( 'ymd' );

	return $classes;
}
endif;

// gallery
if (!function_exists('my_gallery_filter')):
add_filter('post_gallery', 'my_gallery_filter');
function my_gallery_filter($attr) {
	global $post, $wp_locale;

	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'titletag'   => 'dd',
		'contenttag' => 'dd',

		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => -1,
		'link'       => 'file',
		'size'       => 'medium',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}

	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';

	$selector = "gallery-{$instance}";

	$gallery_style = $gallery_div = '';
	$size_class = sanitize_html_class( $size );
	$gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = (!isset($attr['link']) || 'file' != $attr['link']) ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
			$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_content) ) {
			$output .= "
				<{$captiontag} class='wp-caption-text gallery-caption'>
				<div class=\"image-entry\">
					<div class=\"image-title\">" . wptexturize($attachment->post_title) . "</div>
					<div class=\"image-content\">" . wpautop(wptexturize($attachment->post_content)) . "</div>
				</div>
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}

	$output .= "
		<br style='clear: both;' />
		</div>\n";

	return $output;
}
endif;

//
// CUSTOM TAXONOMIES

if (!function_exists('my_register_taxonomy')):
add_action('init', 'my_register_taxonomy', 0);
function my_register_taxonomy() {
	register_taxonomy(
	    'slots_home',
	    'page',
	    array(
	        'hierarchical' => true,
	        'label' => 'Slots Home',
	        'query_var' => true,
	        'rewrite' => false
	    )
	);
}
endif;

//
// SHORTCODES

//
// FUNCTIONS

if (!function_exists('my_block_title')):
function my_block_title($title) {
	$s = array();
	$words = explode(' ', $title);
	foreach($words as $key => $txt):
		$s[] = '<span class="txt txt-' . $key . '">' . $txt . ' </span>';
	endforeach;
	return implode('', $s);
}
endif;

if (!function_exists('my_paginate_links')):
function my_paginate_links( $comments = false )
{
	global $wp_query, $wp_rewrite;

	$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

	$pagination = array(
		'base' => @add_query_arg('page','%#%'),
		'format' => '',
		'total' => $wp_query->max_num_pages,
		'current' => $current,
		'show_all' => false,
		'prev_next' => true,
		'prev_text'=> '&lt;&lt; Anterior',
		'next_text'=> 'Próxima &gt;&gt;',
		//'end_size' => 1,
		//'mid_size' => 2,
		//'type' => 'plain',
		//'add_args' => false, // array of query args to add
		//'add_fragment' => ''
		);

	$custom_args = array(
		's',
		);

	if ( $wp_rewrite->using_permalinks() )
		$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg($custom_args,get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');

	foreach($custom_args as $key)
		if ( !empty($wp_query->query_vars[$key]) )
			$pagination['add_args'] = array($key=>get_query_var($key));

	echo paginate_links($pagination);
}
endif;

//
// AJAX HANDLERS

if ( !function_exists( 'my_ajax_frm_contact' ) ) :
add_action( 'wp_ajax_frm_contact', 'my_ajax_frm_contact' );
add_action( 'wp_ajax_nopriv_frm_contact', 'my_ajax_frm_contact' );
function my_ajax_frm_contact() {
	// init
	$response = array(
		'hasError' => false,
	);

	// clean
	$_POST = array_map('stripslashes_deep', $_POST);
	$_POST = array_map('trim', $_POST);

	$frm_nome = $_POST['frm_nome'];
	$frm_mail = $_POST['frm_mail'];
	$frm_site = $_POST['frm_site'];
	$frm_mens = $_POST['frm_mens'];

	// check required
	$required_fields = array('frm_nome', 'frm_mail', 'frm_mens');
	foreach($required_fields as $field)
	{
		if (empty($$field))
		{
			$response['hasError'] = true;
			$response['fieldName'] = $field;
			switch($field)
			{
				case 'frm_nome':
					$response['message'] = "O campo \"Nome\" precisa ser informado.";
					break;
				case 'frm_mail':
					$response['message'] = "O campo \"E-mail\" precisa ser informado.";
					break;
				case 'frm_mens':
					$response['message'] = "O campo \"Mensagem\" precisa ser informado.";
					break;
				default:
					$response['message'] = "Os campos obrigatórios devem ser preenchidos.";
			}
			break;
		}
	}

	// format message
	if (!$response['hasError'])
	{
		$message = <<<MSG
Nome: $frm_nome
E-mail: $frm_mail
Site: $frm_site

$frm_mens

--
Rampa - Lugar de Criação
www.coparampa.com.br
MSG;

		// send mail
		wp_mail(CFG_MAIL, '[Rampa] Mensagem de ' . $frm_nome, $message);
	}

	// final message
	if (!isset($response['message']))
		$response['message'] = ($response['hasError'])
			? "Desculpe, sua mensagem não pode ser enviada.\n\nParece que estamos com algum problema em nosso serviço de envio. Por favor, tente novamente mais tarde."
			: "Sua mensagem foi enviada com sucesso!\n\nAgradecemos o seu contato.";

	die(json_encode($response));
}
endif;

