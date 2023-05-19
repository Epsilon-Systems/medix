/**
 * @package         Modals
 * @version         12.3.5
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

(function() {
    'use strict';

    window.RegularLabs = window.RegularLabs || {};

    window.RegularLabs.ModalsPopup = window.RegularLabs.ModalsPopup || {
        form: null,

        init: function() {
            if ( ! parent.RegularLabs.ModalsButton) {
                document.querySelector('body').innerHTML = '<div class="alert alert-error">This page cannot function on its own.</div>';
                return;
            }


            this.form         = document.getElementById('modalsForm');
            this.form.editors = Joomla.editors.instances;

            parent.RegularLabs.ModalsButton.setForm(this.form);
        }
    };
})();
