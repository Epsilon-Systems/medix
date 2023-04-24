<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

/*  
    - Esse arquivo serve para exibir a selecao de menus junto ao campo de escolha de posicao de modulo
    
    - Requisitos para usar esse campo:
        - Ter dois fields hidden no xml (um para assignment e outro para assigned). Ex da FAQ:
            <field name="assignment_module_faqs_display" type="hidden" module="assigment" />
		    <field name="assigned_module_faqs_display" type="hidden" module="assigned" />
        
        - No arquivo de tmpl, colocar o codigo abaixo dentro do foreach que percorre os campos a exibir:
            // Eh field de 'Atribuicao de menus' de modulo
            if(!empty($field->getAttribute("module"))){
                // Field de selecao de menus
                if($field->getAttribute("module") == 'assigment'){
                    // Obtem o nome do campo p/ usar em seguida no proximo field
                    $this->assignmentName = $field->getAttribute("name");
                    continue;
                }
                // Field que guarda os menus selecionados
                elseif($field->getAttribute("module") == 'assigned'){
                    // Obtem o nome do campo
                    $this->assignedName = $field->getAttribute("name");
                    $this->item = $displayData->get('Item');
                    // Carrega arquivo que ira exibir o campo
                    require_once JPATH_ROOT."/libraries/noboss/forms/fields/nobossmodulesposition/assignment.php";
                    continue;
                }
            }

    - NOTA: quando o campo eh chamado mais de uma vez na mesma pagina, na segunda chamada os botoes se selecionar / expandir todos itens de menu nao funcionam. Mas eh apenas com os botoes de todos. os demais funcionam normalmente
*/

// Pega valores salvos no banco (caso seja edicao de registro)
$this->item->assignment = $this->item->{$this->assignmentName};
$this->item->assigned = $this->item->{$this->assignedName};
$this->item->client_id = 0;

// Showon (caso definido no input hidden)
$showon = (!empty($field->getAttribute("showon"))) ? ' data-showon=\'' . json_encode(JFormHelper::parseShowOnConditions($field->getAttribute("showon"), $form->getFormControl())) . '\'' : '';

// Carrega tmpl do componente de modulos armazenando o retorno html em variavel php
ob_start();

// Joomla 3
if(version_compare(JVERSION, '4', '<')){
    // Declara manualmente o script que tb eh inserido dentro da tmpl que incluiremos em seguida. Isso eh necessario para que fique com names, ids e atributos conforme a extensao que esta chamando
    JFactory::getDocument()->addScriptDeclaration("jQuery(document).ready(function() {
                                                        menuHide_".$this->assignmentName."(jQuery('#jform_".$this->assignmentName."').val());
                                                        jQuery('#jform_".$this->assignmentName."').change(function()
                                                        {
                                                            menuHide_".$this->assignmentName."(jQuery(this).val());
                                                        })
                                                    });

                                                    function menuHide_".$this->assignmentName."(val) {
                                                        if (val == 0 || val == '-') {
                                                            jQuery('#menuselect_".$this->assignmentName."-group').hide();
                                                        }
                                                        else {
                                                            jQuery('#menuselect_".$this->assignmentName."-group').show();
                                                        }
                                                    }");

    // Inclui tmpl do componente modules
    require JPATH_ADMINISTRATOR . '/components/com_modules/views/module/tmpl/edit_assignment.php';
}
// Joomla 4
else{
    $this->document = Factory::getDocument();
    // Declara o JS usado dentro da tmpl sem especificar um arquivo (apenas para nao dar erro)
    $this->document->getWebAssetManager()->registerScript('com_modules.admin-module-edit-assignment', '');  

    // Declara manualmente o script que seria inserido dentro da tmpl pelo arquivo 'media\com_modules\js\admin-module-edit_assignment.js'. Isso eh necessario para trocar os nomes dos campos na chamada de JS.
    $this->document->getWebAssetManager()->addInlineScript("(() => {
                        const onChange = value => {
                            if (value === '-' || parseInt(value, 10) === 0) {
                                document.getElementById('menuselect_".$this->assignmentName."-group').classList.add('hidden');
                                jQuery('#menuselect_".$this->assignmentName."-group').hide();
                            } else {
                                document.getElementById('menuselect_".$this->assignmentName."-group').classList.remove('hidden');
                                jQuery('#menuselect_".$this->assignmentName."-group').show();
                            }
                        };
                        const onBoot = () => {
                        const element = document.getElementById('jform_".$this->assignmentName."');
                        if (element) {
                            // Initialise the state
                            onChange(element.value); // Check for changes in the state
                            element.addEventListener('change', ({
                                target
                            }) => {
                                onChange(target.value);
                            });
                        }
                        document.removeEventListener('DOMContentLoaded', onBoot);
                        };
                        document.addEventListener('DOMContentLoaded', onBoot);
                    })();");

    // Inclui tmpl do componente modules
    require JPATH_ADMINISTRATOR . '/components/com_modules/tmpl/module/edit_assignment.php';
}

$assignmentHtml = ob_get_clean();

// Realiza replace de 'ids' e 'names' do assigment
$replaceSource = array('_assignment', '[assignment', '->assignment', 'menuselect', 'jform_menus-lbl', 'jform_menus"');
$replaceTarget = array("_{$this->assignmentName}", "[{$this->assignmentName}", "->{$this->assignmentName}", "menuselect_{$this->assignmentName}", "jform_menus-lbl_{$this->assignmentName}", "jform_menus_{$this->assignmentName}\"");
$assignmentHtml = str_replace($replaceSource, $replaceTarget, $assignmentHtml);

// Realiza replace de 'ids' e 'names' do assigned
$assignmentHtml = str_replace('assigned', $this->assignedName, $assignmentHtml);

// Definido showon: adiciona nas divs com classe css control-group
if(!empty($showon)){
    $assignmentHtml = str_replace('control-group"', 'control-group" '.$showon.' ', $assignmentHtml);
}

// Joomla 4
if(version_compare(JVERSION, '4', '>=')){
    // Adiciona classe 'stack' junto com 'control-group' para alinhamento
    $assignmentHtml = str_replace('control-group', 'control-group stack', $assignmentHtml);
    
    // Adiciona classe 'span-3' junto ao primeiro 'control-group' que eh do select 'Atribuicao de modulo'
    $assignmentHtml = substr_replace($assignmentHtml, 'control-group span-3-inline', strpos($assignmentHtml, 'control-group'), strlen('control-group'));
}

// Exibe
echo $assignmentHtml;
