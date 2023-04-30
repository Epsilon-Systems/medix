<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * JoomTestimonials Helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsHelper {
	
	public static function getVersion() {
		$table		= JTable::getInstance('Extension');
		$table->load(array('name' => 'com_joomtestimonials'));
		$registry	= new JRegistry($table->manifest_cache);
		
		return $registry->get('version');
	}
	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($vName = ''){

		self::loadSidebarAssets();



		JHtmlSidebar::addEntry(
				'<i class="fas fa-tachometer-alt isParent"></i> '.JText::_('COM_JOOMTESTIMONIALS_SUBMENU_DASHBOARD'),
				'index.php?option=com_joomtestimonials&view=dashboard',
				$vName == 'dashboard'
		);		
		
		JHtmlSidebar::addEntry(
			'<i class="fas fa-comments isParent"></i> '.JText::_('COM_JOOMTESTIMONIALS_SUBMENU_TESTIMONIALS'),
			'index.php?option=com_joomtestimonials&view=testimonials',
			$vName == 'testimonials'
		);

		JHtmlSidebar::addEntry(
			'<i class="fas fa-folder-open isParent"></i> '.JText::_('COM_JOOMTESTIMONIALS_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_joomtestimonials',
			$vName == 'categories'
		);
		
		$uri = (string) JUri::getInstance();
		$return = urlencode(base64_encode($uri));

		if (JComponentHelper::isEnabled('com_fields'))
		{
			JHtmlSidebar::addEntry(
				'<i class="fas fa-cube isParent"></i> '.JText::_('COM_JOOMTESTIMONIALS_SUBMENU_CUSTOMFIELDS'),
				'index.php?option=com_fields&context=com_joomtestimonials.testimonial',
				$vName == 'fields.fields'
			);

			JHtmlSidebar::addEntry(
				'<i class="fas fa-cubes isParent"></i> '.JText::_('COM_JOOMTESTIMONIALS_SUBMENU_CUSTOMFIELDSGROUP'),
				'index.php?option=com_fields&view=groups&context=com_joomtestimonials.testimonial',
				$vName == 'fields.groups'
			);
		}
		JHtmlSidebar::addEntry(
			'<i class="fas fa-cog isParent"></i> '.JText::_('COM_JOOMTESTIMONIALS_SUBMENU_CONFIG'),
			'index.php?option=com_config&view=component&component=com_joomtestimonials&path=&return='.$return,
			$vName == 'config'
		);

		JHtml::_('stylesheet', 'media/com_joomtestimonials/css/admin.style.css');
		JHtml::_('stylesheet', 'com_joomtestimonials/icons.css');
	}

	public static function loadSidebarAssets(){

		JHtml::_('jquery.framework');
		JHtml::_('stylesheet', 'media/com_joomtestimonials/css/menuBuilder.css');
		JHtml::_('script', 'com_joomtestimonials/menuBuilder.js', array('version' => 'auto', 'relative' => true));

	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @return	JObject
	 */
	public static function getActions($categoryId = 0) {
		$user	= JFactory::getUser();
		$result	= new JObject();

		if (empty($categoryId)) {
			$assetName	= 'com_joomtestimonials';
		} else {
			$assetName	= 'com_joomtestimonials.category.' . (int) $categoryId;
		}

		$actions	= array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete',
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * Returns valid contexts
	 *
	 * @return  array
	 *
	 * @since   3.7.0
	 */
	public static function getContexts()
	{
		JFactory::getLanguage()->load('com_joomtestimonials', JPATH_ADMINISTRATOR);

		$contexts = array(
			'com_joomtestimonials.testimonial'    => JText::_('COM_JOOMTESTIMONIALS')
		);

		return $contexts;
	}

	public static function validateSection($section)
	{
		if (JFactory::getApplication()->isClient('site'))
		{
			// On the front end we need to map some sections
			switch ($section)
			{
				case 'form':
					$section = 'testimonial';
			}
		}


		return $section;
	}
}