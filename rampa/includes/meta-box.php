<?php

//
// SAVE_POST ACTIONS

add_action('save_post', array('MyMetaBoxQuoteAuthor', 'save'));
add_action('save_post', array('MyMetaBoxSchedule', 'save'));
add_action('save_post', array('MyMetaBoxSubtitle', 'save'));
add_action('save_post', array('MyMetaBoxHomePage', 'save'));

//
// MAIN CLASS

class MyMetaBox
{
	function create( $post_type )	{}
	function form( $post, $args )	{}
	function save( $post_id )		{}

	protected function _save( $post_id, $meta_box_id, $name )
	{
		$name = $meta_box_id . '_' . $name;

		delete_post_meta( $post_id, $name );

		if ( isset($_POST[$name]) && '' != $_POST[$name] )
		{
			update_post_meta( $post_id, $name, $_POST[$name] );
		}
	}
}

//
// SUBTITLE

add_action( 'add_meta_boxes', array('MyMetaBoxSubtitle', 'add_meta_boxes') );

class MyMetaBoxSubtitle extends MyMetaBox
{
	private static $id = 'subtitle';
	private static $fields = array( 'subtitle' );
	
	function add_meta_boxes()
	{
		self::create('page');
	}

	function create( $post_type )
	{
		add_meta_box(
			// id
			$post_type . '_' . self::$id,
			// title
			__( 'Subtítulo' ),
			// callback
			array( __CLASS__, 'form' ),
			// page
			$post_type,
			// context
			'normal',
			// priority
			null,
			// callback_args
			array( 'post_type' => $post_type, )
			);
	}

	function form( $post, $args )
	{
		global $wp_locale;

		// value
		$subtitle  = get_post_meta( $post->ID, self::$id . '_subtitle',  true );

		// markup
		$s = '<input type="hidden" id="%_nonce_name%" name="%_nonce_name%" value="%_nonce_value%" />'
			.'%subtitle%'
			;

		// fields
		$subtitle  = '<label for="%id%_subtitle">Subtítulo:</label> <input type="text" id="%id%_subtitle" name="%id%_subtitle" value="' . $subtitle . '" />';
		
		// replacements
		$s = str_replace( '%subtitle%',  $subtitle,  $s );

		// id, nonce
		$s = str_replace( '%id%', self::$id, $s );
		$s = str_replace( '%_nonce_name%', self::$id . '__' . 'nonce', $s );
		$s = str_replace( '%_nonce_value%', wp_create_nonce( plugin_basename( __FILE__ ) ), $s );

		echo $s;
	}

	function save( $post_id )
	{
		if ( !isset($_POST[self::$id . '__' . 'nonce']) || !wp_verify_nonce($_POST[self::$id . '__' . 'nonce'], plugin_basename(__FILE__)))
		{
			return $post_id;
		}

		// save
		foreach((array)self::$fields as $field)
		{
			self::_save( $post_id, self::$id, $field );
		}
	}
} 

//
// HOME PAGE

if (class_exists('MultiPostThumbnails')) {
	new MultiPostThumbnails(array(
		'label' => 'HomePage Image',
		'id' => 'homepage-image',
		'post_type' => 'page'
	));
}

add_action( 'add_meta_boxes', array('MyMetaBoxHomePage', 'add_meta_boxes') );

class MyMetaBoxHomePage extends MyMetaBox
{
	private static $id = 'homepage';
	private static $fields = array( 'section', 'title', 'subtitle', 'seemore' );
	
	function add_meta_boxes()
	{
		self::create('page');
	}

	function create( $post_type )
	{
		add_meta_box(
			// id
			$post_type . '_' . self::$id,
			// title
			__( 'HomePage: detalhamento da chamada' ),
			// callback
			array( __CLASS__, 'form' ),
			// page
			$post_type,
			// context
			'normal',
			// priority
			null,
			// callback_args
			array( 'post_type' => $post_type, )
			);
	}

	function form( $post, $args )
	{
		global $wp_locale;

		// read data
		$section  = get_post_meta( $post->ID, self::$id . '_section',  true );
		$title    = get_post_meta( $post->ID, self::$id . '_title',    true );
		$subtitle = get_post_meta( $post->ID, self::$id . '_subtitle', true );
		$seemore  = get_post_meta( $post->ID, self::$id . '_seemore',  true );

		// markup
		$s = '<input type="hidden" id="%_nonce_name%" name="%_nonce_name%" value="%_nonce_value%" />'
			.'%section%<br />'
			.'%title%<br />'
			.'%subtitle%<br />'
			.'%seemore%<br />'
			;

		// fields
		$section  = '<label for="%id%_section">Seção:</label> <input type="text" id="%id%_section" name="%id%_section" value="' . $section . '" />';
		$title    = '<label for="%id%_title">Título:</label> <input type="text" id="%id%_title" name="%id%_title" value="' . $title . '" />';
		$subtitle = '<label for="%id%_subtitle">Subtítulo:</label> <input type="text" id="%id%_subtitle" name="%id%_subtitle" value="' . $subtitle . '" />';
		$seemore  = '<label for="%id%_seemore">Veja mais:</label> <input type="text" id="%id%_seemore" name="%id%_seemore" value="' . $seemore . '" />';
		
		// replacements
		$s = str_replace( '%section%',  $section,  $s );
		$s = str_replace( '%title%',    $title,    $s );
		$s = str_replace( '%subtitle%', $subtitle, $s );
		$s = str_replace( '%seemore%',  $seemore,  $s );

		// id, nonce
		$s = str_replace( '%id%', self::$id, $s );
		$s = str_replace( '%_nonce_name%', self::$id . '__' . 'nonce', $s );
		$s = str_replace( '%_nonce_value%', wp_create_nonce( plugin_basename( __FILE__ ) ), $s );

		echo $s;
	}

