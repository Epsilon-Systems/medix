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

$subLayoutparams = array('debug' => false, 'client' => 0, 'component' => 'com_joomtestimonials');

// Global params
$date_format		= $params->get('date_format','Y-m-d');

// Layout params
$list_main          = (array)$layoutparams->get('list_main');
$strip_tags         = isset($list_main['strip_tags'])?$list_main['strip_tags']:1;
$permalink          = (bool) $layoutparams->get('show_permalink', 0);

// Init params
$lightbox_button    = $layoutparams->get('lightbox_button','btn btn-primary');
$video_width        = $layoutparams->get('video_width','100%');
$video_height       = $layoutparams->get('video_height','225px');
$show_video			= $layoutparams->get('show_video',1);
$video_type			= $layoutparams->get('video_type',0);
$show_vote			= $layoutparams->get('show_vote',1);
$show_date			= $layoutparams->get('show_date',1);
$vote_position		= (int) $layoutparams->get('rating_position',0);
$text_color			= $layoutparams->get('text_color');
$show_position		= (bool) $layoutparams->get('show_position', 1);
$show_company		= (bool) $layoutparams->get('show_company', 1);
$show_cfields        = $layoutparams->get('show_cfields',1);
$cfields_position   = $layoutparams->get('cfields_position',1);
$link_website		= (bool) $layoutparams->get('link_website');
$show_avatar		= (bool) $layoutparams->get('show_avatar' , 1);
$btext_color		= $text_color ? 'color: ' . $text_color . ';' : '';


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

// custom fields layout
$cfieldsLayout = JLayoutHelper::render('common.item.customfields', [
	'show_cfields' => $show_cfields,
	'cfields' => $item->jcfields
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
<div class="cd-timeline-block testiList">
	<?php if ($show_avatar) : ?>

		<?php $avatar	= $item->avatar ? JHtml::_('image', $item->avatar, $item->avatar, null, false, true) : ''; ?>
		<div class="cd-timeline-img cd-picture"<?php echo $avatar ? " style=\"background-image: url($avatar);\"" : ''; ?>></div>
    <?php endif; ?>
    <div class="cd-timeline-content">
        <?php echo JLayoutHelper::render('common.item.editbutton', ['item' => $item]); ?>
	  <?php if($show_vote && $vote_position == 1):?>
			<div class="testi-vote">
				<?php echo $vote; ?>
			</div>
	  <?php endif;?>
      <h2><?php echo $item->name; ?></h2>
	    <?php if ($show_video) :?>
            <div class="video">
			    <?php echo JoomtestimonialsFrontendHelper::videoBuilder($item->video,$video_width,$video_height,$video_type,$lightbox_button); ?>
            </div>
	    <?php endif; ?>
      <?php if($show_vote && ($vote_position == 0 or $vote_position == 5)):?>
			<div class="testi-vote">
				<?php echo $vote; ?>
			</div>
	  <?php endif;?>
	    <?php  if($cfields_position == 0) : // custom fields position before testimonial text ?>
		    <?php echo $cfieldsLayout; ?>
	    <?php endif; ?>
	    <?php echo $testimonialText ?>
	    <?php  if($cfields_position == 1) : // custom fields position after testimonial text ?>
		    <?php echo $cfieldsLayout; ?>
	    <?php endif; ?>
	  <?php if($show_vote && $vote_position == 4):?>
			<div class="testi-vote">
				<?php echo $vote; ?>
			</div>
	  <?php endif;?>
      <?php if ($showPosition || $showCompany) : ?>
			<div class="testi-position">
			<?php if ($showPosition) : ?>
				<?php echo $item->position; ?>
			<?php endif; ?>
			<?php if ($showCompany) : ?>
					<?php if ($showPosition) : ?>
					<?php endif; ?>
						<?php if ($link_website && $item->website) : ?>
							<a href="<?php echo $item->website; ?>" target="_blank">
							<?php echo $item->company; ?>
							</a>
					<?php else : ?>
						<?php echo $item->company; ?>
					<?php endif; ?>
			<?php endif; ?>
			</div>
		<?php endif; ?>
	    <?php if ($permalink) : ?>
            <div class="permalink"><a href ="<?php echo JRoute::_(JoomtestimonialsHelperRoute::getTestimonialRoute($item->id,$item->name));?>"><?php echo JText::_('COM_JOOMTESTIMONIALS_PERMALINK')?></a></div>
	    <?php endif;?>
    </div>
</div>
