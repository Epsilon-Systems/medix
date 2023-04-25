<?php
/**
 * @copyright    Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
define('PATH_TO_CONFIGS',  JPATH_SITE. '/components/com_joomtestimonials/configs/');
/**
 * JoomTestimonials Helper.
 *
 * @package        Joomla.Administrator
 * @subpackage    JoomBoost.Joomtestimonials
 */
class JoomTestimonialsMigrateHelper
{
    public  static  function migrateJ4(){

        $html ='';

        if(self::migrateMenus()){
            $html .= '<div class="alert-success">Menus migration was successful!</div> <br>';
        }else{
            $html .='<div class="alert-warning">Menus migration failed!</div><br>' ;
        }

        if(self::migrateModules()){
            $html .= '<div class="alert-success">Modules migration was successful!</div> <br>';
        }else{
            $html .='<div class="alert-warning">Modules migration failed!</div><br>' ;
        }

        if(self::migrateGlobalParams()){
            $html .= '<div class="alert-success">Global parameters migration was successful!</div>';
        }else{
            $html .='<div class="alert-warning">Global parameters migration failed!</div>' ;
        }

        return $html;
    }

    public  static  function migrateMenus(){
        //Load menus list from database.
        $db =  JFactory::getDBO();
        $query	= 'SELECT *  from `#__menu` WHERE `link` LIKE '.$db->q('index.php?option=com_joomtestimonials&view=testimonials%').' AND `client_id` = 0';

        $db->setQuery($query);
        $menus = $db->loadObjectList();

        foreach ($menus as $key=>$menu){
            //Create Json file for this item.
            if(!self::createJsonFileFromParams($menu, 'menu')){
                return false;
            }

            //Update this item link and params.
            if(!$params = self::updateItemParams($menu)){
                return false;
            }

            $update = new stdClass();
            $update->id = $menu->id;
            $update->link = 'index.php?option=com_joomtestimonials&view=testimonials';
            $update->params = $params;

            if(!$db->updateObject('#__menu',$update,'id')){
                return false;
            }
        }
        return true;
    }

    public  static  function migrateModules(){
        //Load modules list from database.
        $db =  JFactory::getDBO();
        $query	= 'SELECT *  from `#__modules` WHERE `module` ='.$db->q('mod_joomtestimonials');
        $db->setQuery($query);
        $modules = $db->loadObjectList();

        foreach ($modules as $key=>$module){
            //Create Json file for this item.
            if(!self::createJsonFileFromParams($module, 'module')){
                return false;
            }

            //Update this item params.
            if(!$params = self::updateItemParams($module)){
                return false;
            }

            $update = new stdClass();
            $update->id = $module->id;
            $update->params = $params;

            if(!$db->updateObject('#__modules',$update,'id')){
                return false;
            }

        }
        return true;
    }

    public  static  function migrateGlobalParams(){
        //Load Global params
        $component= JComponentHelper::getComponent('com_joomtestimonials');

        //Create Json file for global params.
        if(!self::createJsonFileFromParams($component, 'global')){
            return false;
        }
        return true;
    }

    public static function createJsonFileFromParams($item, $itemType){

        // take this layout params -> adapt to json file
        $params = json_decode($item->params);
        $id = $item->id;

        //Construct filename
        $layoutType = self::findItemType($item);
        if(!$layoutType) return false;

        $filename = ($itemType == 'global')? "$layoutType.json" : "$layoutType.$itemType.$id.json";

        //Construct file content.
        $json_params = self::prepareParams($params, $layoutType);
        if(!$json_params) return false;

        if(!file_put_contents(PATH_TO_CONFIGS.$filename, $json_params)) return false;

        return true;
    }

    public static function updateItemParams($item){
        ///Set layout type in the params (exemple : "testimonials_layout":"_:default").
        $params = json_decode($item->params);
        $layoutType = self::findItemType($item);

        if(!$layoutType) return false;

        $params->testimonials_layout = '_:'.$layoutType;
        $params = json_encode($params);

        return $params;
    }

