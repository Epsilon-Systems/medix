/**
 * @package         Modules Anywhere
 * @version         7.16.4
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

(function() {
    'use strict';

    window.RegularLabs = window.RegularLabs || {};

    window.RegularLabs.ModulesAnywhereButton = window.RegularLabs.ModulesAnywhereButton || {
        insertText: function(content, editor_name) {
            Joomla.editors.instances[editor_name].replaceSelection(content);
        },
    };
})();
