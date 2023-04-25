<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

$params = LayoutHelper::getListLayoutParams();
$hideHeader     = $displayData['hideHeader'];
$showSubmitButton     = $displayData['showSubmitButton'];
$headerDisplayed = false; // to avoid duplicate displaying of header

?>
<div class="jtHeader">
	<?php if(!$hideHeader):?>
		<?php if ($params->get('show_page_heading', 1)) : ?>
            <div class="page-header">
                <?php if ($showSubmitButton) : ?>
                <?php echo JLayoutHelper::render('common.list.submitButton',['params' => $params]); ?>
                <?php endif; ?>
                <h1><?php echo $this->escape($params->get('page_heading')); ?></h1>
            </div>
		<?php

        $headerDisplayed = true;
        endif;
        ?>
    <?php endif; ?>
	<?php if($hideHeader || !$params->get('show_page_heading', 1) && !$headerDisplayed):
        ?>
            <div class="jtAdd">
                <?php echo JLayoutHelper::render('common.list.submitButton',['params' => $params]); ?>
                <div class="clearfix"></div>
            </div>
	<?php endif; ?>

	<?php if ($params->get('page_subheading')) : ?>
        <h2>
			<?php echo $this->escape($params->get('page_subheading')); ?>
        </h2>
	<?php endif; ?>
</div>