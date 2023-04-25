<?php
/**
 * @copyright      Copyright (c) 2013 - 2016 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
$user      = JFactory::getUser();

?>
<div class="jtAdd">
	<?php echo JLayoutHelper::render('common.list.submitButton',
		[
			'customClass' => $params->get('customclass', 'btn btn-success'),
			'params'      => $params
		],'',['component' => 'com_joomtestimonials']);
	?>
    <div class="clearfix"></div>
</div>