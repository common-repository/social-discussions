<?php
define('LAECHONW_YOU_HAVE_NOT_ADDED_ANY_API_KEY',   __('You have not added any API Key'));
define('LAECHONW_API_KEY_ADDED',                    __('API Key has been added successfully'));
define('LAECHONW_ERROR_LOADING_API_KEYS',           __('Error occured while trying to load the API Keys. Please try again later'));
define('LAECHONW_CURRENTLY_PUBLISHING',             __('You are currently Publishing your Blog to'));
define('LAECHONW_SOCIAL_NETWORKS',                  __('Networks'));
define('LAECHONW_SOCIAL_NETWORK',                   __('Network'));
define('LAECHONW_PLUGIN_NAME',                      __('sd-nw'));
define('LAECHONW_PLUGIN_VERSION',                   '6.2.1');
define('LAECHONW_WIDGET_NAME_POST_EDITOR', 			__('Social Discussions'));
define('LAECHONW_WP_PLUGIN_URL',                  	laechonw_get_plugin_dir());
define('LAECHONW_SOCIAL_NETWORKS',                 __('Networks'));
define('LAECHONW_SOCIAL_NETWORK',                  __('Network'));

add_action('admin_notices', 'laechonw_auth_errors');

global $laechonw_ogtype_facebook;

function laechonw_set_options() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!array_key_exists('laechonw_auth_error_show', $options)) {
		$options['laechonw_auth_error_show'] = 1;
	}
	if(!array_key_exists('laechonw_mixed_mode_alert_show', $options)) {
		$options['laechonw_mixed_mode_alert_show'] = 1;
	}
	if(!array_key_exists('laechonw_enable', $options)) {
		$options['laechonw_enable'] = 1;
	}
	if (!array_key_exists('laechonw_post_types', $options)) {
		$options['laechonw_post_types'] = 'post';
	}
	if (!array_key_exists('laechonw_install_extension_alert_show', $options)) {
		$options['laechonw_install_extension_alert_show'] = 1;
	}
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
}

function laechonw_load_options() {
	global $laechonw_auth_error_show, $laechonw_mixed_mode_alert_show, $laechonw_enable, $laecho_post_types, $laechonw_install_extension_alert_show;
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(is_array($options)) {
		//Auth Error show hide
    	if(array_key_exists('laechonw_auth_error_show', $options)) {
			$laechonw_auth_error_show = $options['laechonw_auth_error_show'];
			if($laechonw_auth_error_show) {
				$laechonw_auth_error_show = 'checked';	
			} else {
				$laechonw_auth_error_show = '';
			}
		} else {
			$laechonw_auth_error_show = 'checked';
		}
		//Mixed Mode Alert
    	if(array_key_exists('laechonw_mixed_mode_alert_show', $options)) {
			$laechonw_mixed_mode_alert_show = $options['laechonw_mixed_mode_alert_show'];
			if($laechonw_mixed_mode_alert_show) {
				$laechonw_mixed_mode_alert_show = 'checked';	
			} else {
				$laechonw_mixed_mode_alert_show = '';
			}
		} else {
			$laechonw_mixed_mode_alert_show = 'checked';
		}
		//Publishing Enable/Disable
		if (array_key_exists('laechonw_enable', $options)) {
			$laechonw_enable = $options['laechonw_enable'];
			if ($laechonw_enable) {
				$laechonw_enable = 'checked';
			} else {
				$laechonw_enable = '';
			}
		} else {
			$laechonw_enable = 'checked';
		}
		//Extension install alert show
		if (array_key_exists('laechonw_install_extension_alert_show', $options)) {
			$laechonw_install_extension_alert_show = $options['laechonw_install_extension_alert_show'];
			if ($laechonw_install_extension_alert_show) {
				$laechonw_install_extension_alert_show = 'checked';
			} else {
				$laechonw_install_extension_alert_show = '';
			}
		} else {
			$laechonw_install_extension_alert_show = 'checked';
		}			
	} else {
		$laechonw_auth_error_show = 'checked';
		$laechonw_mixed_mode_alert_show = 'checked';
		$laechonw_enable = 'checked';
		$laechonw_install_extension_alert_show = 'checked';
	}
	laechonw_mixed_mode();
}

function laechonw_save_options() {
	if ( isset($_POST['laechonw_form_type']) && ($_POST['laechonw_form_type'] == 'laechonw_auth_error_show')) {
		if(array_key_exists('laechonw_auth_error_show', $_POST)) {
			$laechonw_auth_error_show = 1;	
		} else {
			$laechonw_auth_error_show = 0;
		}
		laechonw_auth_error_show($laechonw_auth_error_show);
	} elseif ( isset($_POST['laechonw_form_type']) && ($_POST['laechonw_form_type'] == 'laechonw_enable')) {
		if(array_key_exists('laechonw_enable', $_POST)) {
			$laechonw_enable = 1;	
		} else {
			$laechonw_enable = 0;
		}
		laechonw_enable($laechonw_enable);
	} elseif ( isset($_POST['laechonw_form_type']) && ($_POST['laechonw_form_type'] == 'laechonw_mixed_mode_alert_show')) {
		if(array_key_exists('laechonw_mixed_mode_alert_show', $_POST)) {
			$laechonw_mixed_mode_alert_show = 1;	
		} else {
			$laechonw_mixed_mode_alert_show = 0;
		}
		laechonw_mixed_mode_alert_show($laechonw_mixed_mode_alert_show);
	} elseif ( isset($_POST['laechonw_form_type']) && ($_POST['laechonw_form_type'] == 'laechonw_post_types')) {
		if (array_key_exists('laechonw_post_types', $_POST)) {
			$laechonw_post_types = array();
			foreach($_POST['laechonw_post_types'] as $value) {
				$laechonw_post_types[] = strip_tags($value);
			}
			$laechonw_post_types = implode(',', $_POST['laechonw_post_types']);
		}
		laechonw_post_types_update($laechonw_post_types);
	} elseif ( isset($_POST['laechonw_form_type']) && ($_POST['laechonw_form_type'] == 'laechonw_install_extension_alert_show')) {
		if(array_key_exists('laechonw_install_extension_alert_show', $_POST)) {
			$laechonw_install_extension_alert_show = 1;	
		} else {
			$laechonw_install_extension_alert_show = 0;
		}
		laechonw_install_extension_alert_show($laechonw_install_extension_alert_show);
	}
	//Show success message
	return '<div class="laecho_notice_msg_save">Option has been updated successfully</div>';
}

function laechonw_create_post_meta_box() {
	add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laechonw_post_meta_box', 'post', 'side', 'high' );
    add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laechonw_post_meta_box', 'page', 'side', 'high' );
    add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laechonw_post_meta_box', 'link', 'side', 'high' );
    if(function_exists('get_post_types')) {
        $args=array('public'   => true,
                    '_builtin' => false);
        $post_types=get_post_types($args, '');
        foreach($post_types as $key=>$val) {
            add_meta_box( 'laechonw_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laechonw_post_meta_box', $val->name, 'side', 'high' );
        }
    }
}

