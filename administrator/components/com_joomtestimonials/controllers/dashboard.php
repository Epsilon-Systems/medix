<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Testimonial Controller Class.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsControllerDashboard extends JControllerLegacy {
	
	public function addcat(){		
		
		$this->setRedirect('index.php?option=com_categories&view=category&layout=edit&extension=com_joomtestimonials');
		
	}

	public function addcustomfield(){

		$this->setRedirect('index.php?option=com_fields&view=field&layout=edit&context=com_joomtestimonials.testimonial');

	}

	public function updateDownloadId(){

		$this->checkToken() or jexit('Invalid Token');

		$db = JFactory::getDBO();

		$config = JComponentHelper::getParams('com_joomtestimonials');

		$did = JFactory::getApplication()->input->get('did','');

		// If the download ID is invalid, return without any further action
		if (!preg_match('/^([0-9]{1,}:)?[0-9a-f]{32}$/i', $did)) {
			echo new JResponseJson('','Invalid ID',true);
			jexit();
		}

		JLoader::register('JoomtestimonialsHelperVersion',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/version.php');
		$config->set('downloadid', $did);
		JoomtestimonialsHelperVersion::storeConfig($config);

		echo new JResponseJson('','Download ID updated');
		jexit();

	}
	
}