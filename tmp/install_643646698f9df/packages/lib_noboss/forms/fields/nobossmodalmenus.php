<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

// Para o Joomla 4
use Joomla\Component\Menus\Administrator\Field\Modal\MenuField;

// Joomla 3
if(version_compare(JVERSION, '4', '<')){
    // Carrega arquivo do field original do Joomla que eh estendido
    require_once JPATH_ADMINISTRATOR.'/components/com_menus/models/fields/modal/menu.php';

    class JFormFieldNobossmodalmenus extends JFormFieldModal_Menu {
        protected $type = "nobossmodalmenus";

    }
}
// Joomla 4
else{
    class JFormFieldNobossmodalmenus extends MenuField {
        protected $type = "nobossmodalmenus";
    } 
}
