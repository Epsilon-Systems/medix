<?php
/**
 * @copyright	Copyright (c) 2013 - 2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
use Joomla\CMS\Factory;

defined('_JEXEC') or die;

if( !defined('DS') )  define('DS', DIRECTORY_SEPARATOR);

// Include helpers
require_once dirname(__FILE__) . '/helper.php'; // module helper
require_once JPATH_BASE . '/components/com_joomtestimonials/helpers/joomtestimonials.php'; // frontend helper
require_once JPATH_BASE . '/components/com_joomtestimonials/helpers/route.php'; // router helper
require_once JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/helpers/layout.php'; // layout helper
JLoader::register('JtAuhtoriseHelper', JPATH_SITE . '/components/com_joomtestimonials/helpers/authorise.php');

$doc = JFactory::getDocument();

JHtml::_('jquery.framework');

JLoader::register('JoomTestimonialsHelperWebasset',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/webasset.php');
JoomTestimonialsHelperWebasset::init();
JoomTestimonialsHelperWebasset::$wa->useStyle('fontawesome')->useScript('jquery-noconflict');

Factory::getApplication()->input->set('jt_modules_call_for_params', true);
Factory::getApplication()->input->set('jt_modules_context', array('layout'=>substr( $params->get('testimonials_layout'), 2), 'id'=>$module->id));

$params = LayoutHelper::getListLayoutParams();
$layoutparams = $params->get('layoutparams');
// for old version compatibility < v1.5.0 , box layout was removed and makes serious problems after updates, so this solve the issue , it's temporary, should be removed after 1 year of updates (since v1.5.1.1)
if($params->get('layout', '_:default') == '_:box'){
	$params->set('layout', '_:quote');
}

// layouts loading
$layout                         = str_replace('_:','',$params->get('testimonials_layout', '_:default'));

$pathbase                       = JPATH_SITE . '/components/com_joomtestimonials/layouts';
$myLayouts['testimonial']       = new JLayoutFile('list.'.$layout.'.'.$layout,$pathbase);
$myLayouts['testimonial.css']   = new JLayoutFile('list.'.$layout.'.style',$pathbase); // dynamic css layout

JHtml::_('stylesheet', 'media/com_joomtestimonials/list/'.$layout.'/'.$layout.'.css', false, array(), false, false, true);
JoomtestimonialsFrontendHelper::getLangjt();

$item_video  = (array)$layoutparams->get('item_video');
$video_type         = isset($item_video['video_type'])?$item_video['video_type']:0;

if($video_type) JoomtestimonialsFrontendHelper::loadVideoJs();

$items			= 	modJoomtestimonialsHelper::getItems($params);

$tagId			= 	'jtmodule-'.$module->id;
$display_list_type = $layoutparams->get('display_list_type', 'list');

if($display_list_type!='carousel') {

    // bootstrap params
    $list_columns = (array)$layoutparams->get('list_columns');
    $num_xs       =  isset($list_columns['bs_xs_columns'])?$list_columns['bs_xs_columns']:12;
    $num_sm       =  isset($list_columns['bs_sm_columns'])?$list_columns['bs_sm_columns']:6;
    $num_md       =  isset($list_columns['bs_md_columns'])?$list_columns['bs_md_columns']:4;
    $num_lg       =  isset($list_columns['bs_lg_columns'])?$list_columns['bs_lg_columns']:3;
    $num_xl       =  isset($list_columns['bs_xl_columns'])?$list_columns['bs_xl_columns']:3;
    $num_xxl      =  isset($list_columns['bs_xxl_columns'])?$list_columns['bs_xxl_columns']:3;

    $cspan        = "col-$num_xs col-sm-$num_sm col-md-$num_md col-lg-$num_lg col-xl-$num_xl col-xxl-$num_xxl";

    $gutter_x = isset($list_columns['gutter_x'])?$list_columns['gutter_x']:3;
    $gutter_y = isset($list_columns['gutter_y'])?$list_columns['gutter_y']:3;
    $gutter = "gx-$gutter_x  gy-$gutter_y";
}else{
    \Joomla\CMS\Layout\LayoutHelper::render('common.list.carousel',
        ['id' => $module->id, 'tagId' => $tagId, 'layoutparams' => $layoutparams],
        JPATH_SITE . '/components/com_joomtestimonials/layouts');

    $cspan  ='';
}


$class_sfx		= 	htmlspecialchars($params->get('class_sfx',''),ENT_COMPAT, 'UTF-8');

foreach($items as $item){
    $item->text = '';
    Factory::getApplication()->triggerEvent('onContentPrepare', array ('com_joomtestimonials.testimonial', &$item, &$item->params, 0));
}

// type param
$testi_type         =  $params->get('type','list');

// animation params
$list_animation = (array)$layoutparams->get('list_animation');
$animation      = isset($list_animation['animation'])? $list_animation['animation']: '';
$boxclass       = isset($list_animation['anim_boxclass'])? $list_animation['animation']: '';
$offset         = isset($list_animation['anim_offset'])? $list_animation['animation']: '';
$mobile         = isset($list_animation['anim_mobile'])? $list_animation['animation']: '';
$live           = isset($list_animation['anim_live'])? $list_animation['animation']: '';
$scontainer     = isset($list_animation['anim_scrollcontainer'])? $list_animation['animation']: '';


// Other params
$date_format	=   $params->get('date_format','Y-m-d');
$layout 		= 	$params->get('testimonials_layout', 'default');
$show_vote		=	$layoutparams->get('show_vote', 1);
$show_date		=	$layoutparams->get('show_date', 1);


$carousel = $layoutparams->get('carousel', array());
$bar                   = isset($carousel['bar'])? $carousel['bar'] : 1;
$navbuttons            = isset($carousel['navbuttons'])? $carousel['navbuttons'] : 1;
$next                  = isset($carousel['nav_next'])? $carousel['nav_next'] : '❯';
$prev                  = isset($carousel['nav_prev'])? $carousel['nav_prev'] : '❮';

// if textlimiter enabled
$textlimiter = (array)$layoutparams->get('item_textlimiter');
if(isset($textlimiter['text_limiter']) && $textlimiter['text_limiter']){

    // textlimiter params
    $text_chars		    = 	$textlimiter['text_amount'];
    $text_hover		    =	$textlimiter['text_full'];
    $less_button		=	$textlimiter['less_button'];

    $less_button_js = '';
    $less_click_js  = '';

    if(!$text_hover && $less_button){
        $less_button_js = ".parent().find('.jtshowless').fadeToggle()";
        $less_click_js  = "$('#$tagId .testimonialText .jtshowless').click(function(e){
						e.preventDefault();
						$(this).hide().parent().find('.trunctedText').toggle().next().toggle().parent().find('.jtreadmore').fadeToggle();
					});	";
    }

    if(!$text_hover){ // click
        $js = "
					jQuery(document).ready(function($){
					$('#$tagId .testimonialText .jtreadmore').click(function(e){
						e.preventDefault();
						$(this).hide().parent().find('.trunctedText').hide().next().fadeToggle()$less_button_js;
					});
					$less_click_js		
					});";
    }else{ // hover
        $js = "
					jQuery(document).ready(function($){
						$('#$tagId .testiItem').hover(function(){				
							$(this).find('.trunctedText').toggle().next().fadeToggle().toggleClass('fixHeightHover');			
							
						});				
					});";



        // fix for slider auto height on hover text limiter
        if($display_list_type == 'carousel'){
            $doc->addStyleDeclaration("					
			#$tagId .fullText.fixHeightHover{			
			    position: absolute;
			    z-index: 999999;
			    width: 100%;
			    height: 100%;
			    top: 0px;
			    left: 0px;
			    padding: 20px;
			    background: rgba(0, 0, 0, 0.61) !important;
                color: white !important;
                overflow-y: auto;
			}
		");
        }

    }

    $doc->addScriptDeclaration($js);
}

// load animation for testimonials
//JoomtestimonialsFrontendHelper::loadAnimation($module->id,$animation,$boxclass,$offset,$mobile,$live,$scontainer);

// load dynamic css
$myLayouts['testimonial.css']->render(array(
    'params' => $params,
    'tagid' => '#'.$tagId
));

require(JModuleHelper::getLayoutPath('mod_joomtestimonials', $params->get('testimonials_layout', '_:default')));
Factory::getApplication()->input->set('jt_modules_call_for_params', false);
Factory::getApplication()->input->set('jt_modules_context', null);

