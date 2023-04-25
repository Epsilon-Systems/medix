<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (http://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

JHtml::_('jquery.framework');


JLoader::register('JoomTestimonialsHelperWebasset',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/webasset.php');
JoomTestimonialsHelperWebasset::init();
JoomTestimonialsHelperWebasset::$wa->useStyle('fontawesome')->useScript('jquery-noconflict');


// Include dependancies
require_once JPATH_COMPONENT . '/helpers/route.php';
require_once JPATH_COMPONENT . '/helpers/joomtestimonials.php';

$view = JFactory::getApplication()->input->get('view','','word');

// remove warning message of captcha "Invalid Field : anti-spam"
$errorMessage = \JText::sprintf('JLIB_FORM_VALIDATE_FIELD_INVALID', JText::_('COM_JOOMTESTIMONIALS_ANTISPAM'));
JoomtestimonialsFrontendHelper::killMessage($errorMessage);


JLoader::register('FieldsHelper', JPATH_ADMINISTRATOR . '/components/com_fields/helpers/fields.php');
JLoader::register('LayoutHelper', JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/layout.php');

JLoader::register('JtAuhtoriseHelper', JPATH_SITE . '/components/com_joomtestimonials/helpers/authorise.php');
$controller	= JControllerLegacy::getInstance('Joomtestimonials');
$controller->execute(JFactory::getApplication()->input->getCmd('task'));
$controller->redirect();
