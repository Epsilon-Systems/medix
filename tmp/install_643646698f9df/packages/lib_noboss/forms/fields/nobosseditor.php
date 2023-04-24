<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2020 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

JFormHelper::loadFieldClass('editor');

class JFormFieldNobosseditor extends JFormFieldEditor{

    public $type = "nobosseditor";

    protected function getInput(){
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();
        $input = $app->input;

        // Obtem parametros do componente que estiver carregado na pagina onde campo eh carregado
        $paramsComponent = JComponentHelper::getParams($input->get('option'));

        // Adiciona arquivo JS que customiza cores de textos brancos
        $doc->addScript(JURI::root()."libraries/noboss/forms/fields/assets/js/min/nobosseditor.min.js");

        /* Obtem editor setado na config do componente atual (caso campo existe e caso valor esteja definido)
         * Qnd nao estiver definido, segue regra padrao do joomla que eh pririozar:
         *      1 - Opcao definida no XML pelo parametro 'editor'
         *      2 - Opcao definida nas configuracoes do usuario ou das configuracoes globais do site
         */
        if(!empty($paramsComponent->get('preferred_editor', ''))){
            $this->editorType = array($paramsComponent->get('preferred_editor', ''));
        }

        $style = '';

        if(!empty($this->width)){
            $style = "max-width: {$this->width}; width: 100%;";
        }

        // Adiciona div externa ao editor para podermos setar estilos de largura
        $html = "<div style='{$style}' class='nb-editor {$this->class}'>";

        $html .= parent::getInput();

        // Fecha o html do editor
        $html .= "</div>";
            
        return $html;
    }

}
