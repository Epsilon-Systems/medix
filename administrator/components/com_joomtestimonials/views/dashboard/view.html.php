<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\MVC\View\GenericDataException;

defined('_JEXEC') or die;

JLoader::register('JoomtestimonialsHelperDashboard', JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/helpers/dashboard.php');

/**
 * View class of dashboard.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsViewDashboard extends JViewLegacy {

	/**
	 * Display the view.
	 */
	public function display($tpl = null) {

		JoomtestimonialsHelper::addSubmenu('dashboard');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new GenericDataException(implode("\n", $errors), 500);
		}
		
		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar() {
		require_once JPATH_COMPONENT . '/helpers/joomtestimonials.php';
		$canDo	= JoomtestimonialsHelper::getActions();
		$user	= JFactory::getUser();
		$bar	= JToolBar::getInstance('toolbar');

		JToolBarHelper::title(JText::_('COM_JOOMTESTIMONIALS_TESTIMONIALS_DASHBOARD'), 'dashboard');

		if (count($user->getAuthorisedCategories('com_joomtestimonials', 'core.create'))) {
			JToolBarHelper::addNew('testimonial.add','COM_JOOMTESTIMAONIALS_ADD_TESTI');
		}		
		
		JToolBarHelper::addNew('dashboard.addcat','COM_JOOMTESTIMAONIALS_ADD_NEWCAT');
		JToolBarHelper::addNew('dashboard.addcustomfield','COM_JOOMTESTIMAONIALS_ADD_NEWCUSTOMFIELD');

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_joomtestimonials');
		}
		
		JToolbarHelper::help(null, null, 'https://www.joomboost.com/support/documentation/28-joomtestimonials.html?tmpl=component');
	}

}