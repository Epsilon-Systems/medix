/**
 * @package         Modals
 * @version         12.3.4
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

(function() {
    'use strict';

    window.RegularLabs = window.RegularLabs || {};

    window.RegularLabs.Modals = window.RegularLabs.Modals || {
        close: function() {
            for (const group in parent.RegularLabs.Modals.modals) {
                parent.RegularLabs.Modals.modals[group].close();
            }
        },
    };
})();

window.RLModals = window.RLModals || RegularLabs.Modals;
