<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

use Joomla\Registry\Registry;

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('subform');

class JFormFieldNobosssubform extends JFormFieldSubform {
    protected $type = "nobosssubform";

    protected function getInput(){
        // Versao minima requirida para o joomla foi definida e site nao atende: exibe mensagem avisando e nao exibe subform
        if(!empty($this->getAttribute('minimumversionrequired')) && (version_compare(JVERSION, $this->getAttribute('minimumversionrequired'), '<'))){
            // Exibe mensagem informando que recurso nao esta disponivel
            echo '<div class="alert blockfields__msg_field"><span class="icon-minus-circle"> </span>A feature has been hidden and is only available in Joomla version '.$this->getAttribute('minimumversionrequired').' or higher.</div>';
            return;
        }

        // Adiciona constantes padroes do JS
        jimport('noboss.util.jsconstants');
        NoBossUtilJsconstants::addConstantsDefault();
        
        // Caminho para o arquivo xml
        $xmlPath = $this->getAttribute('formsource');
        $fullXmlPath = JPATH_ROOT."/".$xmlPath;

        // Arquivo XML existe: exibe mensagem de que nao esta incluso no plano
        if(!file_exists($fullXmlPath)){
            return "<div class='alert' style='font-size: 13px; margin: 0 0 10px 0; display: inline-block;'><span class='icon-minus-circle'> </span>".JText::_('LIB_NOBOSS_BLOCK_FIELD_SUBFORM_HEADER')."</div>";
        }

        // guarda se o subform eh multiplo
        $isMultiple = ($this->multiple) ? "true" : "false";

        // seta o layout default do nbsubform caso nenhum tenha sido especificado
        if(empty($this->element['layout'])){
            if($isMultiple === "true"){
                $this->layout = "noboss.form.field.subform.collapse";
           }else{
               $this->layout = "noboss.form.field.subform.single";
           }
        }

        // Joomla 4
        if(version_compare(JVERSION, '4', '>=')){
            /* TODO: o Joomla 4 esta trazendo um alias genérico como valor para $fieldname (ex: '__field22') quando deveria ser o alias do subform (ex: 'categories'). Por isso, fizemos a alteracao abaixo para corrigir pegando o valor a partir do campo $name
                -> Importante: os subforms que estiverem utilizando o layout do Joomla nao pegarao essa correcao
            */
            $temp = explode('[', $this->name);
            $temp = array_pop($temp);
            $temp = str_replace("]", "", $temp);
            $this->fieldname = $temp;
        }

        // passa constantes para o js
        JText::script('LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONFIRM_CANCEL_BUTTON');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONFIRM_CONFIRM_BUTTON');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSSUBFORM_ALERT_MESSAGE_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSSUBFORM_ALERT_MESSAGE_CONTENT');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSSUBFORM_COLLAPSE_NEW_ITEM_VALUE_TEXT');

        // define o texto do botao de acordo com parametro do xml ou constante da library
        $btnText = $this->element['button_text'] ? $this->element['button_text'] : JText::_('LIB_NOBOSS_FIELD_NOBOSSSUBFORM_RESET_BUTTON_DEFAULT_TEXT');
        //parametro com o identificar do campo que servira de titulo do subform
        $this->identifier = $this->element['identifier'];

        $this->htmlButtons = "";

        if($this->layout === 'noboss.form.field.subform.collapse'){
            //parametro com as opcoes do botao para o collapse
            $collapseButtons = $this->element['collapsebuttons'];
            
            if($collapseButtons !== "none"){

                if(!isset($collapseButtons)){
                    $collapseButtons = "grow,shrink";
                }else{
                    $collapseButtons = trim($collapseButtons);
                }

                //se for o botao de exapndir
                if(strpos($collapseButtons, "grow") !== false){
                    $this->htmlButtons .= "  <a data-toggle='grow' class='noboss-collapse-button btn btn-nb' data-id='noboss-collapse-button'><span class='material-icon'>fullscreen</span><span class='noboss-collapse-button__text'>" . JTEXT::_('LIB_NOBOSS_FIELD_NOBOSSSUBFORM_COLLAPSE_BUTTON_EXPAND_TEXT') . "</span></a>";
                }
                //se for o botao de collapse
                if(strpos($collapseButtons, "shrink") !== false){
                    $this->htmlButtons .= " <a data-toggle='shrink' class='noboss-collapse-button btn btn-nb' data-id='noboss-collapse-button'><span class='material-icon'>fullscreen_exit</span><span class='noboss-collapse-button__text'>" . JTEXT::_('LIB_NOBOSS_FIELD_NOBOSSSUBFORM_COLLAPSE_BUTTON_COLLAPSE_TEXT') ."</span></a>";
                }
            }
    
            $this->htmlButtons .= "<div class='subform-btn-extras'>";

            // Setado para exibir botao de reset
            if(!empty($this->element['show_reset']) && $this->element['show_reset'] == true){
                $this->htmlButtons .= "<a class='btn btn-reset btn-nb' data-min='{$this->element['min']}' data-name='{$this->element['name']}' data-multiple='{$isMultiple}' data-id='noboss-subform-reset'>{$btnText}</a>";
            }
    
            // Definido algum botao extra a ser exibido a partir de um field mais externo que herda esse (ex: nobosssubformcalendar)
            if(!empty($this->htmlButtonsExtra)){
                $this->htmlButtons .= $this->htmlButtonsExtra;
            }

            $this->htmlButtons .= "</div>";
        }

        // Pequena gambi que altera um subform 'simples' para 'multiplo' a partir daqui no codigo para que funcione recursos de 'add' e 'delete', usados ao menos quando um tema eh alterado
        if($isMultiple == "false"){
            $this->multiple = true;
            $this->buttons['remove'] = true;
            $this->buttons['add'] = true;
            $this->min = 1;
            $this->max = 2;
        }

        // Joomla 4
        if(version_compare(JVERSION, '4', '>=')){
            // Altera o caminho do layout para j4
            $this->layout = str_replace("noboss.", "noboss.j4.", $this->layout);
        }
        // Joomla 3
        else{
            // Altera o caminho do layout para j3
            $this->layout = str_replace("noboss.", "noboss.j3.", $this->layout);
        }

        // concatena com o html da classe pai
        $html = parent::getInput();

        // exibe o subform
        return $html;

    }

    public function filter($value, $group = null, Registry $input = null)
	{
        // Pequena gambi que altera um subform 'simples' para 'multiplo' a partir daqui no codigo para que consiga carregar os dados mesmo qnd form eh 'simples', ja que os dados sao salvos no formato de subform 'multiplo'
        $this->multiple = true;

        return parent::filter($value, $group, $input);
    }
}
