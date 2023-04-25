<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Joomtestimonials Factory Class.
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsFactory {
	/**
	 * Get credits footer string.
	 * @return	string
	 */
	public static function getFooter() {
		return '';
	}
	


	/**
	 * Get current version of component.
	 */
	public static function getVersion() {
		$table		= JTable::getInstance('Extension');
		$table->load(array('name' => 'com_joomtestimonials'));
		$registry	= new JRegistry($table->manifest_cache);

		return $registry->get('version');
	}

	/**
	 * Get model of component
	 */
	public static function getModel($type, $config = array()) {
		return JModelLegacy::getInstance($type, 'JoomtestimonialsModel', $config);
	}
}