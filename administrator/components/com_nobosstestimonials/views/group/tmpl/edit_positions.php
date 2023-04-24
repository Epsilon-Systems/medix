<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	com_nobosstestimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

// Carrega helper do componente de templates.
JLoader::register('TemplatesHelper', JPATH_ADMINISTRATOR . '/components/com_templates/helpers/templates.php');

// Pega dados do módulo.
$clientId       	=	$this->moduleClientId;
$state          	= 	$this->modulePublished;
$selectedPosition 	= $this->moduleSelectedPosition;

// Adiciona o caminho ao template.
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

// Carrega possições de módulos existentes.
$positions = JHtml::_('modules.positions', $clientId, $state, $selectedPosition);

// Add custom position to options
$customGroupText = JText::_('COM_NOBOSSTESTIMONIALS_TEMPLATES_CUSTOM_POSITION');

// Build field
$attr = array(
	'id'          => 'jform_'. $this->fieldName,
	'list.select' => $selectedPosition,
	'list.attr'   => 'class="chzn-custom-value" '
	. 'data-custom_group_text="' . $customGroupText . '" '
	. 'data-no_results_text="' . JText::_('COM_NOBOSSTESTIMONIALS_ADD_CUSTOM_POSITION') . '" '
	. 'data-placeholder="' . JText::_('COM_NOBOSSTESTIMONIALS_TYPE_OR_SELECT_POSITION') . '" '
);

// Pega o campo de posição de módulo.
$fieldPosition = $this->form->getField($this->fieldName);

$select = JHtml::_('select.groupedlist', $positions, 'jform['.$this->fieldName.']', $attr);

// Pega o nome do campo de posição de módulo.
$fieldPositionName = $fieldPosition->getAttribute("name");
// Pega o id do campo de posição de módulo.
$fieldPositionId = $fieldPosition->id;
// Pega o label do campo de posição de módulo.
$fieldPositionLabel = $fieldPosition->getAttribute("label");
// Pega o description do campo de posição de módulo.
$fieldPositionDescription = $fieldPosition->getAttribute("description");

// FIXME: nao temos como renderizar o field do joomla? ou entao pelo menos carregar o html do layout de fields do joomla?
echo
	'<div class="control-group" data-showon="[{&quot;field&quot;:&quot;jform['.$this->showRadioName.']&quot;,&quot;values&quot;:[&quot;1&quot;],&quot;sign&quot;:&quot;=&quot;,&quot;op&quot;:&quot;&quot;}]">
		<div class="control-label">
			<label id="'.$fieldPositionId.'-lbl" for="'.$fieldPositionId.'" class="hasPopover" title="" data-content="'. JText::_($fieldPositionDescription) .'" data-original-title="'.JText::_($fieldPositionLabel).'">
				' . JText::_($fieldPositionLabel) . '
			</label>
		</div>
		<div class="controls">' .
			$select .
		'</div>
	</div>';
