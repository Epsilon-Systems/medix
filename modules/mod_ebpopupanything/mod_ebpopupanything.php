<?php
/**
 * @package Module EB Popup for Joomla!
 * @version 1.5: mod_ebpopupanything.php Sep 2021
 * @author url: https://www/extnbakers.com
 * @copyright Copyright (C) 2021 extnbakers.com. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html 
**/
// Add in all PHP fiels:
defined('_JEXEC') or die;
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
$document = JFactory::getDocument();
require_once dirname( __FILE__ ).'/core/helper.php';
$layout = 'default';
require JModuleHelper::getLayoutPath($module->module, $layout);?>