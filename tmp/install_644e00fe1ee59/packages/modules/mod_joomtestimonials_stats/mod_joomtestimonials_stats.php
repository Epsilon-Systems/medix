<?php
/**
 * @copyright	Copyright (c) 2013 - 2016 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

JLoader::register('modJoomtestimonialsStatsHelper', __DIR__ . '/helper.php');

JLoader::register('JoomTestimonialsHelperWebasset',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/webasset.php');
JoomTestimonialsHelperWebasset::init();
JoomTestimonialsHelperWebasset::$wa->useStyle('fontawesome')->useScript('jquery-noconflict');

$stats = modJoomtestimonialsStatsHelper::getStats();

$tableclass			          = $params->get('tableclass',"table table-striped");
$todayoption 			      = $params->get('today',1);
$yesterdayoption 		      = $params->get('yesterday',1);
$thismonthoption 			  = $params->get('thismonth',1);
$lastmonthoption 			  = $params->get('lastmonth',1);
$thisyearoption 			  = $params->get('thisyear',1);
$lastyearoption 			  = $params->get('lastyear',1);
$totaloption 			      = $params->get('total',1);

require(JModuleHelper::getLayoutPath('mod_joomtestimonials_stats', $params->get('layout', 'default')));