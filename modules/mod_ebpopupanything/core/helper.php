<?php
/**
 * @package Module EB Popup for Joomla!
 * @version 1.5: mod_ebpopupanything.php Sep 2021
 * @author url: https://www/extnbakers.com
 * @copyright Copyright (C) 2021 extnbakers.com. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html 
**/

defined('_JEXEC') or die;



if(!class_exists('JModelLegacy')){

	class JModelLegacy extends JModel{}

}



class EBPopUpAnythingHelper {

	public function getEmbedCode($url,$width=640,$height=385)	

	{



		if(strstr($url,"youtube"))

		{

			preg_match('/[\\?\\&]v=([^\\?\\&]+)/', $url, $matches);

			$id = $matches[1]; 

			return '<object height="' . $height . '">

			<param name="movie" value="http://www.youtube.com/v/' . $id . '&hl=en_US&fs=1?rel=0"></param>

			<param name="allowFullScreen" value="true"></param>

			<param name="allowscriptaccess" value="always"></param>

			<embed src="http://www.youtube.com/v/' . $id . '&hl=en_US&fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" height="' . $height . '"></embed></object>';

		}

		else if(strstr($url,"vimeo"))

		{

			$embed = simplexml_load_string(EBPopUpAnythingHelper::GetVimeoEmbed($url,$widthm,$height));		

			return  html_entity_decode($embed->html);

		}

	}

	

	##

	#You may want to use oEmbed discovery instead of hard-coding the oEmbed endpoint.

	public function GetVimeoEmbed($url,$width=640,$height=1000) 

	{

		$xml_url = 'http://vimeo.com/api/oembed.xml?url=' . rawurlencode($url) .'&height='.$height;

		$curl = curl_init($xml_url);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

		$return = curl_exec($curl);

		curl_close($curl);

		return $return;

	}

}