function laechonw_post_meta_box( $object, $box ) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$this_post_type = $object -> post_type;
	//HTML
	$html = '';
	//Extension download
	$laechonw_install_extension_alert_show = $options['laechonw_install_extension_alert_show'];
	if($laechonw_install_extension_alert_show) {
		global $is_gecko, $is_safari, $is_chrome;
		$html .= '<div style="display: none;" id="linksalpha_post_download_chrome" class="misc-pub-section laechonw_post_meta_box_first"><img src="//lh4.ggpht.com/RcHmTiAjiRPW5GSamTaet1etjiNYaeHVT2yOtEsJDEs9IRWTdt1P64zpDmh6XzAbN4HH9byl9YhgTK_NbcXq=s16" style="vertical-align: text-bottom" />&nbsp;Install <a class="linksalpha_post_download_chrome_link" target="_blank" href="https://chrome.google.com/webstore/detail/ffifmkcjncgmnnmkedgkiabklmjdmpgi">Post extension for Chrome</a>.</div>';
		$html .= '<div style="display: none;" id="linksalpha_post_download_firefox" class="misc-pub-section laechonw_post_meta_box_first"><img src="//lh5.ggpht.com/HE6TEsIgCGZgRKAZJ8SI1Yq7rGGxy5s_TQhleiphoEY2QFye1OlFRm8r_6JmGq4OUfHq07OE2dk6XeHWcYyU=s16" style="vertical-align: text-bottom" />&nbsp;Install <a class="linksalpha_post_download_firefox_link" href="http://www.linksalpha.com/downloads/app?id=980907126">Post extension for Firefox</a>.</div>';
		$html .= '<div style="display: none;" id="linksalpha_post_download_safari" class="misc-pub-section laechonw_post_meta_box_first"><img src="//lh6.ggpht.com/4FQoS1Pn8OQOlahH5ESbjJv8iuVPV2If34-fABfBWcrJLUja5wiyLgWAekHWEuk_WaZg_iU9bf4Jli07WDQrRQ=s16" style="vertical-align: text-bottom" />&nbsp;Install <a class="linksalpha_post_download_safari_link" href="http://www.linksalpha.com/downloads/app?id=980926069">Post extension for Safari</a>.</div>';
		if($is_gecko) {
			$browser = 'firefox';
		} elseif($is_chrome) {
			$browser = 'chrome';
		} elseif($is_safari) {
			$browser = 'safari';
		} else {
			$browser = '';
		}
		$html .= '<input type="hidden" name="linksalpha_browser" id="linksalpha_browser" value="'.$browser.'" autocomplete="off" />';
	}
	//Publish
	$curr_val = get_post_meta( $object->ID, '_laecho_meta_show', true );
	if($curr_val == '') {
		$curr_val = 1;
	}
    $html  .= '<div  class="misc-pub-section">';
	if($curr_val) {
		$html .= '<input type="checkbox" name="laecho_meta_cb_show"    id="laecho_meta_cb_show" checked />';
	} else {
		$html .= '<input type="checkbox" name="laecho_meta_cb_show"    id="laecho_meta_cb_show" />';
	}
	$html .= '&nbsp;<label for="laecho_meta_cb_show">Show Social Sharing Buttons</a></label>';	
	//Hidden
	$html .= '<input type="hidden" name="laecho_meta_nonce" value="'. wp_create_nonce( plugin_basename( __FILE__ ) ).'" />';
	$html .= '</div>';
	//Published
	$laechonw_meta_published = get_post_meta($object -> ID, '_laechonw_meta_published', true);
	if (in_array($laechonw_meta_published, array('done', 'failed'))) {
		$inputs_disabled = 'disabled="disabled"';
	} else {
		$inputs_disabled = '';
	}
	$curr_val_publish = get_post_meta($object -> ID, '_laechonw_meta_publish', true);
	if ($curr_val_publish == '' && $options['laechonw_enable']) {
		$curr_val_publish = 1;
	}
	$html .= '<div class="misc-pub-section">';
	$html_label = '&nbsp;<label for="laechonw_meta_cb_publish">' . __('Publish this') . ' ' . ucfirst($this_post_type) . __(' to') . ' <a href="' . LAECHO_PLUGIN_ADMIN_URL . '">' . __('configured Networks') . '</a></label>';
	$html_label_type_disabled = '&nbsp;<label for="laechonw_meta_cb_publish">' . __('Publishing of') . ' ' . ucfirst($this_post_type) . ' <a href="http://codex.wordpress.org/Post_Types" target="_blank">' . __('Post Type') . '</a>' . __(' to') . ' <a href="' . LAECHO_PLUGIN_ADMIN_URL . '">' . __('configured Networks') . '</a>' . ' ' . __('has been disabled. To Publish, check this checkbox or ') . '<a href="' . LAECHO_PLUGIN_ADMIN_URL . '#networkpub">' . __('change the setting.') . '</a></label>';
	$html_label_type_disabled_all = '&nbsp;<label for="laechonw_meta_cb_publish">' . __('Publishing of ') . '' . __('Posts ') . '</a>' . __(' to') . ' <a href="' . LAECHO_PLUGIN_ADMIN_URL . '">' . __('configured Networks') . '</a>' . ' ' . __('has been disabled. To Publish, check this checkbox or ') . '<a href="' . LAECHO_PLUGIN_ADMIN_URL . '#networkpub">' . __('change the setting.') . '</a></label>';	
	if ($curr_val_publish) {
		if (array_key_exists('laechonw_post_types', $options)) {
			if (in_array($this_post_type, explode(',', $options['laechonw_post_types']))) {
				$html .= '<input type="checkbox" name="laechonw_meta_cb_publish" id="laechonw_meta_cb_publish" checked ' . $inputs_disabled . ' />';
			} else {
				$inputs_disabled = 'disabled="disabled"';
				$html .= '<input type="checkbox" name="laechonw_meta_cb_publish" id="laechonw_meta_cb_publish" ' . $inputs_disabled . ' />';
				$html_label = $html_label_type_disabled;
			}
		} else {
			$html .= '<input type="checkbox" name="laechonw_meta_cb_publish" id="laechonw_meta_cb_publish" checked ' . $inputs_disabled . ' />';
		}
	} else {
			
		if (in_array($this_post_type, explode(',', $options['laechonw_post_types']))) {
			$html .= '<input type="checkbox" name="laechonw_meta_cb_publish" id="laechonw_meta_cb_publish" ' . $inputs_disabled . ' />';
		} else {
			$inputs_disabled = 'disabled="disabled"';
			$html .= '<input type="checkbox" name="laechonw_meta_cb_publish" id="laechonw_meta_cb_publish" ' . $inputs_disabled . ' />';
			$html_label = $html_label_type_disabled_all;
		}
	}
	if ($options['laechonw_enable'] || $curr_val_publish) {
		$html .= $html_label;	
	} else {
		$html .= $html_label_type_disabled_all;
	}
	$html .= '</div>';
	//Message
	$curr_val_message = get_post_meta($object -> ID, 'laechonw_postmessage', true);
	$html .= '<div class="misc-pub-section">';
	$html .= '<div class="laechonw_post_meta_box_label_box"><label class="laechonw_post_meta_box_label" for="laechonw_postmessage"><a target="_blank" href="http://help.linksalpha.com/wordpress-plugin-network-publisher/message">'. __('Message').'</a>'.(' to be included in the post(for Facebook & LinkedIn):') . '</label></div>';
	$html .= '<textarea ' . $inputs_disabled . 'name="laechonw_postmessage" id="laechonw_postmessage" ' . $inputs_disabled . '>' . $curr_val_message . '</textarea>';
	$html .= '</div>';
	//Twitter handle
	$curr_val_twitterhandle = get_post_meta($object -> ID, 'laechonw_twitterhandle', true);
	$html .= '<div class="misc-pub-section">';
	$html .= '<div class="laechonw_post_meta_box_label_box"><label class="laechonw_post_meta_box_label" for="laechonw_twitterhandle">@<a target="_blank" href="http://help.linksalpha.com/wordpress-plugin-network-publisher/twitter-handle">' .__('Twitter handles').'</a>'.__(' to mention in the post:') . '</label></div>';
	$html .= '<input ' . $inputs_disabled . ' name="laechonw_twitterhandle" id="laechonw_twitterhandle" value="'. $curr_val_twitterhandle .'" ' . $inputs_disabled . ' />';
	$html .= '<div class="laechonw_post_meta_box_helper">2 max, comma separated</div>';
	$html .= '</div>';
	//Twitter hash
	$curr_val_twitterhash = get_post_meta($object -> ID, 'laechonw_twitterhash', true);
	$html .= '<div class="misc-pub-section">';
	$html .= '<div class="laechonw_post_meta_box_label_box"><label class="laechonw_post_meta_box_label" for="laechonw_twitterhash"><a target="_blank" href="http://help.linksalpha.com/wordpress-plugin-network-publisher/twitter-hashtag">' . __('Twitter hashtags').'</a>'.__(' to be included in the post:') . '</label></div>';
	$html .= '<input ' . $inputs_disabled . ' name="laechonw_twitterhash" id="laechonw_twitterhash" value="'.$curr_val_twitterhash.'" ' . $inputs_disabled . ' />';
	$html .= '<div class="laechonw_post_meta_box_helper">2 max, comma separated</div>';
	$html .= '</div>';
	//Facebook Page Type
	$curr_val_ogtype_facebook = get_post_meta($object -> ID, 'laechonw_ogtype_facebook', true);
	$facebook_page_type = array('article' => __('Article'), 'blog' => __('Blog'), 'book' => __('Book'), 'profile' => __('External Profile'), 'video.movie' => __('Movie'), 'video.episode' => __('TV Episode'), 'video.tv_show' => __('TV Show'), 'video.other' => __('Video'), 'website' => __('Website'));
	$facebook_page_type_options = '';
	foreach ($facebook_page_type as $key => $val) {
		if ($curr_val_ogtype_facebook == $key) {
			$facebook_page_type_options = $facebook_page_type_options . '<option value="' . htmlentities($key) . '" selected>' . htmlentities($val) . '</option>';
		} else {
			$facebook_page_type_options = $facebook_page_type_options . '<option value="' . htmlentities($key) . '">' . htmlentities($val) . '</option>';
		}
	}
	$html .= '<div class="misc-pub-section">';
	$html .= '<label for="laechonw_ogtype_facebook">' . __('Page Type for Facebook metatags.') . '</label>';
	$html .= '<select ' . $inputs_disabled . ' name="laechonw_ogtype_facebook" id="laechonw_ogtype_facebook" ' . $inputs_disabled . '>' . $facebook_page_type_options . '</select>';
	$html .= '</div>';
	//Content
	$curr_val_content = get_post_meta($object -> ID, '_laechonw_meta_content', true);
	if ($curr_val_content == '') {
		$curr_val_content = 0;
	}
	if(in_array($laechonw_meta_published, array('failed', 'done'))) {
		$html .= '<div class="misc-pub-section">';
	} else {
		$html .= '<div class="misc-pub-section laecho_nw_post_meta_box_last">';	
	}
	if ($curr_val_content) {
	} else {
		$html .= '<input type="checkbox" name="laechonw_meta_cb_content" id="laechonw_meta_cb_content" ' . $inputs_disabled . ' />';
	}
	$html .= '&nbsp;<label for="laechonw_meta_cb_content">' . __('Use Excerpt for publishing to Networks') . '</label>';
	$html .= '</div>';
    //Content Sent successfully
    if ($laechonw_meta_published == 'failed') {
		$html .= '<div class="misc-pub-section laecho_nw_post_meta_box_last" style="color:red;"><img src="' . LAECHONW_WP_PLUGIN_URL . '/icons/alert.png" />&nbsp;' . __('Post to social networks failed.') . '</div>';
	} elseif ($laechonw_meta_published == 'done') {
		$html .= '<div class="misc-pub-section laecho_nw_post_meta_box_last" style="color:green;"><input type="checkbox" checked disabled="disabled" />&nbsp;<label for="laechonw_meta_cb_content">' . __('Data sent successfully.') . '</label></div>';
	}
	//Manually post an update
	if(in_array($laechonw_meta_published, array('failed', 'done'))) {;
		$html .= '<div class="misc-pub-section" style="border-bottom:0px;padding-bottom:0px;">';
		$html .= '<input type="button" class="button-primary" id="laechonw_post_update" value="Post an Update">';
		$post_data = laechonw_get_post_data_republish($object);
		$post_data_string = http_build_query($post_data);
		$html .= '<input type="hidden" id="laechonw_post_data" value="'.$post_data_string.'">';
		$html .= '</div>';
	}
	//Hidden
	$html .= '<input type="hidden" name="laechonw_meta_nonce" value="'. wp_create_nonce( plugin_basename( __FILE__ ) ).'" />';
	echo $html;
}

