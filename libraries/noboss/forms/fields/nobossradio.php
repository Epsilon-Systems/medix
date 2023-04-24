<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('radio');

// Sobreescreve o field do joomla para setar layout especifico no Joomla 4
class JFormFieldNobossradio extends JFormFieldRadio
{
	protected $type = 'nobossradio';

	protected function getInput() {
        // Joomla 4
        if(version_compare(JVERSION, '4', '>=')){
            $this->layout = 'joomla.form.field.radio.switcher';
        }
        
        return parent::getInput();
	}
}
