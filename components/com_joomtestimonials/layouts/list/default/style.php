<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

// Inits
$doc            = JFactory::getDocument();
$params   = LayoutHelper::getListLayoutParams();
$layoutparams   = $params->get('layoutparams');

$tagid          = isset($displayData['tagid']) && !empty($displayData['tagid']) ? $displayData['tagid'] : '';
$css			= '';

// Layout params
$vote_position		= (int) $layoutparams->get('rating_position',0);
$font_size			= (int) $layoutparams->get('font_size');
$text_color			= $layoutparams->get('text_color');
$link_color			= $layoutparams->get('link_color','');

$avatar_size		= (int) $layoutparams->get('avatar_size', 60);
$custom_css			= implode('',(array) $layoutparams->get('custom_css'));

$type				=  $layoutparams->get('list_type', null);

// border params
$border_box_color	= $layoutparams->get('box_border_color','#dddddd');
$box_color			= $layoutparams->get('box_color','#f5f5f5');
$box_border_type	= $layoutparams->get('box_border_type','dashed');
$border_radius	= $layoutparams->get('box_border_radius','0px');

// other calculations
$info_margin	    = $avatar_size + 25;


// add custom link color not for buttons
if(!empty($link_color)){
	$css .= "$tagid .testiItem a:not(.btn){
		color: $link_color !important;
	}";
}

// if normal type (without background)
if($type == 'item-normal'){
	$css .= "		
			$tagid .testiItem{
				border: 1px $box_border_type $border_box_color;
				border-radius: $border_radius;				
			}";
}

// will show cards view style
if($type == 'item-card'){
	$css .= "$tagid .testiItem{
    				border: 1px $box_border_type $border_box_color;	
    				border-radius: $border_radius;	
					background-color: $box_color;		
				}
	";
}

// change font size and font color
if ($font_size || $text_color) {
	$basic		= '';

	if ($font_size) {
		$basic	.= 'font-size: ' . $font_size . "px;\n";
	}

	if ($text_color) {
		$basic .= 'color: ' . $text_color . ";\n";
	}

	$css	.= "
		$tagid .defaultTestimonials .testimonialsContainer {
			$basic
		}
	";

}

// floated card type
if($type == 'item-card-floated'){
	$avatar_size = $avatar_size / 2;
	$navatar = $avatar_size + 10;
	$css .= "
			$tagid .defaultTestimonials .testi-avatar-left .testi-item .testi-quote
			, $tagid .defaultTestimonials .testi-avatar-left .testi-item .testi-name
			, $tagid .defaultTestimonials .testi-avatar-left .testi-item .testi-position{
				margin-left: 0px !important;
			}
			
			
			$tagid .defaultTestimonials .testi-avatar{
				position: absolute !important;
				border: 5px $box_border_type $box_color;
				border-radius: $border_radius;
				box-sizing: border-box;
			}
			
			$tagid .floatedcontent{
				float: right;
			    background: $box_color;
			    padding: 15px 10px;
				width: 80%;
			    width: calc(100% - {$avatar_size}px) !important;
			    padding-left: {$navatar}px;
			    box-sizing: border-box;
				min-height: 120px;
				border-radius: 5px;
				
			}
			
			$tagid .testiItem{
			text-align: left !important;
			}

			
			";


}

// inject css to header
$doc->addStyleDeclaration($css . $custom_css);