function laechonw_save_post_meta_box( $post_id, $post ) {
	if(empty($_POST['laecho_meta_nonce'])) {
		return $post_id;
	}
	if ( !wp_verify_nonce( $_POST['laecho_meta_nonce'], plugin_basename( __FILE__ ) ) ) {
		return $post_id;	
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	//Show
	if($_POST['laecho_meta_cb_show']) {
		$new_meta_value = 1;
	} else {
		$new_meta_value = 0;
	}
	update_post_meta( $post_id, '_laecho_meta_show', $new_meta_value );
	if (empty($_POST['laechonw_meta_nonce'])) {
		return $post_id;
	}
	if (!wp_verify_nonce($_POST['laechonw_meta_nonce'], plugin_basename(__FILE__))) {
		return $post_id;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}
	// Postmessage - Facebook
	$new_meta_value_postmessage = '';
	if (!empty($_POST['laechonw_postmessage'])) {
		if ($_POST['laechonw_postmessage']) {
			$new_meta_value_postmessage = strip_tags($_POST['laechonw_postmessage']);
		}
	}
	update_post_meta($post_id, 'laechonw_postmessage', $new_meta_value_postmessage);
	// Twitterhandle
	$new_meta_value_twitterhandle = '';
	if (!empty($_POST['laechonw_twitterhandle'])) {
		if ($_POST['laechonw_twitterhandle']) {
			$new_meta_value_twitterhandle = strip_tags($_POST['laechonw_twitterhandle']);
			$new_meta_value_twitterhandle = str_replace("@", "", $new_meta_value_twitterhandle);
		}
	}
	update_post_meta($post_id, 'laechonw_twitterhandle', $new_meta_value_twitterhandle);
	// Twitterhash
	$new_meta_value_twitterhash = '';
	if (!empty($_POST['laechonw_twitterhash'])) {
		if ($_POST['laechonw_twitterhash']) {
			$new_meta_value_twitterhash = strip_tags($_POST['laechonw_twitterhash']);
			$new_meta_value_twitterhash = str_replace("#", "", $new_meta_value_twitterhash);
		}
	}
	update_post_meta($post_id, 'laechonw_twitterhash', $new_meta_value_twitterhash);
	//facebook pagetype
	$new_meta_value_ogtypefacebook = '';
	if (!empty($_POST['laechonw_ogtype_facebook'])) {
		if ($_POST['laechonw_ogtype_facebook']) {
			$new_meta_value_ogtypefacebook = strip_tags($_POST['laechonw_ogtype_facebook']);
		}
	}
	update_post_meta($post_id, 'laechonw_ogtype_facebook', $new_meta_value_ogtypefacebook);
	// Published
	$new_meta_value_publish = 0;
	if (!empty($_POST['laechonw_meta_cb_publish'])) {
		if ($_POST['laechonw_meta_cb_publish']) {
			$new_meta_value_publish = 1;
		}
	}
	update_post_meta($post_id, '_laechonw_meta_publish', $new_meta_value_publish);
	// Content
	$new_meta_value_content = 0;
	if (!empty($_POST['laechonw_meta_cb_content'])) {
		if ($_POST['laechonw_meta_cb_content']) {
			$new_meta_value_content = 1;
		}
	}
	update_post_meta($post_id, '_laechonw_meta_content', $new_meta_value_content);
}

function laechonw_auth_errors() {
	//Get options
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!is_array($options)) {
		return;
	}
	if(empty($options['laechonw_auth_error_show'])) {
		return;
	}
	$laechonw_auth_error_show = $options['laechonw_auth_error_show'];
	if(!$laechonw_auth_error_show) {
		return;
	}
	if (empty($options['api_key'])) {
		return;
	}
	$api_key = $options['api_key'];
	$link = 'http://www.linksalpha.com/a/networkpubautherrors';
	$params = array('api_key'=>$api_key,
					'plugin'=>LAECHONW_PLUGIN_NAME,
					'plugin_version'=>laechonw_version(),
					);
	$response_full = laechonw_http_post($link, $params);
	$response_code = $response_full[0];
	if($response_code == 200) {
        return;
	}
	if($response_code == 401) {
		echo "
		<div class='updated fade' style='padding:10px;'>
			<div style='color:red;font-weight:bold;'>
				<img src='".LAECHONW_WP_PLUGIN_URL ."/icons/alert.png' style='vertical-align:text-bottom;' />&nbsp;".LAECHONW_WIDGET_NAME_POST_EDITOR.' - '.__("Authorization Error")."
			</div>
			<div style='padding-top:0px;'>
				".__("Authorization provided on one or more of your Network accounts has expired. Please")." <a target='_blank' href='http://www.linksalpha.com/networks'>".__("add the related Account")."</a> ".__("again to be able to publish content. To learn more, ")."<a target='_blank' href='http://help.linksalpha.com/networks/authorization-error'>".__("Click Here")."</a>. ".__("To access Settings page of the plugin, ")."<a href='".LAECHO_PLUGIN_ADMIN_URL."'>".__("Click Here.")."</a>
			</div>
		</div>
		";
        return;
	}
    return;
}

