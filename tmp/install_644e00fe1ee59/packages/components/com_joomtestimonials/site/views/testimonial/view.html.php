<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * View class for a list of testimonials.
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.Joomtestimonials
 */
class JoomtestimonialsViewTestimonial extends JViewLegacy {
    protected $item;
    protected $params;
    protected $state;
    public $hide_header = 0;

    /**
     * Display the view.
     */
    public function display($tpl = null) {
        JHtml::_('jquery.framework');
        $app	= JFactory::getApplication();
        $doc	= JFactory::getDocument();

        // Get some data from the models
        $this->state		= $this->get('State');
        $this->item		    = $this->get('Item');
        $this->params       = LayoutHelper::getListLayoutParams();
        $offset = $this->state->get('list.offset');

        $item_video  = $this->params->get('layoutparams')->get('item_video');
        $video_type  = $item_video->video_type;

        if($video_type)
        {
            JoomtestimonialsFrontendHelper::loadVideoJs();
        }

        JHtml::_('stylesheet', 'media/com_joomtestimonials/list/default/default.css', false, array(), false, false, true);
        $this->myLayouts['testimonial.css'] = new JLayoutFile('list.default.style'); // dynamic css layout
        $this->myLayouts['testimonial.css']->render();

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            $app->enqueueMessage(implode("\n", $errors), 'error');
            return false;
        }


        $this->pageclass_sfx	= htmlspecialchars($this->params->get('pageclass_sfx'));

        // Check for layout override only if this is not the active menu item
        // If it is the active menu item, then the view and category id will match
        $active	= $app->getMenu()->getActive();

        $this->setLayout('default');

        JPluginHelper::importPlugin('content');
        $app->triggerEvent('onContentPrepare', array ('com_joomtestimonials.testimonial', &$this->item, &$this->params, $offset));
        $this->_prepareDocument();

        $doc->addScriptDeclaration('
            $( document ).ready(function() {
                jQuery(".permalink").addClass("hidden");
            });
        ');

        parent::display($tpl);
    }

    /**
     * Prepares the document.
     */
    protected function _prepareDocument() {
        $app		= JFactory::getApplication();
        $menus		= $app->getMenu();
        $title		= null;

        // Because the application sets the default page title,
        // we need to get it from the menu item itself
        $menu		= $menus->getActive();

/*      if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_JOOMTESTIMONIALS_DEFAULT_PAGE_TITLE'));
        }
*/
        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->get('sitename');
        } else if ($app->get('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } else if ($app->get('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        JFactory::getDocument()->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }

    public function getVoteLayout($number){

        $icolor = $this->params->get('layoutparams')->get('inactivestar_color','#d2d2d2');
        $acolor = $this->params->get('layoutparams')->get('activestar_color','#edb867');


        $style = '
			span.joomstar:after {
    			content: "\2605";
    			color: '.$icolor.';
				font-size: 20px;
			}
				
			span.joomstar.joomactivestar:after{	
				color: '.$acolor.';
			}			
		';

        JFactory::getDocument()->addStyleDeclaration($style);

        $number = (int) $number;

        $vote = '<div class="joomstars">';

        for($x=1;$x<=$number;$x++) {
            $vote .= '<span class="joomstar joomactivestar"></span>';
        }

        while ($x<=5) {
            $vote .= '<span class="joomstar joominactivestar"></span>';
            $x++;
        }

        $vote .= '</div>';

        return $vote;

    }

}