<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;


class JFormFieldNobossrandomid extends JFormField
{

	protected $type = 'nobossrandomid';

    protected function getInput() {
		$valueGet = $this->__get('value');

		// Caso nao tenha valor definido, gera um valor randomico
        $value = empty($valueGet) ? uniqid() : $valueGet;
        
		// Seta o valor
        $this->__set('value', $value);

        $html = '';

       
        // Definido para exibir em campo text permitindo edicao 
        if(!empty($this->element['input']) && $this->element['input'] == 'text'){
            // // Exibe o label aqui no input para que nao fique em duas colunas no J3
            // if(!empty($this->element['label'])){
            //     $html .= "<label id='{$this->id}-lbl' for='{$this->id}'>
            //                 ".$this->element['label']."
            //             </label>";
            // }

            if(!empty($this->pattern)){
                $this->pattern = "pattern='{$this->pattern}'";
            }
            else{
                $this->pattern = '';
            }

            $html .=  "</div><div><input type='text' 
                            name='{$this->name}'
                            id='{$this->id}'
                            value='{$value}'
                            required='required'
                            aria-required='true'
                            aria-invalid='false'
                            class='required form-control'
                            maxlength='20'
                            {$this->pattern}
                        />";
        }
        // Exibir em input hidden
        else{
            $html .=  "<input type='hidden' 
                            name='{$this->name}'
                            id='{$this->id}'
                            value='{$value}'
                        />";
        }

		return $html;
    }

    protected function getLabel(){
        // Definido para exibir em campo text permitindo edicao 
        if(!empty($this->element['input']) && $this->element['input'] == 'text'){
            return parent::getLabel();
        }
        // Exibir em input hidden
        else{
            return;
        }
    }
}
