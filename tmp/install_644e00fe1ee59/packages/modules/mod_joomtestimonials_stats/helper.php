<?php
/**8
 * @copyright	Copyright (c) 2013 - 2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/models', 'JoomtestimonialsModelDashboard');

/**
 * JoomTestimonials Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	JoomLa.JoomTestimonials.Stats
 */

class modJoomtestimonialsStatsHelper {

    public static function getStats(){

        JLoader::register('JoomtestimonialsHelperStats',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/stats.php');

        return JoomtestimonialsHelperStats::getTestiStats();

    }
    
}
