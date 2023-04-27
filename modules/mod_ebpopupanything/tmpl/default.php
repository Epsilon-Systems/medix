<?php
/**
 * @package Module EB Popup for Joomla!
 * @version 1.5: mod_ebpopupanything.php Sep 2021
 * @author url: https://www/extnbakers.com
 * @copyright Copyright (C) 2021 extnbakers.com. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html 
**/
// Add in all PHP fiels:
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$mdl_path =  JURI::base().'modules/'.$module->module;
$document->addStyleSheet($mdl_path.'/assets/css/isqpopup.css?v='.rand());

JHtml::script('modules/' . $module->module . '/assets/js/isqpopup.js');
if (!defined('SMART_JQUERY') && $params->get('include_jquery', 0) == "1") {
    JHtml::script('https://code.jquery.com/jquery-1.11.1.min.js');
    JHtml::script('modules/' . $module->module . '/assets/js/jquery-noconflict.js');
    define('SMART_JQUERY', 1);
}
	$tagid = 'EBPopupAnything-'.$module->id;
		
	## Check Content Type For Popup and load appropriate content
	$clss='';
	if($params->get('content_type') == 1)
	{
		$popup_content = $params->get('html_content_popup');
		$clss='padd';
	}
	elseif($params->get('content_type') == 2)
	{
		$target= '';
		if($params->get('popupimage_url_open') == 1)		
		{
			$target= 'target="_blank"';
		}
		$popup_content = '<a href="'.$params->get('popupimage_url').'" '.$target.'><img src="'.JURI::root().'/'.$params->get('popupimage').'" alt="" ></a>';
	}
	else if($params->get('video_embed')!='')		
		$popup_content = EBPopUpAnythingHelper::getEmbedCode($params->get('video_embed'),$params->get('video_embed_width'),$params->get('video_embed_height'));		
	else
		$popup_content = "Content not added!!";
	
	echo '<a class="js-open-modal '.$tagid.'" href="javascript:void(0);" data-modal-id="'.$tagid.'"></a>
		<div id="'.$tagid.'" class="EBPopupAnything-box modal-box">
			<div  id="isq-popup" class="isq_center EBPopupAnything-box"><a href="javascript:void(0);" class="js-modal-close isqclose">×</a>
				<div class="modal-body '.$clss.'">
					'.JHtml::_('content.prepare', $popup_content).'
				</div>
			</div>
		</div>';
?>
<script type="text/javascript">
jQuery( window ).on( "load", function() {
	<?php 
	
	if($params->get('cookieset')==0)
	{?>setPopupCookie("<?php echo $tagid?>","0","0");<?php }?>
	var str = getPopupCookie("<?php echo $tagid?>");	
	if(getPopupCookie("<?php echo $tagid?>")=="" || str.search("0 expires=")!=-1)
	{
		var appendthis =  ("<div class='<?php echo $tagid?> modal-overlay js-modal-close'></div>");
		<?php 
		## Open On Page Load
		if($params->get('popuptriggeron') == '1'){?>
			jQuery("body").append(appendthis);
			jQuery("html").addClass("ebpopupanything");
			jQuery(".modal-overlay").fadeTo(500, 0.7);
			jQuery('#<?php echo $tagid?>').fadeIn(jQuery(".<?php echo $tagid?>").data());		
		<?php 
		}
		else 
		{ 	## Open On Page Close?>
			var mouseX = 0;
			var mouseY = 0;
			var popupCounter = 0;		
			document.addEventListener("mousemove", function(e) {
				mouseX = e.clientX;
				mouseY = e.clientY;
				
			});
			jQuery(document).mouseleave(function () {
				if (mouseY < 100) {
					if (popupCounter < 1) {
						var appendthis =  ("<div class='<?php echo $tagid?> modal-overlay js-modal-close'></div>");
						jQuery("body").append(appendthis);
						jQuery(".modal-overlay").fadeTo(500, 0.7);
						jQuery('#<?php echo $tagid?>').fadeIn(jQuery(".<?php echo $tagid?>").data());		
						jQuery("html").addClass("ebpopupanything");
					}
					popupCounter ++;
				}

			});
			
		<?php }?>	
			
		/* Dynamic Style and popup Position*/
		jQuery("#<?php echo $tagid?> .modal-body").css({background:'<?php echo $params->get('color_popup_BG')?>'});
		jQuery("#<?php echo $tagid?> .modal-body").css({color:'<?php echo $params->get('popup_content_color')?>'});
		jQuery("#<?php echo $tagid?> a").css({color:'<?php echo $params->get('popup_content_color')?>'});		
		jQuery("#<?php echo $tagid?> a.isqclose").css({background:'<?php echo $params->get('color_popup_BG')?>'});		
		jQuery("#<?php echo $tagid?>").css({width:'<?php echo $params->get('width_popup')?>'});
		<?php if($params->get('position_style') == 1){?>
		jQuery(".<?php echo $tagid?>.modal-overlay").css({background:'<?php echo $params->get('overlay_color')?>'});
		<?php }?>
		<?php if($params->get('position_type') == 2){?>
		jQuery("#<?php echo $tagid?>").css({'box-shadow':'0 3px 30px 15px <?php echo $params->get('boxshadow_color')?>'});
		<?php }?>

		/* Assign the Popup Height/Width */
		/*jQuery(window).resize(function() 
		{						
			jQuery(".modal-box").css({
				top: (jQuery(window).height() - jQuery(".modal-box").outerHeight()) / 2,
				left: (jQuery(window).width() - jQuery(".modal-box").outerWidth()) / 2
			});
		}); */
		jQuery(window).resize();
		/**/
		
		/* Close Popup Event Trigger*/
		jQuery("a.js-modal-close, .modal-overlay").click(function() {		
			jQuery(".modal-box, .modal-overlay").fadeOut(500, function() {
				jQuery(".modal-overlay").remove();
				jQuery("html").removeClass("ebpopupanything");
				<?php 
				## Check Set Cookie Enable or not
				if($params->get('cookieset')==1)
				{
					switch($params->get('cookietime'))
					{
						case 1:
							$expire_time = $params->get('cookiesduration')*24*60*60*1000;
							break;
						case 2:
							$expire_time = $params->get('cookiesduration')*60*60*1000;
							break;
						case 3:
							$expire_time = $params->get('cookiesduration')*60*1000;
							break;
						default: 
							$expire_time = 1*60*1000;			
							break;
					}
					?>
					setPopupCookie("<?php echo $tagid?>","Executed","<?php echo $expire_time?>")
				<?php
				}
				?>	
			});
		});
		
	}
});
</script>
<?php if($params->get('position_style') == 1){?>
<style>.<?php echo $tagid?>.modal-overlay{background:<?php echo $params->get('overlay_color')?>};</style>
<?php }?>
