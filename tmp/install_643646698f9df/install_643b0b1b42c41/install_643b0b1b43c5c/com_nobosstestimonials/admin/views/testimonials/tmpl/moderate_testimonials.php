<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	com_nobosstestimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;
?>

<div class='alert alert-notice'>
	<button type="button" class="close" data-dismiss="alert">×</button> 
	<?php echo JText::_('COM_NOBOSSTESTIMONIALS_ALERT_PENDING_TESTIMONIALS'); ?>
	<ul>
		<?php foreach($this->pendingTestimonials as $pendingTestimony) { ?>
			<li>
				<?php
				$messageTestimonial = JText::_('COM_NOBOSSTESTIMONIALS_ITEM_PENDING_TESTIMONIALS');
				$messageTestimonial = str_replace("#author_name#", $pendingTestimony->author_name, $messageTestimonial);
				$messageTestimonial = str_replace("#link#", JRoute::_('index.php?option=com_nobosstestimonials&task=testimonial.edit&id=' . $pendingTestimony->id), $messageTestimonial);
				$messageTestimonial = str_replace("#data#", date_format(date_create($pendingTestimony->created),JText::_('NOBOSS_EXTENSIONS_GLOBAL_DATE_FORMAT')), $messageTestimonial);
				echo $messageTestimonial;
				?>
			</li>
		<?php } ?>
	</ul>
</div>