function laechonw_auth_error_show($laechonw_auth_error_show) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['laechonw_auth_error_show'] = $laechonw_auth_error_show;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function laechonw_mixed_mode() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!is_array($options)) {
		return;
	}
	if(empty($options['laechonw_mixed_mode_alert_show'])) {
		return;
	}
	$laechonw_mixed_mode_alert_show = $options['laechonw_mixed_mode_alert_show'];
	if(!$laechonw_mixed_mode_alert_show) {
		return;
	}
	if (empty($options['id_2'])) {
		return;
	}
	$id = $options['id_2'];
	$link = 'http://www.linksalpha.com/a/networkpubmixedmode';
	$params = array('id'=>$id,
					'plugin'=>LAECHONW_PLUGIN_NAME,
					'plugin_version'=>laechonw_version(),
					);
	$response_full = laechonw_http_post($link, $params);
	$response_code = $response_full[0];
	if($response_code == 200) {
		$response = laechonw_json_decode($response_full[1]);
		if ($response->errorCode > 0) {
			if($response->errorMessage == 'mixed mode') {
				echo "
				<div class='updated fade' style='padding:10px;'>
					<div style='color:red;font-weight:bold;'>
						<img src='".LAECHONW_WP_PLUGIN_URL ."/icons/alert.png' style='vertical-align:text-bottom;' />&nbsp;".LAECHONW_WIDGET_NAME_POST_EDITOR.' - '.__("Mixed Mode Alert")."
					</div>
					<div style='padding-top:0px;'>
						".__("Publishing of your website content via LinksAlpha Network Publisher seems to be configured using both the Network Publisher Plugin and RSS Feed of your website. LinksAlpha recommends use of Network Publisher plugin over RSS Feed. ")."<a target='_blank' href='http://help.linksalpha.com/wordpress-plugin-network-publisher/mixed-mode-alert'>".__("Click here")."</a> ".__("to read the help document that will help resolve this Mixed Mode configuration issue.")."
					</div>
				</div>
				";
			}
		}
	}
}

function laechonw_mixed_mode_alert_show($laechonw_mixed_mode_alert_show) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['laechonw_mixed_mode_alert_show'] = $laechonw_mixed_mode_alert_show;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function laechonw_install_extension_alert_show($laechonw_install_extension_alert_show) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['laechonw_install_extension_alert_show'] = $laechonw_install_extension_alert_show;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function laechonw_enable($laechonw_enable) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['laechonw_enable'] = $laechonw_enable;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function laechonw_post_types_update($laechonw_post_types_input) {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$options['laechonw_post_types'] = $laechonw_post_types_input;
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}

