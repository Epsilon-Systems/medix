<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Layout\LayoutHelper;

defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
?>

<div class="p-3">
		<p><?php echo JText::_('COM_JOOMTESTIMONIALS_TESTIMONIALS_BATCH_TIP'); ?></p>

        <div class="row">
            <div class="form-group col-md-6">
                <div class="controls">
                    <?php echo LayoutHelper::render('joomla.html.batch.language', []); ?>
                </div>
            </div>
            <div class="form-group col-md-6">
                <div class="controls">
                    <?php echo LayoutHelper::render('joomla.html.batch.access', []); ?>
                </div>
            </div>
        </div>

		<?php if ($published >= 0) : ?>
		<div class="control-group">
			<div class="controls">
                <?php echo JLayoutHelper::render('joomla.html.batch.item', array('extension' => 'com_joomtestimonials')); ?>
			</div>
		</div>
		<?php endif; ?>
</div>

