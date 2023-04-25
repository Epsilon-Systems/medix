<?php
/**
 * @copyright	Copyright (c) 2013 - 2016 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;
require_once JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/helpers/layout.php'; // layout helper
JHtml::_('jquery.framework');

JLoader::register('modJoomtestimonialsSubmitHelper', __DIR__ . '/helper.php');
JLoader::register('JoomtestimonialsHelperRoute', JPATH_ROOT . '/components/com_joomtestimonials/helpers/route.php');
JLoader::register('JoomtestimonialsFrontendHelper', JPATH_ROOT . '/components/com_joomtestimonials/helpers/joomtestimonials.php');
JLoader::register('JtAuhtoriseHelper', JPATH_SITE . '/components/com_joomtestimonials/helpers/authorise.php');


// set baspath of layouts
JLayoutHelper::$defaultBasePath = JPATH_SITE . '/components/com_joomtestimonials/layouts';

JLoader::register('JoomTestimonialsHelperWebasset',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/webasset.php');
JoomTestimonialsHelperWebasset::init();
JoomTestimonialsHelperWebasset::$wa->useStyle('fontawesome')->useScript('jquery-noconflict');

// params
$layout 		   	      = $params->get('layout','form');
$customClass		   	  = $params->get('customclass','btn btn-default');


// get form from view
if($layout == 'form' or $layout == 'default'){
	$form    = modJoomtestimonialsSubmitHelper::getForm();

	// remove warning message of captcha "Invalid Field : anti-spam"
	$errorMessage = \JText::sprintf('JLIB_FORM_VALIDATE_FIELD_INVALID', JText::_('COM_JOOMTESTIMONIALS_ANTISPAM'));
	JoomtestimonialsFrontendHelper::killMessage($errorMessage);

}



// display module
require(JModuleHelper::getLayoutPath('mod_joomtestimonials_submit', $layout == 'button_new' ? 'button' : $layout));
