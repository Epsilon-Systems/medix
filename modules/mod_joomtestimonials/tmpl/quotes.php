<?php
/**
 * @copyright	Copyright (c) 2013 - 2016 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
$document			= JFactory::getDocument();

$user				= JFactory::getUser();
$canCreate			= $user->authorise('core.create', 'com_joomtestimonials');
$canEdit			= $user->authorise('core.edit', 'com_joomtestimonials');

?>
<div id="jb_template">
	<?php if($display_list_type == 'carousel') : ?>
        <div class="<?php echo $class_sfx;?>" id="<?php echo $tagId; ?>">
            <div class="defaultTestimonials">
                <div class="testimonialsContainer">
                    <div class="testiList testiList">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
					            <?php foreach ($items as $item):?>
                                    <div style="text-align: center;" class="swiper-slide">
							            <?php
							            echo $myLayouts['testimonial']->render(array(
								            'items' => array($item),
								            'params' => $params,
                                            'layout' => substr($params->get('testimonials_layout'), 2),
                                            'canCreate' => $canCreate,
                                            'canEdit' => $canEdit
							            ));
							            ?>
                                    </div>
					            <?php endforeach; ?>
                            </div>
				            <?php
				            if($bar == 2) echo '<div class="swiper-scrollbar"></div>';
                            if($bar == 1) echo '<div class="swiper-pagination"></div>';

				            if($navbuttons == 1){ ?>
                                <div class="swiper-button-prev"><?php echo $prev ?></div>
                                <div class="swiper-button-next"><?php echo $next ?></div>
				            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php elseif($display_list_type == 'list') : ?>
        <div class="<?php echo $class_sfx;?>" id="<?php echo $tagId; ?>">
            <div class="defaultTestimonials">
                <div class="testimonialsContainer">
                    <div class='testiList testiList row <?php echo ($gutter)?$gutter:"" ?>'>
			            <?php foreach ($items AS $item){ ?>
                            <div class="<?php echo $cspan ?>">

					            <?php
					            // load testimonial item layout
					            echo $myLayouts['testimonial']->render(array(
						            'items' => array($item),
						            'params' => $params,
                                    'layout' => substr($params->get('testimonials_layout'), 2),
                                    'canCreate' => $canCreate,
                                    'canEdit' => $canEdit
					            ));
					            ?>

                            </div>

				            <?php
			            } // end of videos loops
			            ?>
                    </div>
                </div>
            </div>
        </div>
	<?php endif ?>
</div>