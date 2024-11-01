<?php

function laecho_load_buttons($link, $title, $description, $image, $site_name, $data, $margin_top, $margin_right, $margin_bottom, $margin_left, $data_foursquare) {
	$linksalpha_tag_id = 'linksalpha_tag_'.rand();
	if($image) {
        $display_cntrs = '<div style="margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px" id="'.$linksalpha_tag_id.'" class="linksalpha-email-button" data-url="'.$link.'" data-text="'. $title .'" data-desc="'. $description .'" data-image="'.$image.'" data-site="'. $site_name .'"';
    } else {
        $display_cntrs = '<div style="margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px" id="'.$linksalpha_tag_id.'" class="linksalpha-email-button" data-url="'.$link.'" data-text="'. $title .'" data-desc="'. $description .'" data-site="'. $site_name .'"';
    }
	foreach($data_foursquare as $key=>$val) {
		$display_cntrs .= ' '.$key.'="'.$val.'"';
	}
	$display_cntrs .= '></div>';
	$url = '//www.linksalpha.com/social/loader?tag_id='.$linksalpha_tag_id.'&amp;'.$data;
	$display_cntrs .= '<script type="text/javascript" src="'.$url.'"></script>';
	return $display_cntrs;
}

function laecho_load_icons($link, $title, $description, $image, $site_name, $data, $margin_top, $margin_right, $margin_bottom, $margin_left, $data_foursquare) {
	$linksalpha_tag_id = 'linksalpha_tag_'.rand();
	$style = 'margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px !important;';
	if($image) {
        $display_cntrs = '<div style="'.$style.'" id="'.$linksalpha_tag_id.'" data-url="'.$link.'" data-text="'. $title .'" data-desc="'. $description .'" data-image="'.$image.'" data-site="'. $site_name .'"';;
    } else {
        $display_cntrs = '<div style="'.$style.'" id="'.$linksalpha_tag_id.'" data-url="'.$link.'" data-text="'. $title .'" data-desc="'. $description .'" data-site="'. $site_name .'"';
    }
	foreach($data_foursquare as $key=>$val) {
		$display_cntrs .= ' '.$key.'="'.$val.'"';
	}
	$display_cntrs .= '></div>';
	$url = '//www.linksalpha.com/social/loader_icons?tag_id='.$linksalpha_tag_id.'&amp;'.$data;
	$display_cntrs .= '<script type="text/javascript" src="'.$url.'"></script>';
	return $display_cntrs;
}

function laecho_load_icon($link, $title, $description, $image, $site_name, $data, $margin_top, $margin_right, $margin_bottom, $margin_left, $data_foursquare) {
	$linksalpha_tag_id = 'linksalpha_tag_'.rand();
	$style = 'margin:'.$margin_top.'px '.$margin_right.'px '.$margin_bottom.'px '.$margin_left.'px !important;';
	if($image) {
        $display_cntrs = '<div style="'.$style.'" id="'.$linksalpha_tag_id.'" data-url="'.$link.'" data-text="'. $title .'" data-desc="'. $description .'" data-image="'.$image.'" data-site="'. $site_name .'"';
    } else {
        $display_cntrs = '<div style="'.$style.'" id="'.$linksalpha_tag_id.'" data-url="'.$link.'" data-text="'. $title .'" data-desc="'. $description .'" data-site="'. $site_name .'"';
    }
	foreach($data_foursquare as $key=>$val) {
		$display_cntrs .= ' '.$key.'="'.$val.'"';
	}
	$display_cntrs .= '></div>';
	$url = '//www.linksalpha.com/social/loader_icon?tag_id='.$linksalpha_tag_id.'&amp;'.$data;
	$display_cntrs .= '<script type="text/javascript" src="'.$url.'"></script>';
	return $display_cntrs;
}

function laecho_opt_follow_subscribe($link,$data,$data_div) {
	$linksalpha_tag_id = 'linksalpha_tag_'.rand();
	$html = '<div style="'.$style.'" id="'.$linksalpha_tag_id.'" data-url=".$link." data-fs="'.$data_div.'"></div>';
	$url = '//www.linksalpha.com/social/loader_fs?tag_id='.$linksalpha_tag_id.'&amp;'.$data;
	$html .= '<script type="text/javascript" src="'.$url.'"></script>';
	return $html;
}

?>