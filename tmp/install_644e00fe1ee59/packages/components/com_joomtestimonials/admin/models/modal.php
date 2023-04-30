<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Testimonial Model.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */


class JoomtestimonialsModelModal extends JModelAdmin
{
    /**
     * Method to get the record form.
     *
     * @param	array	$data		An optional array of data for the form to interogate.
     * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
     * @return	JForm				A JForm object on success, false on failure.
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Initialize variables.
        $app	= JFactory::getApplication();
        $layout = $app->input->get('layout');

        if($app->input->get('resetOptions') == true)  $loadData = false;

        $name = 'com_joomtestimonials.testimonialslayout.'.$layout;

        $path = JPATH_SITE.'/components/com_joomtestimonials/forms/';
        $source = 'list_template_'.$layout;

        // Get the form.
        JForm::addFormPath($path);

        $form	= $this->loadForm($name, $source, array('control' => 'jform', 'load_data' => $loadData));

        if (empty($form)) return false;

        return $form;
    }



protected function loadFormData()
    {
        // some inits
        $app	= JFactory::getApplication();
        $layout = $app->input->get('layout', 'default');
        $menuId = $app->input->get('menuId', 0);
        $moduleId = $app->input->get('moduleId', 0);
        $filename = JPATH_SITE.'/components/com_joomtestimonials/configs/';

        // if from session
        if($Invalid_data = $app->getUserState('Joomtestimonials.validation.data')) return $Invalid_data;

        // get from saved data
        $filename .= $menuId ? $layout.'.menu.'.$menuId.'.json' : '';
        $filename .= $moduleId ? $layout.'.module.'.$moduleId.'.json' : '';
        $filename .= !$menuId && !$moduleId ? $layout.'.json': '';

        $data = is_file($filename) ? json_decode(file_get_contents($filename)) : [];

        // todo File\Joomla\CMS\Filesystem\File::exists()


        return $data;
    }

}