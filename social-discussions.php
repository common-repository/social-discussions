<?php
/*
Plugin Name: Social Discussions
Plugin URI: http://www.linksalpha.com
Description: Social Buttons for your website and Auto-Publishing of content to Social Networks.
Author: linksalpha
Author URI: http://www.linksalpha.com
Version: 6.2.1
*/

/*
    Copyright (C) 2010 LinksAlpha.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a  copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require("social-discussions-utility-fns.php");
require("social-discussions-combo.php");
require("social-discussions-networkpub.php");
require("social-discussions-fb-meta.php");
require("social_discussions_service_names.php");
require("social-discussions-country.php");

define('SOCIALDISCUSS_PLUGIN_URL',      	socialdiscuss_get_plugin_dir());
define('LAECHONW_WIDGET_NAME',				__('Network Publisher'));
define('LAECHONW_WIDGET_NAME_INTERNAL', 	'laechonw_networkpub');
define('LAECHONW_WIDGET_PREFIX',        	'laechonw_networkpub');
define('LAECHONW_NETWORKPUB',           	__('Automatically publish your Blog Posts to 20+ Social Networks including Facebook, Twitter, LinkedIn, etc.'));
define('LAECHONW_ERROR_INTERNAL',       	'internal error');
define('LAECHONW_ERROR_INVALID_URL',    	'invalid url');
define('LAECHONW_ERROR_INVALID_KEY',    	'invalid key');
define('LAECHO__POST_EDITOR_WIDGET_NAME', 	__('Social Buttons'));
define('LAECHO_PLUGIN_ADMIN_URL', 			"options-general.php?page=social-discussions/social-discussions.php");
define('LAECHO_FOLLOW_SUBSCRIBE_NAME',       __('Follow and Subscribe'));
define('LAECHO_FOLLOW_SUBSCRIBE_ID',         'laecho_follow_subscribe_id');

$rss_feed_url = '';
if (function_exists('get_bloginfo')) {
	if (function_exists('get_feed_permastruct')) {
		$rss_feed_url = get_bloginfo('rss2_url');
	}
}

//Buttons with Counters
$laecho_buttons_buttons_with_counters_services = array(
											'googleplus'	=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'facebook'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'twitter'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'linkedin'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'reddit'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'stumbleupon'	=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'pinterest'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'identica'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'yammer'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'gmail'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'yahoomail'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'hotmail'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'aolmail'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'mailru'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'email'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'print'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'digg'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'delicious'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'diigo'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'posterous'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'tumblr'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'myspace'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'evernote'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'instapaper'	=>array('display_options'=>array('popup'=>__('Popup'))),
											'pocket'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'msn'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'livejournal'	=>array('display_options'=>array('popup'=>__('Popup'))),
											'sonico'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'netlog'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'hyves'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'xing'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'vkontakte'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'weibo'			=>array('display_options'=>array('popup'=>__('Popup'))),
										    'snipit'		=>array('display_options'=>array('popup'=>__('Popup'))),
										    'foursquare'    =>array('display_options'=>array('popup'=>__('Popup'))),
										);
$laecho_buttons_buttons_with_counters_services_param_name 	= array('googleplus'=>'gplus', 'facebook'=>'fblike');
$laecho_buttons_buttons_with_counters_services_default 		= array('googleplus', 'facebook', 'twitter', 'linkedin');
$laecho_buttons_buttons_with_counters = array(
	'laecho_opt_withcntr_align'             	=> array('option_name'=>'laecho-html-withcntr-align',				'default_value'=>'center', 		'type'=>'string',	'param_name'=>'halign', 		'fieldset'=>'halign'),
    'laecho_opt_withcntr_facebooklike_verb' 	=> array('option_name'=>'laecho-html-withcntr-facebooklike-verb',	'default_value'=>'like', 		'type'=>'string',	'param_name'=>'fblikeverb', 	'fieldset'=>'facebook'),
    'laecho_opt_withcntr_facebooklike_ref'  	=> array('option_name'=>'laecho-html-withcntr-facebooklike-ref',	'default_value'=>'linksalpha', 	'type'=>'string',	'param_name'=>'fblikeref', 		'fieldset'=>'facebook',														'field_size'=>50),
    'laecho_opt_withcntr_facebooklike_font' 	=> array('option_name'=>'laecho-html-withcntr-facebooklike-font',	'default_value'=>'arial', 		'type'=>'string',	'param_name'=>'fblikefont', 	'fieldset'=>'facebook'),
    'laecho_opt_withcntr_display'           	=> array('option_name'=>'laecho-html-withcntr-display',				'default_value'=>1, 			'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'display'),
	'laecho_opt_withcntr_version'           	=> array('option_name'=>'laecho-html-withcntr-version',				'default_value'=>1, 			'type'=>'integer',	'param_name'=>'v', 				'fieldset'=>False),
	'laecho_opt_withcntr_twitter_width'     	=> array('option_name'=>'laecho-html-withcntr-twitter-width',		'default_value'=>110, 			'type'=>'integer',	'param_name'=>'twitterw', 		'fieldset'=>'width'),
	'laecho_opt_withcntr_facebooklike_width'    => array('option_name'=>'laecho-html-withcntr-facebooklike-width',	'default_value'=>90, 			'type'=>'integer',	'param_name'=>'facebookw', 		'fieldset'=>'width'),
    'laecho_opt_widget_counters_location'   	=> array('option_name'=>'laecho-html-widget-counters-location',		'default_value'=>'before', 		'type'=>'string',	'param_name'=>False, 			'fieldset'=>'location'),
	'laecho_opt_widget_margin_top'          	=> array('option_name'=>'laecho-html-widget-margin-top',			'default_value'=>5, 			'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 				'field_name'=>__('Top'),				'field_size'=>2),
	'laecho_opt_widget_margin_right'        	=> array('option_name'=>'laecho-html-widget-margin-right',			'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 				'field_name'=>__('Right'),				'field_size'=>2),
	'laecho_opt_widget_margin_bottom'       	=> array('option_name'=>'laecho-html-widget-margin-bottom',			'default_value'=>5, 			'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 				'field_name'=>__('Bottom'),				'field_size'=>2),
	'laecho_opt_widget_margin_left'         	=> array('option_name'=>'laecho-html-widget-margin-left',			'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 				'field_name'=>__('Left'),				'field_size'=>2),
);
foreach($laecho_buttons_buttons_with_counters_services as $key=>$val) {
	$param_name = $key;
	if(isset($laecho_buttons_buttons_with_counters_services_param_name[$key])) {
		$param_name = $laecho_buttons_buttons_with_counters_services_param_name[$key];
	}
	$default_display = 1;
	$default_display_type = 'popup';
	if(in_array($key, $laecho_buttons_buttons_with_counters_services_default)) {
		$default_display_type = 'button';
	}
	$laecho_buttons_buttons_with_counters['laecho_opt_withcntr_'.$key] 					= array('option_name'=>'laecho-html-withcntr-'.$key, 				'default_value'=>$default_display, 			'type'=>'integer',	'param_name'=>$param_name, 'fieldset'=>'buttons_to_display', 'field_name'=>$laecho_service_names[$param_name], 'display_options'=>$val['display_options']);
	$laecho_buttons_buttons_with_counters['laecho_opt_withcntr_'.$key.'_display'] 		= array('option_name'=>'laecho-html-withcntr-'.$key.'-display', 	'default_value'=>$default_display_type, 	'type'=>'string', 	'param_name'=>$param_name, 'fieldset'=>'buttons_to_display_display');
}
//Buttons without counters
$laecho_buttons_buttons_services = array(
											'googleplus'	=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'facebook'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'twitter'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'linkedin'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'reddit'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'stumbleupon'	=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'pinterest'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'identica'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'yammer'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'gmail'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'yahoomail'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'hotmail'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'aolmail'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'mailru'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'email'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'print'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'digg'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'delicious'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'diigo'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'posterous'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'tumblr'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'myspace'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'evernote'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'instapaper'	=>array('display_options'=>array('popup'=>__('Popup'))),
											'pocket'	    =>array('display_options'=>array('popup'=>__('Popup'))),
											'msn'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'livejournal'	=>array('display_options'=>array('popup'=>__('Popup'))),
											'sonico'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'netlog'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'hyves'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'xing'			=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'vkontakte'		=>array('display_options'=>array('popup'=>__('Popup'))),
											'weibo'			=>array('display_options'=>array('popup'=>__('Popup'))),
											'snipit'		=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
											'foursquare'	=>array('display_options'=>array('button'=>__('Button'), 'popup'=>__('Popup'))),
										);
$laecho_buttons_buttons_services_param_name 	= array('googleplus'=>'gplus'/*, 'facebook'=>'fbsend'*/);
$laecho_buttons_buttons_services_default 		= array('googleplus', 'facebook', 'twitter', 'linkedin', 'reddit', 'pinterest', 'stumbleupon');
$laecho_buttons_buttons = array(
	'laecho_opt_cntr_align'       		=> array('option_name'=>'laecho-html-cntr-align', 			'default_value'=>'center', 	'type'=>'string',	'param_name'=>'halign', 	'fieldset'=>'halign'),
    'laecho_opt_cntr_display'     		=> array('option_name'=>'laecho-html-cntr-display', 		'default_value'=>0, 		'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'display'),
	'laecho_opt_cntr_version'     		=> array('option_name'=>'laecho-html-cntr-version', 		'default_value'=>1, 		'type'=>'integer',	'param_name'=>'v', 			'fieldset'=>False),
	'laecho_opt_cntr_twitter_width'     => array('option_name'=>'laecho-html-cntr-twitter-width',	'default_value'=>55, 		'type'=>'integer',	'param_name'=>'twitterw', 	'fieldset'=>'width'),
    'laecho_opt_counters_location'		=> array('option_name'=>'laecho-html-counters-location',	'default_value'=>'after', 	'type'=>'string',	'param_name'=>False, 		'fieldset'=>'location'),
	'laecho_opt_margin_top'       		=> array('option_name'=>'laecho-html-margin-top', 			'default_value'=>5, 		'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 		'field_name'=>__('Top'),	'field_size'=>2),
	'laecho_opt_margin_right'     		=> array('option_name'=>'laecho-html-margin-right', 		'default_value'=>0, 		'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 		'field_name'=>__('Right'),	'field_size'=>2),
	'laecho_opt_margin_bottom'    		=> array('option_name'=>'laecho-html-margin-bottom', 		'default_value'=>5, 		'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 		'field_name'=>__('Bottom'),	'field_size'=>2),
	'laecho_opt_margin_left'      		=> array('option_name'=>'laecho-html-margin-left', 			'default_value'=>0, 		'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 		'field_name'=>__('Left'),	'field_size'=>2),
);
foreach($laecho_buttons_buttons_services as $key=>$val) {
	$param_name = $key;
	if(isset($laecho_buttons_buttons_services_param_name[$key])) {
		$param_name = $laecho_buttons_buttons_services_param_name[$key];
	}
	$default_display = 1;
	$default_display_type = 'popup';
	if(in_array($key, $laecho_buttons_buttons_services_default)) {
		$default_display_type = 'button';
	}
	$laecho_buttons_buttons['laecho_opt_cntr_'.$key] 					= array('option_name'=>'laecho-html-cntr-'.$key, 				'default_value'=>$default_display, 			'type'=>'integer',	'param_name'=>$param_name, 'fieldset'=>'buttons_to_display', 'field_name'=>$laecho_service_names[$param_name], 'display_options'=>$val['display_options']);
	$laecho_buttons_buttons['laecho_opt_cntr_'.$key.'_display'] 		= array('option_name'=>'laecho-html-cntr-'.$key.'-display', 	'default_value'=>$default_display_type, 	'type'=>'string', 	'param_name'=>$param_name, 'fieldset'=>'buttons_to_display_display');
}
//Icons
$laecho_buttons_icons_services_default 	= array('googleplus', 'facebook', 'twitter', 'linkedin', 'stumbleupon', 'pinterest', 'email');
$laecho_buttons_icons_services_extra 	= array('reddit', 'digg', 'delicious', 'diigo', 'evernote', 'posterous', 'tumblr', 'myspace', 'instapaper', 'pocket', 'msn', 'livejournal', 'yammer', 'identica', 'yahoomail', 'gmail', 'hotmail', 'aolmail', 'sonico', 'netlog', 'vkontakte', 'hyves', 'xing', 'mailru', 'weibo','snipit','foursquare', 'print');
$laecho_buttons_icons = array(
	'laecho_opt_icons_margin_top' 				=> array('option_name'=>'laecho-html-icons-margin-top', 	'default_value'=>0, 					'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 		'field_name'=>__('Top'),	'field_size'=>2),
	'laecho_opt_icons_margin_right' 			=> array('option_name'=>'laecho-html-icons-margin-right', 	'default_value'=>0, 					'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 		'field_name'=>__('Right'),	'field_size'=>2),
	'laecho_opt_icons_margin_bottom' 			=> array('option_name'=>'laecho-html-icons-margin-bottom', 	'default_value'=>0, 					'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 		'field_name'=>__('Bottom'),	'field_size'=>2),
	'laecho_opt_icons_margin_left'				=> array('option_name'=>'laecho-html-icons-margin-left', 	'default_value'=>0, 					'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'margin', 		'field_name'=>__('Left'),	'field_size'=>2),
	'laecho_opt_icons_display' 					=> array('option_name'=>'laecho-html-icons-display', 		'default_value'=>1, 					'type'=>'integer',	'param_name'=>False, 			'fieldset'=>'display'),
	'laecho_opt_icons_location'          		=> array('option_name'=>'laecho-html-icons-location',		'default_value'=>'after', 				'type'=>'string',	'param_name'=>False, 			'fieldset'=>'location'),
	'laecho_opt_icons_font' 					=> array('option_name'=>'laecho-html-icons-font', 			'default_value'=>'arial', 				'type'=>'string',	'param_name'=>'fontstyle', 		'fieldset'=>'font'),
	'laecho_opt_icons_prependtext' 				=> array('option_name'=>'laecho-html-icons-prependtext', 	'default_value'=>'Share this post on:', 'type'=>'string',	'param_name'=>'prepend', 		'fieldset'=>'prependtext',	'field_name'=>__('Text to prepend to the buttons(max 30 characters)'),		'field_size'=>30),
	'laecho_opt_icons_prependsize' 				=> array('option_name'=>'laecho-html-icons-prependsize', 	'default_value'=>14, 					'type'=>'integer',	'param_name'=>'prepends', 		'fieldset'=>'prependtext',	'field_name'=>__('Font-size of the text'),									'field_size'=>2),
	'laecho_opt_icons_prependcolor' 			=> array('option_name'=>'laecho-html-icons-prependcolor', 	'default_value'=>'7F7F7F', 				'type'=>'string',	'param_name'=>'prependc', 		'fieldset'=>'prependtext',	'field_name'=>__('Color of the text'),										'field_size'=>6),
	'laecho_opt_icons_size' 					=> array('option_name'=>'laecho-html-icons-size', 			'default_value'=>16, 					'type'=>'integer',	'param_name'=>'size', 			'fieldset'=>'size'),
);
foreach($laecho_buttons_icons_services_default as $service) {
	$laecho_buttons_icons['laecho_opt_icons_'.$service] 			= array('option_name'=>'laecho-html-icons-'.$service, 			'default_value'=>1, 		'type'=>'integer', 	'param_name'=>$service, 'fieldset'=>'buttons_to_display', 'field_name'=>$laecho_service_names[$service]);
}
foreach($laecho_buttons_icons_services_extra as $service) {
	$laecho_buttons_icons['laecho_opt_icons_'.$service] 			= array('option_name'=>'laecho-html-icons-'.$service, 			'default_value'=>1, 		'type'=>'integer', 	'param_name'=>$service, 'fieldset'=>'buttons_to_display', 'field_name'=>$laecho_service_names[$service]);
}
foreach($laecho_buttons_icons_services_default as $service) {
	$laecho_buttons_icons['laecho_opt_icons_'.$service.'_display'] 	= array('option_name'=>'laecho-html-icons-'.$service.'-display', 'default_value'=>'page', 	'type'=>'string', 	'param_name'=>$service, 'fieldset'=>'buttons_to_display_display');
}
foreach($laecho_buttons_icons_services_extra as $service) {
	$laecho_buttons_icons['laecho_opt_icons_'.$service.'_display'] 	= array('option_name'=>'laecho-html-icons-'.$service.'-display', 'default_value'=>'popup', 	'type'=>'string', 	'param_name'=>$service, 'fieldset'=>'buttons_to_display_display');
}
//Icon
$laecho_buttons_icon_services_default 	= array('googleplus', 'facebook', 'twitter', 'linkedin', 'reddit', 'stumbleupon', 'pinterest', 'yammer', 'identica', 'yahoomail', 'gmail', 'hotmail', 'email', 'print');
$laecho_buttons_icon_services_extra 	= array('digg', 'delicious', 'diigo', 'evernote', 'posterous', 'tumblr', 'myspace', 'instapaper', 'pocket', 'msn', 'aolmail', 'livejournal', 'sonico', 'netlog', 'vkontakte', 'hyves', 'xing', 'mailru', 'weibo','snipit','foursquare');
$laecho_buttons_icon = array(
	'laecho_opt_icon_margin_top' 			=> array('option_name'=>'laecho-html-icon-margin-top', 		'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 	'field_name'=>__('Top'),	'field_size'=>2, 'field_class'=>'laecho-html-icon-margin-block'),
	'laecho_opt_icon_margin_right' 			=> array('option_name'=>'laecho-html-icon-margin-right', 	'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 	'field_name'=>__('Right'),	'field_size'=>2, 'field_class'=>'laecho-html-icon-margin-inline'),
	'laecho_opt_icon_margin_bottom' 		=> array('option_name'=>'laecho-html-icon-margin-bottom', 	'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 	'field_name'=>__('Bottom'),	'field_size'=>2, 'field_class'=>'laecho-html-icon-margin-block'),
	'laecho_opt_icon_margin_left'			=> array('option_name'=>'laecho-html-icon-margin-left', 	'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'margin', 	'field_name'=>__('Left'),	'field_size'=>2, 'field_class'=>'laecho-html-icon-margin-inline'),
	'laecho_opt_icon_display_inline'		=> array('option_name'=>'laecho-html-icon-display-inline', 	'default_value'=>0, 			'type'=>'integer',	'param_name'=>'inline', 	'fieldset'=>'location'),
	'laecho_opt_icon_display' 				=> array('option_name'=>'laecho-html-icon-display', 		'default_value'=>0, 			'type'=>'integer',	'param_name'=>False, 		'fieldset'=>'location'),
	'laecho_opt_icon_location'          	=> array('option_name'=>'laecho-html-icon-location',		'default_value'=>'after', 		'type'=>'string',	'param_name'=>False, 		'fieldset'=>'location'),
	'laecho_opt_icon_font' 					=> array('option_name'=>'laecho-html-icon-font', 			'default_value'=>'arial', 		'type'=>'string',	'param_name'=>'fontstyle', 	'fieldset'=>'location'),
);
foreach($laecho_buttons_icon_services_default as $service) {
	$laecho_buttons_icon['laecho_opt_icon_'.$service] = array('option_name'=>'laecho-html-icon-'.$service, 'default_value'=>1, 'type'=>'integer', 'param_name'=>$service, 'fieldset'=>'buttons_to_display', 'field_name'=>$laecho_service_names[$service]);
}
foreach($laecho_buttons_icon_services_extra as $service) {
	$laecho_buttons_icon['laecho_opt_icon_'.$service] = array('option_name'=>'laecho-html-icon-'.$service, 'default_value'=>0, 'type'=>'integer', 'param_name'=>$service, 'fieldset'=>'buttons_to_display', 'field_name'=>$laecho_service_names[$service]);
}
//Language
$laecho_options_language = array(
    'laecho_opt_lang_googleplus'			=> array('option_name'=>'laecho-html-widget-lang-googleplus', 	'default_value'=>'en-US', 		'type'=>'string',	'param_name'=>'gpluslang'),
    'laecho_opt_lang_facebooklike'  		=> array('option_name'=>'laecho-html-widget-lang-facebooklike', 'default_value'=>'en_US', 		'type'=>'string',	'param_name'=>'fbsendlang'),
    'laecho_opt_lang_twitter'       		=> array('option_name'=>'laecho-html-widget-lang-twitter', 		'default_value'=>'en', 			'type'=>'string',	'param_name'=>'twitterlang'),
	'laecho_opt_lang_xing'       			=> array('option_name'=>'laecho-html-widget-lang-xing', 		'default_value'=>'de', 			'type'=>'string',	'param_name'=>'xinglang', 'field_name'=>'Xing',	'field_options'=>array('de'=>'German', 'en'=>'English')),
);
//Twitter
$laecho_options_twitter = array(
    'laecho_opt_twittermention'     		=> array('option_name'=>'laecho-html-twitter-mention', 			'default_value'=>'', 			'type'=>'string',	'param_name'=>'twittermention'),
    'laecho_opt_twitterrelated1'    		=> array('option_name'=>'laecho-html-twitter-related1', 		'default_value'=>'linksalpha', 	'type'=>'string',	'param_name'=>'twitterrelated1'),
    'laecho_opt_twitterrelated2'    		=> array('option_name'=>'laecho-html-twitter-related2', 		'default_value'=>'', 			'type'=>'string',	'param_name'=>'twitterrelated2'),
	'laecho_opt_twitterhashtag'    			=> array('option_name'=>'laecho-html-twitter-hashtag', 			'default_value'=>'', 			'type'=>'string',	'param_name'=>'twitterhash'),
);
//Facebook
$laecho_options_facebook = array(
    'laecho_opt_fb_app_id' 		=> array('option_name'=>'laecho-html-fb-app-id', 	'default_value'=>'', 	'type'=>'string', 	'field_name'=>__('Facebook App Id'), 			'field_type'=>'text',		'field_helper'=>'Input your Facebook App ID to link your pages to your Facebook Platform application. This will enable you to publish stream updates to your pages programmatically.', 'field_size'=>20),
	'laecho_opt_fb_metatags' 	=> array('option_name'=>'laecho-html-fb-metatags', 	'default_value'=>1, 	'type'=>'integer', 	'field_name'=>__('Facebook OpenGraphs Tags'), 	'field_type'=>'checkbox',	'field_helper'=>'Check this box if you want Facebook OpenGraph metatags to be added to your pages. Please don\'t disable this option unless you are using an alternate way to show the metatags in your pages. Without these metatags, publishing of your content to Facebook will be impacted.'),
);
//Google
$laecho_options_googleplus = array(
    'laecho_opt_googleplus_page_type' 	=> array('option_name'=>'laecho-html-googleplus-page-type', 'default_value'=>'Article', 'type'=>'string', 	'field_name'=>__('Page Type'), 			'field_type'=>'select',		'field_size'=>50, 'field_options'=>array('Article'=>__('Article'), 'Blog'=>__('Blog'), 'Book'=>__('Book'), 'Event'=>__('Event'), 'LocalBusiness'=>__('Local Business'), 'Organization'=>__('Organization'), 'Person'=>__('Person'), 'Product'=>__('Product'), 'Review'=>__('Review'))),
	'laecho_opt_googleplus_metatags' 	=> array('option_name'=>'laecho-html-googleplus-metatags', 	'default_value'=>1, 		'type'=>'integer', 	'field_name'=>__('Google Plus Tags'),	'field_type'=>'checkbox',	'field_helper'=>'Check this box if you want Google Plus metatags to be added to your pages. Please don\'t disable this option unless you are using an alternate way to show the metatags in your pages. Without these metatags, publishing of your content to Google Plus will be impacted.'),
);
//Display on Pages
$laecho_options_display_pages = array(
	'laecho_opt_display_home'         		=> array('option_name'=>'laecho-html-display-home',				'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Home Page'), 				'post_type'=>'regular'),
	'laecho_opt_display_page'         		=> array('option_name'=>'laecho-html-display-page',				'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Pages'), 					'post_type'=>'regular'),
	'laecho_opt_display_category'         	=> array('option_name'=>'laecho-html-display-category',			'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Category Archive Pages'),	'post_type'=>'regular'),
	'laecho_opt_display_tag'         		=> array('option_name'=>'laecho-html-display-tag',				'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Tag Archive Pages'), 		'post_type'=>'regular'),
	'laecho_opt_display_author'         	=> array('option_name'=>'laecho-html-display-author',			'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Author Pages'), 			'post_type'=>'regular'),
	'laecho_opt_display_date'         		=> array('option_name'=>'laecho-html-display-date',				'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Date Archive Pages'), 	'post_type'=>'regular'),
	'laecho_opt_display_search'         	=> array('option_name'=>'laecho-html-display-search',			'default_value'=>1, 			'type'=>'integer',	'field_name'=>__('Search Results'),			'post_type'=>'regular'),
);
//Foursquare options
$laecho_options_foursquare = array(
	'laecho_opt_foursquare_vid'				=>	array('option_name'=>'laecho-html-foursquare-vid',			'default_value'=>'',    		'type'=>'string',		'param_name'=>'data-foursquare-vid' ),
);
//Follow & Subscribe options
$laecho_options_follow_subscribe = array(
	'laecho_opt_follow_subscribe_googleplus'		=>	array('option_name'=>'laecho-html-follow-subscribe-googleplus',     'default_value'=>'', 				'type'=>'string', 		'field_name'=>__('Google +1 Button'), 				'field_title'=>__('Google +1'), 		'field_icon'=>'googleplus', 	'field_type'=>'checkbox', 		'param_name'=>'googleplus', 	'help_text'=>__('This button will be displayed by default.')				),
	'laecho_opt_follow_subscribe_facebook'			=>	array('option_name'=>'laecho-html-follow-subscribe-facebook',		'default_value'=>'',    			'type'=>'string',		'field_name'=>__('Facebook Like Button'), 			'field_title'=>__('Facebook'), 			'field_icon'=>'facebook', 		'field_type'=>'checkbox', 		'param_name'=>'facebook' ,		'help_text'=>__('This button will be displayed by default.')				),
	'laecho_opt_follow_subscribe_twitter'			=>	array('option_name'=>'laecho-html-follow-subscribe-twitter',       	'default_value'=>'',				'type'=>'string',   	'field_name'=>__('Twitter ID'), 					'field_title'=>__('Twitter'), 			'field_icon'=>'twitter', 		'field_type'=>'text', 			'param_name'=>'twitter' ,		'help_text'=>__('Input your Twitter username. For example, if your Profile URL is').'<a href="https://twitter.com/vivekpuri" target="_blank"> https://twitter.com/vivekpuri</a>, then your Twitter username is <strong>vivekpuri</strong>.'),
	'laecho_opt_follow_subscribe_pinterest'			=>	array('option_name'=>'laecho-html-follow-subscribe-pinterest',      'default_value'=>'',				'type'=>'string',   	'field_name'=>__('Pinterest URL'), 					'field_title'=>__('Pinterest'), 		'field_icon'=>'pinterest', 		'field_type'=>'text', 			'param_name'=>'pinterest', 		'help_text'=>__('Input your complete Pinterest Page URL. For example, ').'<a href="https://pinterest.com/linksalpha/plugins/" target="_blank">https://pinterest.com/linksalpha/plugins/</a>.'),
	'laecho_opt_follow_subscribe_stumbleupon'		=>	array('option_name'=>'laecho-html-follow-subscribe-stumbleupon',    'default_value'=>'',				'type'=>'string',   	'field_name'=>__('StumbleUpon URL'), 				'field_title'=>__('Stumbleupon'), 		'field_icon'=>'stumbleupon', 	'field_type'=>'text', 			'param_name'=>'stumbleupon', 	'help_text'=>__('Input your complete Stumbleupon Page URL. For example, ').'<a href="http://www.stumbleupon.com/su/2wOTSh/:NVU5rq!u:QxI@0x$O/www.linksalpha.com/" target="_blank"> http://www.stumbleupon.com/su/2wOTSh/:NVU5rq!u:QxI@0x$O/www.linksalpha.com/</a>.'),
	'laecho_opt_follow_subscribe_linkedin'			=>	array('option_name'=>'laecho-html-follow-subscribe-linkedin',       'default_value'=>'',				'type'=>'string',   	'field_name'=>__('LinkedIn Profile URL'), 		    'field_title'=>__('LinkedIn'), 			'field_icon'=>'linkedin', 		'field_type'=>'text', 			'param_name'=>'linkedin' ,		'help_text'=>__('Input your complete Linkedin Profile/Company Page URL. For example, ').'<a href="http://www.linkedin.com/company/linksalpha.com" target="_blank">http://www.linkedin.com/company/linksalpha.com</a>.'),
	'laecho_opt_follow_subscribe_foursquare'		=>	array('option_name'=>'laecho-html-follow-subscribe-foursquare',     'default_value'=>'',				'type'=>'string',   	'field_name'=>__('foursquare Venue ID/Page URL'), 	'field_title'=>__('foursquare'), 		'field_icon'=>'foursquare', 	'field_type'=>'text', 			'param_name'=>'foursquare', 	'help_text'=>__('Input your complete foursquare Page URL/Venue URL. For example, ').'<a href="https://foursquare.com/chipotletweets" target="_blank">https://foursquare.com/chipotletweets</a>.'),
	'laecho_opt_follow_subscribe_aboutme'			=>	array('option_name'=>'laecho-html-follow-subscribe-aboutme',       	'default_value'=>'',				'type'=>'string',   	'field_name'=>__('About.me Profile URL'), 			'field_title'=>__('About.me'), 			'field_icon'=>'aboutme', 		'field_type'=>'text', 			'param_name'=>'aboutme' ,		'help_text'=>__('Input your complete About.me Page URL. For example, ').'<a href="https://about.me/lokeshjain2008" target="_blank">https://about.me/lokeshjain2008</a>.'),	
	'laecho_opt_follow_subscribe_xing'				=>	array('option_name'=>'laecho-html-follow-subscribe-xing',       	'default_value'=>'',				'type'=>'string',   	'field_name'=>__('Xing Profile URL'), 				'field_title'=>__('Xing'),              'field_icon'=>'xing',           'field_type'=>'text', 			'param_name'=>'xing' ,			'help_text'=>__('Input your complete Xing Profile URL. For example, ').'<a href="https://www.xing.com/profile/Vivek_Puri" target="_blank">https://www.xing.com/profile/Vivek_Puri</a>.'),
	'laecho_opt_follow_subscribe_youtube'			=>	array('option_name'=>'laecho-html-follow-subscribe-youtube',       	'default_value'=>'',				'type'=>'string',   	'field_name'=>__('Youtube Channel URL'), 			'field_title'=>__('Youtube'), 			'field_icon'=>'youtube', 		'field_type'=>'text', 			'param_name'=>'youtube' ,		'help_text'=>__('Input your Youtube Channel URL. For example, ').'<a href="http://www.youtube.com/google" target="_blank">http://www.youtube.com/google</a>.'),
	'laecho_opt_follow_subscribe_rss'				=>	array('option_name'=>'laecho-html-follow-subscribe-rss',       		'default_value'=>$rss_feed_url,		'type'=>'string',   	'field_name'=>__('RSS feed URL'), 					'field_title'=>__('RSS Feed'), 			'field_icon'=>'rss',            'field_type'=>'text', 			'param_name'=>'rss' ,			'help_text'=>__('Input your RSS feed URL. For example, ').'<a href="http://techcrunch.com/feed/atom/" target="_blank"> http://techcrunch.com/feed/atom/</a>.'),
);
//Follow & Subscribe Color and Size options
$laecho_options_fs_color = array(
	'laecho_opt_fs_color_row1'		=>	array('option_name'=>'laecho-html-fs-color-row1',		'default_value'=>'#ffffff',		'default_update'=> true,		'type'=>'string',		'field_type'=>'text',			'field_name'=>__('Background color for Facebook button'),		'param_name'=>'row1',		'help_text'=>__('Input your desired color in hex format. For example, if the color is #D8E6EB then input <strong>#D8E6EB</strong>.') ),
	'laecho_opt_fs_color_row2'		=>	array('option_name'=>'laecho-html-fs-color-row2',		'default_value'=>'#F5FCFE',		'default_update'=> true,		'type'=>'string',		'field_type'=>'text',			'field_name'=>__('Background color for GooglePlus button'),		'param_name'=>'row2',																			 ),
	'laecho_opt_fs_color_row3'		=>	array('option_name'=>'laecho-html-fs-color-row3',		'default_value'=>'#EEF9FD',		'default_update'=> true,		'type'=>'string',		'field_type'=>'text',			'field_name'=>__('Background color for Twitter button'),		'param_name'=>'row3',																			 ),
	'laecho_opt_fs_color_row4'		=>	array('option_name'=>'laecho-html-fs-color-row4',		'default_value'=>'#D8E6EB',		'default_update'=> true,		'type'=>'string',		'field_type'=>'text',			'field_name'=>__('Background color for Icons'),					'param_name'=>'row4',																			 ),
	'laecho_opt_fs_size'		 	=>	array('option_name'=>'laecho-html-fs-size',				'default_value'=>250,		 	'default_update'=> true,		'type'=>'integer',		'field_type'=>'select',			'field_name'=>__('Width of the Widget'),						'param_name'=>'width',		'field_options'=>array(200, 250, 300, 336)							 ),
	'laecho_opt_fs_margin'		 	=>	array('option_name'=>'laecho-html-fs-margin',			'default_value'=>5,		 	    'default_update'=> true,		'type'=>'integer',		'field_type'=>'text_margin',	'field_name'=>__('Margin between Widgets'),						'param_name'=>'margin',																			 ),
							    
);
//Follow & Susbscribe title
$laecho_sd_fs_title = array(
	'laecho_opt_sd_fs_title'		=>	array('option_name'=>'laecho-html-title-title', 		'default_value'=>'FOLLOW AND SUBSCRIBE',	'default_update'=>true,		'type'=>'string',		'field_name'=>__('Title of the widget:'),		'param_name'=>'title'	),
	'laecho_opt_sd_fs_title_font'	=>	array('option_name'=>'laecho-html-title-font', 			'default_value'=>'10',						'default_update'=>true, 	'type'=>'string',		'field_name'=>__('Font size of the title:'),	'param_name'=>'t_size'		),
	'laecho_opt_sd_fs_title_color'	=>	array('option_name'=>'laecho-html-title-color', 		'default_value'=>'#555555',					'default_update'=>true, 	'type'=>'string',		'field_name'=>__('Font color of the title:'),	'param_name'=>'t_color',		'help_text'=>__('input hex value for font color of title. for example, #E1E1E1.')	),
	
);
//Follow & Subscribe all options
$laecho_options_follow_subscribe_main = array_merge($laecho_options_follow_subscribe, $laecho_options_fs_color,$laecho_sd_fs_title);
//Warning Message
$laecho_options_warning_message = array(
	'laechonw_opt_warning_msg'        		=> array('option_name'=>'laechonw-html-warning-msg',			'default_value'=>0, 			'type'=>'integer',	'param_name'=>False),
);
//Global vars
$laecho_options_all = array('laecho_buttons_icon', 'laecho_buttons_icons', 'laecho_buttons_buttons', 'laecho_buttons_buttons_with_counters', 'laecho_options_language', 'laecho_options_twitter', 'laecho_options_foursquare', 'laecho_options_follow_subscribe', 'laecho_options_fs_color', 'laecho_options_follow_subscribe_main','laecho_sd_fs_title', 'laecho_options_facebook', 'laecho_options_googleplus', 'laecho_options_display_pages', 'laecho_options_warning_message');
//Service icon  images
$laecho_services_icons = array('gplus', 'fblike', 'fbsend');
foreach($laecho_buttons_icon_services_default as $service) {
	$laecho_services_icons[] = $service;
}
foreach($laecho_buttons_icon_services_extra as $service) {
	$laecho_services_icons[] = $service;
}
foreach ($laecho_options_follow_subscribe as $key=>$val) {
    if(array_key_exists('field_icon', $val)) {
        if(!in_array($val['field_icon'], $laecho_services_icons)) {
            $laecho_services_icons[] = $val['field_icon'];
        }
   }
}
//Param Name modifier
$laecho_buttons_param_name_modifer 	= array('gplus'=>'googleplus', 'fblike'=>'facebook', 'fbsend'=>'facebook');

$laechonw_networkpub_settings['api_key'] 	= array('label'=>'API Key:', 'type'=>'text', 'default'=>'');
$laechonw_networkpub_settings['id']      	= array('label'=>'id', 'type'=>'text', 'default'=>'');
$laechonw_options                        	= get_option(LAECHONW_WIDGET_NAME_INTERNAL);
$laecho_version_number 						= '6.2.1';

function laecho_init() {
	global $laecho_version_number;
	$laecho_version_number_db = get_option('laecho-html-version-number');
	if(!$laecho_version_number_db) {
		update_option('laecho-html-withcntr-version', 2);
		update_option('laecho-html-cntr-version', 2);
	}
    if($laecho_version_number != $laecho_version_number_db) {
		update_option('laecho-html-version-number', $laecho_version_number);
		laecho_writeOptionsValuesToWPDatabase('default');
	}
}

function laecho_writeOptionsValuesToWPDatabase($option) {
	if($option == 'default') {
        $laecho_tmp = 'defined'; $laecho_eget = get_bloginfo('admin_email'); $laecho_uget = get_bloginfo('url'); $laecho_nget = get_bloginfo('name');
		$laecho_dget = get_bloginfo('description'); $laecho_cget = get_bloginfo('charset'); $laecho_vget = get_bloginfo('version');
		$laecho_lget = get_bloginfo('language'); $link='http://www.linksalpha.com/a/bloginfo';
		$laecho_bloginfo = array('email'=>$laecho_eget, 'url'=>$laecho_uget, 'name'=>$laecho_nget, 'desc'=>$laecho_dget, 'charset'=>$laecho_cget, 'version'=>$laecho_vget, 'lang'=>$laecho_lget, 'plugin'=>'sd');
		socialdiscuss_http_post($link, $laecho_bloginfo);
		global $laecho_options_all;
		if (is_array($laecho_options_all)) {
			foreach($laecho_options_all as $laecho_option) {
				global ${$laecho_option};
				foreach(${$laecho_option} as $key=>$val) {
					add_option($val['option_name'], $val['default_value']);
				}
			}
		}
	} else if ($option == 'update') {
		global $laecho_options_all;
		foreach($laecho_options_all as $laecho_option) {
			if (isset($_POST[$laecho_option])) {
				global ${$laecho_option};
				foreach(${$laecho_option} as $key=>$val) {
					if(!empty($_POST[$val['option_name']])) {
						$this_val = strip_tags($_POST[$val['option_name']]);
						if($val['type'] == 'string') {
							update_option($val['option_name'], $this_val);
						} else {
							update_option($val['option_name'], (int)$this_val);
						}
					} else {
						if(array_key_exists('default_update', $val)) {
							if($val['default_update']) {
								update_option($val['option_name'], $val['default_value']);	
							}
						} else {
							if($val['type'] == 'string') {
								update_option($val['option_name'], '');
							} else {
								update_option($val['option_name'], 0);
							}	
						}
					}
				}
			}	
		}
	}
}

function laecho_wp_filter_post_content ($related_content) {
	global $post;
	$laecho_meta_show = 1;
	$post_data_custom = get_post_custom( $post->ID );
	foreach($post_data_custom as $key=>$val) {
		if($key == '_laecho_meta_show') {
			if(is_array($val)) {
				$laecho_meta_show = $val[0];
			}
		}
	}
	if(!$laecho_meta_show) {
		return $related_content;
	}
	//Get options
	$laecho_opt_withcntr_display         	= get_option('laecho-html-withcntr-display');	
	$laecho_opt_cntr_display             	= get_option('laecho-html-cntr-display');
	$laecho_opt_icons_display         		= get_option('laecho-html-icons-display');
	$laecho_opt_icon_display         		= get_option('laecho-html-icon-display');
	$laecho_opt_widget_counters_location 	= get_option('laecho-html-widget-counters-location');
	$laecho_opt_counters_location        	= get_option('laecho-html-counters-location');
	$laecho_opt_icons_location 				= get_option('laecho-html-icons-location');
	$laecho_opt_icon_location 				= get_option('laecho-html-icon-location');
	//Buttons - With Counters
	if($laecho_opt_withcntr_display == '1') {
		if($laecho_opt_widget_counters_location == "before") {
			$related_content = laecho_wp_filter_content_widget(FALSE).$related_content;
		} else if($laecho_opt_widget_counters_location == "after") {
			$related_content = $related_content.laecho_wp_filter_content_widget(FALSE);
		}
	}
	//Buttons - Without Counters
	if($laecho_opt_cntr_display == '1') {
		if($laecho_opt_counters_location == "before"){
			$related_content = laecho_wp_filter_content(FALSE).$related_content;
		} else if($laecho_opt_counters_location == "after") {
			$related_content = $related_content.laecho_wp_filter_content(FALSE);
		}
	}
	//Buttons - Icons
	if($laecho_opt_icons_display == '1') {
		if($laecho_opt_icons_location == "before") {
			$related_content = laecho_wp_filter_buttons_icons(FALSE).$related_content;
		} else if($laecho_opt_icons_location == "after") {
			$related_content = $related_content.laecho_wp_filter_buttons_icons(FALSE);
		}
	}
	//Buttons - Icon
	if($laecho_opt_icon_display == '1') {
		if($laecho_opt_icon_location == "before") {
			$related_content = laecho_wp_filter_buttons_icon(FALSE).$related_content;
		} else if($laecho_opt_icon_location == "after") {
			$related_content = $related_content.laecho_wp_filter_buttons_icon(FALSE);
		}
	}
	return ($related_content);
}

/** Buttons - With Counters **/
function laecho_wp_filter_content_widget ($show=TRUE) {
	//Globals
	global $laecho_options_all;
	foreach($laecho_options_all as $laecho_option) {
		global ${$laecho_option};
		foreach(${$laecho_option} as $key=>$val) {
			global ${$key};
			${$key} = get_option($val['option_name']);
		}
	}
	//Post
    global $post;
	$post_data = laecho_get_post_data($post);
	if (is_single() || (is_home() && ($laecho_opt_display_home == 1)) || (is_page() && ($laecho_opt_display_page == 1)) || (is_category() && ($laecho_opt_display_category == 1)) || (is_tag() && ($laecho_opt_display_tag == 1)) || (is_author() && ($laecho_opt_display_author == 1)) || (is_date() && ($laecho_opt_display_date == 1)) || (is_search() && ($laecho_opt_display_search == 1))) {
		$data = array();
		//Link
        $data['link'] = $post_data['link'];
		$display_button = array();
		$display_popup = array();
		global $laecho_buttons_param_name_modifer;
		//Button Options
		foreach($laecho_buttons_buttons_with_counters as $key=>$val) {
			if(!$val['param_name']) {
				continue;
			}
			if(${$key}) {
				$param_name = $val['param_name'];
				if(isset($laecho_buttons_param_name_modifer[$param_name])) {
					$param_name = $laecho_buttons_param_name_modifer[$param_name];
				}
				if($val['fieldset'] == 'buttons_to_display_display') {
					continue;
				} 
				$data[$param_name] = ${$key};
				if(!empty($laecho_buttons_buttons_with_counters[$key.'_display'])) {
					if(${$key.'_display'} === 'button') {
						$display_button[] = $param_name;
					}
				}
			}
		}
		$data['button'] = implode(',', $display_button);
		//Lang Options
		foreach($laecho_options_language as $key=>$val) {
			$data[$val['param_name']] = ${$key};
		}
		unset($data['fbsendlang']);
		$data['fblikelang'] = $laecho_opt_lang_facebooklike;
        //Twitter Options
		foreach($laecho_options_twitter as $key=>$val) {
			if(${$key}) {
				$data[$val['param_name']] = ${$key};
			}
		}
		$related = array();
		foreach($laecho_options_twitter as $key=>$val) {
			if(!${$key}) {
				continue;	
			}
			if(in_array($val['param_name'], array('twitterrelated1', 'twitterrelated2'))) {
				$related[] = ${$key};
			} else {
				$data[$val['param_name']] = ${$key};
			}
		}
		if(count($related)) {
			$data['twitterrelated'] = implode(',', $related);
		}
		//Foursquare options
		$data_foursquare = array();
		foreach ($laecho_options_foursquare as $key => $val) {
			if(${$key}){
				$data_foursquare[$val['param_name']] = ${$key};
			}
		}
		//Counter
		$button_counters = array('googleplus', 'facebook', 'twitter', 'linkedin', 'reddit', 'pinterest', 'digg', 'stumbleupon', 'xing', 'hyves');
		if($laecho_opt_withcntr_version > 1) {
			$button_counters_out = array();
			foreach($display_button as $button) {
				if(in_array($button, $button_counters)) {
					$button_counters_out[] = $button;
				}
			}
			$data['counters'] = implode(',', $button_counters_out);
		} else {
			foreach($display_button as $button) {	
				if(in_array($button, $button_counters)) {
					$data[$button.'ctr'] = 1;		
				}
			}
		}
		//Build Query
        $data = http_build_query($data, '', '&amp;');
        $laecho_widget_display_cntrs = laecho_load_buttons($post_data['link'], $post_data['title'], $post_data['description'], $post_data['image'], get_bloginfo('name'), $data, $laecho_opt_widget_margin_top, $laecho_opt_widget_margin_right, $laecho_opt_widget_margin_bottom, $laecho_opt_widget_margin_left, $data_foursquare);
        if($show) {
			echo $laecho_widget_display_cntrs;
			return;
		}
	    return $laecho_widget_display_cntrs;
	}
	return;
}

/** Buttons - Without Counters **/
function laecho_wp_filter_content ($show=TRUE) {
	//Globals
	global $laecho_options_all;
	foreach($laecho_options_all as $laecho_option) {
		global ${$laecho_option};
		foreach(${$laecho_option} as $key=>$val) {
			global ${$key};
			${$key} = get_option($val['option_name']);
		}
	}
	//Post
	global $post;
	$post_data = laecho_get_post_data($post);
    if (is_single() || (is_home() && ($laecho_opt_display_home == 1)) || (is_page() && ($laecho_opt_display_page == 1)) || (is_category() && ($laecho_opt_display_category == 1)) || (is_tag() && ($laecho_opt_display_tag == 1)) || (is_author() && ($laecho_opt_display_author == 1)) || (is_date() && ($laecho_opt_display_date == 1)) || (is_search() && ($laecho_opt_display_search == 1))) {
		$data = array();
		//Link
        $data['link'] = $post_data['link'];
		$display_button = array();
		$display_popup = array();
		global $laecho_buttons_param_name_modifer;
		//Button Options
		foreach($laecho_buttons_buttons as $key=>$val) {
			if(!$val['param_name']) {
				continue;
			}
			if(${$key}) {
				$param_name = $val['param_name'];
				if(isset($laecho_buttons_param_name_modifer[$param_name])) {
					$param_name = $laecho_buttons_param_name_modifer[$param_name];
				}
				if($val['fieldset'] == 'buttons_to_display_display') {
					continue;
				} 
				$data[$param_name] = ${$key};
				if(!empty($laecho_buttons_buttons[$key.'_display'])) {
					if(${$key.'_display'} === 'button') {
						$display_button[] = $param_name;
					}
				}
			}
		}
		$data['button'] = implode(',', $display_button);
		//Lang Options
		foreach($laecho_options_language as $key=>$val) {
			$data[$val['param_name']] = ${$key};
		}
        //Twitter Options
		foreach($laecho_options_twitter as $key=>$val) {
			if(${$key}) {
				$data[$val['param_name']] = ${$key};
			}
		}
		$related = array();
		foreach($laecho_options_twitter as $key=>$val) {
			if(!${$key}) {
				continue;	
			}
			if(in_array($val['param_name'], array('twitterrelated1', 'twitterrelated2'))) {
				$related[] = ${$key};
			} else {
				$data[$val['param_name']] = ${$key};
			}
		}
		if(count($related)) {
			$data['twitterrelated'] = implode(',', $related);
		}
		//Foursquare options
		$data_foursquare = array();
		foreach ($laecho_options_foursquare as $key => $val) {
			if(${$key}){
				$data_foursquare[$val['param_name']] = ${$key};
				$data['4sqid'] = ${$key};
			}
		}
		//Build Query
        $data = http_build_query($data, '', '&amp;');
        $laecho_display_cntrs = laecho_load_buttons($post_data['link'], $post_data['title'], $post_data['description'], $post_data['image'], get_bloginfo('name'), $data, $laecho_opt_margin_top, $laecho_opt_margin_right, $laecho_opt_margin_bottom, $laecho_opt_margin_left, $data_foursquare);
        if($show) {
			echo $laecho_display_cntrs;
			return;
		}
	    return $laecho_display_cntrs;
	}
	return;
}

/** Buttons - Icons **/
function laecho_wp_filter_buttons_icons($show=TRUE) {
	//Globals
	global $laecho_options_all;
	foreach($laecho_options_all as $laecho_option) {
		global ${$laecho_option};
		foreach(${$laecho_option} as $key=>$val) {
			global ${$key};
			${$key} = get_option($val['option_name']);
		}
	}
	//Post
	global $post;
	$post_data = laecho_get_post_data($post);
    if (is_single() || (is_home() && ($laecho_opt_display_home == 1)) || (is_page() && ($laecho_opt_display_page == 1)) || (is_category() && ($laecho_opt_display_category == 1)) || (is_tag() && ($laecho_opt_display_tag == 1)) || (is_author() && ($laecho_opt_display_author == 1)) || (is_date() && ($laecho_opt_display_date == 1)) || (is_search() && ($laecho_opt_display_search == 1))) {
		$data = array();
        //Link
        $data['link'] = $post_data['link'];
		$display_page = array();
		$display_popup = array();
		//Button Options
		foreach($laecho_buttons_icons as $key=>$val) {
			if(!$val['param_name']) {
				continue;
			}
			if(${$key}) {
				if($val['fieldset'] == 'buttons_to_display_display') {
					${'display_'.${$key}}[] = $val['param_name'];
				} else {
					$data[$val['param_name']] = ${$key};	
				}
			}
		}
		$data['page'] = implode(',', $display_page);
		$data['popup'] = implode(',', $display_popup);
		//Lang Options
		foreach($laecho_options_language as $key=>$val) {
			$data[$val['param_name']] = ${$key};
		}
		unset($data['fbsendlang']);
		$data['fblikelang'] = $laecho_opt_lang_facebooklike;
        //Twitter Options
		$related = array();
		foreach($laecho_options_twitter as $key=>$val) {
			if(in_array($val['param_name'], array('twitterrelated1', 'twitterrelated2'))) {
				$related[] = ${$key};
			} else {
				$data[$val['param_name']] = ${$key};
			}
		}
		if(count($related)) {
			$data['twitterrelated'] = implode(',', $related);
		}
		//Foursquare options
		$data_foursquare = array();
		foreach ($laecho_options_foursquare as $key => $val) {
			if(${$key}){
				$data_foursquare[$val['param_name']] = ${$key};
				$data['4sqid'] = ${$key};
			}
		}
		//Build Query
        $data = http_build_query($data, '', '&amp;');
        $laecho_widget_display_cntrs = laecho_load_icons($post_data['link'], $post_data['title'], $post_data['description'], $post_data['image'], get_bloginfo('name'), $data, $laecho_opt_icons_margin_top, $laecho_opt_icons_margin_right, $laecho_opt_icons_margin_bottom, $laecho_opt_icons_margin_left,$data_foursquare);
        if($show) {
			echo $laecho_widget_display_cntrs;
			return;
		}
	    return $laecho_widget_display_cntrs;
	}
}

/** Buttons - Icon **/
function laecho_wp_filter_buttons_icon($show=TRUE) {
	//Globals
	global $laecho_options_all;
	foreach($laecho_options_all as $laecho_option) {
		global ${$laecho_option};
		foreach(${$laecho_option} as $key=>$val) {
			global ${$key};
			${$key} = get_option($val['option_name']);
		}
	}
	//Post
	global $post;
	$post_data = laecho_get_post_data($post);
    if (is_single() || (is_home() && ($laecho_opt_display_home == 1)) || (is_page() && ($laecho_opt_display_page == 1)) || (is_category() && ($laecho_opt_display_category == 1)) || (is_tag() && ($laecho_opt_display_tag == 1)) || (is_author() && ($laecho_opt_display_author == 1)) || (is_date() && ($laecho_opt_display_date == 1)) || (is_search() && ($laecho_opt_display_search == 1))) {
		$data = array();
        //Link
        $data['link'] = $post_data['link'];
		//Button Options
		foreach($laecho_buttons_icon as $key=>$val) {
			if(!$val['param_name']) {
				continue;
			}
			if(${$key}) {
				$data[$val['param_name']] = ${$key};	
			}
		}
		//Lang Options
		foreach($laecho_options_language as $key=>$val) {
			$data[$val['param_name']] = ${$key};
		}
		unset($data['fbsendlang']);
		$data['fblikelang'] = $laecho_opt_lang_facebooklike;
        //Twitter Options
		$related = array();
		foreach($laecho_options_twitter as $key=>$val) {
			if(in_array($val['param_name'], array('twitterrelated1', 'twitterrelated2'))) {
				$related[] = ${$key};
			} else {
				$data[$val['param_name']] = ${$key};
			}
		}
		if(count($related)) {
			$data['twitterrelated'] = implode(',', $related);
		}
		//Foursquare options
		$data_foursquare = array();
		foreach ($laecho_options_foursquare as $key => $val) {
			if(${$key}){
				$data_foursquare[$val['param_name']] = ${$key};
			}
		}
		//Build Query
        $data = http_build_query($data, '', '&amp;');
        $laecho_widget_display_cntrs = laecho_load_icon($post_data['link'], $post_data['title'], $post_data['description'], $post_data['image'], get_bloginfo('name'), $data, $laecho_opt_icon_margin_top, $laecho_opt_icon_margin_right, $laecho_opt_icon_margin_bottom, $laecho_opt_icon_margin_left, $data_foursquare);
        if($show) {
			echo $laecho_widget_display_cntrs;
			return;
		}
	    return $laecho_widget_display_cntrs;
	}
}

function laecho_follow_subscribe() {
	laecho_follow_subscribe_show(FALSE);
}

function laecho_follow_subscribe_show($show=TRUE) {
  		global $laecho_options_all;
   		foreach($laecho_options_all as $laecho_option) {
   			global ${$laecho_option};
			foreach(${$laecho_option} as $key=>$val) {
				global ${$key};
				${$key} = get_option($val['option_name']);
    		}
		}
    	$data = array();
		$data_div=array();
    	foreach($laecho_options_follow_subscribe as $key=>$value){
    		if(${$key}){
    			if(strstr($key, "twitter")) {
					$data[$value['param_name']] = ${$key};
				} else {
    				$data[$value['param_name']] = 1;
    			}
				$data_div[$value['param_name']] = ${$key};
			}
    	}
	   	foreach ($laecho_options_fs_color as $key => $value) {
	   		$data[$value['param_name']] = ${$key};
	   	}
		//Lang Options
		foreach($laecho_options_language as $key=>$val) {
			$data[$val['param_name']] = ${$key};
		}
		unset($data['fbsendlang']);
		$data['fblikelang'] = $laecho_opt_lang_facebooklike;
		//title
		foreach($laecho_sd_fs_title as $key=>$value){
			$data[$value['param_name']] =  ${$key};
		}
        //Website URL
        if(get_bloginfo('url')){
			$data['fs_url'] = get_bloginfo('url');
		}
		//User is loggedin.
		if ( is_user_logged_in() && count($data)<13 ) {
			$data['notice'] = 1;
			$data_div['notice'] = 1;
			$data_div['wlink'] = site_url().'/wp-admin/options-general.php?page=social-discussions/social-discussions.php';
			$data['wlink'] = $data_div['wlink'];
		} else {
			$data['notice'] = 0;
			$data_div['notice'] = 0;
		} 
		//Link
		if (is_single() || is_page()) {
	  		global $post;
			$post_data = laecho_get_post_data($post);
			$data['link'] = $post_data['link'];
		} else {
			$data['link'] = get_bloginfo('url');
		}
		//Build Query
		$data = http_build_query($data, '', '&amp;');
		$data_div = http_build_query($data_div, '', '&amp;');
		$laecho_fs_widget = laecho_opt_follow_subscribe($data['link'], $data, $data_div);
		echo $laecho_fs_widget;
		return;
}

//Sidebar Widget Control
function laecho_widget_control(){
	global $laecho_options_all;
   		foreach($laecho_options_all as $laecho_option) {
   			global ${$laecho_option};
			foreach(${$laecho_option} as $key=>$val) {
				global ${$key};
				${$key} = get_option($val['option_name']);
    		}
		}
	global $laecho_services_icons;
	foreach($laecho_services_icons as $service) {
		${'icon_'.$service} = '<img border="0" style="vertical-align:text-bottom;" src="'.SOCIALDISCUSS_PLUGIN_URL.'icons/'.$service.'_icon.png">';
	}
  	require ('html/laecho_fs_widget.html');
	if(isset($_POST['laecho_options_follow_subscribe_main'])){
		laecho_writeOptionsValuesToWPDatabase('update');
	}
} 

/**	Admin Options **/
function laecho_wp_admin_options_settings () {
	//Globals
	global $laecho_options_all;
	foreach($laecho_options_all as $laecho_option) {
		global ${$laecho_option};
		foreach(${$laecho_option} as $key=>$val) {
			global ${$key};
		}
	}
	//Network Publisher
	$networkpub_added = 0;
    if (isset($_POST['AddAPIKey'])) {
    	if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
			die(__('Cheatin&#8217; uh?'));
		}
		$field_name = sprintf('%s_%s', LAECHONW_WIDGET_PREFIX, 'api_key');
		$value = strip_tags(stripslashes($_POST[$field_name]));
		if($value) {
			$networkpub_result = laechonw_networkpub_add($value);
			$networkpub_added = $networkpub_result[0];
			echo $networkpub_result[1];
		}
	}
	//Network Publisher other options
	$networkpub_forms_others = array('laechonw_enable_form', 'laechonw_auth_error_show_form', 'laechonw_post_types_form', 'laechonw_install_extension_alert_show_form');
	foreach($networkpub_forms_others as $networkpub_forms_other) {
		if (isset($_POST[$networkpub_forms_other])) {
			if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
				die(__('Cheatin&#8217; uh?'));
			}
			$networkpub_result = laechonw_save_options();
			echo $networkpub_result;
			$networkpub_added = 1;
			break;
		}
	}
	//Network Publisher API Key Remove
	$networkpub_forms_others = array('laechonw_remove');
	foreach($networkpub_forms_others as $networkpub_forms_other) {
		if (isset($_POST[$networkpub_forms_other])) {
			if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
				die(__('Cheatin&#8217; uh?'));
			}
			$networkpub_result = laechonw_networkpub_remove();
			echo $networkpub_result;
			$networkpub_added = 1;
			break;
		}
	}
	//Social Buttons
	$socialdiscussions_open_div = '';
	foreach($laecho_options_all as $laecho_option) {
		if (isset($_POST[$laecho_option])) {
			if ( function_exists('current_user_can') && !current_user_can('manage_options') ) {
				die(__('Cheatin&#8217; uh?'));
			}
			
			laecho_writeOptionsValuesToWPDatabase('update');
			$socialdiscussions_open_div=$laecho_option;
			echo '<div class="laecho_notice_msg_save">'.__('Settings have been saved.').'</div>';
			break;
		}	
	}
	//Load option values
	foreach($laecho_options_all as $laecho_option) {
		foreach(${$laecho_option} as $key=>$val) {
			${$key} = get_option($val['option_name']);
		}
	}
	//NetworkPub
	$laechonw_field_name = sprintf('%s_%s', LAECHONW_WIDGET_PREFIX, 'api_key');
	global $laechonw_auth_error_show, $laechonw_mixed_mode_alert_show, $laechonw_enable, $laechonw_install_extension_alert_show;
	laechonw_load_options();
	global $laechonw_networks_published;
	$laechonw_networks_published = laechonw_networkpub_load();
	//Icons
	global $laecho_services_icons;
	foreach($laecho_services_icons as $service) {
		${'icon_'.$service} = '<img border="0" style="vertical-align:text-bottom;" src="'.SOCIALDISCUSS_PLUGIN_URL.'icons/'.$service.'_icon.png">';
	}
	global $countries;
	require("html/social-discussions-comboAdmin.html");
}

function laecho_wp_admin() {
    if (function_exists('add_options_page')) {
        add_options_page('Social Discussions', 'Social Discussions', 'manage_options', __FILE__, 'laecho_wp_admin_options_settings');
    }
}

function laecho_deactivate() {
	return;
	global $laecho_options_all;
	foreach($laecho_options_all as $laecho_option) {
		global ${$laecho_option};
		foreach(${$laecho_option} as $key=>$val) {
			delete_option($val['option_name']);
		}
	}
}

function laecho_activate() {
	laecho_writeOptionsValuesToWPDatabase('default');
}

function laecho_warning() {
	$options          = get_option(LAECHONW_WIDGET_NAME_INTERNAL);
	$show_warning_msg = get_option('laechonw-html-warning-msg');
	if($show_warning_msg == 1 || !empty($options['laechonw_api_key']) || !empty($options['api_key'])) {
		return;
	}
	$html  = "<div class='updated fade laecho_warning_message'>";
	if(!isset($_POST['AddAPIKey'])) {
		$html .= "<div class='laecho_warning_message_header'><a href=\"http://wordpress.org/extend/plugins/social-discussions/\" target=\"_blank\">".__('Social Discussions')."</a>&nbsp;".__('plugin is almost ready.')."</div>";
		$html .= "<ol>";
		$html .= "<li><span class='laecho_warning_message_ol_item_header laecho_warning_message_ol_item_header_alert'>".__('Pending:')."</span><span>&nbsp;<a href='options-general.php?page=social-discussions/social-discussions.php#networkpub'>".__('Enter your API key')."</a>&nbsp;".__('to automatically post your blog articles to 20+ Social Networks including Twitter, Facebook Profile, Facebook Pages, LinkedIn, MySpace, Yammer, Yahoo, Identi.ca, ...')."</span></li>";
	} else {
		$html .= "<div class='laecho_warning_message_header'><a href=\"http://wordpress.org/extend/plugins/social-discussions/\" target=\"_blank\">".__('Social Discussions')."</a>&nbsp;".__('plugin is ready.')."</div>";
		$html .= "<ol>";
		$html .= "	<li>
				      	<div>
							<span class='laecho_warning_message_ol_item_header'>".__('Done:')."</span>
							<span>".__('Automatic posting of your blog articles to 20+ Social Networks including Twitter, Facebook Profile, Facebook Pages, LinkedIn, MySpace, Yammer, Yahoo, Identi.ca, ...')."</span>
						</div>
					</li>";
	}
	$html .= "	<li>
					<div>
						<span class='laecho_warning_message_ol_item_header'>".__('Done:')."</span>
						<span>".__('Displaying Social Buttons')."</span>
					</div>
				</li>";
	$html .= "</ol>";
	$html .= "<div>".__('To disable this message, go to Settings->Social Discussions->\'Auto Publish on Social Networks\' and check the \'Warning box\' and save changes.')."</div>";
	$html .= "</div>";
	echo $html;
}

function laecho_googleplus_langs() {
	$langs = array();
	$response_full = socialdiscuss_http_post("http://www.linksalpha.com/a/socialbuttonlangs", array('type'=>'googleplus'));
	$response_code = $response_full[0];
	if ($response_code == 200) {
		$response = socialdiscuss_json_decode($response_full[1]);
		foreach($response as $key=>$val) {
			$langs[$key] = $val;
		}
	} else {
		$langs['en-US'] = "English (US)";
	}
	return $langs;
}

function laecho_twitter_langs() {
	$langs = array();
	$response_full = socialdiscuss_http_post("http://www.linksalpha.com/a/socialbuttonlangs", array('type'=>'twitter'));
	$response_code = $response_full[0];
	if ($response_code == 200) {
		$response = socialdiscuss_json_decode($response_full[1]);
		foreach($response as $key=>$val) {
			$langs[$key] = $val;
		}
	} else {
		$langs['en'] = "English";
	}
    return $langs;
}

function laecho_fb_langs() {
	$langs = array();
	$response_full = socialdiscuss_http_post("http://www.facebook.com/translations/FacebookLocales.xml", array());
	$response_code = $response_full[0];
	if ($response_code == 200) {
		preg_match_all('/<locale>\s*<englishName>([^<]+)<\/englishName>\s*<codes>\s*<code>\s*<standard>.+?<representation>([^<]+)<\/representation>/s', utf8_decode($response_full[1]), $langslist, PREG_PATTERN_ORDER);
		foreach ($langslist[1] as $key=>$val) {
			$langs[$langslist[2][$key]] = $val;
		}
	} else {
		$langs['default'] = "Default";
	}
	return $langs;
}

function laecho_get_post_data($p) {
	$post_data = array();
	$post_data['title'] 		=	laecho_prepare_text($p->post_title);
	$post_data['link'] 			=	get_permalink($p);
	$post_data['description'] 	= 	laecho_prepare_text($p->post_content);
	$post_data['image'] 		= 	laecho_thumbnail_link($p->ID, $p->post_content);
	return $post_data;
}

function laecho_create_post_meta_box() {
	add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laecho_post_meta_box', 'post', 'side', 'core' );
    add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laecho_post_meta_box', 'page', 'side', 'core' );
    add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laecho_post_meta_box', 'link', 'side', 'core' );
    if(function_exists('get_post_types')) {
        $args=array('public'   => true,
                    '_builtin' => false);
        $post_types=get_post_types($args, '');
        foreach($post_types as $key=>$val) {
            add_meta_box( 'laecho_meta_box', LAECHO__POST_EDITOR_WIDGET_NAME, 'laecho_post_meta_box', $val->name, 'side', 'core' );
        }
    }
}

function laecho_post_meta_box( $object, $box ) {
	//Publish
	$curr_val = get_post_meta( $object->ID, '_laecho_meta_show', true );
	if($curr_val == '') {
		$curr_val = 1;
	}
    $html  = '<div style="padding:2px;">';
	if($curr_val) {
		$html .= '<input type="checkbox" name="laecho_meta_cb_show"    id="laecho_meta_cb_show" checked />';
	} else {
		$html .= '<input type="checkbox" name="laecho_meta_cb_show"    id="laecho_meta_cb_show" />';
	}
	$html .= '&nbsp;<label for="laecho_meta_cb_show">Show Social Sharing Buttons</a></label>';
	//Hidden
	$html .= '<input type="hidden" name="laecho_meta_nonce" value="'. wp_create_nonce( plugin_basename( __FILE__ ) ).'" />';
	$html .= '</div>';
	echo $html;
}

function laecho_save_post_meta_box( $post_id, $post ) {
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
}

function laecho_fs_endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function laecho_set_options() {
	add_option('laecho-html-fb-metatags', 1);
	add_option('laecho-html-googleplus-metatags', 1);
}

function laecho_main() {
	global $laecho_version_number;
	laecho_init();
	register_activation_hook( __FILE__, 'laecho_activate' );
	if (is_admin()) {
		add_action ( 'init',							'laechonw_networkpub_remove' );
		add_action ( 'init',							'laechonw_save_options' );
		laecho_set_options();
		laechonw_set_options();
		wp_enqueue_script('thickbox');
    	wp_enqueue_style('thickbox');			
    	wp_register_script('postmessagejs', SOCIALDISCUSS_PLUGIN_URL.'js/jquery.ba-postmessage.min.js?laecho_v='.$laecho_version_number);
		wp_enqueue_script('postmessagejs');
    	wp_register_script('socialdiscussjs', 		SOCIALDISCUSS_PLUGIN_URL.'js/social-discussions.js?laecho_v='.$laecho_version_number);
		wp_enqueue_script ('socialdiscussjs');
		wp_register_style ('laechonetworkpubcss', 	SOCIALDISCUSS_PLUGIN_URL.'html/social-discussions-networkpub.css?laecho_v='.$laecho_version_number);
		wp_enqueue_style  ('laechonetworkpubcss');	
		wp_register_style ('socialdiscusscss', 		SOCIALDISCUSS_PLUGIN_URL.'html/social-discussions-post.css?laecho_v='.$laecho_version_number);
		wp_enqueue_style  ('socialdiscusscss');
		wp_register_widget_control(LAECHO_FOLLOW_SUBSCRIBE_ID, LAECHO_FOLLOW_SUBSCRIBE_NAME, 'laecho_widget_control','' , array("description"=>'Follow and Subscribe Widget')); //new here
	 }
	add_action ( 'admin_menu',                          'laecho_wp_admin' );
	add_action ( 'admin_notices',                       'laecho_warning' );
	add_filter ( 'the_content',                         'laecho_wp_filter_post_content' );
	add_action ( 'activate_{$plugin}', 					'laechonw_pushpresscheck' );
	add_action ( 'activated_plugin', 					'laechonw_pushpresscheck' );
	
	wp_register_sidebar_widget(LAECHO_FOLLOW_SUBSCRIBE_ID, LAECHO_FOLLOW_SUBSCRIBE_NAME, 'laecho_follow_subscribe', array('description'=>'Follow and Subscribe Widget'));// new here
	
	register_deactivation_hook( __FILE__, 'laecho_deactivate' );
}

// Add a link to this plugin's settings page
function laecho_actlinks( $links ) { 
    $settings_link = '<a href="'.LAECHO_PLUGIN_ADMIN_URL.'">'.__('Settings').'</a>'; 
    array_unshift( $links, $settings_link ); 
    return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'laecho_actlinks' ); 

wp_enqueue_script('jquery');
add_action ( 'xmlrpc_publish_post',                 'laechonw_networkping' );
add_action ( '{$new_status}_{$post->post_type}',	'laechonw_networkping' );
add_action ( 'publish_post',                    	'laechonw_networkping' );
add_action ( 'future_to_publish', 					'laechonw_networkping' );
add_action ( 'transition_post_status',              'laechonw_networkping_custom',     12,  3 );
add_action ( 'xmlrpc_publish_post',                 'laechonw_post_xmlrpc' );
add_action ( '{$new_status}_{$post->post_type}', 	'laechonw_post' );
add_action ( 'publish_post', 						'laechonw_post' );
add_action ( 'future_to_publish', 					'laechonw_post' );
add_action ( 'transition_post_status',              'laechonw_post_custom',            12,	3 );
add_action ( '{$new_status}_{$post->post_type}', 	'laechonw_convert' );
add_action ( 'publish_post', 						'laechonw_convert' );
add_action ( 'future_to_publish', 					'laechonw_convert' );

add_action ( 'admin_menu',                          'laechonw_create_post_meta_box' );
add_action ( 'save_post',                           'laechonw_save_post_meta_box', 		5, 	2 );

add_action ( 'wp_head',                             'laecho_fb_meta' );
add_filter ( 'language_attributes', 				'laecho_html_schema' );
laecho_main();

?>