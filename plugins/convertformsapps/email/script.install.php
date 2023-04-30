<?php

/**
 * @package         Convert Forms
 * @version         4.0.2 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2022 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

require_once __DIR__ . '/script.install.helper.php';

class PlgConvertFormsAppsEmailInstallerScript extends PlgConvertFormsAppsEmailInstallerScriptHelper
{
	public $name = 'PLG_CONVERTFORMSAPPS_EMAIL';
	public $alias = 'email';
	public $extension_type = 'plugin';
	public $plugin_folder = 'convertformsapps';
	public $show_message = false;
}