function laechonw_disabled_check($laechonw_enable) {
	$html = '<div class="laecho_nw_alert_disable_pub">	
             	<div class="laecho_nw_alert_disable_pub_header"><img src="' . LAECHONW_WP_PLUGIN_URL . '/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;' . __('Alert - Publishing has been Disabled!') . '</div>
                <div>' . __('You have disabled publishing of posts using Network Publisher. To Enable it again please check the ').'<a href="' . LAECHO_PLUGIN_ADMIN_URL . '#setting_laechonw_enable">'.__('Enable Publishing Checkbox.').'</a></div>
				<div>' . __('If you still face issues, please open a ticket at: ') . '<a target="_blank" href="http://support.linksalpha.com/">' . __('LinksAlpha.com Help Desk.') . '</a></div>
			</div>';
	if ($laechonw_enable != 'checked') {
		return $html;
	}
}

function laechonw_networkping($id) {
	if(!$id) {
		return FALSE;
	}
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(empty($options['laechonw_id']) or empty($options['api_key'])) {
		return;
	}
	$link = 'http://www.linksalpha.com/a/ping?id='.$options['laechonw_id'];
	$response_full = laechonw_http($link);
	return;
}

function laechonw_networkping_custom($new, $old, $post) {
    if ($new == 'publish' && $old != 'publish') {
        $post_types = get_post_types( array('public' => true), 'objects' );
        foreach ( $post_types as $post_type ) {
            if ( $post->post_type == $post_type->name ) {
                laechonw_networkping($post->ID, $post);
                break;
            }
        }
	}
    return;
}

function laechonw_convert($id) {
	if(!$id) {
		return;
	}
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!empty($options['id_2'])) {
		return;
	}
	if(empty($options['laechonw_id']) or empty($options['api_key'])) {
		return;
	}
	// Build Params
	$link = 'http://www.linksalpha.com/a/networkpubconvert';
	$params = array('id'=>$options['laechonw_id'],
					'api_key'=>$options['api_key'],
					'plugin'=>LAECHONW_PLUGIN_NAME,
					);
	//HTTP Call
	$response_full = laechonw_http_post($link, $params);
	$response_code = $response_full[0];
	if ($response_code != 200) {
		return;
	}
	$response = laechonw_json_decode($response_full[1]);
	if ($response->errorCode > 0) {
		return;
	}
	//Update options
	$options['id_2'] = $response->results;
	//Save
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	return;
}


function laechonw_post($post_id) {
	//Network keys
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$laechonw_meta_publish = get_post_meta($post_id, '_laechonw_meta_publish', true);
	if (empty($options['api_key']) or empty($options['id_2'])) {
		return;
	}
	$id = $options['id_2'];
	$api_key = $options['api_key'];
    // Publishing Enabled/Disbaled
    if (array_key_exists('laechonw_enable', $options)) {
		$laechonw_enable_value = $options['laechonw_enable'];
	} else {
		$laechonw_enable_value = 1;
	}
	if (!$laechonw_enable_value && !$laechonw_meta_publish) {
		  return;
	}
	if (!$options['laechonw_post_types']) {
		return;
	}
	$post_types_enabled = explode(',', $options['laechonw_post_types']);
	$post_type = get_post_type($post_id);
	if (!in_array($post_type, $post_types_enabled)) {
		return;
	}
	//Post data
	$post_data = get_post( $post_id, ARRAY_A );
    //Post Published?
	if (!in_array($post_data['post_status'], array('future', 'publish'))) {
		return;
	}
    //Post too old
    $post_date = strtotime($post_data['post_date_gmt']);
    $current_date = time();
    $diff = $current_date - $post_date;
    $days = floor( $diff / (60*60*24) );
    if($days > 3) {
         return;
     }
	//Post data: id, content and title
	$post_title = $post_data['post_title'];
	//Post data: id, content and title
	$post_title = $post_data['post_title'];
	if ($laechonw_meta_content) {
		$post_content = $post_data['post_excerpt'];
	} else {
		$post_content = $post_data['post_content'];
	}
	$post_message = get_post_meta($post_id, 'laechonw_postmessage', true);
	$post_twitterhandle = get_post_meta($post_id, 'laechonw_twitterhandle', true);
	$post_twitterhash = get_post_meta($post_id, 'laechonw_twitterhash', true);
	if ($laechonw_meta_publish == "") {
		
	} elseif ($laechonw_meta_publish == 0) {
		return;
	}
	$laechonw_meta_published = get_post_meta($post_id, '_laechonw_meta_published', true);
	if ($laechonw_meta_published == 'done') {
		return;
	}
	//Post meta - laechonw_meta_content
	$laechonw_meta_content = get_post_meta($post_id, '_laechonw_meta_content', true);
	//Post data: id, content and title
	$post_title = $post_data['post_title'];
	if ($laechonw_meta_content) {
		$post_content = $post_data['post_excerpt'];
	} else {
		$post_content = $post_data['post_content'];
	}
	//Post data: Permalink
	$post_link = get_permalink($post_id);
	//Post data: Categories
	$post_categories_array = array();
	$post_categories_data = get_the_category( $post_id );
	foreach($post_categories_data as $category) {
		$post_categories_array[] = $category->cat_name;		}
		$post_categories = implode(",", $post_categories_array);
		//Post tags
		$post_tags_array = array();
		$post_tags_data = wp_get_post_tags( $post_id );
	foreach($post_tags_data as $tag) {
		$post_tags_array[] = $tag->name;
	}
	$post_tags = implode(",", $post_tags_array);
	//Post Geo
	if(function_exists('get_wpgeo_latitude')) {
		if(get_wpgeo_latitude( $post_id ) and get_wpgeo_longitude( $post_id )) {
			$post_geotag = get_wpgeo_latitude( $post_id ).' '.get_wpgeo_longitude( $post_id );			}
		}
	if(!isset($post_geotag)) {
		$post_geotag = '';
	}
	// Build Params
	$link = 'http://www.linksalpha.com/a/networkpubpost';
	$params = array('id'=>$id,
					'api_key'=>$api_key,
					'post_id'=>$post_id,
					'post_link'=>$post_link,
					'post_title'=>$post_title,
					'post_content'=>$post_content,
					'content_message' => $post_message,
					'twitterhandle' => $post_twitterhandle, 
					'hashtag' => $post_twitterhash,
					'plugin'=>LAECHONW_PLUGIN_NAME,
					'plugin_version'=>laechonw_version(),
					'post_categories'=>$post_categories,
					'post_tags'=>$post_tags,
					'post_geotag'=>$post_geota
					);
	//Featured Image
	$post_image = laechonw_thumbnail_link( $post_id );
	if($post_image) {
		$params['post_image'] = $post_image;
	}
	//HTTP Call
	$response_full = laechonw_http_post($link,$params);
    $response_code = $response_full[0];
	if ($response_code == 200) {
		update_post_meta($post_id, '_laechonw_meta_published', 'done');
		return;
	}
	update_post_meta($post_id, '_laechonw_meta_published', 'failed');
    return;
}


function laechonw_post_xmlrpc($post_id) {
    laechonw_post($post_id);
}


function laechonw_post_custom($new, $old, $post) {
    if ($new == 'publish' && $old != 'publish') {
        $post_types = get_post_types( array('public' => true), 'objects' );
        foreach ( $post_types as $post_type ) {
            if ( $post->post_type == $post_type->name ) {
                laechonw_post($post->ID);
                break;
            }
        }
	}
    return;
}


