<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Factory;

defined('_JEXEC') or die;

/**
 * JoomTestimonials Component Route Helper
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.Joomtestimonials
 */
class JoomtestimonialsHelperRoute {
	protected static $lookup;





	public static function getFormRoute($id = null, $return = null, $modal = false) {

		// create the link.
		if ($id) {
			$link	= JUri::root().'index.php?option=com_joomtestimonials&task=testimonial.edit&t_id=' . $id;
		} else {
			$link	= 'index.php?option=com_joomtestimonials&view=form&layout=edit&t_id=0';
		}

		if(!$modal) {

			$language =  '*';

			// get item id
			$link .= self::findMenuItemId(
				[
					['view' => 'form']
				],
				$language

			);
        }

		if ($return) {
			$link	.= '&return=' . base64_encode($return);
		}

		if ($modal) {
			$link	.= '&tmpl=component';
		}

		return $link;
	}
	public static function getTestimonialRoute($id,$name)
	{

		$name = JFilterOutput::stringURLSafe($name);

		$link = 'index.php?option=com_joomtestimonials&view=testimonial&id='.$id.":".$name;

		return $link;
	}


	/*
	 * find menu item id from a set of rules
	 */
	private static function findMenuItemId($rules, $language)
	{
		foreach ($rules as $rule)
		{
			$itemid = self::executeRule($rule, $language);

			if ($itemid > 0)
			{
				return "&Itemid=" . $itemid;
			}
		}

		return "&Itemid=" . JFactory::getApplication()->getMenu()->getActive()->id;
	}

	/*
	 * Find menu item id from a given rule
	 */
	private static function executeRule($rule, $language)
	{


		$menus     = JFactory::getApplication()->getMenu()->getMenu();
		$hasId     = isset($rule['id']) ? true : false;
		$hasLayout = isset($rule['layout']) ? true : false;

		$rulesLength = count($rule);

		foreach ($menus as $menu)
		{
			// check if menu item is a component
			if ($menu->component != 'com_joomtestimonials')
			{
				continue;
			}

			// check if menu item has view query
			if (!isset($menu->query['view']))
			{
				continue;
			}

			// check language only if multilanguage enabled
			if ($language && $language !== '*' && JLanguageMultilang::isEnabled())
			{
				$checkLanguage = ($menu->language == $language);
			}
			else
			{
				$checkLanguage = true;
			}


			// rule has view and layout and id
			if ($rulesLength == 3 &&
				$hasLayout &&
				$hasId &&
				$menu->query['view'] == $rule['view'] &&
				$checkLanguage &&
				isset($menu->query['layout']) && $menu->query['layout'] == $rule['layout'] &&
				isset($menu->query['id']) && $menu->query['id'] == $rule['id'])

			{
				return $menu->id;
			}

			// rule has view and id
			if ($rulesLength == 2 &&
				$hasId && $menu->query['view'] == $rule['view'] &&
				$checkLanguage &&
				isset($menu->query['id']) && $menu->query['id'] == $rule['id']
			)
			{

				return $menu->id;
			}

			// rule has view and layout
			if ($rulesLength == 2 &&
				$hasLayout &&
				$menu->query['view'] == $rule['view'] &&
				$checkLanguage &&
				isset($menu->query['layout']) && $menu->query['layout'] == $rule['layout'] //&&
			)
			{
				return $menu->id;
			}

			// rule has view only
			if ($rulesLength == 1 &&
				$menu->query['view'] == $rule['view'] &&
				$checkLanguage &&
				!$hasId &&
				!$hasLayout
			)
			{
				return $menu->id;
			}

		}

		return 0;

	}

}