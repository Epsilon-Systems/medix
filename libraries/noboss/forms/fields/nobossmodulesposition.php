<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

/* 
 * Exibe o campo para selecionar / adicionar posicao de modulo
 *  - Compativel com Joomla 3 e Joomla 4
 */

use Joomla\Component\Modules\Administrator\Field\ModulesPositioneditField;
use Joomla\Component\Modules\Administrator\Service\HTML\Modules;

// Adiciona arquivo de traducao do com_modules
JFactory::getLanguage()->load('com_modules', JPATH_ROOT.'/administrator/');

// Joomla 4
if(version_compare(JVERSION, '4', '>=')){
    class JFormFieldNobossmodulesposition extends ModulesPositioneditField{
   
        public $type = "nobossmodulesposition";
    
        /* A funcao eh reescrita para Joomla 4 apenas para mudar a forma que eh chamada a funcao 'positions'. No field original eh chamada atravpes de HTMLHelper::_('modules.positions', $clientId, 1, $this->value), o que gera erro no uso por outras extensoes. Mudamos para chamar diretamente por Modules::positions('modules.positions', $clientId, 1, $this->value);
         */
        protected function getInput(){
            
            $data = $this->getLayoutData();
            $clientId  = $this->client === 'administrator' ? 1 : 0;
            
            //$positions =  HTMLHelper::_('modules.positions', $clientId, 1, $this->value)
            $modules = new Modules();
            $positions = $modules->positions('modules.positions', $clientId, 1, $this->value);
    
            $data['client']    = $clientId;
            $data['positions'] = $positions;
    
            $renderer = $this->getRenderer($this->layout);
            $renderer->setComponent('com_modules');
            $renderer->setClient(1);
    
            return $renderer->render($data);
        }
    
    }    
}

// Joomla 3
else{
    require JPATH_ROOT . '/administrator/components/com_modules/models/fields/modulesposition.php'; 
    
    class JFormFieldNobossmodulesposition extends JFormFieldModulesPosition{
   
        public $type = "nobossmodulesposition";

        /* A funcao utiliza codigo baseado na que consta no arquivo administrator\components\com_nobossfaq\views\group\tmpl\edit_positions.php
            - No arquivo original, a funcao para obter as posicoes eh "$positions = JHtml::_('modules.positions', $clientId, $state, $selectedPosition);", o que nao funciona quando queremos chamar de dentro dos nossos componentes. Por isso, mudamos a forma para chamar como"$positions = JHtmlModules::positions('modules.positions', $clientId, 1, $this->value);" e antes fazer require do arquivo onde consta essa funcao
        */
        protected function getInput(){

            JLoader::register('TemplatesHelper', JPATH_ADMINISTRATOR . '/components/com_templates/helpers/templates.php');
            JLoader::register('JHtmlModules', JPATH_ADMINISTRATOR . '/components/com_modules/helpers/html/modules.php');

            JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
            $clientId       = 0;
            $state          = 1;
            $selectedPosition = $this->value;
            
            //$positions = JHtml::_('modules.positions', $clientId, $state, $selectedPosition);
            $positions = JHtmlModules::positions('modules.positions', $clientId, 1, $this->value);

            // Add custom position to options
            $customGroupText = JText::_('COM_MODULES_CUSTOM_POSITION');

            // Campo foi carregado dentro de um modulo: adiciona 'params' no id e name
            if(JFactory::getApplication()->input->get('option') == 'com_modules' || JFactory::getApplication()->input->get('option') == 'com_templates'){
                $id = 'jform_params_'.$this->getAttribute("name");
                $name = 'jform[params]['.$this->getAttribute("name").']';
            }
            else{
                $id = 'jform_'.$this->getAttribute("name");
                $name = 'jform['.$this->getAttribute("name").']';
            }

            // Build field
            $attr = array(
                'id'          => $id,
                'list.select' => $this->value,
                'list.attr'   => 'class="chzn-custom-value" '
                . 'data-custom_group_text="' . $customGroupText . '" '
                . 'data-no_results_text="' . JText::_('COM_MODULES_ADD_CUSTOM_POSITION') . '" '
                . 'data-placeholder="' . JText::_('COM_MODULES_TYPE_OR_SELECT_POSITION') . '" '
            );

            return JHtml::_('select.groupedlist', $positions, $name, $attr);
        }
    }   
}
