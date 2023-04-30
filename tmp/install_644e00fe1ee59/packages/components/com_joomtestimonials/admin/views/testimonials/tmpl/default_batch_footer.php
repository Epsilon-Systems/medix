<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_joomtestimonials
 *
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
defined('_JEXEC') or die;

?>
<button class="btn" type="button" onclick="document.id('batch-category-id').value=''; document.id('batch-access').value=''; document.id('batch-language-id').value=''" data-bs-dismiss="modal">
    <?php echo JText::_('JCANCEL'); ?>
</button>
<button class="btn btn-primary" type="submit" onclick="Joomla.submitbutton('testimonial.ProcessBatch');">
    <?php echo JText::_('JGLOBAL_BATCH_PROCESS'); ?>
</button>