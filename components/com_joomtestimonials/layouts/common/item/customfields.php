<?php
/*8
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

use \Joomla\Component\Fields\Administrator\Helper\FieldsHelper;

// show fields
$show_cfields  = $displayData['show_cfields'];
// custom fields value
$cfields = $displayData['cfields'];

?>
<?php if ($show_cfields) : ?>
		<div class="jtCustomFields my-2">
			<?php foreach ($cfields as $field) : ?>
				<?php echo FieldsHelper::render($field->context, 'field.render', array('field' => $field)); ?><br>
			<?php endforeach ?>
		</div>
<?php endif; ?>