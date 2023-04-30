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
$css				= '';

// Layout params
$vote_position		= (int) $layoutparams->get('rating_position',0);
$font_size			= (int) $layoutparams->get('font_size');
$text_color			= $layoutparams->get('text_color');


$show_position		= (bool) $layoutparams->get('show_position',1);
$show_company		= (bool) $layoutparams->get('show_company',1);
$show_avatar		= (bool) $layoutparams->get('show_avatar',1);
$avatar_position	= $layoutparams->get('avatar_position_box', 'top') == 'top' ? 'top' : 'bottom';
$avatar_size		= (int) $layoutparams->get('avatar_size', 60);
$avatar_radius		= (int) $layoutparams->get('avatar_radius', 50);
$avatar_align		= $layoutparams->get('avatar_align', 'left');
$type				=  $layoutparams->get('list_type', null);
$arrow_left			= $show_avatar ? $avatar_size / 2 : 30;
$custom_css			= implode('',(array) $layoutparams->get('custom_css'));


// box params
$box_color			= $layoutparams->get('box_color', '#f5f5f5');
$box_border_color	= $layoutparams->get('box_border_color', '#dddddd');
$box_text_color		= $layoutparams->get('box_text_color');
$btext_color		= $box_text_color ? 'color: ' . $box_text_color . ';' : '';
//card params

$card_bg	= $layoutparams->get('card_bg', '');
$card_border	= $layoutparams->get('card_border', '');

// other calculations
$info_margin		= $avatar_size + 25;

if($type == 'item-card'){
	$css .= "$tagid .testiList .testiQuote{
		border: 1px solid {$card_border};
		background: $card_bg;
	}";
}

if($avatar_position == 'top'){

	$css .="		
	$tagid .testi-quote-box:after,$tagid .testi-quote-box:before{		
		top: -10px !important;
		border-width: 0 10px 10px 10px !important;
		border-style: solid;
	}
	
	$tagid .testimonialsContainer .testi-quote-box:before {
		border-color: transparent transparent {$box_border_color} transparent;
	}

	$tagid .testimonialsContainer .testi-quote-box:after {
		border-color: transparent transparent {$box_color} transparent;
	}
	
	$tagid .testi-quote-box{
		margin-top: 15px;
	}
	
	";
}else{
	$css .="
			
	$tagid .testimonialsContainer .testi-quote-box:before {
		border-top-color: $box_border_color transparent;
	}

	$tagid .testimonialsContainer .testi-quote-box:after {
		border-top-color: $box_color;
	}
			
			
			";
}

// add custom css
if ($font_size || $text_color) {
	$basic		= '';

	if ($font_size) {
		$basic	.= 'font-size: ' . $font_size . "px;\n";
	}

	if ($text_color) {
		$basic .= 'color: ' . $text_color . ";\n";
	}

	$css	.= "
		$tagid .testimonialsContainer {
			$basic
		}
	";
}

$css	.= "	
	
	$tagid .testimonialsContainer .testi-avatar {
		width: {$avatar_size}px;
		height: {$avatar_size}px;

		-webkit-border-radius: {$avatar_radius}px;
		-moz-border-radius: {$avatar_radius}px;
		border-radius: {$avatar_radius}px;
	}	

	$tagid .testimonialsContainer .testi-quote-box {
		$btext_color
		background-color: $box_color;
		border-color: $box_border_color;
	}
	
";


if($vote_position == 2){

	$css .= "
	$tagid .testi-quote-box { margin-top: 30px;}
	$tagid .defaultTestimonials  .testi-avatar {position: relative;}
	$tagid .defaultTestimonials  .testi-vote {
		position: absolute;
    	bottom: -22px;
    	right: 0;
    	left: 0;
    	margin: 0 auto;
    	text-align: center;    
	}";

}

if($vote_position == 3){

	$css .= "
	$tagid .testiQuote{ padding-top: 30px;}
	$tagid .defaultTestimonials  .testi-avatar {position: relative;}
	$tagid .defaultTestimonials  .testi-vote {
		position: absolute;
    	top: -20px;
    	right: 0;
    	left: 0;
    	margin: 0 auto;
    	text-align: center;
	}";

}


// inject css to header
$doc->addStyleDeclaration($css . $custom_css);