<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Filesystem\Folder;

defined('_JEXEC') or die;

require_once  JPATH_ROOT . '/administrator/components/com_joomtestimonials/models/testimonial.php';

/**
 * Methods supporting a form of submitting Testimonial.
 *
 * @package		Joomla.Site
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsModelForm extends JoomtestimonialsModelTestimonial {
	protected $_context = 'com_joomtestimonials.testimonial';

	/**
	 * Get the return URL.
	 * @return	string	The return URL.
	 */
	public function getReturnPage() {	
				
		return base64_encode($this->getState('return_page'));
	}

	/**
	 * Method to auto-populate the model state.
	 * Note. Calling getState in this method will result in recursion.
	 */
	protected function populateState() {

		$app = JFactory::getApplication();

		// component params
		$gparams = JComponentHelper::getParams('com_joomtestimonials');
		// global params
		$gparams2 = $app->getParams();

		// merger both params
		$params = clone $gparams2;
		$params->merge($gparams);

		$this->setState('params', $params);

		// Load state from the request.
		$pk = $app->input->getInt('t_id');	
		
		$this->setState('testimonial.id', $pk);

		// Add compatibility variable for default naming conventions.
	
		$this->setState('form.id', $pk);
		$categoryId	= $app->input->getInt('catid');
		$this->setState('testimonial.catid', $categoryId);

		$return = $app->input->get('return', null, 'default', 'base64');

		if (!JUri::isInternal(base64_decode($return))) {
			
			$input = $app->input;		
			
			$itemid = $input->getInt('Itemid');
			$itemid = "&Itemid=$itemid";	
			
			$return = JRoute::_("index.php?option=com_joomtestimonials&view=form&layout=edit$itemid");
			$return = base64_encode($return);
		}

		$this->setState('return_page', base64_decode($return));
		$this->setState('layout', $app->input->getCmd('layout'));
	}

	/**
	 * Method to get form.
	 */
	function getForm($data = array(), $loadData = true) {

		
		if (!($form = parent::getForm($data, $loadData))) {
			return false;
		}

		// Set form field attributes
		$config				= JComponentHelper::getParams('com_joomtestimonials');



		$optional_fields	= array(
			'catid'		=> 1,
			'email'		=> 1,
			'position'	=> 1,
			'company'	=> 1,
			'website'	=> 1,
			'vote'	=> 1,
			'file'	=> 1,
			'video'	=> 1,
		);

		foreach ($optional_fields as $field => $default) {
			if ($config->get('field_' . $field . '_visible', $default) && $config->get('field_' . $field . '_required', $default)) {
				$form->setFieldAttribute($field, 'required', 'true');
				$form->setFieldAttribute($field, 'class', 'required ' . $form->getFieldAttribute($field, 'class'));
			} else {
				$form->setFieldAttribute($field, 'required', 'false');

			}
		}

		# hide placeholders
		if(!$config->get('show_placeholders',1)){

			$fields_with_placeholders = ['name','email','position','company','website','testimonial'];

			foreach ($fields_with_placeholders as $placeholder_field){
				$form->setFieldAttribute($placeholder_field, 'hint', '');
			}

		}

		if ($config->get('field_avatar_visible') && $config->get('field_avatar_required') && !$form->getValue('avatar')) {
			//$form->setFieldAttribute('avatar_file', 'required', 'true');
			$form->setFieldAttribute('avatar_file', 'class', 'required ' . $form->getFieldAttribute('avatar', 'class'));
		} else {
			$form->setFieldAttribute('avatar_file', 'required', 'false');
		
		}



		// joomla reload page when the category field has changed, so we need to empty this attribute.
		if ($form->getField('catid'))
		{
			$form->setFieldAttribute('catid', 'onchange', '');
		}

        // Field Testimonial switch to editor (by default textarea)
        if($config->get('testimonial_field_type',0)){
            $form->setFieldAttribute('testimonial', 'type', 'editor');
        }
		
		// for image picker
		if($config->get('picture_field_type',0)){

            $spath = JPATH_ROOT.DIRECTORY_SEPARATOR.$config->get('picture_dir','images/avatar');
            $ppath = JURI::base().$config->get('picture_dir','images/avatar');

            if(!Folder::exists($spath)){
                JFactory::getApplication()->enqueueMessage("<strong>Image Picker can't be used</strong><br>No images found on this folder <code>".$config->get('picture_dir','images/avatar').'</code>','warning');
            }else{
                $form->setFieldAttribute('avatar_file', 'type', 'imagelist');
                $form->setFieldAttribute('avatar_file', 'hide_none', 'true');
                $form->setFieldAttribute('avatar_file', 'hide_default', 'true');
                $form->setFieldAttribute('avatar_file', 'directory', $config->get('picture_dir'));




                $cscript = "jQuery(document).ready(function($){
					
					$('#jform_avatar_file option').each(function() {					    
					    $(this).data('img-src','{$ppath}/' + $(this).attr('value'))
					});
				
					$('#jform_avatar_file').imagepicker();		
			});";

                JFactory::getDocument()->addScriptDeclaration($cscript);
                \Joomla\CMS\Factory::getDocument()->addStyleDeclaration(".image_picker_image{max-height: 100px}");
            }


		}

		$user	= JFactory::getUser();

		if (!$user->authorise('core.edit.state', 'com_joomtestimonials')) {
			$form->setFieldAttribute('state', 'filter', 'unset');
		}


		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return mixed	The data for the form.
	 */
	protected function loadFormData() {
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();

		// Check the session for previously entered form data.
		$data	= JFactory::getApplication()->getUserState('com_joomtestimonials.edit.testimonial.data', array());

		if (empty($data)) {
			$data	= $this->getItem();

			// Prime some default values.
			if ($this->getState('testimonial.id') == 0) {
				$data->set('catid', $app->input->getInt('catid', $app->getUserState('com_joomtestimonials.testimonials.filter.category_id')));

				if ($user->get('id')) {
					$data->set('name', $user->get('name'));
					$data->set('email', $user->get('email'));
				}
			}

			$lang = $data->get('language');

			if(JLanguageMultilang::isEnabled() && is_null($lang)){
				$data->set('language',JFactory::getLanguage()->getTag());
			}
		}


		if(is_array($data)){

			if(JLanguageMultilang::isEnabled() && !isset($data['language'])){
				$data['language'] = JFactory::getLanguage()->getTag();
			}
		}




		return $data;
	}
}