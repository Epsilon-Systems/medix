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

// init params
$font_size			= (int) $layoutparams->get('font_size');
$text_color			= $layoutparams->get('text_color');
$show_position		= (bool) $layoutparams->get('show_position');
$link_website		= (bool) $layoutparams->get('link_website');
$custom_css			= implode('',(array) $layoutparams->get('custom_css'));


$name_color         = $layoutparams->get('name_color');

$box_color			= $layoutparams->get('box_color', '#f5f5f5');
$box_border_color	= $layoutparams->get('box_border_color', '#dddddd');
$btext_color		= $text_color ? 'color: ' . $text_color . ';' : '';


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
		$tagid .cd-timeline-content *{
			$basic
		}
	";
}

$css	.= "

	$tagid .cd-timeline-content h2{
		color: $name_color !important;
	}

	$tagid .cd-timeline-content{
		border: 1px solid {$box_border_color};
		background-color: {$box_color};		
  		box-shadow: 0 3px 0 {$box_border_color};
	}
	
	$tagid #cd-timeline::before{
		background-color: {$box_border_color};
	}
	
	@media only screen and (min-width: 1170px) {
		$tagid .cd-timeline-block:nth-child(even) .cd-timeline-content::before {
			border-right-color: {$box_border_color};
		}
		$tagid .cd-timeline-content::before {
			border-left-color: {$box_border_color};
		}		

	}
	@media only screen and (max-width: 1169px) {
	
		$tagid .cd-timeline-content::before{
			    border-right: 7px solid {$box_border_color};
		}

	}
	
	
";

// inject css to header
$doc->addStyleDeclaration($css . $custom_css);
// inject js to header
$doc->addScript('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js');