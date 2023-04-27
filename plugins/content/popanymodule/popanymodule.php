<?php
/*------------------------------------------------------------------------
# plg_popanymodule - PopAnyModule
# ------------------------------------------------------------------------
# author    Infyways Solutions
# copyright Copyright (C) 2023 Infyways Solutions. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.infyways.com
# Technical Support:  Forum - http://support.infyways/com
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.plugin.plugin');
class plgContentPopAnyModule extends JPlugin
{
	public function onContentPrepare($context, $article, $params, $page = 0)
	{
		
		$tags['popanymodule'] = 'popanymodule';
				
		if (strpos($article->text, 'popanymodule')) {
		$document = JFactory::getDocument();
		JHtml::_('jquery.framework');
		$base_url=JURI::root();
		$jsfiles = $this->params->get('jsfiles');
		$animation = $this->params->get('animation');
		$open_effect = $this->params->get('open_effect');
		$close_effect = $this->params->get('close_effect');
		$open_speed = $this->params->get('open_speed',1000);
		$close_speed = $this->params->get('close_speed',1000);
		$overlayOpacity = $this->params->get('overlayOpacity',0.7);
		$speed_selection = $this->params->get('speed_selection');
		$open_speed_auto = $this->params->get('open_speed_auto');
		$close_speed_auto = $this->params->get('close_speed_auto');
		if($speed_selection==1)
		{
			$open=$open_speed;
			$close=$close_speed;
		}
		else
		{
			$open="'$open_speed_auto'";
			$close="'$close_speed_auto'";
		}
		
				
			//$string =$article->text; 
				
			$regex="`{(.*?)}`";	
			preg_match_all($regex, $article->text, $matches);	
			$a = count($matches[0]);
			$character_mask = " \t\n\r\0\x0B\xC2\xA0";
			
			for($x=0;$x < $a ;$x++) {
			$real_tag = substr($matches[0][$x], 1, -1);
			$ersatz = '';
			$shortcode = '';
			$opti = array();
			$shortcode = trim(strstr( $real_tag , ' ' , true ),$character_mask);

			if ($shortcode == '') { $shortcode = $real_tag; }
			$optionen = '';
			$optionen = strstr( $real_tag , ' ' );
			if($optionen != '') {
			preg_match_all('/[a-z]*="(.*?)"/', $optionen, $opts);
			$b = count($opts[0]);
			for($y=0;$y<$b;$y++) {
			$parn = trim(strstr($opts[0][$y] , '=' , true),$character_mask);
			$owert = trim(substr(strstr($opts[0][$y] , '=') , 1),$character_mask);          
			$opti[$parn] = '';
			$opti[$parn] = substr($owert,1,-1);
			}
			}	
			$ran = rand(0,1000);
			
			switch($shortcode) {
			case $tags['popanymodule']:
			$class = isset($opti['class']) ? $opti['class']:"";
			$style = isset($opti['style']) ? $opti['style']:"";
			$width = isset($opti['width']) ? $opti['width']:"400";
			$height = isset($opti['height']) ? $opti['height']:"400";
			$id = isset($opti['id']) ? $opti['id']:"1";
			$id = $this->get_module($id);
			$color = isset($opti['color']) ? "style='color:".$opti['color'].";'" :"";
			
			
			$image = isset($opti['image']) ? "<img src='$opti[image]'/>" :"";
			$text = isset($opti['text']) ? $opti['text']:"";
		
			
			$ersatz="
			<a href=\"#inline-$ran\" class=\"plg-pop-module $class\" style=\"$style\">$image$text</a>
			<div style=\"display: none;\">
			<div id=\"inline-$ran\" style=\"max-width:100%;width:$width;height:$height;overflow:auto;\">
			$id
			</div>
			</div>
			</a>";
			break; 
			
			
			}
			
			
		if(in_array($shortcode, $tags)) { 
        $article->text = preg_replace('`'.preg_quote($matches[0][$x]).'`', $ersatz, $article->text, 1);
     	}		
			}

			
			// Don't repeat the CSS for each instance of this bot in a page!
			static $lightbox_css;
			$js="	jQuery.noConflict();
					jQuery(document).ready(function() {
						jQuery(\".plg-pop-module\").pmfancybox({
							openEffect : '$open_effect',
							closeEffect : '$close_effect',
							openSpeed : $open,
							closeSpeed : $close,
							helpers: {overlay : {opacity : $overlayOpacity}}
						});
					});";
			if (!$lightbox_css) 
			{
			$doc = JFactory::getDocument();
			$doc->addStyleSheet("plugins/content/popanymodule/assets/jquery.fancybox.css");
			$doc->addScript( 'plugins/content/popanymodule/assets/jquery.fancybox.js' );
			$doc->addScriptDeclaration($js);
				
			
						$lightbox_css = 1;
			}
		//	$article->text=$string;
		}
		
	//check if there is a tooltip at all for performance
	
		}
		function get_module($module_id)
		{
			$document = JFactory::getDocument();
			$renderer = $document->loadRenderer('module');
			$contents = '';
			$database = JFactory::getDBO();
			$database->setQuery("SELECT * FROM #__modules WHERE id='$module_id' ");
			$modules = $database->loadObjectList();
			$module = $modules[0];	
			$contents = $renderer->render($module);		
			return $contents; 
		}
    }
?>