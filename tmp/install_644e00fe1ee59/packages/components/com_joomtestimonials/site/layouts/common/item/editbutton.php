<?php
/*8
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

extract($displayData);

// can edit
$canEdit  = JtAuhtoriseHelper::canEdit($item->created_by);

// item id
$id       = $item->id;

?>
<?php if ($canEdit) : ?>
	<div class="testiEdit">
		<a class="btn btn-sm btn-success  testi-modal hasTooltip"
		   rel="{handler: 'iframe', size: {x: 600, y: 550}}"
		   href="<?php echo JoomtestimonialsHelperRoute::getFormRoute($id, JUri::current(), true); ?>"
		   title="<?php echo JText::_('COM_JOOMTESTIMONIALS_FORM_EDIT_TESTIMONIAL'); ?>">
			<i class="fas fa-edit"></i>
		</a>
	</div>
<?php endif; ?>