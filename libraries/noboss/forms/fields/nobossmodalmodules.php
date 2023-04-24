<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

// Adicionado para Joomla 4
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\Database\ParameterType;

// Carrega select com posicoes de modulo permitindo abrir em modal para edicao
// Código inspirado no plugin 'JFormFieldEBModules' (plugins\engagebox\module\form\fields\ebmodules.php)
class JFormFieldNobossmodalmodules extends JFormFieldList {

    protected $type = "nobossmodalmodules";

    protected $options = array();

    protected function getOptions() {
        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $this->options);
        
        return $options;

    }

    protected function getModules($limit = null){
        $db	= JFactory::getDbo();
        $query =  $db->getQuery(true);
        $query->select('id, title, module, position, published');
        $query->from('#__modules AS m');
        $query->where("m.client_id = 0");
        $query->where("published IN ('0', '1')");

        // Limita numero de exibicoes
        if(!empty($limit)){
            $query->setLimit("{$limit}");
            // Ordena priorizando a exibicao dos modulos da no boss
            $query->order("module like 'mod_noboss%' DESC, module like 'mod_nb%' DESC, published DESC, module, ordering");
        }else{
            // Ordena priorizando os ids mais recentes
            $query->order("id desc, published DESC, module, ordering");
        }

        // Set the query
        $db->setQuery($query);

        // Dados nao encontrados
        if (!($modules = $db->loadObjectList())) {
            JFactory::getApplication()->enqueueMessage(JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSMODULES_ERROR_LOAD', $db->getErrorMsg()), 'warning');
            return false;
        }

        return $modules;
    }

    protected function getInput() {
        $modalName = 'modal_' . $this->id;

        // Obtem os modulos do site
        $modules = $this->getModules();

        // Limite maximo a exibir definido no xml
        if(!empty($this->element['limit'])){
            $this->limit = (int)$this->element['limit'];
        }
        // Limite nao definido: forca um limite
        else{
            $this->limit = 2000;
        }
        
        // Adiciona classe para termos controle no select
        $this->class .= ' nb-module-select';

        // Existe mais modulos que o limite: repete pesquisa trazendo apenas os modulos mais recentes dentro do limite
        if(count($modules) > $this->limit){
            // Obtem os modulos do site
            $modules = $this->getModules($this->limit);
        }

        // Percorre resultados para montar opcoes do select
        foreach($modules as $module){
            $title = $module->title . ' (' . $module->module . ')';
            if($module->published == '0'){
                $title .= JText::_('LIB_NOBOSS_FIELD_NOBOSSMODULES_NOT_PUBLISHED');
            }

            $this->options[] = JHtml::_('select.option', $module->id, $title);
        }

        // Adiciona JS que habilita e desabilita botao de edicao de modulo
        JFactory::getDocument()->addScriptDeclaration('
            jQuery(function($) {
                jQuery(document).on("change", "#' . $this->id . '", function(e) {
                    if(jQuery(this).val() != ""){
                        jQuery("#'.$this->id.'_edit").removeAttr("disabled");
                    }
                    else{
                        jQuery("#'.$this->id.'_edit").attr("disabled", true);
                    }
                });

                if(jQuery("#' . $this->id . '").val() !== ""){
                    jQuery("#' . $this->id . '").trigger("change");
                }
            });
        ');

        // JS que eh executado quando usuario clica no botao de editar (troca a url do iframe da modal diretamente p/ url que abre edicao do modulo selecionado)
        JFactory::getDocument()->addScriptDeclaration('
            jQuery(document).on("click", "#' . $this->id . '_edit", function(e) {
                var moduleID = jQuery("#' . $this->id . '").val();
                
                var url = "' . JURI::base() . 'index.php?option=com_modules&view=module&task=module.edit&layout=modal&tmpl=component&id=" + moduleID;
                jQuery("#' . $modalName . ' iframe").attr("src", url);
            });
        ');

        // Options da modal (nao passamos a url da modal pq isso manipulamos via JS por conta da variacao do ID de modulo selecionado)
        $options = array(
            'title'       => JText::_('LIB_NOBOSS_FIELD_NOBOSSMODULES_BUTTON_EDIT_MODULE'),
            'url'         => '#',
            'backdrop'    => 'static',
            'keyboard'    => false,
            'closeButton' => false,
            'height'      => '400px',
            'width'       => '800px',
            'bodyHeight'  => 70,
            'modalWidth'  => 80,
            // OBS:  eh usado nos botoes de 'fechar' e 'salvar e fechar' p/ Joomla 3 para que modal seja fechada
            'footer'      => '<button type="button" class="btn btn-secondary"'
                    . ' onclick="jQuery(\'#' . $modalName . ' iframe\').contents().find(\'#closeBtn\').click();"  >'
                    . JText::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
                    . '<button type="button" class="btn btn-primary"'
                    . ' onclick="jQuery(\'#' . $modalName . ' iframe\').contents().find(\'#saveBtn\').click();" >'
                    . JText::_('JSAVE') . '</button>'
                    . '<button type="button" class="btn btn-success"'
                    . ' onclick="jQuery(\'#' . $modalName . ' iframe\').contents().find(\'#applyBtn\').click();">'
                    . JText::_('JAPPLY') . '</button>',
        );

        // Joomla 3
        if(version_compare(JVERSION, '4', '<')){
            // Renderiza a modal
            echo '<div class="nb-module-modal">'.JHtml::_('bootstrap.renderModal', $modalName, $options).'</div>';

            return parent::getInput() . 
                '<a class="btn btn-nb btn-secondary editModule nb-module-btn-edit" data-toggle="modal" href="#'. $modalName .'" id="'.$this->id.'_edit" disabled>
                    <span class="icon-edit"></span> ' . JText::_('LIB_NOBOSS_FIELD_NOBOSSMODULES_BUTTON_EDIT_MODULE') . '
                </a>';
        }

        // Joomla 4
        else{
            $doc = Factory::getDocument();
            $doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobossmodalmodules.min.css");

            // Renderiza a modal
            echo '<div class="nb-module">'.HTMLHelper::_('bootstrap.renderModal', $modalName, $options).'</div>';

            // Retorna input parent (field list) e mais o botao ao lado para editar
            return parent::getInput() . '<button class="btn btn-primary nb-module-btn-edit" id="'.$this->id.'_edit" data-bs-toggle="modal" type="button" data-bs-target="#'.$modalName.'" disabled><span class="icon-edit" aria-hidden="true"></span>' . JText::_('LIB_NOBOSS_FIELD_NOBOSSMODULES_BUTTON_EDIT_MODULE') . '</button>';
        }

    }
}