	function save( $post_id )
	{
		if ( !isset($_POST[self::$id . '__' . 'nonce']) || !wp_verify_nonce($_POST[self::$id . '__' . 'nonce'], plugin_basename(__FILE__)))
		{
			return $post_id;
		}

		// save
		foreach((array)self::$fields as $field)
		{
			self::_save( $post_id, self::$id, $field );
		}
	}
}

//
// QUOTE AUTHOR

class MyMetaBoxQuoteAuthor extends MyMetaBox
{
	private static $id = 'author';
	private static $fields = array( 'profession' );

	function create( $post_type )
	{
		add_meta_box(
			// id
			$post_type . '_' . self::$id,
			// title
			__( 'Descrição do Autor' ),
			// callback
			array( __CLASS__, 'form' ),
			// page
			$post_type,
			// context
			'normal',
			// priority
			null,
			// callback_args
			array( 'post_type' => $post_type, )
			);
	}

	function form( $post, $args )
	{
		global $wp_locale;

		// read data
		$profession = get_post_meta( $post->ID, self::$id . '_profession', true );

		// markup
		$s = '<input type="hidden" id="%_nonce_name%" name="%_nonce_name%" value="%_nonce_value%" />'
			.'%profession%<br />'
			;

		// field: profession
		$profession = '<label for="%id%_profession">Profissão:</label> <input type="text" id="%id%_profession" name="%id%_profession" value="' . $profession . '" />';
		$s = str_replace( '%profession%', $profession, $s );

		// id, nonce
		$s = str_replace( '%id%', self::$id, $s );
		$s = str_replace( '%_nonce_name%', self::$id . '__' . 'nonce', $s );
		$s = str_replace( '%_nonce_value%', wp_create_nonce( plugin_basename( __FILE__ ) ), $s );

		echo $s;
	}

	function save( $post_id )
	{
		if ( !isset($_POST[self::$id . '__' . 'nonce']) || !wp_verify_nonce($_POST[self::$id . '__' . 'nonce'], plugin_basename(__FILE__)))
		{
			return $post_id;
		}

		// save
		foreach((array)self::$fields as $field)
		{
			self::_save( $post_id, self::$id, $field );
		}
	}
}

//
// SCHEDULE

class MyMetaBoxSchedule extends MyMetaBox
{
	private static $id = 'schedule';
	private static $fields = array( 'day', 'month', 'year', 'link' );

	function create( $post_type )
	{
		add_meta_box(
			// id
			$post_type . '_' . self::$id,
			// title
			__( 'Agenda de Eventos' ),
			// callback
			array( __CLASS__, 'form' ),
			// page
			$post_type,
			// context
			'normal',
			// priority
			null,
			// callback_args
			array( 'post_type' => $post_type, )
			);
	}

	function form( $post, $args )
	{
		global $wp_locale;

		// read data
		$day	= get_post_meta( $post->ID, self::$id . '_day', true );
		$month	= get_post_meta( $post->ID, self::$id . '_month', true );
		$year	= get_post_meta( $post->ID, self::$id . '_year', true );
		$link	= get_post_meta( $post->ID, self::$id . '_link', true );

		// markup
		$s = '<input type="hidden" id="%_nonce_name%" name="%_nonce_name%" value="%_nonce_value%" />'
			.'%day%<br />'
			.'%month%<br />'
			.'%year%<br />'
			.'%link%'
			;

		// field: profession
		$day	= '<label for="%id%_day">Dia:</label> <input type="text" id="%id%_day" name="%id%_day" value="' . $day . '" /> (número)';
		$month	= '<label for="%id%_month">Mês:</label> <input type="text" id="%id%_month" name="%id%_month" value="' . $month . '" /> (número)';
		$year	= '<label for="%id%_year">Ano:</label> <input type="text" id="%id%_year" name="%id%_year" value="' . $year . '" /> (número)';
		$link	= '<label for="%id%_link">Link:</label> <input type="text" id="%id%_link" name="%id%_link" value="' . $link . '" />';
		$s = str_replace( '%day%', $day, $s );
		$s = str_replace( '%month%', $month, $s );
		$s = str_replace( '%year%', $year, $s );
		$s = str_replace( '%link%', $link, $s );

		// id, nonce
		$s = str_replace( '%id%', self::$id, $s );
		$s = str_replace( '%_nonce_name%', self::$id . '__' . 'nonce', $s );
		$s = str_replace( '%_nonce_value%', wp_create_nonce( plugin_basename( __FILE__ ) ), $s );

		echo $s;
	}

	function save( $post_id )
	{
		if ( !isset($_POST[self::$id . '__' . 'nonce']) || !wp_verify_nonce($_POST[self::$id . '__' . 'nonce'], plugin_basename(__FILE__)))
		{
			return $post_id;
		}

		// save
		foreach((array)self::$fields as $field)
		{
			self::_save( $post_id, self::$id, $field );
		}
	}
}