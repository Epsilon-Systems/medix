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

    window.RegularLabs.ModulesAnywherePopup = window.RegularLabs.ModulesAnywherePopup || {
        form          : null,
        options       : {},
        tag_characters: {},
        tag_type      : '',

        init: function() {
            if ( ! parent.RegularLabs.ModulesAnywhereButton) {
                document.querySelector('body').innerHTML = '<div class="alert alert-error">This page cannot function on its own.</div>';
                return;
            }

            this.options = Joomla.getOptions ? Joomla.getOptions('rl_modulesanywhere_button', {}) : Joomla.optionsStorage.rl_modulesanywhere_button || {};
            this.options.editor_name;

            if ( ! this.options.editor_name) {
                document.querySelector('body').innerHTML = 'No editor name found.';
                return;
            }

            this.form = document.querySelector('[name="adminForm"]');

            this.tag_characters.start = this.options.tag_characters[0];
            this.tag_characters.end   = this.options.tag_characters[1];
        },

        insert: function(type, id) {
            const content = this.generateCode(type, id);

            parent.RegularLabs.ModulesAnywhereButton.insertText(content, this.options.editor_name);
            window.parent.Joomla.Modal.getCurrent().close();
        },

        generateCode: function(type, id) {
            const self = this;

            if (type === 'position') {
                return wrapTag(this.options.modulepos_tag + ' position="' + id + '"');
            }

            const style     = this.form.style.value;
            const showtitle = this.form.showtitle.value;

            const attribs = [type + '="' + id + '"'];

            if (style && style !== '0') {
                attribs.push('style="' + style + '"');
            }

            if (showtitle !== '') {
                attribs.push('showtitle="' + (showtitle === '0' ? 'false' : 'true') + '"');
            }

            function wrapTag(string) {
                return self.tag_characters.start
                    + string.trim()
                    + self.tag_characters.end;
            }

            return wrapTag(this.options.module_tag + ' ' + attribs.join(' '));
        },
    };
})();
