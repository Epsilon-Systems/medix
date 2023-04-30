<?php
/*
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * JoomTestimonials Helper.
 *
 * @package		Joomla.Frontend
 * @subpackage	JoomBoost.Joomtestimonials
 */
class JtAuhtoriseHelper {

	public static function canEdit($created_by){

		$user = \Joomla\CMS\Factory::getUser();
		$userId = $user->get('id');

		// Check general edit permission first.
		if ($user->authorise('core.edit', 'com_joomtestimonials'))
			return true;

		// Now check if edit.own is available.
		if (
			!empty($userId) &&
			$user->authorise('core.edit.own', 'com_joomtestimonials') &&
			$userId == $created_by // Check for a valid user and that they are the owner.
		)
			return true;

		// not allowed
		return false;

	}

	public static function canCreate(){

		$user = \Joomla\CMS\Factory::getUser();

		if($user->authorise('core.create', 'com_joomtestimonials'))
			return true;

		// not allowed
		return false;

	}


}