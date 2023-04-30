<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
$Layout = new JLayoutFile('list.default.default');
$layoutparams      = $this->params->get('layoutparams');

$user				= JFactory::getUser();
$canCreate			= JtAuhtoriseHelper::canCreate();


JHtml::_('bootstrap.renderModal', 'a.testi-modal');


// init params
$vote_position		= (int) $layoutparams->get('rating_position',0);
$font_size			= (int) $layoutparams->get('font_size');
$text_color			= $layoutparams->get('text_color');
$show_avatar		= (bool) $layoutparams->get('show_avatar',1);
$avatar_position	= $layoutparams->get('avatar_position', 'top') == 'top' ? 'top' : 'left';
$avatar_size		= (int) $layoutparams->get('avatar_size', 60);
$custom_css			= $layoutparams->get('custom_css')->custom_css;
$css				= '';
$type				= $layoutparams->get('list_type', 0);
$info_margin		= $avatar_size + 25;
$border_box_color	= $layoutparams->get('box_border_color','#dddddd');
$box_color			= $layoutparams->get('box_color','#f5f5f5');

// if normal will show dashed borders
if($type == 'item-normal'){
    $css .= ".testiList [class*='col-']:not(:last-child):after,.testiList [class*='span']:not(:last-child):after {
				border-left: 1px dashed {$border_box_color};
				width: 1px;
				content: '';
				display:block;
				position: absolute;
				top:0;
				bottom: 0;
				right: 0;
				min-height: 170px;
			}
			
			.testiList{
				border-bottom: 1px dashed {$border_box_color};
				margin-bottom: 0px !important;
			}";
}
// will show cards view style
if($type == 'item-cards'){
    $css .= "	.testiItem{
    				border: 1px solid {$border_box_color};		
					background-color: {$box_color};		
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
		.defaultTestimonials .testimonialsContainer {
			$basic
		}
	";
}

if($type == 'item-cards-floated'){
    $avatar_size = $avatar_size / 2;
    $navatar = $avatar_size + 10;
    $css .= "
			.defaultTestimonials .testi-avatar-left .testi-item .testi-quote
			, .defaultTestimonials .testi-avatar-left .testi-item .testi-name
			, .defaultTestimonials .testi-avatar-left .testi-item .testi-position{
				margin-left: 0px !important;
			}
			
			
			.defaultTestimonials .testi-avatar{
				position: absolute;
				border: 5px solid $box_color;
				box-sizing: border-box;
			}
			
			.floatedcontent{
				float: right;
			    background: $box_color;
			    padding: 15px 10px;
				width: 80%;
			    width: calc(100% - {$avatar_size}px);
			    padding-left: {$navatar}px;
			    box-sizing: border-box;
				min-height: 120px;
				border-radius: 5px;
				
			}
			
			";


}

if($vote_position == 2){

    $css .= "	
	.defaultTestimonials  .testi-avatar {position: relative;}
	.defaultTestimonials  .testi-vote {position: absolute;
    	bottom: -22px;
    	right: 0;
    	left: 0;
    	margin: 0 auto;
    	text-align: center;
	}";

}

if($vote_position == 3){

    $css .= "

		div.testiList:not(.testiList0){
			padding-top: 20px;
		}
	
	.defaultTestimonials  .testi-avatar {position: relative;}
	.defaultTestimonials  .testi-vote {position: absolute;
    	top: -20px;
    	right: 0;
    	left: 0;
    	margin: 0 auto;
    	text-align: center;
	}";

}

if($vote_position == 1 or $vote_position == 0){

    $css .= "
		.defaultTestimonials .testi-avatar-left .testi-vote {margin-left: {$info_margin}px;
	}
				
	";

}

// inject css to header
JFactory::getDocument()->addStyleDeclaration($css . $custom_css);

?>
<div id="jb_template">
    <div class="defaultTestimonials <?php echo $this->pageclass_sfx;?>">
        <?php if(!$this->hide_header):?>
            <?php if ($this->params->get('show_page_heading', 1)) : ?>
                <div class="page-header">
                    <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
                </div>
            <?php endif; ?>
        <?php endif;?>
        <?php if ($this->params->get('page_subheading')) : ?>
            <h2>
                <?php echo $this->escape($this->params->get('page_subheading')); ?>
            </h2>
        <?php endif; ?>
        <div class="testimonialsContainer <?php echo ($show_avatar ? ' testi-avatar-' . $avatar_position : ''); ?>">
            <?php
            echo $Layout->render(array(
                    'items' => array($this->item),
                    'params' => $this->params,
                    'layout'=>'default')
            );
            ?>
        </div>
    </div>
</div>