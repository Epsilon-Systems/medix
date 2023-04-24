<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("_JEXEC") or die('Restricted access');

class JFormFieldNobossmodal extends JFormField
{

    protected $type = "nobossmodal";

    protected function getLabel(){
        // Parametro de versao minima requirida para o joomla esta definido e versao atual eh menor: nao exibe a modal
        if((!empty($this->getAttribute('minimumversionjoomlarequired'))) && (JVERSION < $this->getAttribute('minimumversionjoomlarequired'))){
            return;
        }

        $label = $this->getAttribute('label');

        // Nao tem label definido: fecha html e carrega botao alinhado na esqueda
        if(empty($label)){
            return '</div><div>'.$this->getModal();
        }
        else{
            return parent::getLabel();
        }
    }

    protected function getInput(){
        $label = $this->getAttribute('label');

        // Tem label definido: carrega bt no input
        if(!empty($label)){
            return $this->getModal();
        }
    }

    function getModal(){
        // Adiciona constantes padroes do JS
        jimport('noboss.util.jsconstants');
        NoBossUtilJsconstants::addConstantsDefault();
        
        // Obtem a tag do idioma que esta sendo navegado
        $currentLanguage = JFactory::getLanguage()->getTag();

        // Obtem valor
        $json = htmlspecialchars($this->value);
        // Obtem texto label
        $label = JText::_($this->getAttribute('label'));
        // Texto para botão de abrir a modal
        $buttonOpenModal = $this->getAttribute('button');
        // Se o texto do botao nao estiver definido, pega o label e se nao tiver label, coloca valor default
        $buttonOpenModal = empty($buttonOpenModal) ? (empty($label) ? JText::_('NOBOSS_EXTENSIONS_MODAL_ITEMS_CUSTOMIZATION_BUTTON') : $label) : JText::_($buttonOpenModal);

        // Caminho para o arquivo xml
        $xmlPath = $this->getAttribute('formsource');
        $fullXmlPath = JPATH_ROOT."/".$xmlPath;
        
        $attrNotFoundMessage = $this->getAttribute('not_found_message');

        $html = "";

        // Arquivo XML existe: exibe botao para abrir modal
        if(file_exists($fullXmlPath)){
            $html .= "<a data-id='noboss-modal' class='btn btn-nb'>
                        {$buttonOpenModal}
                      </a>";
        }
        // Arquivo XML nao existe e foi definida mensagem para qnd nao for encontrado
        else if (!empty($attrNotFoundMessage)){
            $html = JText::_($attrNotFoundMessage);
        }
        // Arquivo XML nao existe e aplica mensagen default de recurso nao incluso no plano
        else{
            $html = "<div class='alert' style='font-size: 11px; padding: 5px; margin: 0 0 0 10px; display: inline-block;'><span class='icon-minus-circle'> </span>".JText::_('LIB_NOBOSS_BLOCK_FIELD_MODAL_COMPLETE_SIDE_FIELD')."</div>";
        }

        // Definido no xml que devemos obter o valor de um campo de ID do formulario onde a modal eh chamada e enviar junto na requisicao ajax da modal
        if(!empty($this->getAttribute('aliasfieldid'))){
            $aliasFieldId = $this->getAttribute('aliasfieldid');
            $valueFieldId = $this->form->getData()->get($aliasFieldId);
        }

        $html .= "<input type='hidden' data-formsource='{$xmlPath}' name='{$this->name}' data-id='noboss-modal-input-hidden' data-modal-name='{$this->getAttribute('name')}' ".((!empty($valueFieldId) ? "data-valuefieldid='{$valueFieldId}'" : ''))." value='{$json}' class='{$this->class}'/>";

        $doc = JFactory::getDocument();

        $doc->addScript(JURI::root()."libraries/noboss/forms/fields/assets/js/min/nobossmodal.min.js");
        $doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobossmodal.min.css");
        // adiciona ao js a versao do joomla
        $doc->addScriptOptions('nobossmodal', array(
            'lowerJVersion' => version_compare(JVERSION, '3.7.3', '<'),
            'higherJVersion' => version_compare(JVERSION, '3.8.0', '>=')
        ));
        // Verifica se já tem o objeto com as constantes de tradução
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], ".nobossmodal")) {
            // Adiciona as constantes de trasução
            $doc->addScriptDeclaration(
                '
                if(!codeLanguage){
                    var codeLanguage = "'.$currentLanguage.'";
                }

                if(!translationConstants){
                    var translationConstants = {};  
                }
                translationConstants.nobossmodal = {};
                
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CANCEL_LABEL = "'. JText::_('LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CANCEL_LABEL').'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CANCEL_DESC = "'. JText::_("LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CANCEL_DESC").'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_RESET_LABEL = "'. JText::_('LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_RESET_LABEL').'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_RESET_DESC = "'. JText::_("LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_RESET_DESC").'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONFIRM_CANCEL_BUTTON = "'. JText::_("LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONFIRM_CANCEL_BUTTON").'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONFIRM_CONFIRM_BUTTON = "'. JText::_("LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONFIRM_CONFIRM_BUTTON").'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONNECTION_ERROR_TITLE = "'. JText::_("LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONNECTION_ERROR_TITLE").'";
                translationConstants.nobossmodal.LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONNECTION_ERROR_CONTENT = "'. JText::_("LIB_NOBOSS_FIELD_NOBOSSMODAL_MODAL_CONNECTION_ERROR_CONTENT").'";
                '
            );
        }

        // Joomla 3
        if(version_compare(JVERSION, '4', '<')){
            // Nao chamamos no Joomla 4 pq o template ja carrega a versao 5
            $doc->addStyleSheet("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css");
        }
        
        return $html;
    }
}
