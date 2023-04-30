<?php
/**
 * @copyright	Copyright (c) 2013-2017 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

$app = JFactory::getApplication();

JLoader::register('JoomTestimonialsHelperWebasset',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/webasset.php');
JoomTestimonialsHelperWebasset::init();
JoomTestimonialsHelperWebasset::$wa->useStyle('fontawesome')->useScript('jquery-noconflict');


// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_joomtestimonials')) {

	return $app->enqueueMessage(JText::_('JERROR_ALERTNOAUTHOR'),'error');
}

// Include JS
JHtml::_('script', '/media/com_joomtestimonials/js/admin.script.js', array('version' => 'auto', 'relative' => true));

// Include dependancies
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
require_once JPATH_COMPONENT . '/helpers/factory.php';
require_once JPATH_COMPONENT . '/helpers/joomtestimonials.php';
require_once  JPATH_COMPONENT_SITE . '/helpers/joomtestimonials.php';

$controller	= JControllerLegacy::getInstance('Joomtestimonials');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();