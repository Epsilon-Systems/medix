<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
extract($displayData);

$user = JFactory::getUser();
$canCreate = JtAuhtoriseHelper::canCreate();
$canEdit   = JtAuhtoriseHelper::canEdit($user->id);

if ($canCreate || $canEdit) {
    JHtml::_('bootstrap.renderModal', 'a.testi-modal');
}

$layoutparams = LayoutHelper::getListLayoutParams()->get('layoutparams');
$type   = $layoutparams->get('list_type', 'item-normal');

$carousel = (array)$layoutparams->get('carousel');
$bar                   = isset($carousel['bar'])? $carousel['bar'] : 1;
$navbuttons            = isset($carousel['navbuttons'])? $carousel['navbuttons'] : 1;
$next                  = isset($carousel['nav_next'])? $carousel['nav_next'] : '❯';
$prev                  = isset($carousel['nav_prev'])? $carousel['nav_prev'] : '❮';
?>

    <div class="testimonialsContainer" id="testimonialsContainer">
        <div class='testiList row w-100'>
            <div class="swiper-container" >
                <div class="swiper-wrapper" >
                    <?php foreach ($items AS $item){?>
                        <div class="<?php echo $cspan?> swiper-slide">
                            <?php
                            // load testimonial item layout
                            echo JLayoutHelper::render('list.'.$layout.'.'.$type, array(
                                'item' => $item,
                            ),
                            $basePath = JPATH_SITE.'/components/com_joomtestimonials/layouts'
                            );
                            ?>
                        </div>
                    <?php } //end of videos loops ?>
                </div>
                <?php if($bar == 2) :?><div class="swiper-scrollbar"></div> <?php endif; ?>
                <?php if($bar == 1) :?><div class="swiper-pagination"></div> <?php endif; ?>

                <?php if($navbuttons === '1') : ?>
                    <div class="swiper-button-prev"> <?php echo $nav_prev ?> </div>
                    <div class="swiper-button-next"> <?php echo $nav_next ?> </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
