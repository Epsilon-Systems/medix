<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2020 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

// TODO: DEPRECATED em abri/21. Utilizar o field nobosscustomeditor especificando type='css'

defined("JPATH_PLATFORM") or die;

jimport('joomla.form.helper');
jimport('noboss.forms.fields.nobosscustomeditor');

class JFormFieldNobosscustomcss extends JFormFieldNobosscustomeditor{

    protected $type = "nobosscustomcss";

    protected function getInput(){
        $this->element['editor_type'] = 'css';
        
        return parent::getInput();
    }  

}
