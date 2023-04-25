<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

// this extend fix module form problem
class JoomtestimonialsView extends JViewLegacy{

	function _setPath($type, $path)
	{
		$component = 'com_joomtestimonials';
		$app = \JFactory::getApplication();

		// Clear out the prior search dirs
		$this->_path[$type] = array();

		// Actually add the user-specified directories
		$this->_addPath($type, $path);

		// Always add the fallback directories as last resort
		switch (strtolower($type))
		{
			case 'template':
				// Set the alternative template search dir
				if (isset($app))
				{
					$component = preg_replace('/[^A-Z0-9_\.-]/i', '', $component);
					$fallback = JPATH_THEMES . '/' . $app->getTemplate() . '/html/' . $component . '/' . $this->getName();
					$this->_addPath('template', $fallback);
				}
				break;
		}
	}
}

/**
 * View class for adding/editing testimonials.
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.Joomtestimonials
 */
class JoomtestimonialsViewForm extends JoomtestimonialsView {
	protected   $form;
	protected   $item;
	protected   $return_page;
	protected   $state;
	public      $ignore_fieldsets;

	public function display($tpl = null) {

		$user		= JFactory::getUser();
		$app		= JFactory::getApplication();
        $doc	    = JFactory::getDocument();
        $url        = JUri::getInstance();
        $currentUrl = $url->toString();

		// Get model data.
		$this->state		= $this->get('State');
		$this->item			= $this->get('Item');
		$this->form			= $this->get('Form');
        $this->params		= $this->state->params;
		$this->isModule     = 0;
        $this->user = \Joomla\CMS\Factory::getUser();


        $this->ignore_fieldsets = array('testimonial');

		JHtml::_('behavior.keepalive');
		JHtml::_('behavior.formvalidator');
		
		$this->return_page	= $this->get('ReturnPage',base64_encode($currentUrl));

		$authorised = empty($this->item->id) ? JtAuhtoriseHelper::canCreate() :  JtAuhtoriseHelper::canEdit($this->item->created_by);

        if ($authorised !== true) {

            // redirect to login page

            if ($this->user->get('guest') && ComponentHelper::getParams('com_joomtestimonials')->get('redirect_to_login_page',0)) {
                $return = base64_encode(Uri::getInstance());
                $login_url_with_return = Route::_('index.php?option=com_users&view=login&return=' . $return);
                $app->enqueueMessage(Text::_('COM_JOOMTESTIMONIALS_PLEASE_LOGIN_FIRST_TO_SUBMIT_TESTIMONIAL'), 'notice');
                $app->redirect($login_url_with_return, 403);
            } else {
                $app->enqueueMessage(Text::_('JERROR_ALERTNOAUTHOR'), 'error');
                $app->setHeader('status', 403, true);

                return;
            }

            return false;
        }

        if (!empty($this->item) && $this->item->id) {
            $this->form->bind($this->item);
        }

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            $app->enqueueMessage(implode("\n", $errors), 'error');
            return false;
        }

		// Create a shortcut to the parameters.
		$params	= &$this->state->params;

		//Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->params	= $params;
		$this->user		= $user;
		$this->isModal	= $app->input->get('tmpl') == 'component';

		// this fix redirection problem once form is submitted and processed , check testimonial controller -> getReturnPage Method.
		if($app->input->get('isModule',0,'int') == 1){
			$this->isModule    = 1;
		}

        // load assets
        if ($this->isModal) {
            JFactory::getDocument()->addStyleDeclaration("body{padding: 0px !important; margin: 0px !important} #system-message-container{margin: 15px;}");
        }

		JFactory::getDocument()->addScriptOptions('com_joomtestimonials.form', array(
            'isModal' => (int) $this->isModal
        ));

        if ($this->params->get('picture_field_type')) {
            JFactory::getDocument()->addScript(JUri::base() . 'media/com_joomtestimonials/js/image-picker.min.js');
            JFactory::getDocument()->addStyleSheet(JUri::base() . 'media/com_joomtestimonials/css/image-picker.css');
        }

		// Check for layout override only if this is not the active menu item
		// If it is the active menu item, then the view and category id will match
		$active	= $app->getMenu()->getActive();

		if ((!$active) || (strpos($active->link, 'view=form') === false)) {
			if ($layout	= $this->params->get('form_layout')) {
				$this->setLayout($layout);
			}
		} else if (isset($active->query['layout'])) {
			// We need to set the layout in case this is an alternative menu item (with an alternative layout)
			$this->setLayout($active->query['layout']);
		}

		$this->_prepareDocument();

		parent::display($tpl);
	}





	/**
	 * Prepares the document
	 */
	protected function _prepareDocument() {
		$app	= JFactory::getApplication();
		$menus	= $app->getMenu();
		$title	= null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if (empty($this->item->id)) {
			$head = JText::_('COM_JOOMTESTIMONIALS_FORM_SUBMIT_TESTIMONIAL');
		} else {
			$head = JText::_('COM_JOOMTESTIMONIALS_FORM_EDIT_TESTIMONIAL');
		}

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', $head);
		}

		$title	= $this->params->def('page_title', $head);

		if ($app->get('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		} elseif ($app->get('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		JFactory::getDocument()->setTitle($title);

		if ($this->params->get('menu-meta_description')) {
			JFactory::getDocument()->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords')) {
			JFactory::getDocument()->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots')) {
			JFactory::getDocument()->setMetadata('robots', $this->params->get('robots'));
		}
	}
}