<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

// Init injected vars
$params   = LayoutHelper::getListLayoutParams();
$layoutparams = $params->get('layoutparams');

$item   = $displayData['item'];
$layoutparams = $params->get('layoutparams');
$subLayoutparams = array('debug' => false, 'client' => 0, 'component' => 'com_joomtestimonials');

// Global params
$date_format		= $params->get('date_format','Y-m-d');

// Layout params
$list_main          = (array)$layoutparams->get('list_main');
$strip_tags         = $list_main['strip_tags'];
$permalink          = (bool) $layoutparams->get('show_permalink', 0);

// init params
$lightbox_button    = $layoutparams->get('lightbox_button','btn btn-primary');
$video_width        = $layoutparams->get('video_width','100%');
$video_height       = $layoutparams->get('video_height','225px');
$show_video			= $layoutparams->get('show_video',1);
$video_type			= $layoutparams->get('video_type',0);
$show_vote			= $layoutparams->get('show_vote',1);
$show_date			= $layoutparams->get('show_date',1);
$vote_position		= (int) $layoutparams->get('rating_position',0);
$show_position		= (bool) $layoutparams->get('show_position',1);
$show_company		= (bool) $layoutparams->get('show_company',1);
$link_website		= (bool) $layoutparams->get('link_website',0);
$show_avatar		= (bool) $layoutparams->get('show_avatar',1);
$show_cfields        = $layoutparams->get('show_cfields',1);
$cfields_position   = $layoutparams->get('cfields_position',1);
$avatar_align		= $layoutparams->get('avatar_align', 'left');
$avatar_position	= $layoutparams->get('avatar_position_box', 'top') == 'top' ? 'top' : 'bottom';
$avatar_size		= (int) $layoutparams->get('avatar_size', 60);
$arrow_left			= $show_avatar ? $avatar_size / 2 : 30;
$info_margin		= $avatar_size + 25;
$box_text_color		= $layoutparams->get('box_text_color');
$btext_color		= $box_text_color ? 'color: ' . $box_text_color . ';' : '';



// avatar layout
$avatarLayout = JLayoutHelper::render('common.item.avatar', [
    'link' => $item->avatar,
    'name' => $item->name
],null,$subLayoutparams);

// custom fields layout
$cfieldsLayout = JLayoutHelper::render('common.item.customfields', [
    'show_cfields' => $show_cfields,
    'cfields' => $item->jcfields
],null,$subLayoutparams);

// testimonial text layout with text limiter and date
$testimonialText = JLayoutHelper::render('common.item.testimonial', [
    'params' => [
        'textlimiter' =>  $layoutparams->get('item_textlimiter'),
        'strip_tags' => $strip_tags,
        'show_date' => $show_date,
        'date_format' => $date_format
    ],
    'testimonial' => $item->testimonial,
    'created'     => $item->created
],null,$subLayoutparams);

// Vote Layout
$vote = JLayoutHelper::render('common.item.vote', [
    'vote' => $item->vote,
    'inactivestar_color' => $layoutparams->get('inactivestar_color','#d2d2d2'),
    'activestar_color'   => $layoutparams->get('activestar_color','#edb867')
],null,$subLayoutparams);

$showPosition	= $show_position && $item->position;
$showCompany	= $show_company && $item->company;
?>

<div class="testiQuote testiAnimate">
    <?php echo JLayoutHelper::render('common.item.editbutton', ['item' => $item]); ?>
    <div class="testi-item testi-item-<?php echo $item->id; ?>">
        <?php if ($avatar_position != 'top'): ?>
            <div class="testi-quote-box">
                <?php if ($show_video) : ?>
                    <div class="video">
                        <?php if ($video_type) : ?>
                            <?php echo JoomtestimonialsFrontendHelper::videoBuilder($item->video, $video_width, $video_height, $video_type, $lightbox_button); ?><?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($show_vote && $vote_position == 5): ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
                <?php  if($cfields_position == 0) : // custom fields position before testimonial text ?>
                    <?php echo $cfieldsLayout; ?>
                <?php endif; ?>
                <?php echo $testimonialText ?>
                <?php  if($cfields_position == 1) : // custom fields position after testimonial text ?>
                    <?php echo $cfieldsLayout; ?>
                <?php endif; ?>
                <?php if ($show_vote && $vote_position == 4): ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>

        <div class="testi-information clearfix">
            <?php if ($show_avatar) : ?>
                <?php if ($vote && $vote_position == 3): //vote before avatar ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
                <?php echo $avatarLayout ?>
                <?php if ($vote && $vote_position == 2): //vote after avatar ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="testi-information2">
                <?php if ($show_vote && $vote_position == 1): ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
                <div class="testi-name">
                    <?php echo $item->name; ?>
                </div>
                <?php if ($show_vote && $vote_position == 0): ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
                <?php if ($showPosition || $showCompany) : ?>
                    <div class="testi-position">
                        <?php if ($showPosition) : ?>
                            <?php echo $item->position; ?>
                        <?php endif; ?>

                        <?php if ($showCompany) : ?>
                            <?php if ($showPosition) : ?>
                                /
                            <?php endif; ?>

                            <?php if ($link_website && $item->website) : ?>
                                <a href="<?php echo $item->website; ?>" target="_blank">
                                    <?php echo $item->company; ?>
                                </a>
                            <?php else : ?>
                                <?php echo $item->company; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($permalink) : ?>
                            <div class="permalink"><a
                                    href="<?php echo JRoute::_(JoomtestimonialsHelperRoute::getTestimonialRoute($item->id, $item->name)); ?>"><?php echo JText::_('COM_JOOMTESTIMONIALS_PERMALINK') ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($avatar_position != 'bottom'): ?>
            <div class="testi-quote-box">
                <?php if ($show_video) : ?>
                    <div class="video">
                        <?php echo JoomtestimonialsFrontendHelper::videoBuilder($item->video, $video_width, $video_height, $video_type, $lightbox_button); ?>                                    </div>
                <?php endif; ?>
                <?php if ($show_vote && $vote_position == 5): ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
                <?php  if($cfields_position == 0) : // custom fields position before testimonial text ?>
                    <?php echo $cfieldsLayout; ?>
                <?php endif; ?>
                <?php echo $testimonialText ?>
                <?php  if($cfields_position == 1) : // custom fields position after testimonial text ?>
                    <?php echo $cfieldsLayout; ?>
                <?php endif; ?>
                <?php if ($show_vote && $vote_position == 4): ?>
                    <div class="testi-vote">
                        <?php echo $vote; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>
</div>
