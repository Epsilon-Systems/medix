<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

class JFormRuleUploadsize  extends JFormRule{

	public function test(SimpleXMLElement $element, $value, $group = null, JRegistry $input = null, JForm $form = null)
	{

		// get avatar file data
		$avatar_file_data  = JFactory::getApplication()->input->files->get('jform')['avatar_file'];
		// get max size value
		$avatar_max_size = JComponentHelper::getParams('com_joomtestimonials')->get('avatar_max_upload_size',200) * 1024;
		// get required value
		$isRequired = JComponentHelper::getParams('com_joomtestimonials')->get('field_avatar_required',0);
		// get visible value
		$isVisible  = JComponentHelper::getParams('com_joomtestimonials')->get('field_avatar_visible',1);

		// using required as attribute has problems, i come out with another solution
		// $required = ((string) $element['required'] == 'true' || (string) $element['required'] == 'required');

		if (!$isRequired && $isVisible && empty($avatar_file_data['name']))
		{
			return true;
		}

		if($isRequired && $isVisible && empty($avatar_file_data['name'])){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_JOOMTESTIMONIALS_NO_AVATAR'),'warning');
			return false;
		}

		$maxSize = JUtility::getMaxUploadSize();
		$maxSize = $avatar_max_size < $maxSize ? $avatar_max_size : $maxSize;

		if( $avatar_file_data['size'] > $maxSize){
			//$element->attributes()->message = 'Picture size is too big, maximum upload size is '.JHtml::_('number.bytes', $maxSize);
			JFactory::getApplication()->enqueueMessage(JText::sprintf('COM_JOOMTESTIMONIALS_BIGSIZE_AVATAR',JHtml::_('number.bytes', $maxSize)), 'warning');
			return false;
		}

	}
}
