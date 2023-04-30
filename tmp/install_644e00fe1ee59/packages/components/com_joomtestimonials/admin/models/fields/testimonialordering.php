<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of Testimonials.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JFormFieldTestimonialOrdering extends JFormField {

	/** @var string		The form field type. */
	protected $type	= 'TestimonialOrdering';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 */
	protected function getInput() {
		// Initialize variables.
		$html	= array();
		$attr	= '';

		// Initialize some field attributes.
		$attr	.= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$attr	.= ((string) $this->element['disabled']) == 'true' ? ' disabled="disabled"' : '';
		$attr	.= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';

		// Initialize Javascript field attributes.
		$attr	.= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		// Get some field values from the form.
		$testimonialId	= (int) $this->form->getValue('id');
		$categoryId		= (int) $this->form->getValue('catid');
		
		// Build the query for the ordering list.
		$query = 'SELECT ordering AS value, name AS text'
				. ' FROM #__joomtestimonials'
				. ' WHERE catid = ' . (int) $categoryId
				. ' ORDER BY ordering'
		;

		// Create a read-only list (no name) with a hidden input to store the value.
		if ((string) $this->element['readonly'] == 'true') {
			$html[]	= JHtml::_('list.ordering', '', $query, trim($attr), $this->value, $testimonialId ? 0 : 1);
			$html[]	= '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '" />';
		} else {
			// Create a regular list.
			$html[]	= JHtml::_('list.ordering', $this->name, $query, trim($attr), $this->value, $testimonialId ? 0 : 1);
		}

		return implode($html);
	}
}