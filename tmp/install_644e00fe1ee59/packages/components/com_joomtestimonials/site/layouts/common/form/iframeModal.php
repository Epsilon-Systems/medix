<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

$doc = JFactory::getDocument();

JHtml::_('jquery.framework');
JHtml::script(Juri::base() . 'media/com_joomtestimonials/js/iziModal.min.js');
JHtml::stylesheet(Juri::base() . 'media/com_joomtestimonials/css/iziModal.min.css');

$doc->addScriptDeclaration('
    jQuery(document).ready(function($){
    
        var closeIziModal =   jQuery("#jt-form-iframe").iziModal("close");  

        jQuery(".jtHeader,.jtAdd").on("click", ".jtModal", function () {        
            
            jQuery("#jt-form-iframe").iziModal({
                title: "'.JText::_('COM_JOOMTESTIMONIALS_SUBMIT_TESTIMONIAL').'",
                icon: "fas fa-plus",
                overlayClose: true,
                iframe : true,
                iframeURL: jQuery(this).attr("href"),
                fullscreen: true            
            });
            jQuery("#jt-form-iframe").iziModal("open");
        });

    });    
');

?>
