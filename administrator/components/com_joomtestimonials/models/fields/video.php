<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('url');

class JFormFieldVideo extends JFormFieldUrl{
	protected $type = 'Video';
	protected function getInput()
	{
		$input = rtrim($this->getRenderer($this->layout)->render($this->getLayoutData()), PHP_EOL);
		if(!empty($this->value)){
			return $input .= '<div class="mt-2 p-0 shadow-sm d-inline-block  rounded overflow-hidden bg-dark" >'.JoomtestimonialsFrontendHelper::videoBuilder($this->value,'100%',225,0).'</div>';
		}else{
			return $input;
		}
	}

}