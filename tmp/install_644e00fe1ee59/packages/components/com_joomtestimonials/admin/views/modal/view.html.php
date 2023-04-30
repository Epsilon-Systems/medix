<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit a Testimonial.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsViewModal extends JViewLegacy
{
    /**
     * The \JForm object
     *
     * @var \Joomla\CMS\Form\Form
     */
    protected $form;
    protected $action;
    protected $layout;

    /**
     * Display the view.
     */
    public function display($tpl = null)
    {
        $app	      = JFactory::getApplication();
        $this->form   = $this->get('Form');
        $this->action = JRoute::_('index.php?option=com_joomtestimonials');
        $this->layout = $app->input->get('layout');

        parent::display($tpl);
    }

}