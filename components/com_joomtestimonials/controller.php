<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\MVC\View\GenericDataException;

defined('_JEXEC') or die;

/**
 * JUI Testimonials Component Controller.
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.Joomtestimonials
 */
class JoomtestimonialsController extends JControllerLegacy {
	protected $default_view		= 'testimonials';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false) {
		$cachable	= true;
		$user		= JFactory::getUser();

		// Set the default view name and format from the Request.
		// Note we are using w_id to avoid collisions with the router and the return page.
		// Frontend is a bit messier than the backend.
		$id    = $this->input->getInt('w_id');
		$vName = $this->input->get('view', 'testimonials');
		$this->input->set('view', $vName);

		if ($user->get('id') || ($this->input->getMethod() == 'POST' && $vName = 'testimonials')) {
			$cachable = false;
		}

		$safeurlparams = array(
			'id'				=> 'INT',
			'limit'				=> 'UINT',
			'limitstart'		=> 'UINT',
			'filter_order'		=> 'CMD',
			'filter_order_Dir'	=> 'CMD',
			'lang'				=> 'CMD'
		);

		// Check for edit form.
		if ($vName == 'form' && !$this->checkEditId('com_joomtestimonials.edit.testimonial', $id)) {
			// Somehow the person just went to the form - we don't allow that.
            throw new GenericDataException(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 403);
		}

		return parent::display($cachable, $safeurlparams);
	}
}