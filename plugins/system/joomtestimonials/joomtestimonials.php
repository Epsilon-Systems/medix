<?php
/**
 * @package		JoomTestimonials
 * @copyright	2013-2017 JoomBoost, https://www.joomboost.com
 * @license		GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

# No Permission
defined('_JEXEC') or die();

use Joomla\CMS\Factory;

define('PATH_TO_CONFIG', JPATH_SITE.'/components/com_joomtestimonials/configs/');

class plgSystemJoomtestimonials extends JPlugin {

    /**
     * Creates json file and store Data for new menu item.
     *
     * @param $context
     * @param $table
     * @param $isNew
     * @return bool|void
     * @throws Exception
     *
     */
    public  function onContentAfterSave($context, &$table, $isNew){

        // inits
        $app  = Factory::getApplication();

        // don't continue if context  is not menu item
        if(
            $context != 'com_menus.item' || // check context
            $table->link != 'index.php?option=com_joomtestimonials&view=testimonials'
        )
            return;

        $layout_params = json_decode($table->params);

        // Create Json file from selected menu item
        if(!str_contains($layout_params->testimonials_layout, '_:')) {
            $source = $layout_params->testimonials_layout;
            $new_menu_id = $table->id;
            $this->CopyJsonFile($source, $new_menu_id, 'menu');
            return true ;
        }

        // Create Json file for new menu items
        $active_layout = $app->getUserState('testimonial_active_layout');
        $data = $app->getUserState('com_joomtestimonials.'.$active_layout.'.menu.tmp.json');

        // don't continue if not new menu item
        if(
            !$isNew || // check if new
            empty($active_layout) ||
            empty($data)

        )
            return false;


        $layout_params = json_decode($table->params);
        $layout        = substr($layout_params->testimonials_layout, 2);


        if($layout != $active_layout)
            return false;

        $menu_id = $table->id;

        $filename = PATH_TO_CONFIG.$layout.'.menu.'.$menu_id.'.json';
        file_put_contents($filename, $data);

        return true;
    }

    /**
     * Creates json file and store Data for new module item.
     *
     * @param $context
     * @param $table
     * @param $isNew
     * @return bool|void
     * @throws Exception
     */
    public function onExtensionAfterSave($context, &$table, $isNew){

        // inits
        $app  = Factory::getApplication();
        $active_layout = $app->getUserState('testimonial_active_layout');
        $data = $app->getUserState('com_joomtestimonials.'.$active_layout.'.module.tmp.json');

        if(
            $context != 'com_modules.module' || // check context
            $table->module != 'mod_joomtestimonials'
        )
            return;

        $layout_params = json_decode($table->params);

        // Create Json file from selected module
        if(!str_contains($layout_params->testimonials_layout, '_:')) {
            $source = $layout_params->testimonials_layout;
            $new_module_id = $table->id;
            $this->CopyJsonFile($source, $new_module_id, 'module');
            return true ;
        }

        // Create Json file for new module
        if(
            !$isNew || // check if new
            empty($active_layout) ||
            empty($data)

        )
            return false;

        $layout        = substr($layout_params->testimonials_layout, 2);

        if($layout != $active_layout)
            return false;

        $module_id = $table->id;

        $filename = PATH_TO_CONFIG.$layout.'.module.'.$module_id.'.json';
        file_put_contents($filename, $data);

        return true;
    }

    /**
     * Copy params from an existing given item and apply those params to the handled item.
     *
     * @param $source
     * @param $new_id
     * @param $type
     * @throws Exception
     */
    public static function CopyJsonFile($source, $new_id, $type) {

        // Copy layout params from $source
        $filename =  PATH_TO_CONFIG.$source;
        $params = file_get_contents($filename);

        $layout = explode('.', $source);

        $filename = PATH_TO_CONFIG.$layout[0].'.'.$type.'.'.$new_id.'.json';
        file_put_contents($filename, $params);

        // Update item layout type
        $db =  JFactory::getDBO();

        switch ($type){
            case 'menu':
                $table = '#__menu';
                break;
            case 'module':
                $table = '#__modules';
                break;
        }

        $query	= 'SELECT `params`  from  `'.$table.'` WHERE `id`='.$db->q($new_id);

        $db->setQuery($query);
        $params = $db->loadResult();

        $params = json_decode($params);
        $params->testimonials_layout = '_:'.$layout[0];
        $params = json_encode($params);

        $query	= 'UPDATE  '.$table
            . ' SET params ='.$db->q($params)
            . ' WHERE id ='.$db->q($new_id)
        ;

        $db->setQuery($query);

        $application = JFactory::getApplication();
        if(!$db->execute()){
            $application->enqueueMessage('Failed to update item layout type '.$db->getError(), 'error');
        }else{
            //TODO translate with "COM_JOOMTESTIMONIALS_SAVE_SUCCESSFUL"
            $application->enqueueMessage('Parameters of the selected item were successfully applied to this item.', 'success');
        }

    }

}
