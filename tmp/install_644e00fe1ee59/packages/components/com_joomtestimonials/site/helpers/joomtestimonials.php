<?php
/*
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\Form;
// No direct access.
defined('_JEXEC') or die;

/**
 * JoomTestimonials Helper.
 *
 * @package		Joomla.Frontend
 * @subpackage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsFrontendHelper {

	public static function killMessage($error){

		$instance = JFactory::getApplication();
		$reflection = new \ReflectionProperty(get_class($instance), 'messageQueue');
		$reflection->setAccessible(true);

		$messages = JFactory::getApplication()->getMessageQueue();

		foreach($messages as $key=>$message) {
			if($message['message'] == $error) {
				unset($messages[$key]);
			}
		}

		$reflection->setValue($instance, $messages);
	}

	public static function videoBuilder($url ,$width = '100%' ,$height = '225px' ,$type = 0, $btn_class='btn btn-primary') {
		if (strpos($url, 'youtube') > 0) {
			$url = preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
			$url = $matches[1];
			return self::videoType($url, $type, 'youtube', $width, $height, $btn_class);
		} elseif (strpos($url, 'vimeo') > 0) {
			$url = preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $matches);
			$url = $matches[5];
			return self::videoType($url, $type, 'vimeo', $width, $height, $btn_class);

		}elseif (strpos($url, 'dailymotion') > 0) {
			$url = preg_match("!^.+dailymotion\.com/(video|hub)/([^_]+)[^#]*(#video=([^_&]+))?|(dai\.ly/([^_]+))!", $url, $matches);
			if (isset($matches[6])) {
				$url =  $matches[6];
			}
			if (isset($matches[4])) {
				$url =  $matches[4];
			}
			else{
				$url =  $matches[2];
			}
			return self::videoType($url, $type, 'dailymotion', $width, $height, $btn_class);
		}
	}


	private static function videoType($id, $type, $video, $width, $height, $btn_class){


		if($video == 'youtube'){
			$url = "https://www.youtube.com/watch?v=$id";
			$embed = "https://www.youtube.com/embed/$id";
		}
		if($video == 'vimeo'){
			$url = "https://www.vimeo.com/$id";
			$embed = "https://player.vimeo.com/video/$id";
		}
		if($video == 'dailymotion'){
			$url = "https://www.dailymotion.com/video/$id";
			$embed = "http://www.dailymotion.com/embed/video/$id";
		}

		if($type == 1){
			return "<a class='{$btn_class} mediabox' href='$url' >".JText::_('COM_JOOMTESTIMONIALS_BUTTON_VIDEO_LABEL')."</a>";

		}elseif(!$type){
			return "<iframe width='$width' height='$height' src='$embed'></iframe>";
		}
		elseif($type == 2 && !empty($id))
			return true;
		else
			return false;

	}
    public static function getLangjt($admin = 0){
	    $lang = JFactory::getLanguage();
	    $base_dir = $admin ? JPATH_ADMINISTRATOR : JPATH_SITE;
	    $language_tag = $lang->getTag();
	    $reload = true;

	    return $lang->load('com_joomtestimonials', $base_dir, $language_tag, $reload);

    }

	public static function loadVideoJs() {
		$doc = JFactory::getDocument();
		JHtml::_('jquery.framework');

		JHtml::_("script",Juri::root() . "/media/com_joomtestimonials/js/video.js");
		//JHtml::_("script",Juri::base() . "media/com_joomtestimonials/js/initvideo.js");
		JHtml::_("stylesheet",Juri::root() . "/media/com_joomtestimonials/css/video.css");

	}

    public static function loadAnimation($layoutparams)
    {
	    $list_animation  = (array)$layoutparams->get('list_animation');

        $animation  = isset($list_animation['animation'])? $list_animation['animation'] : 0;
        $boxclass   = isset($list_animation['anim_boxclass'])? $list_animation['anim_boxclass'] : 'animatemycat';
        $offset     = isset($list_animation['anim_offset'])? $list_animation['anim_offset'] : 'bounce';
        $mobile     = isset($list_animation['anim_mobile'])? $list_animation['anim_mobile'] : true;
        $live       = isset($list_animation['anim_live'])? $list_animation['anim_live'] : true;
        $scontainer = isset($list_animation['anim_scrollcontainer'])? $list_animation['anim_scrollcontainer'] : null;
        $id = 'testimonials';

        $anim_attributes[] = "data-wow-duration='{$list_animation['anim_duration']}'";
        $anim_attributes[] = "data-wow-delay='{$list_animation['anim_delay']}'";
        $data['anim_attributes'] = implode(' ', $anim_attributes);

        if($animation){

            JHtml::_('stylesheet', 'media/com_joomtestimonials/css/animate.css', false, array(), false, false, true);
            JHtml::_("script",'//cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js');
            JFactory::getApplication()->getDocument()->addScriptDeclaration(" 
            
                $(document).ready( function() {
                    $('.testiAnimate').each(function(){
                        this.classList.add(\"".$list_animation['anim_boxclass']."\");
                        this.classList.add(\"".$list_animation['anim_animateclass']."\");
                        this.setAttribute('data-wow-duration', '".$list_animation['anim_duration']."');
                        this.setAttribute('data-wow-delay', '".$list_animation['anim_delay']."');
                    });
                               
                    let animate{$id} = new WOW(
                        {
                            boxClass:     '$boxclass',
                            animateClass: 'animated',
                            iteration: 5,
                            offset:       $offset,
                            mobile:       $mobile,
                            live:         $live,
                            scrollContainer: $scontainer
                        }
                    );
                    
                    animate{$id}.init();
                });
            ");
        }
    }

    /*
     * This method remove / if found at the beginning of avatar link
     * @avatar string
     * @return string
     */
    public static function fixAvatar($avatar){
	    if (strpos($avatar, '/') === 0) {
		    return ltrim($avatar, "/");
	    }

	    return $avatar;
    }

}