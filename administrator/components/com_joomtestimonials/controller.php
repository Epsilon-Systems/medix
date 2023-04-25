<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\Exception;
use Joomla\CMS\Language\Text;
/**
 *JoomTestimonials Controller.
 *
 * @package		Joomla.Administrator
 * @subpackage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsController extends JControllerLegacy {

	/**
	 * Method to display a view.
	 *
	 * @param	bool 				$cachable	If true, the view output will be cached.
	 * @param	bool 				$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFileterInput::clean()}.
	 * @return	JControllerLegacy	This object to support chaining.
	 */
	public function display($cachable = false, $urlparams = false) {

		$view		= $this->input->get('view', 'dashboard');
		$this->input->set('view', $view);
		$layout		= $this->input->get('layout', 'default');
		$id			= $this->input->getInt('id');

		// Check for edit form.
		if ($layout == 'edit') {
			switch ($view) {
				case 'testimonial':
					$vName	= 'testimonials';
					break;
			}

			if (!$this->checkEditId('com_joomtestimonials.edit.' . $view, $id)) {
				// Somehow the person just went to the form - we don't allow that.
                throw new Exception\ResourceNotFound(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));

                //$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
				//$this->setMessage($this->getError(), 'error');
				$this->setRedirect(JRoute::_('index.php?option=com_joomtestimonials&view=' . $vName, false));

				return false;
			}
		}

		return parent::display();
	}
}