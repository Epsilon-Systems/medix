<?php
/*8
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

use Joomla\CMS\HTML\Helpers\StringHelper;

defined('JPATH_BASE') or die;

// testimonial text params
$textlimiter    = (array)$displayData['params']['textlimiter'];
$strip_tags     = $displayData['params']['strip_tags'];
$show_date      = $displayData['params']['show_date'];
$date_format    = $displayData['params']['date_format'];

$text_limit 	= 	isset($textlimiter['text_limiter'])?$textlimiter['text_limiter']:0;
$text_chars		= 	isset($textlimiter['text_amount'])?$textlimiter['text_amount']:200;
$text_hover		=	isset($textlimiter['text_full'])?$textlimiter['text_full']:1;
$less_button	=	isset($textlimiter['less_button'])?$textlimiter['less_button']:1;
$readmore_classes=	isset($textlimiter['text_button_classes'])?$textlimiter['text_button_classes']:'btn btn-sm btn-light';


// testimonial text
$testimonial    = $displayData['testimonial'];

// testimonial date
$created        = $displayData['created'];
$view = JFactory::getApplication()->input->get('view');

$fullTextLength      = strlen(strip_tags($testimonial));

$truncatedText       = StringHelper::truncate(strip_tags($testimonial),$text_chars);
$truncatedTextLength = strlen($truncatedText);

?>


<div class="testimonialText">
    <?php if ($text_limit): ?>
        <div class="trunctedText">
            <?php echo $truncatedText; ?>
        </div>
        <div class="fullText" style="display:none;">
            <?php echo $strip_tags ? strip_tags($testimonial) : $testimonial; ?>
        </div>
        <?php if ($show_date): ?>
            <div class="testi-date">
                <small><em><?php echo JHtml::_('date', $created, $date_format) ?></em></small>
            </div>
        <?php endif; ?>

        <?php if ($fullTextLength > $truncatedTextLength): // truncated text length is smaller or equal to full text length then no need to display read more button & showlen button
            ?>
            <?php if (!$text_hover): ?>
            <a href="#"
               class="jtreadmore <?php echo $readmore_classes ?>"><?php echo JText::_('COM_JOOMTESTIMONIALS_READ_MORE') ?></a>
        <?php endif; ?>
            <?php if (!$text_hover && $less_button): ?>
            <a href="#" class="jtshowless <?php echo $readmore_classes ?>"
               style="display:none"><?php echo JText::_('COM_JOOMTESTIMONIALS_SHOW_LESS') ?></a>
        <?php endif; ?>
        <?php endif; ?>
    <?php else: ?>
        <div class="testiNoLimiter"><?php echo $testimonial; ?></div>
        <?php if ($show_date): ?>
            <div class="testi-date">
                <small><em><?php echo JHtml::_('date', $created, $date_format) ?></em></small>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
