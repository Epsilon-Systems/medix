<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

/**
 * View class for a list of testimonials.
 *
 * @package		Joomla.Frontend
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsViewTestimonials extends JViewLegacy {

    public    $hide_header = 0;
    public    $show_submit_button = 1;
    protected $items;
    protected $pagination;
    protected $state;
    protected $text_limit;
    protected $text_chars;
    protected $text_hover;
    protected $myLayouts = array();
    protected $num_xs = 12;
    protected $num_sm = 6;
    protected $num_md = 4;
    protected $num_lg = 3;
    protected $num_xl = 3;
    protected $num_xxl = 3;
    protected $cspan = '';
    protected $gutter_x = 3;
    protected $gutter_y = 3;
    protected $gutter = '';

    /**
     * Display the view.
     */
    public function display($tpl = null)
    {
        // inits
        $app	= JFactory::getApplication();

        // Get some data from the model
        $this->state		= $this->get('State');
        $this->items		= $this->get('Items');
        $this->pagination	= $this->get('Pagination');
        $this->params		= LayoutHelper::getListLayoutParams();

        $offset = $this->state->get('list.offset');


        $layoutparams       = $this->params->get('layoutparams');

        $list_main = (array)$layoutparams->get('list_main');
        $this->show_submit_button = isset($list_main['show_submit_button'])?$list_main['show_submit_button'] : 0;

        // layouts
        $default_layout = $this->params->get('testimonials_layout', ':_default');
        $layout = $app->input->get('layout', substr($default_layout, 2),'word');

        $this->myLayouts['testimonial.css'] = new JLayoutFile('list.'.$layout.'.style'); // dynamic css layout
        $this->myLayouts['header']          = new JLayoutFile('common.list.header');
        $this->myLayouts['pagination']      = new JLayoutFile('common.list.pagination');

        JHtml::_('stylesheet', 'media/com_joomtestimonials/list/'.$layout.'/'.$layout.'.css', false, array(), false, false, true);

        // autoload dynamic css
        $this->myLayouts['testimonial.css']->render(["tagid"=>"#jt-menu"]);

        // load animation
        if($layoutparams->get('supportAnimation')) JoomtestimonialsFrontendHelper::loadAnimation($layoutparams);

        $display_list_type = $layoutparams->get('display_list_type');
        if($display_list_type!='carousel'){
            // columns
            $list_columns = (array)$layoutparams->get('list_columns');

                $this->num_xs       =  isset($list_columns['bs_xs_columns'])?$list_columns['bs_xs_columns']:12;
                $this->num_sm       =  isset($list_columns['bs_sm_columns'])?$list_columns['bs_sm_columns']:6;
                $this->num_md       =  isset($list_columns['bs_md_columns'])?$list_columns['bs_md_columns']:4;
                $this->num_lg       =  isset($list_columns['bs_lg_columns'])?$list_columns['bs_lg_columns']:3;
                $this->num_xl       =  isset($list_columns['bs_xl_columns'])?$list_columns['bs_xl_columns']:3;
                $this->num_xxl       =  isset($list_columns['bs_xxl_columns'])?$list_columns['bs_xxl_columns']:3;

            $this->cspan        = "col-$this->num_xs col-sm-$this->num_sm col-md-$this->num_md col-lg-$this->num_lg col-xl-$this->num_xl col-xxl-$this->num_xxl";
            $this->gutter_x = isset($list_columns['gutter_x'])?$list_columns['gutter_x']:3;
            $this->gutter_y = isset($list_columns['gutter_y'])?$list_columns['gutter_y']:3;
            $this->gutter = "gx-$this->gutter_x  gy-$this->gutter_y";

            $this->animated = '';
        }elseif($layoutparams->get('supportCarousel')){

            \Joomla\CMS\Layout\LayoutHelper::render('common.list.carousel',
                ['id'=>'testimonialsContainer', 'tagId'=>'testimonialsContainer', 'layoutparams'=>$layoutparams],
                JPATH_SITE.'/components/com_joomtestimonials/layouts');
            $this->cspan = '';
            $this->animated = '-animated'; // Display Carousel
        }else{
            $this->animated = '';
        }

        // load js code of video field
        $item_video        = (array)$layoutparams->get('item_video');
        $video_type         = isset($item_video['video_type'])?$item_video['video_type']:0;

        echo ($video_type)? JoomtestimonialsFrontendHelper::loadVideoJs() : '';

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            $app->enqueueMessage(implode("\n", $errors), 'error');
            return false;
        }

        $this->pageclass_sfx	= htmlspecialchars($this->params->get('pageclass_sfx'));
        $this->layout = substr($this->params->get('testimonials_layout', '_:default'), 2);
        $this->setLayout('default');

        // Custom fields
        JPluginHelper::importPlugin('content');
        foreach($this->items as $item){
            $item->text = '';
            $app->triggerEvent('onContentPrepare', ['com_joomtestimonials.testimonial', &$item, &$item->params, 0]);
        }

        // Text limiter
        JLayoutHelper::render('common.item.textLimiter', ['params'=>$layoutparams]);

        $this->_prepareDocument();

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

        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_JOOMTESTIMONIALS_DEFAULT_PAGE_TITLE'));
        }

        $title = $this->params->get('page_title', '');

        // display page numbers in title tag to avoid duplicate title pages
        $start = JFactory::getApplication()->input->get('start',0,'int');
        if($start > 0){

            $limit = $this->params->get('list_limit',6);

            // calculate page number from limi
            $pageNumber = round($start/$limit);


            $title = $title.' - '.JText::_('COM_JOOMTESTIMONIALS_PAGE').' '.$pageNumber;
        }

        if (empty($title)) {
            $title = $app->get('sitename');
        } else if ($app->get('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
        } else if ($app->get('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
        }

        $this->document->setTitle($title);

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

}