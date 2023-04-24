<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('range');

class JFormFieldNobossrange extends JFormFieldRange
{
	protected $type = 'nobossrange';

	protected function getInput() {
        // Adiciona constantes padroes do JS
        jimport('noboss.util.jsconstants');
        NoBossUtilJsconstants::addConstantsDefault();

        // Verifica se o min e max não está null e define valores default
        $this->min = empty($this->min) ? 0 : $this->min;
        $this->max = empty($this->max) ? 100 : $this->max;
        
        // Adiciona a classe nobossrange no campo range
        $this->class .= " nobossrange";

        $attr = '';

        if ((string) $this->readonly == '1' || (string) $this->readonly == 'true'){
            $attr .= ' readonly';
            $this->disabled = 'true';
        }
        
        $html = parent::getInput();
        // Cria um campo number que fica ao lado do range
        $html .= "<input class='nobossrange--input form-control' type='number' {$attr} name='{$this->fieldname}' value='{$this->value}' min='{$this->min}' max='{$this->max}' step='{$this->step}'/>";

        // Adiciona o js e css do campo personalizado na pagina
        $doc = JFactory::getDocument();
		$doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobossrange.min.css");
        $doc->addScript(JURI::root()."libraries/noboss/forms/fields/assets/js/min/nobossrange.min.js");
        
        return $html;
	}
}
