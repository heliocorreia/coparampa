<?php

//
// QUOTE

if (!function_exists( 'my_post_type_quote')) :
add_action('init', 'my_post_type_quote');
function my_post_type_quote()
{
	$post_type = 'quote';

	register_post_type( $post_type, array(
		'labels' => array(
		    'name' => __('Frases'),
		    'singular_name' => __('Frase'),
		    'add_new' => __('Adicionar Nova'),
		    'add_new_item' => __('Adicionar Nova Frase'),
		    'edit_item' => __('Editar Frase'),
		    'new_item' => __('Nova Frase'),
		    'view_item' => __('Ver Frase'),
		    'search_items' => __('Perquisar por Frases'),
		    'not_found' =>  __('Nenhum registro encontrado'),
		    'not_found_in_trash' => __('Nenhum registro encontrado no Lixo'),
		    'parent_item_colon' => '',
		    'menu_name' => 'Frases',
			),
		'public'				=> true,
		'menu_position' 		=> 5,
		'hierarchical' 			=> false,
		'supports' 				=> array( 'title', 'editor', 'page-attributes' ),
		'register_meta_box_cb'	=> 'my_post_type_quote_metaboxes',
		'has_archive'			=> false,
	) );
}
function my_post_type_quote_metaboxes()
{
	$post_type = 'quote';

	MyMetaBoxQuoteAuthor::create($post_type);
}
endif;

//
// SLIDES

if (!function_exists( 'my_post_type_slides')) :
add_action('init', 'my_post_type_slides');
function my_post_type_slides()
{
	$post_type = 'slides';

	register_post_type( $post_type, array(
		'labels' => array(
		    'name' => __('Slides'),
		    'singular_name' => __('Slide'),
		    'add_new' => __('Adicionar Novo'),
		    'add_new_item' => __('Adicionar Novo Slide'),
		    'edit_item' => __('Editar Slide'),
		    'new_item' => __('Nova Slide'),
		    'view_item' => __('Ver Slide'),
		    'search_items' => __('Perquisar por Slides'),
		    'not_found' =>  __('Nenhum registro encontrado'),
		    'not_found_in_trash' => __('Nenhum registro encontrado no Lixo'),
		    'parent_item_colon' => '',
		    'menu_name' => 'Slides',
			),
		'public'				=> true,
		'menu_position' 		=> 5,
		'hierarchical' 			=> false,
		'supports' 				=> array( 'title', 'thumbnail', 'page-attributes' ),
		'has_archive'			=> false,
	) );
}
endif;

//
// SCHEDULE

if (!function_exists( 'my_post_type_schedule')) :
add_action('init', 'my_post_type_schedule');
function my_post_type_schedule()
{
	$post_type = 'schedule';

	register_post_type( $post_type, array(
		'labels' => array(
		    'name' => __('Eventos'),
		    'singular_name' => __('Evento'),
		    'add_new' => __('Adicionar Novo'),
		    'add_new_item' => __('Adicionar Novo Evento'),
		    'edit_item' => __('Editar Evento'),
		    'new_item' => __('Novo Evento'),
		    'view_item' => __('Ver Evento'),
		    'search_items' => __('Perquisar por Evento'),
		    'not_found' =>  __('Nenhum registro encontrado'),
		    'not_found_in_trash' => __('Nenhum registro encontrado no Lixo'),
		    'parent_item_colon' => '',
		    'menu_name' => 'Evento',
			),
		'public'				=> true,
		'menu_position' 		=> 5,
		'hierarchical' 			=> false,
		'supports' 				=> array( 'title', 'page-attributes' ),
		'register_meta_box_cb'	=> 'my_post_type_schedule_metaboxes',
		'has_archive'			=> false,
	) );
}
function my_post_type_schedule_metaboxes()
{
	$post_type = 'schedule';

	MyMetaBoxSchedule::create($post_type);
}
endif;