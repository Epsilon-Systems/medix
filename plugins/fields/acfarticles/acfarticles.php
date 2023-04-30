<?php

/**
 * @package         Advanced Custom Fields
 * @version         2.4.0 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2023 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die;

JLoader::register('ACF_Field', JPATH_PLUGINS . '/system/acf/helper/plugin.php');

if (!class_exists('ACF_Field'))
{
	JFactory::getApplication()->enqueueMessage('Advanced Custom Fields System Plugin is missing', 'error');
	return;
}

use Joomla\Registry\Registry;
use NRFramework\Cache;

class PlgFieldsACFArticles extends ACF_Field
{
	
	
	/**
	 * Transforms the field into a DOM XML element and appends it as a child on the given parent.
	 *
	 * @param   stdClass    $field   The field.
	 * @param   DOMElement  $parent  The field node parent.
	 * @param   Form        $form    The form.
	 *
	 * @return  DOMElement
	 *
	 * @since   3.7.0
	 */
	public function onCustomFieldsPrepareDom($field, DOMElement $parent, Joomla\CMS\Form\Form $form)
	{
		if (!$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form))
		{
			return $fieldNode;
		}

		$fieldNode->setAttribute('multiple', true);

		return $fieldNode;
	}

	/**
	 * Prepares the field value for the (front-end) layout
	 *
	 * @param   string    $context  The context.
	 * @param   stdclass  $item     The item.
	 * @param   stdclass  $field    The field.
	 *
	 * @return  string
	 */
	public function onCustomFieldsPrepareField($context, $item, $field)
	{
		// Check if the field should be processed by us
		if (!$this->isTypeSupported($field->type))
		{
			return;
		}

		$value = array_filter((array) $field->value);
		
		if (!$value)
		{
			return;
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.*')
			->from($db->quoteName('#__content', 'a'))
			->where($db->quoteName('a.id') . ' IN (' . implode(',', $value) . ')')
			->where($db->quoteName('a.state') . ' = 1');

		$db->setQuery($query);

		if (!$articles = $db->loadAssocList())
		{
			return;
		}

		

		$field->value = $articles;

		return parent::onCustomFieldsPrepareField($context, $item, $field);
	}

	
}