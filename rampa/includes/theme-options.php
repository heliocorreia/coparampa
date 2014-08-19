<?php

// based on
// http://blog.themeforest.net/wordpress/create-an-options-page-for-your-wordpress-theme/

$mytheme_shortname = 'rampa_theme';
function mytheme_get_option($option, $echo=true, $escape_html=false) {
	global $mytheme_shortname;
	
	$value = get_option( $option );
	
	if ($escape_html)
	{
		$value = htmlentities($value, ENT_COMPAT, 'UTF-8');
	}
	
	if ($echo)
	{
		echo $value;
		return;
	}

	return $value;
}

if (is_admin())
{
$mytheme_themename = 'Rampa';
$mytheme_options = array (
	// You can set $mytheme_themename and $mytheme_shortname to whatever you like. The last line starts an array for all our options to go in.
	array(
		'name' => 'Optional Content',
		'type' => 'title',
		),
	array( 'type' => 'open' ),
	array(
		'id' => $mytheme_shortname.'_footer_message',
		'std' => '',
		'type' => 'textarea',
		'name' => 'Footer',
		'desc' => 'Text to display as footer content.',
		),
	// array(
		// 'name' => 'Title',
		// 'desc' => 'Enter a title to display for your welcome message.',
		// 'id' => $mytheme_shortname.'_welcome_title',
		// 'std' => '',
		// 'type' => 'text',
		// ),
	// array(
		// 'name' => 'Disable Welcome Message?',
		// 'desc' => 'Check this box if you would like to DISABLE the welcome message.',
		// 'id' => $mytheme_shortname.'_welcome_disable',
		// 'type' => 'checkbox',
		// 'std' => 'false',
		// ),
	array( 'type' => 'close' )
);

function mytheme_add_admin() {
	global $mytheme_themename, $mytheme_shortname, $mytheme_options;
	if ( isset($_GET['page']) && $_GET['page'] == basename(__FILE__) ) {
		if ( isset($_REQUEST['action']) && 'save' == $_REQUEST['action'] ) {
			$_REQUEST = array_map( 'stripslashes_deep', $_REQUEST );
			foreach ($mytheme_options as $value) {
				if ( isset($value['id']) && isset($_REQUEST[ $value['id'] ]) ) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ] );
				}
			}
			// foreach ($mytheme_options as $value) {
				// if ( isset($value['id']) && isset( $_REQUEST[ $value['id'] ] ) ) {
					// update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
				// } else {
					// delete_option( $value['id'] );
				// }
			// }
			header("Location: themes.php?page=" . basename(__FILE__) . "&saved=true");
			die;
		} else if ( isset($_REQUEST['action']) && 'reset' == $_REQUEST['action'] ) {
			foreach ($mytheme_options as $value) {
			delete_option( $value['id'] ); }
			header("Location: themes.php?page=" . basename(__FILE__) . "&reset=true");
			die;
		}
	}
	add_theme_page($mytheme_themename." Options", "".$mytheme_themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {
    global $mytheme_themename, $mytheme_shortname, $mytheme_options;
    if ( isset($_REQUEST['saved']) && $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p>'.$mytheme_themename.' settings saved.</p></div>';
    if ( isset($_REQUEST['reset']) && $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p>'.$mytheme_themename.' settings reset.</p></div>';
?>
<div class="wrap">
	<h2><?php echo $mytheme_themename; ?> settings</h2>
	<form method="post">
		<?php foreach ($mytheme_options as $value) {
		// Next is the code which tells WordPress how to display the ‘type’ of option used (title, open, close, text, textarea, checkbox etc.)
		switch ( $value['type'] ) {
		case "open": ?>
		<table class="form-table">
		<tbody>
		<?php break; case "close": ?>
		</tbody>
		</table>
		<?php break; case "title": ?>
		<h3><?php echo $value['name']; ?></h3>
		<?php
		break;
		case 'text':
		?>
		<tr valign="top">
		    <th scope="row"><?php echo $value['name']; ?></th>
		    <td>
		    	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != '') { mytheme_get_option( $value['id'], true, true ); } else { echo $value['std']; } ?>" />
		    	<br /><small><?php echo $value['desc']; ?></small>
		    </td>
		</tr>
		<?php
		break;
		case 'textarea':
		?>
		<tr valign="top">
		    <th scope="row"><?php echo $value['name']; ?></td>
		    <td>
		    	<textarea cols="50" rows="8" name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>"><?php if ( get_option( $value['id'] ) != '') { mytheme_get_option( $value['id'], true, true ); } elseif (isset($value['std'])) { echo $value['std']; } ?></textarea>
		    	<br /><small><?php echo $value['desc']; ?></small>
		    </td>
		</tr>
		<?php
		break;
		case 'select':
		?>
		<tr valign="top">
		    <th scope="row"><strong><?php echo $value['name']; ?></th>
		    <td>
		    	<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select>
		    	<br /><small><?php echo $value['desc']; ?></small>
	    	</td>
		</tr>
		<?php
		break;
		case "checkbox":
		?>
	    <tr valign="top">
	    	<th scope="row"><strong><?php echo $value['name']; ?></strong></th>
	        <td width="80%"><? if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
				<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
				<br /><small><?php echo $value['desc']; ?></small>
            </td>
	    </tr>
		<?php
		break;
	} // switch
	} // foreach
?>
		<p class="submit">
			<input name="save" type="submit" value="Save changes" class="button-primary" />
			<input type="hidden" name="action" value="save" />
		</p>
	</form>
	<form method="post">
		<p class="submit">
			<input name="reset" type="submit" value="Reset" />
			<input type="hidden" name="action" value="reset" />
		</p>
	</form>
</div>
<?php
}

add_action('admin_menu', 'mytheme_add_admin');
}