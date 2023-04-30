<?php

/**
 * @package         Advanced Custom Fields
 * @version         2.4.0 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2019 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die;

if (!@include_once(JPATH_PLUGINS . '/system/nrframework/autoload.php'))
{
	throw new RuntimeException('Novarain Framework is not installed', 500);
}

use \NRFramework\HTML;
use Joomla\CMS\Form\Form;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);
JLoader::register('ACFHelper', __DIR__ . '/helper.php');

class ACF_Field extends FieldsPlugin
{
	/**
	 *  Override the field type
	 *
	 *  @var  string
	 */
	protected $overrideType;

	/**
	 *  Whether the field is required
	 *
	 *  @var  bool
	 */
	protected $required = false;

	/**
	 *  The validation rule will be used to validate the field on saving
	 *
	 *  @var  string
	 */
	protected $validate;

	/**
	 *  Field's Hint Description
	 *
	 *  @var  string
	 */
	protected $hint;

	/**
	 *  Field's Class
	 *
	 *  @var  string
	 */
	protected $class;

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
	public function onCustomFieldsPrepareDom($field, DOMElement $parent, Form $form)
	{
		if (!$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form))
		{
			return;
		}

		// Load framework's fields
		$form->addFieldPath(JPATH_PLUGINS . '/system/nrframework/fields');
		$form->addFieldPath(JPATH_PLUGINS . '/fields/' . $field->type . '/fields');

		// Set Field Class
		if ($this->class)
		{
			$fieldNode->setAttribute('class', $this->class);
		}

		// Set field placeholder
		if ($hint = $field->params->get('hint', $this->hint))
		{
			$fieldNode->setAttribute('hint', $hint);
		}

		// Set Field Type
		if ($this->overrideType)
		{
			$fieldNode->setAttribute('type', $this->overrideType);
		}

		// Set Field Required
		if ($this->required)
		{
			$fieldNode->setAttribute('required', $this->required);
		}

		// Set validation rule
		if ($this->validate)
		{
			$form->addRulePath(JPATH_PLUGINS . '/system/nrframework/NRFramework/Rules');
			$form->addRulePath(JPATH_PLUGINS . '/system/acf/form/rules');
			$fieldNode->setAttribute('validate', $this->validate);
		}

		// Set Field Description
		$desc_def  = JText::_(str_replace('ACF', 'ACF_', strtoupper($field->type)) . '_VALUE_DESC');
		$desc_user = $fieldNode->getAttribute('description');
		$desc      = !empty($desc_user) ? $desc_user : $desc_def;
	
		$fieldNode->setAttribute('description', $desc);

		// Gather all Joomla 3 CSS fixes in a file and load it.
		if (!defined('nrJ4'))
		{
			JHtml::stylesheet('plg_system_nrframework/joomla3.css', ['relative' => true, 'version' => 'auto']);
			JHtml::stylesheet('plg_system_acf/joomla3.css', ['relative' => true, 'version' => 'auto']);
		}

		return $fieldNode;
	}

	/**
	 * The form event. Load additional parameters when available into the field form.
	 * Only when the type of the form is of interest.
	 *
	 * @param   Form      $form  The form
	 * @param   stdClass  $data  The data
	 *
	 * @return  void
	 *
	 * @since   3.7.0
	 */
	public function onContentPrepareForm(Form $form, $data)
	{
		$data = (object) $data;
		
		// Make sure we are manipulating the right field.
		if (isset($data->type) && ($data->type != $this->_name))
		{
			return;
		}

		// Load framework's fields
		$form->addFieldPath(JPATH_PLUGINS . '/system/nrframework/fields');
		
		if (JFactory::getApplication()->isClient('administrator'))
		{
			// load ACF backend style
			JHtml::stylesheet('plg_system_acf/acf-backend.css', ['relative' => true, 'version' => 'auto']);
			
			if (defined('nrJ4'))
			{
				JHtml::stylesheet('plg_system_nrframework/joomla4.css', ['relative' => true, 'version' => 'auto']);
				HTML::fixFieldTooltips();
			}
		
			// Display extension notices
			\NRFramework\Notices\Notices::getInstance([
				'ext_element' => 'acf',
				'ext_type' => 'plugin',
				'ext_xml' => 'plg_system_acf',
				'exclude' => [
					'Geolocation'
				]
			])->show();
		}

		return parent::onContentPrepareForm($form, $data);
	}
}
