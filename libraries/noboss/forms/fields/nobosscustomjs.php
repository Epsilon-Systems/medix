<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

// TODO: DEPRECATED em abri/21. Utilizar o field nobosscustomeditor especificando type='js'

defined("JPATH_PLATFORM") or die;

jimport('joomla.form.helper');
jimport('noboss.forms.fields.nobosscustomeditor');

class JFormFieldNobosscustomjs extends JFormFieldNobosscustomeditor{
    
    protected $type = "nobosscustomjs";

    protected function getInput(){
        $this->element['editor_type'] = 'js';

        return parent::getInput();
    }  

}
