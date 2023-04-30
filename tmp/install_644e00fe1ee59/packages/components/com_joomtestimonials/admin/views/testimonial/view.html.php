<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\MVC\View\GenericDataException;

defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a Testimonial.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsViewTestimonial extends JViewLegacy {

	protected $state;
	protected $item;
	protected $form;

	/**
	 * Display the view.
	 */
	public function display($tpl = null) {
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new GenericDataException(implode("\n", $errors), 500);
        }

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= $this->item->id == 0;
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		$canDo		= JoomtestimonialsHelper::getActions($this->state->get('filter.category_id'), $this->item->id);

		JToolBarHelper::title(JText::_('COM_JOOMTESTIMONIALS_TESTIMONIAL_MANAGER'), 'testimonial.png');


		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || (count($user->getAuthorisedCategories('com_joomtestimonials', 'core.create'))))) {
			JToolBarHelper::apply('testimonial.apply');
			JToolBarHelper::save('testimonial.save');
		}

		if (!$checkedOut && (count($user->getAuthorisedCategories('com_joomtestimonials', 'core.create')))) {
			JToolBarHelper::save2new('testimonial.save2new');
		}

		// If an existing item, can save to a copy.
		if (!$isNew && (count($user->getAuthorisedCategories('com_joomtestimonials', 'core.create')))) {
			JToolBarHelper::save2copy('testimonial.save2copy');
		}

		if (empty($this->item->id)) {
			JToolBarHelper::cancel('testimonial.cancel');
		} else {
			JToolBarHelper::cancel('testimonial.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}