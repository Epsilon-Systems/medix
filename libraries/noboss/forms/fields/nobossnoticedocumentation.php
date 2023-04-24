<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

// Exibe uma notificacao no topo da extensao de um modulo para quando eh registro novo
class JFormFieldNobossnoticedocumentation extends JFormField
{

    protected $type = "nobossnoticedocumentation";
    
    protected function getInput(){    
        // Obtem o texto a ser exibido
        $text = $this->getAttribute('text');

        // Nao exibe se texto nao definido ou modulo ja estiver salvo
        if(empty($text) || (JFactory::getApplication()->input->get('id', 0, "INT") > 0)){
            return;
        }

        // Exibe a mensagem no topo da pagina
        JFactory::getDocument()->addScriptDeclaration('
        jQuery(document).ready(function (jQuery) {
            jQuery("#system-message-container").before("<div class=\"feedback-notice feedback-notice--success\" style=\"margin-top:-5px;\"><span class=\"feedback-notice__icon fa fa-info-circle\"></span><div class=\"feedback-notice__content\"><p class=\"feedback-notice__message\">'.JText::_($text).'</p></div></div>");
        });');


        // TODO: podemos analisar de ter um JS que remove a mensagem apos xx segundos
    }
}