    public static function findItemType($item){
//Case Menu
        if(isset($item->link)){
            preg_match('/.*&layout=(.*)/',$item->link,$matches);

            if(isset($matches[1])){
                if($matches[1] == 'quote' || $matches[1] == 'box') $matches[1] = 'quotes';
                return $matches[1];
            }

            return 'default';
        }

//Case Module and Global
        $params = json_decode($item->params);
        $type ='';
        if(isset($params->layout))
            $type = substr($params->layout, 2);

        if(isset($params->testimonials_layout))
            $type = substr($params->testimonials_layout, 2);

        if($type == 'box' || $type == 'quote') $type = 'quotes';
        if($type) return $type;

        return false;
    }

    public static function prepareParams($params, $layoutType)
    {
        $migrate_params   = new stdClass();
        $params           = new JRegistry($params);
        $layout           = ($params->get('layout', false))? '-'.substr($params->get('layout'), 2):'';
        $layoutparams     = new JRegistry($params->get('layoutparams'.$layout));

        $list_main        = array();
        $list_columns     = array();
        $item_textlimiter = array();
        $item_video       = array();
        $list_animation   = array();
        $carousel         = array();

        if($layoutType != 'timeline'){
            $migrate_params->supportCarousel  = 1;
            $migrate_params->supportAnimation = 1;
        }

        $list_main['orderby']          = $params->get('orderby' , '');
        $list_columns['bs_xs_columns'] = $params->get('bs_xs_columns' , '');
        $list_columns['bs_sm_columns'] = $params->get('bs_sm_columns' , '');
        $list_columns['bs_md_columns'] = $params->get('bs_md_columns' , '');
        $list_columns['bs_lg_columns'] = $params->get('bs_lg_columns' , '');
        $list_columns['bs_xl_columns'] = $params->get('bs_xl_columns' , '');
        $list_columns['bs_xxl_columns']= $params->get('bs_xxl_columns' , '');

        $list_main['list_limit']              = $params->get('list_limit' , '');
        $list_main['show_pagination']         = $params->get('show_pagination' , '');
        $list_main['show_pagination_results'] = $params->get('show_pagination_results' , '');


        switch ($layoutparams->get('list_type', '0')) {
            case 0 :
                $migrate_params->list_type = 'item-normal';
                break;
            case 1 :
                $migrate_params->list_type = 'item-card';
                break;
            case 2 :
                $migrate_params->list_type = 'item-card-floated';
                break;
            default :
                $migrate_params->list_type = 'item-normal';
                break;
        }

        $migrate_params->box_color         = $layoutparams->get('box_color' , '');
        $migrate_params->font_size         = $layoutparams->get('font_size' , '');
        $migrate_params->text_color        = $layoutparams->get('text_color' , '');
        $migrate_params->link_color        = $layoutparams->get('link_color' , '');
        $migrate_params->box_border_color  = $layoutparams->get('box_border_color' , '');
        $migrate_params->box_border_type   = $layoutparams->get('box_border_type' , '');
        $migrate_params->box_border_radius = $layoutparams->get('box_border_radius' , '');
        $item_video['show_video']       = $layoutparams->get('show_video' , '');
        $item_video['video_type']       = $layoutparams->get('video_type' , '');
        $item_video['video_width']      = $layoutparams->get('video_width' , '');
        $item_video['video_height']     = $layoutparams->get('video_height' , '');
        $item_video['lightbox_button']  = $layoutparams->get('lightbox_button' , '');
        $migrate_params->show_cfields   = $layoutparams->get('show_fields' , '');
        $migrate_params->show_vote           = $layoutparams->get('show_vote' , '');
        $migrate_params->activestar_color    = $layoutparams->get('activestar_color' , '');
        $migrate_params->inactivestar_color  = $layoutparams->get('inactivestar_color' , '');
        $migrate_params->rating_position     = $layoutparams->get('rating_position' , '');
        $migrate_params->permalink_btn_class = $layoutparams->get('permalink_btn_class' , '');
        $migrate_params->show_date       = $layoutparams->get('show_date' , '');
        $migrate_params->show_position   = $layoutparams->get('show_position' , '');
        $migrate_params->show_company    = $layoutparams->get('show_company' , '');
        $migrate_params->link_website    = $layoutparams->get('link_website' , '');
        $migrate_params->show_avatar     = $layoutparams->get('show_avatar' , '');
        $migrate_params->avatar_position = $layoutparams->get('avatar_position' , '');
        $migrate_params->avatar_size     = $layoutparams->get('avatar_size' , '');
        $migrate_params->avatar_radius   = $layoutparams->get('avatar_radius' , '');
        $migrate_params->custom_css      = array('custom_css' => $layoutparams->get('custom_css' , ''));
        $migrate_params->avatar_position_box  = $layoutparams->get('avatar_position_box' , '');
        $migrate_params->card_bg              = $layoutparams->get('card_bg' , '');
        $migrate_params->card_border          = $layoutparams->get('card_border' , '');


        $list_animation['animation']            = $params->get('animation' , '');
        $list_animation['anim_boxclass']        = $params->get('anim_boxclass' , '');
        $list_animation['anim_animateclass']    = $params->get('anim_animateclass' , '');
        $list_animation['anim_duration']        = $params->get('anim_duration' , '');
        $list_animation['anim_delay']           = $params->get('anim_delay' , '');
        $list_animation['anim_offset']          = $params->get('anim_offset' , '');
        $list_animation['anim_mobile']          = $params->get('anim_mobile' , '');
        $list_animation['anim_live']            = $params->get('anim_live' , '');
        $list_animation['anim_scrollcontainer'] = $params->get('anim_scrollcontainer' , '');


        $migrate_params->display_list_type    = $params->get('type' , 'list');

        $carousel['autoplay']           = $params->get('autoplay' , '1');
        $carousel['autoplaydelay']      = $params->get('autoplaydelay' , '2000');
        $carousel['effect']             = $params->get('effect' , 'slide');
        $carousel['slideshadows']       = $params->get('slideshadows' , 'true');
        $carousel['item1024']           = $params->get('item1024' , '');
        $carousel['item768']            = $params->get('item768' , '');
        $carousel['item480']            = $params->get('item480' , '');
        $carousel['bar']                = $params->get('bar' , '');
        $carousel['navbuttons']         = $params->get('navbuttons' , '');
        $carousel['navbuttons_onhover'] = $params->get('navbuttons_onhover' , '');
        $carousel['navbuttons_color']   = $params->get('navbuttons_color' , '');
        $carousel['nav_prev']           = $params->get('nav_prev' , '');
        $carousel['nav_next']           = $params->get('nav_next' , '');
        $carousel['autoheight']         = $params->get('autoheight' , '');
        $carousel['citemheight']        = $params->get('citemheight' , '');
        $carousel['loop']               = $params->get('loop' , '');
        $carousel['loopblank']          = $params->get('loopblank' , '');
        $carousel['grapcursor']         = $params->get('grapcursor' , '');


        $list_main['strip_tags']              = $params->get('strip_tags' , '');
        $list_main['show_submit_button']      = $params->get('show_submit_button' , '');
        $migrate_params->box_text_color       = $params->get('box_text_color' , '');
        $migrate_params->cfields_position     = $params->get('cfields_position' , 1);
        $migrate_params->show_permalink       = $params->get('show_permalink' , '');
        $migrate_params->date_format          = $params->get('date_format' , '');



        $item_textlimiter['text_limiter']        = $params->get('text_limiter' , '');
        $item_textlimiter['text_amount']         = $params->get('text_amount' , '');
        $item_textlimiter['text_full']           = $params->get('text_full' , '');
        $item_textlimiter['less_button']         = $params->get('less_button' , '');
        $item_textlimiter['text_button_classes'] = $params->get('text_button_classes' , '');


        $migrate_params->list_main            = $list_main;
        $migrate_params->list_columns         = $list_columns;
        $migrate_params->item_video           = $item_video;
        $migrate_params->item_textlimiter     = $item_textlimiter;
        $migrate_params->list_animation       = $list_animation;
        $migrate_params->carousel             = $carousel;

        $json_params = json_encode($migrate_params);

        return $json_params;
    }
}