function laechonw_networkpub_add($api_key) {
	if (!$api_key) {
		$errdesc = laechonw_error_msgs('invalid key');
		return array(1, $errdesc);
	}
	$url = get_bloginfo('url');
    if (!$url) {
		$errdesc = laechonw_error_msgs('invalid url');
		return array(1, $errdesc);
	}
	$desc = get_bloginfo('description');
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if(!empty($options['laechonw_id'])) {
		$id = $options['laechonw_id'];
	} elseif (!empty($options['id_2'])) {
		$id = $options['id_2'];
	} else {
		$id = '';
	}
	$url_parsed = parse_url($url);
	$url_host = $url_parsed['host'];
	if( substr_count($url, 'localhost') or strpos($url_host, '192.168.') === 0 or strpos($url_host, '127.0.0') === 0 or (strpos($url_host, '172.') === 0 and (int)substr($url_host, 4, 2) > 15 and (int)substr($url_host, 4, 2) < 32 ) or strpos($url_host, '10.') === 0 ) {
		$errdesc = laechonw_error_msgs('localhost url');
		return array(1, $errdesc);
	}
	$link   = 'http://www.linksalpha.com/a/networkpubaddone';
	// Build Params
	$params = array('url'=>urlencode($url),
					'key'=>$api_key,
					'plugin'=>LAECHONW_PLUGIN_NAME,
					'version'=>LAECHONW_PLUGIN_VERSION,
					'all_keys'=>$options['api_key'],
					'id'=>$id);
	//HTTP Call
	$response_full = laechonw_http_post($link,$params);
	$response_code = $response_full[0];
	if ($response_code != 200) {
		$errdesc = laechonw_error_msgs($response_full[1]);
		return array(1, $errdesc);
	}
	$response = laechonw_json_decode($response_full[1]);
	if ($response->errorCode > 0) {
		$errdesc = laechonw_error_msgs($response->errorMessage);
		return array(1, $errdesc);
	}
	//Update options - Site id
	$options['id_2'] = $response->results->id;
	//Update options - Network Keys
	if(empty($options['api_key'])) {
		$options['api_key'] = $response->results->api_key;	
	} else {
		$option_api_key_array = explode(',', $options['api_key']);
		$option_api_key_new = $response->results->api_key;
		$option_api_key_new_array = explode(',', $option_api_key_new);
		foreach($option_api_key_new_array as $key=>$val) {
			if(!in_array($val, $option_api_key_array)) {
				$options['api_key'] = $options['api_key'].','.$val;
			}
		}
	}
	//Save
	update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	//Return
	$html = '<div class="laecho_notice_msg_save">'.LAECHONW_API_KEY_ADDED.'</div>';
	return array(2, $html);
}


function laechonw_networkpub_load() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (empty($options['api_key'])) {		
		$html = '<div class="laecho_nw_error">'.LAECHONW_YOU_HAVE_NOT_ADDED_ANY_API_KEY.'</div>';
		return $html;
	}
	$link = 'http://www.linksalpha.com/a/networkpubget';
	$body = array('key'=>$options['api_key'], 'version'=>2);	
	$response_full = laechonw_http_post($link, $body);
	$response_code = $response_full[0];
	if ($response_code != 200) {
		$html = laechonw_error_msgs($response_full[1]); 
		return $html;
	}
	$response = laechonw_json_decode($response_full[1]);
	if($response->errorCode > 0) {
		$html = '<div class="laecho_nw_error">'.LAECHONW_ERROR_LOADING_API_KEYS.'.</div>';
		return $html;
	}
	if(count($response->results_deleted)) {
		$option_api_key_array = explode(',', $options['api_key']);
		foreach($response->results_deleted as $row) {
			if(in_array($row, $option_api_key_array)) {
				$pos = $option_api_key_array[$row];
				unset($option_api_key_array[$pos]);
			}
		}
		$api_key = implode(",", $option_api_key_array);
		$options['api_key'] = $api_key;
		update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
	}
	if(!count($response->results)) {
		$html = '<div class="laecho_nw_error">You have not added an API Key</div>';
		return $html;
	}
	if(count($response->results) == 1) {
		$html = '<div style="padding:0px 10px 10px 10px;">'.LAECHONW_CURRENTLY_PUBLISHING.'&nbsp;<span id="lanetworkpub_pub_count">'.count($response->results).'&nbsp;'.LAECHONW_SOCIAL_NETWORK.'</span></div>';	
	} else {
		$html = '<div style="padding:0px 10px 10px 10px;">'.LAECHONW_CURRENTLY_PUBLISHING.'&nbsp;<span id="lanetworkpub_pub_count">'.count($response->results).'&nbsp;'.LAECHONW_SOCIAL_NETWORKS.'</span></div>';
	}
	$html .= '<form action="" method="post">';
	$html .= '<table class="networkpub_added">';
	$html .= '<tr><th>'.__('Network').'</th><th>'.__('Option').'</th><th>'.__('Results').'</th><th>'.__('Remove').'</th></tr>';
	$i = 1;
	foreach($response->results as $row) {
		$html .= '<tr id="r_key_'.$row->api_key.'">';
		if($i&1) {
			$html .= '<td>';
		} else {
			$html .= '<td style="background-color:#F7F7F7;">';
		}
		$html .= '<a target="_blank" href="'.$row->profile_url.'">'.$row->name.'</a></td>';
		if($i&1) {
			$html .= '<td style="text-align:center;">';
		} else {
			$html .= '<td style="text-align:center;background-color:#F7F7F7;">';
		}
		$html .= '<a href="http://www.linksalpha.com/a/networkpuboptions?api_key='.$row->api_key.'&id='.$options['id_2'].'&version='.laechonw_version().'&KeepThis=true&TB_iframe=true&height=465&width=650" title="Publish Options" class="thickbox" type="button">'.__('Options').'</a></td>';
		if($i&1) {
			$html .= '<td style="text-align:center;">';
		} else {
			$html .= '<td style="text-align:center;background-color:#F7F7F7;">';
		}
		$html .= '<a href="https://www.linksalpha.com/a/networkpublogs?api_key=' . $row -> api_key . '&id=' . $options['id_2'] . '&version=' . laechonw_version() . '&KeepThis=true&TB_iframe=true&height=400&width=920" title="Publish Results" class="thickbox" type="button" />' . __('Results') . '</a></td>';
		if($i&1) {
			$html .= '<td style="text-align:center;">';
		} else {
			$html .= '<td style="text-align:center;background-color:#F7F7F7;">';
		}
		$html .= '<a href="#" class="lanetworkpubre"><input type="hidden" name="lanetworkpubre_api_key_one" value="'.$row->api_key.'" /> '.__('Remove').'</a></td>';
		$html .= '</tr>';
		$i++;
	}
	$html .= '</table>';
	$html .= '<input type="hidden" name="laechonw_networkpub_key"	id="laechonw_networkpub_key" />';
	$html .= '<input type="hidden" name="laechonw_form_type" 		value="laechonw_remove" />';
	$html .= '<input type="hidden" name="laechonw_remove" 			value="true" />';
	$html .= '</form>';
	return $html;
}


