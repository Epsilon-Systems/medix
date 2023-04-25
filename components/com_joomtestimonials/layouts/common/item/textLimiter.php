<?php
/*8
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;
extract($displayData);
$doc	= JFactory::getDocument();

$textlimiter = (array)$params->get('item_textlimiter');
$this->text_limit	    = 	$textlimiter['text_limiter'];
$this->text_chars		= 	$textlimiter['text_amount'];
$this->text_hover		=	$textlimiter['text_full'];
$this->less_button		=	$textlimiter['less_button'];

if($this->text_limit){

    $less_button_js = '';
    $less_click_js  = '';

    if(!$this->text_hover && $this->less_button){
        $less_button_js = ".parent().find('.jtshowless').fadeToggle()";
        $less_click_js  = "$('.testimonialText .jtshowless').click(function(e){
						e.preventDefault();
						$(this).hide().parent().find('.trunctedText').toggle().next().toggle().parent().find('.jtreadmore').fadeToggle();
					});	";
    }

    if(!$this->text_hover){
        $js = "
					jQuery(document).ready(function($){
					$('.testimonialText .jtreadmore').click(function(e){
						e.preventDefault();
						$(this).hide().parent().find('.trunctedText').hide().next().fadeToggle()$less_button_js;
					});
					$less_click_js		
					});";
    }else{
        $js = "
					jQuery(document).ready(function($){
						$('.testiItem, .testimonialText, .test-item').hover(function(){				
							$(this).find('.trunctedText').toggle().next().toggle();
						});				
					});";
    }


    $doc->addScriptDeclaration($js);
}