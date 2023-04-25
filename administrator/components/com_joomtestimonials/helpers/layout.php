<?php
/**
 * @copyright    Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Form\Form;

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\Filesystem\Folder;
define('PATH_TO_CONFIGS',  JPATH_SITE . '/components/com_joomtestimonials/configs/' );
/**
 * JoomTestimonials Helper.
 *
 * @package        Joomla.Administrator
 * @subpackage    JoomBoost.Joomtestimonials
 */
class LayoutHelper
{

    public static $data = [];

    /**
     * Method to get an array or a list of existing testimonial layouts.
     *
     * @return    array/string    array or html list of layouts.
     */
    public static function getListLayouts($list = false)
    {
        $path = JPATH_SITE . '/components/com_joomtestimonials/layouts/list';
        $path_to_xml = JPATH_SITE . '/components/com_joomtestimonials/forms/list_template_';

        $files = Folder::folders($path, $filter = '.', $recurse = false, $full = false, $exclude = ['.svn', 'CVS', '.DS_Store', '__MACOSX'],$excludeFilter = ['^\..*'] );

        foreach ($files as $k=>$file){
            if(!is_file($path_to_xml . $file . '.xml')) unset($files[$k]);

            $option = JFactory::getApplication()->input->get('option');
            if($option == 'com_modules' && $file == 'timeline' ) unset($files[$k]);
        }

        if (!$list) return $files;

        foreach ($files as $k => $layout) {
            $xml = new SimpleXMLElement($path_to_xml . $layout . '.xml', $options = 0, $data_is_url = true);
            $form = new Form('myLayoutForm');
            $form->load($xml);
            $option = $form->getField('layout')->getAttribute('option');

            $data['_:' . $layout] = $option;
        }
        return $data;
    }

    public static function getListLayoutParams()
    {
        $app = JFactory::getApplication();

        $Module = false;
        $Menu = false;

        $params = JComponentHelper::getParams('com_joomtestimonials');
        $default_layout = $params->get('testimonials_layout', '_:default');

        $layout = $app->input->get('layout', substr($default_layout, 2), 'word');
        $option = $app->input->get('option');

        $jt_module = $app->input->get('jt_modules_call_for_params', false);
        $jt_modules_context = $app->input->get('jt_modules_context');

        if($jt_module && $jt_modules_context){
// Case Module
            $context = $jt_modules_context['layout'].'.module.'.$jt_modules_context['id'];
            if(  isset(static::$data[$context]) && !empty(static::$data[$context]) )
                return static::$data[$context];

            $Module = true;
        }
        else{

            $view = $app->input->get('view');
            $menu = $app->getMenu()->getActive();
            $Menulayout = $menu->getParams()->get('testimonials_layout');
// Case Menu
            $context = $Menulayout.'.menu.'.$menu->id;
            if( $option == 'com_joomtestimonials' && $view == 'testimonials' && $Menulayout) {
                if(isset(static::$data[$context]) && !empty(static::$data[$context]))  return static::$data[$context];
                    $Menu = true;
                }
// Case global
            if( $option == 'com_joomtestimonials' && $view == 'testimonials' && !$Menulayout )
                if(isset(static::$data[$layout]) && !empty(static::$data[$layout])) return static::$data[$layout];
        }

        $globalLayoutParams = static ::getGlobalLayoutParams($layout);

        if ($Menu) {

            $menuLayoutParams = static ::getMenuLayoutParams($menu, null, null);
            $menuParams = $menu->getParams();

            // merging menu params with global params
            $params->merge($menuParams);

            // merging layout params only
            $globalLayoutParams->merge($menuLayoutParams);

            //context
            $layout = $menuParams->get('testimonials_layout').'.menu.'.$menu->id;
        }

        if($Module){

            $modulelayout = $jt_modules_context['layout'];
            $moduleId     = $jt_modules_context['id'];

            $ModuleLayoutParams = static ::getModuleLayoutParams($moduleId, $modulelayout);

            $moduleParams = new JRegistry();
            $moduleParams->loadString(JModuleHelper::getModuleById($moduleId)->params);

            // merging module params with global params
            $params->merge($moduleParams);

            // merging layout params only
            $globalLayoutParams->merge($ModuleLayoutParams);

            //context
            $layout = $modulelayout.'.module.'.$moduleId;
        }

        $params->set('layoutparams', $globalLayoutParams);

        static ::$data[$layout] = $params;
        return static ::$data[$layout];
    }

    /**
     * @param $layout  String  Global layout to catch its params.
     * @return  String  layout params.
     */
    public static function getGlobalLayoutParams($layout)
    {
        $data = new JRegistry();
        $filename = PATH_TO_CONFIGS . $layout . '.json';

        if (is_file($filename)) {
            $data->loadString(file_get_contents($filename)) ;
        }
        return $data;
    }

