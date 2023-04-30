<?php
/**
 * @copyright	Copyright (c) 2013 - 2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;


class modJoomtestimonialsSubmitHelper {


   public static function getForm(){

   	    // init
        $document	= JFactory::getDocument();
        $ccaptcha    = JComponentHelper::getParams('com_joomtestimonials')->get('captcha');
	    $gcaptcha    = JFactory::getApplication()->get('captcha');
        $input      = JFactory::getApplication()->input;

        // save request details
        $old_option     = $input->getCmd('option');
        $old_view       = $input->getCmd('view');
        $old_id         = $input->getInt('id');
	    $old_layout     = $input->getCmd('layout');

	    //capture form view
        ob_start();

		    $input->set('id', 0,'int');
		    $input->set('option','com_joomtestimonials','word');
		    $input->set('view','form','word');
		    $input->set('layout','edit','word');
	        $input->set('isModule',1,'int');

	        $options['name'] = 'form';
	        $options['layout'] = 'edit';
	        $options['tmpl'] = 'component';
	        $options['base_path'] = JPATH_ROOT . '/components/com_joomtestimonials';

	        JFactory::getLanguage()->load('com_joomtestimonials',JPATH_SITE);

	        JForm::addFormPath(JPATH_ROOT . '/components/com_joomtestimonials/models/forms/');
	        JForm::addFieldPath(JPATH_ROOT . '/administrator/components/com_joomtestimonials/models/fields/');
	        require_once  JPATH_ROOT . '/administrator/components/com_joomtestimonials/tables/testimonial.php';
	        require_once  JPATH_ROOT . '/components/com_joomtestimonials/controllers/testimonial.php';
	        require_once  JPATH_ROOT . '/components/com_joomtestimonials/models/form.php';
	        require_once  JPATH_ROOT . '/components/com_joomtestimonials/views/form/view.html.php';

	        // Fix captcha problem
	        if($ccaptcha)
		        JFactory::getApplication()->set('captcha',$ccaptcha);
	        else
		        JFactory::getApplication()->set('captcha',$gcaptcha);

			//load view
	        $controller = new JoomtestimonialsControllerTestimonial();
	        $controller->_model = new JoomtestimonialsModelForm();
	        $view = new JoomtestimonialsViewForm($options);

	        $view->setModel($controller->_model, true);
	        //  $view->hide_header = 1;
	        $view->display();

	        $output = ob_get_contents();

        ob_end_clean();


	   // restore request details
	   $input->set('option', $old_option,'word');
	   $input->set('view', $old_view,'word');
	   $input->set('layout', $old_layout,'word');
	   $input->set('id', $old_id,'int');

	    // return form view
        return $output;


    }


}