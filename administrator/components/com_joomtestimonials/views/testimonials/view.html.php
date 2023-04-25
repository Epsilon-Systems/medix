<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\MVC\View\GenericDataException;

defined('_JEXEC') or die;

/**
 * View class for a list of Testimonials.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsViewTestimonials extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;
    public $filterForm;

    /**
     * The active search filters
     *
     * @var    array
     * @since  4.0.0
     */
    public $activeFilters;

	/**
	 * Display the view.
	 */
	public function display($tpl = null) {
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
        $this->filterForm    = $this->get('FilterForm');

        $this->activeFilters = $this->get('ActiveFilters');

		JoomtestimonialsHelper::addSubmenu('testimonials');

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

		$state	= $this->get('State');
		$canDo	= JoomtestimonialsHelper::getActions($state->get('filter.category_id'));
		$this->set('canDo', $canDo);

		$user	= JFactory::getUser();
		$bar	= JToolBar::getInstance('toolbar');

		JToolBarHelper::title(JText::_('COM_JOOMTESTIMONIALS_TESTIMONIALS_MANAGER'), 'comments');

		if (count($user->getAuthorisedCategories('com_joomtestimonials', 'core.create'))) {
			JToolBarHelper::addNew('testimonial.add');
		}

		if ($canDo->get('core.edit')) {
			JToolBarHelper::editList('testimonial.edit');
		}

		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::publish('testimonials.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('testimonials.unpublish', 'JTOOLBAR_UNPUBLISH', true);

			JToolBarHelper::archiveList('testimonials.archive');
			JToolBarHelper::checkin('testimonials.checkin');
		}

		if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'testimonials.delete', 'JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('testimonials.trash');
		}

		// Add a batch button
		if ($canDo->get('core.edit')) {

            $bar->popupButton('batch')
                ->text('JTOOLBAR_BATCH')
                ->selector('collapseModal')
                ->listCheck(true);
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_joomtestimonials');
		}

	}

}