    /**
     * @param $menu  String  Menu layout to catch its params.
     * @return  String  layout params.
     */
    public static function getMenuLayoutParams($menu, $id, $layout)
    {
        $data = new JRegistry();
        if($menu){
            $menu_id = $menu->id;
            $layout = substr($menu->getParams()->get('testimonials_layout'), 2);
        }else{
            $menu_id = $id;
        }
        $filename = PATH_TO_CONFIGS . $layout . '.menu.' . $menu_id. '.json';

        if (is_file($filename)) {
            $data->loadString(file_get_contents($filename)) ;
        }
        return $data;
    }

    /**
     * @param $module  String  Menu layout to catch its params.
     * @return  String  layout params.
     */
    public static function getModuleLayoutParams($id, $layout)
    {
        $data = new JRegistry();
        $filename = PATH_TO_CONFIGS . $layout . '.module.' . $id. '.json';

        if (is_file($filename)) {
            $data->loadObject(json_decode(file_get_contents($filename))) ;
        }
        return $data;
    }


    public  static  function  getListLayoutTypes() {

        $app	= JFactory::getApplication();
        $layout = $app->input->get('layout');
        $path = JPATH_SITE . '/components/com_joomtestimonials/layouts/list/'.$layout;
        $dirs = array();

        $files = Folder::files($path, $filter = '.', $recurse = false, $full = false, $exclude = ['.svn', 'CVS', '.DS_Store', '__MACOSX'],
            $excludeFilter = ['^\..*', '.*~']);

        foreach ($files as $file){
            if (str_contains($file, 'item-')) {
                $type = explode('.', $file);
                $dirs[$type[0]] = ucfirst(str_replace('-', ' ', substr($type[0], '5')));
            }
        }

        return $dirs ;
    }

    public  static  function  getSetLayoutType() {
        $app = JFactory::getApplication();
        $layout = $app->input->get('layout');

        if($menuId = $app->input->get('menuId')){
            $data = static ::getMenuLayoutParams(false, $menuId, $layout);
            return $data;
        }

        if($moduleId = $app->input->get('moduleId')){
            $data = static ::getModuleLayoutParams($moduleId, $layout);
            return $data;
        }

        $data = static ::getGlobalLayoutParams($layout);
        return $data;

    }

    public  static  function getSelectedValue(){
        $db =  JFactory::getDBO();
        $uri = Uri::getInstance();
        $option = $uri->getVar('option');
        $id = $uri->getVar('id');

        if(!$id) return;

        $table	= ($option == 'com_menus')? '`#__menu`': '`#__modules`';
        $query	= "SELECT `params`  from  {$table}  WHERE `id` = {$id}";

        $db->setQuery($query);
        $data = json_decode($db->loadResult());
        return $data->testimonials_layout;
    }

    public  static  function  getLayoutParentTypes()
    {
        $db =  JFactory::getDBO();
        $data = array();
        $data['Layout'] = self::getListLayouts(true);

        $query	= 'SELECT *  from `#__menu` WHERE `link` LIKE '.$db->q('index.php?option=com_joomtestimonials&view=testimonials%')
            .' AND `published`=1 AND `params` LIKE '.$db->q('%testimonials_layout%');
        $db->setQuery($query);
        $menu_list = $db->loadObjectList();

        $query	= 'SELECT *  from `#__modules` WHERE `module`='.$db->q('mod_joomtestimonials').' AND `published`=1';
        $db->setQuery($query);
        $module_list = $db->loadObjectList();

        $path = JPATH_SITE . '/components/com_joomtestimonials/configs';

        // create configs folder if doesn't exist
        if(!\Joomla\CMS\Filesystem\Folder::exists($path))
            \Joomla\CMS\Filesystem\Folder::create($path);

        $files = Folder::files($path, $filter = '.', $recurse = false, $full = false, $exclude = ['.svn', 'CVS', '.DS_Store', '__MACOSX'],
            $excludeFilter = ['^\..*', '.*~']);

        foreach ($files as $file){
            $segments = explode('.', $file);

            $option = JFactory::getApplication()->input->get('option');
            if($option == 'com_modules' && $segments[0] == 'timeline') continue;

            if(count($segments) > 2){
                $list = ($segments[1] =='menu' )? $menu_list : $module_list;
                foreach ($list as $item){
                    $params = json_decode($item->params);
                    $layout = ($params->testimonials_layout)? $params->testimonials_layout:'';

                    if($item->id == $segments[2] && substr($layout, 2) == $segments[0]){
                        $data['Existing '.$segments[1].' layouts'][$file] = ucfirst($item->title).' (ID:'.$segments[2].', Layout: '.ucfirst($segments[0]).')';
                    }
                }
            }
        }

        return $data;
    }

}