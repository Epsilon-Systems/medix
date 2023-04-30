<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;

defined('_JEXEC') or die;

/**
 * Testimonial List Controller Class.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsControllerTestimonials extends JControllerAdmin {
	/** @var string		The prefix to use with controller messages. */
	protected $text_prefix	= 'COM_JOOMTESTIMONIALS_TESTIMONIALS';

	/**
	 * Proxy for getModel.
	 */
	public function getModel($name = 'Testimonial', $prefix = 'JoomtestimonialsModel', $config = array('ignore_request' => true))
    {
		$model	= parent::getModel($name, $prefix, $config);
		return $model;
	}

    function layoutModal()
    {
        $view		= $this->input->get('view', 'modal');
        $layout		= $this->input->get('layout', 'default');
        $this->input->set('view', $view);
        $this->input->set('layout', $layout);

        if(!PluginHelper::isEnabled('system','joomtestimonials')){
            // Ensure plugin is enabled to allow saving
            $db = Factory::getDbo();

            $query	= 'UPDATE #__extensions'
                . ' SET enabled = 1'
                . ' WHERE element ='.$db->q("joomtestimonials").' AND type ='.$db->q("plugin")
            ;
            $db->setQuery($query);
            if(!$db->execute()){
                $application = JFactory::getApplication();
                $application->enqueueMessage('Failed to enable plugin to allow layout options saving, global options will be used therefor.'.$db->getError(), 'error');
            }
        }

        return parent::display();
    }

    function saveModal()
    {
        $app = JFactory::getApplication();
        $data    = $this->input->get('jform', [],'array');

        $layout  = $this->input->get('layout');
        $id = $this->input->get('id', '-1');
        $type = $this->input->get('type', '');

        //Process validation
        $model = $this->getModel('modal');
        $form = $model->getForm($DATA = array(), false);
        $validData = $model->validate($form, $data);

        // Check for validation errors.
        if ($validData === false)
        {
            // Get the validation messages.
            $errors = $model->getErrors();

            // Push up to three validation messages out to the user.
            for ($i = 0, $n = \count($errors); $i < $n && $i < 3; $i++)
            {
                if ($errors[$i] instanceof \Exception)
                {
                    $app->enqueueMessage($errors[$i]->getMessage(), 'warning');
                }
                else
                {
                    $app->enqueueMessage($errors[$i], 'warning');
                }
            }

            // Save the data in the session.
            $app->setUserState('Joomtestimonials.validation.data', $data);

            // Reload Modal
            $this->input->set('tmpl','component');
            if($type == 'menu')  $this->input->set('menuId', $id);
            if($type == 'module'){
                $this->input->set('moduleId', $id);
                $this->input->set('isModule', 1);
            }

            return $this->layoutModal();
        }

        $app->setUserState('Joomtestimonials.validation.data', '');

        $data =  json_encode($data);
        // Building file.json path and save
        $filename = JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_joomtestimonials'.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR;

        switch ($type){
            case 'menu':
                if($id){
                    // case menu item editing.
                    $filename .= $layout.'.menu.'.$id.'.json';
                    file_put_contents($filename, $data);
                }else{
                    // case new menu item (store data in the session, plugin will create json file when saving the new menu item.
                    $app  = Factory::getApplication();
                    $app->setUserState('com_joomtestimonials.'.$layout.'.menu.tmp.json', $data);
                    $app->setUserState('testimonial_active_layout', $layout);
                }

                break;

            case 'module' :
                if($id){
                    // case module item editing.
                    $filename .= $layout.'.module.'.$id.'.json';
                    file_put_contents($filename, $data);
                }else{
                    // case new modue(store data in the session, plugin will create json file when saving the new menu item.
                    $app  = Factory::getApplication();
                    $app->setUserState('com_joomtestimonials.'.$layout.'.module.tmp.json', $data);
                    $app->setUserState('testimonial_active_layout', $layout);
                }
                break;

            default :
                // case global.
                $filename .= $layout.'.json';
                file_put_contents($filename, $data);
                break;
        }

        $this->closeModal();
    }

    protected function closeModal()
    {
        echo '<script> parent.document.querySelector("#closeModal").click(); </script> ';
        exit();
    }

	public function resetOptions()
    {

        $view		= $this->input->get('view', 'modal');
        $layout		= $this->input->get('layout', 'default');
        $this->input->set('view', $view);
        $this->input->set('layout', $layout);

        $this->input->set('resetOptions', true);
        $this->input->set('tmpl', 'component');


        return parent::display();
    }
}