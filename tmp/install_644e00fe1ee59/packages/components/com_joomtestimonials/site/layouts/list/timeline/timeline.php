<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
$user				= JFactory::getUser();
$canCreate = JtAuhtoriseHelper::canCreate();
$canEdit   = JtAuhtoriseHelper::canEdit($user->id);

extract($displayData);

if ($canCreate || $canEdit) {
    JHtml::_('bootstrap.renderModal', 'a.testi-modal');
}

$type   = LayoutHelper::getListLayoutParams()->get('layoutparams')->get('list_type', 'item-normal');

?>

    <section id="cd-timeline" class="cd-container testimonialsContainer w-100">

        <?php foreach($items as $item):?>
            <?php
            // load testimonial item layout
            echo JLayoutHelper::render('list.'.$layout.'.'.$type, array(
                'item' => $item,
                'canEdit' => $canEdit,

            ),
                $basePath = JPATH_SITE.'/components/com_joomtestimonials/layouts'
            );
            ?>
        <?php endforeach; ?>

    </section>


<script type="text/javascript">

    jQuery(document).ready(function($){
        var timelineBlocks = $('.cd-timeline-block'),
            offset = 0.8;

        //hide timeline blocks which are outside the viewport
        hideBlocks(timelineBlocks, offset);

        //on scolling, show/animate timeline blocks when enter the viewport
        $(window).on('scroll', function(){
            (!window.requestAnimationFrame)
                ? setTimeout(function(){ showBlocks(timelineBlocks, offset); }, 100)
                : window.requestAnimationFrame(function(){ showBlocks(timelineBlocks, offset); });
        });

        function hideBlocks(blocks, offset) {
            blocks.each(function(){
                ( $(this).offset().top > $(window).scrollTop()+$(window).height()*offset ) && $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');
            });
        }

        function showBlocks(blocks, offset) {
            blocks.each(function(){
                ( $(this).offset().top <= $(window).scrollTop()+$(window).height()*offset && $(this).find('.cd-timeline-img').hasClass('is-hidden') ) && $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
            });
        }
    });

</script>