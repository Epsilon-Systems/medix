<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

class JFormRuleVideo  extends JFormRule{

	public function test(SimpleXMLElement $element, $value, $group = null, JRegistry $input = null, JForm $form = null)
	{

		// If the field is empty and not required, the field is valid.
		$required = ((string) $element['required'] == 'true' || (string) $element['required'] == 'required');

		if (!$required && empty($value))
		{
			return true;
		}

		if (JoomtestimonialsFrontendHelper::videoBuilder($value,"","",2)){
			return true;
		}else{
			return false;
		}
	}
}
