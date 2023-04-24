<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

/* Permite definer um header http no carregamento da paina
    - O field surgiu inicialmente da necessidade de modificar o valor de 'cross-origin-opener-policy' para 'unsafe-none' dentro da extensao de calendario porque o Joomla 4 tem um plugin 'HTTP Headers' que define por padrao esse valor como 'same-origin', impedindo que uma janela de browser converse com outra (recurso usado na autenticacao da api do google)
    - O campo deve enviar dois parametros: 'header' e 'value'
*/
class JFormFieldNobossHttpheader extends JFormField {
  
    protected $type = "nobosshttpheader";

    protected function getInput(){
        $header = $this->getAttribute('header', '');
        $value = $this->getAttribute('value', '');

        if(!empty($header) && !empty($value)){
            JFactory::getApplication()->setHeader($header, $value, true);
        }
    }
}