function laechonw_networkpub_remove() {
	if(empty($_POST)) {
		return;
	}
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (!empty($_POST['laechonw_networkpub_key'])) {
		$key_only = $_POST['laechonw_networkpub_key'];
		$link = 'http://www.linksalpha.com/a/networkpubremove';
		$body = array('id'=>$options['id_2'], 'key'=>$key_only);
		$response_full = laechonw_http_post($link, $body);
		$response_code = $response_full[0];
		if ($response_code != 200) {
			$errdesc = laechonw_error_msgs($response_full[1]); 
			echo $errdesc;		
			return;
		}
		$api_key = $options['api_key'];
		$api_key_array = explode(',', $api_key);
		if(in_array($key_only, $api_key_array)) {
			$api_key_array = array_diff($api_key_array, array($key_only)); 
		}
		$api_key = implode(",", $api_key_array);
		$options['api_key'] = $api_key;
		update_option(LAECHONW_WIDGET_NAME_INTERNAL, $options);
		return '<div class="laecho_notice_msg_save">Network has been removed successfully</div>';
	}
}


function laechonw_json_decode($str) {
	if (function_exists("json_decode")) {
	    return json_decode($str);
	} else {
		if (!class_exists('Services_JSON')) {
			require_once("JSON.php");
		}
	    $json = new Services_JSON();
	    return $json->decode($str);
	}
}


function laechonw_http($link) {
	if (!$link) {
		return array(500, 'invalid url');
	}
	if( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );
	}
	if (class_exists('WP_Http')) {
		$request = new WP_Http;
		$headers = array( 'Agent' => LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url') );
		$response_full = $request->request( $link );
        if(isset($response_full->errors)) {			
			return array(500, 'internal error');			
		}
		$response_code = $response_full['response']['code'];
		if ($response_code == 200) {
			$response = $response_full['body'];
			return array($response_code, $response);
		}
		$response_msg = $response_full['response']['message'];
		return array($response_code, $response_msg);
	}
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
	$snoop = new Snoopy;
	$snoop->agent = LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url');
	if($snoop->fetchtext($link)){
		if (strpos($snoop->response_code, '200')) {
			$response = $snoop->results;
			return array(200, $response);
		}
	}
	return array(500, 'internal error');
}


function laechonw_http_post($link, $body) {
	if (!$link) {
		return array(500, 'invalid url');
	}
	if( !class_exists( 'WP_Http' ) ) {
		include_once( ABSPATH . WPINC. '/class-http.php' );
	}
	if (class_exists('WP_Http')) {
		$request = new WP_Http;
		$headers = array( 'Agent' => LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url') );
		$response_full = $request->request( $link, array( 'method' => 'POST', 'body' => $body, 'headers'=>$headers) );
		if(isset($response_full->errors)) {
			return array(500, 'internal error');
		}
		$response_code = $response_full['response']['code'];
		if ($response_code == 200) {
			$response = $response_full['body'];
			return array($response_code, $response);
		}
		$response_msg = $response_full['response']['message'];
		return array($response_code, $response_msg);
	}
	require_once(ABSPATH.WPINC.'/class-snoopy.php');
	$snoop = new Snoopy;
	$snoop->agent = LAECHONW_WIDGET_NAME.' - '.get_bloginfo('url');
	if($snoop->submit($link, $body)){
		if (strpos($snoop->response_code, '200')) {
			$response = $snoop->results;
			return array(200, $response);
		} 
	}	
	return array(500, 'internal error');
}


function laechonw_error_msgs($errMsg) {

	$arr_errCodes  = explode(";", $errMsg);
	$errCodesCount = count($arr_errCodes);

	switch (trim($arr_errCodes[0])) {
	
		case 'internal error':
			$html = '<div class="laecho_nw_error">'.__('An unknown error occured. Please try again later. Else, open a ticket with').'&nbsp;<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk').'</div>';
			return $html;		
			break;
	
		case 'invalid url':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Your website URL is invalid').'</div>
							<div>'.__('URL of your website is not valid and as a result LinksAlpha.com is not able to connect to it. You can try adding the website URL directly in the').'&nbsp;'.'<a target="_blank" href="https://www.linksalpha.com/websites">'.__('LinksAlpha Website Manager.').'</a>&nbsp;'.__('If that also does not work, please open a ticket at').'&nbsp;'.'<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk.').'</a></div>
						</div>';
			return $html;
			break;
		
		case 'remote url error':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Remote URL error').'</div>
							<div>'.__('Your website is either loading extremely slowly or it is in maintenance mode. As a result LinksAlpha.com is not able to connect to it. You can try adding the website URL directly in the').'&nbsp;'.'<a target="_blank" href="https://www.linksalpha.com/websites">'.__('LinksAlpha Website Manager.').'</a>&nbsp;'.__('If that also does not work, please open a ticket at').'&nbsp;'.'<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk.').'</a></div>
						</div>';
			return $html;
			break;
			
		case 'feed parsing error':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('RSS Feed parsing error').'</div>
							<div>'.__('Your RSS feed has errors and as a result LinksAlpha.com is not able to connect to it. You can try validating your RSS feed using').'&nbsp;'.'<a target="_blank" href="http://feedvalidator.org/">'.__('Feed Validator.').'</a>&nbsp;'.__('If the RSS feed is indeed valid and you continue to face isses, please open a ticket at').'&nbsp;'.'<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk.').'</a></div>
						</div>';
			return $html;
			break;

		case 'feed not found':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('RSS Feed URL not found').'</div>
							<div>'.__('Plugin was not able to find RSS feed URL for your website. Please ensure that under Settings').'->'.__('General').'->'.__('Blog address (URL)').'&nbsp;'.__('the URL is filled-in correctly').'</div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
			
		case 'invalid key':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Invalid Key').'</div>
							<div>'.__('The').'&nbsp;'.'<a target="_blank" href="https://www.linksalpha.com/account/your_api_key">'.__('User').'</a>&nbsp;'.__('or').'&nbsp;<a target="_blank" href="https://www.linksalpha.com/networks">'.__('Network').'</a>&nbsp;'.__('API key that you entered is not valid. Please input a valid key and try again.').'</div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
			
		case 'subscription upgrade required':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Account Error').'</div>
							<div>'.__('Please ').'&nbsp;'.'<a target="_blank" href="http://www.linksalpha.com/account">'.__('Upgrade your Account').'</a>&nbsp;'.__('to be able to Publish to more Networks. You can learn more about LinksAlpha Networks by').'&nbsp;<a target="_blank" href="http://help.linksalpha.com/networks-1">'.__('clicking here').'</a></div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
			
		case 'localhost url':
			$html  = 	'<div class="laecho_nw_error">
							<div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('Website/Blog inaccessible').'</div>
							<div>'.__('You are trying to use the plugin on localhost or behind a firewall which is not supported. Please install the plugin on a Wordpress blog on a live server.').'</div>
							<div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
						</div>';
			return $html;
			break;
			
		case 'multiple accounts':
			$html = '<div class="laecho_nw_error">
                        <div class="laecho_nw_error_header"><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;Account Error</div>
                        <div>'.__('The key that you entered is for a LinksAlpha account that is different from the currently used account for this website. You can use API key from only one account on this website. Please input a valid <a target="_blank" href="http://www.linksalpha.com/account/your_api_key">User</a> or <a target="_blank" href="http://www.linksalpha.com/user/networks">Network</a> API key and try again').'.</div>
                        <div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
                    </div>';
			return $html;
			break;
			
		case 'no networks':
			$html = '<div class="laecho_nw_error">
                        <div class="laecho_nw_error_header"><b><img src="'.LAECHONW_WP_PLUGIN_URL .'/icons/alert.png" style="vertical-align:text-bottom;" />&nbsp;'.__('No Network Accounts Found').'</b></div>
                        <div>'.__('You should first authorize LinksAlpha to publish to your social network profiles').' <a target="_blank" href="http://www.linksalpha.com/networks">'.__('Click Here').'</a> '.__('to get started.').'</div>
                        <div>'.__('If you still face issues, please open a ticket at: ').'<a target="_blank" href="http://support.linksalpha.com/">LinksAlpha.com '.__('Help Desk').'</a></div>
                    </div>';
			return $html;
			break;
			
		default:
			$html = '<div class="laecho_nw_error">'.__('An unknown error occured. Please try again later. Else, open a ticket with').'&nbsp;<a target="_blank" href="http://support.linksalpha.com">'.__('LinksAlpha Help Desk').'</div>';
			return $html;		
			break;			
	}	
}


function laechonw_get_plugin_dir() {
	global $wp_version;
	if ( version_compare($wp_version, '2.8', '<') ) {
		$path = dirname(plugin_basename(__FILE__));
		if ( $path == '.' )
		$path = '';
		$plugin_path = trailingslashit( plugins_url( $path ) );
	} 
	else {
		$plugin_path = trailingslashit( plugins_url( '', __FILE__) );
	}	
	return $plugin_path;
}


function laechonw_pushpresscheck() {
	$active_plugins = get_option('active_plugins');
	$pushpress_plugin = 'pushpress/pushpress.php';
	$this_plugin_key = array_search($pushpress_plugin, $active_plugins);
	if ($this_plugin_key) {
		$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
		if(array_key_exists('laechonw_id', $options)) {
			if($options['laechonw_id']) {
				$link = 'http://www.linksalpha.com/a/pushpress';
				$body = array('id'=>$options['laechonw_id']);
				$response_full = laechonw_http_post($link, $body);
				$response_code = $response_full[0];	
			}	
		}
	}
}

function laechonw_post_types() {
	$options = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	if (empty($options['laechonw_post_types'])) {
		$post_types_in_options = array();
	} else {
		$post_types_in_options = explode(',', $options['laechonw_post_types']);
	}
	if (!function_exists('get_post_types')) {
		return;
	}
	$html = '';
	$args = array('public' => true, '_builtin' => false);
	$output = 'names';
	$operator = 'and';
	$post_types = get_post_types($args, $output, $operator);
	array_unshift($post_types, 'post', 'page');
	foreach ($post_types as $post_type) {
		$checked = '';
		if (in_array($post_type, $post_types_in_options)) {
			$checked = 'checked';
		}
		$html .= '<div style="padding-bottom:2px;"><input id="laechonw_post_type_' . $post_type . '" type="checkbox" value="' . $post_type . '" name="laechonw_post_types[]" ' . $checked . ' />&nbsp;<label for="laechonw_post_type_' . $post_type . '" >' . $post_type . '</label></div>';
	}
	return $html;
}

function laechonw_networkpubcheck() {
	$active_plugins = get_option('active_plugins');
	$pushpress_plugin = 'network-publisher/networkpub.php';
	$this_plugin_key = array_search($pushpress_plugin, $active_plugins);
	if ($this_plugin_key) {
		return True;
	}
	return False;
}


function laechonw_thumbnail_link( $post_id ) {
	if(function_exists('get_post_thumbnail_id') and function_exists('wp_get_attachment_image_src')) {
        $src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'medium');
        if($src) {
            $src = $src[0];
            return $src;
        }
    }
	if(!$post_content) {
		return False;
	}
    if(class_exists("DOMDocument") and function_exists('simplexml_import_dom')) {
		libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        if(!($doc->loadHTML($post_content))){
			return False;
		}
		try {
			$xml = @simplexml_import_dom($doc);
			if($xml) {
				$images = $xml->xpath('//img');
				if(!empty($images)) {
					return $images[0]['src'];
				}
			} else {
				return False;	
			}
		} catch (Exception $e) {
			return False;
		}
    }
    return False;
}

function laechonw_prepare_string($string, $string_length) {
	$final_string = '';
	$utf8marker = chr(128);
	$count = 0;
	while (isset($string{$count})) {
		if ($string{$count} >= $utf8marker) {
			$parsechar = substr($string, $count, 2);
			$count += 2;
		} else {
			$parsechar = $string{$count};
			$count++;
		}
		if ($count > $string_length) {
			return $final_string;
		}
		$final_string = $final_string . $parsechar;
	}
	return $final_string;
}

function laechonw_prepare_text($text) {
	$text = stripslashes($text);
	$text = strip_tags($text);
	$text = preg_replace("/\[.*?\]/", '', $text);
	$text = preg_replace('/([\n \t\r]+)/', ' ', $text);
	$text = preg_replace('/( +)/', ' ', $text);
	$text = preg_replace('/\s\s+/', ' ', $text);
	$text = laechonw_prepare_string($text, 310);
	$text = laechonw_smart_truncate($text, 300);
	$text = trim($text);
	$text = htmlspecialchars($text);
	return $text;
}

function laechonw_get_post_data_republish($p) {
	$post_data = array();
	$post_data['page_url'] 				=	get_permalink($p);
	if($p->post_title) {
		$post_data['page_title'] 		=	laechonw_prepare_text($p->post_title);	
	}
	if($p->post_content) {
		$post_data['page_text'] 		= 	laechonw_prepare_text($p->post_content);	
	}
	$page_url_image = laechonw_thumbnail_link($p->ID, $p->post_content);
	if($page_url_image) {
		$post_data['page_url_image'] 	= 	$page_url_image;	
	}
	return $post_data;
}

function laechonw_smart_truncate($string, $required_length) {
	$parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
	$parts_count = count($parts);
	$length = 0;
	$last_part = 0;
	for (; $last_part < $parts_count; ++$last_part) {
		$length += strlen($parts[$last_part]);
		if ($length > $required_length) {
			break;
		}
	}
	return implode(array_slice($parts, 0, $last_part));
}


function laechonw_version() {
	return LAECHONW_PLUGIN_VERSION;
}

?>