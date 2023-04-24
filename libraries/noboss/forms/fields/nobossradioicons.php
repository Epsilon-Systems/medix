<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('radio');
jimport('noboss.util.loadextensionassets');

// Sobreescreve o field do joomla para permitir o uso facilitado de exibicao de icones como opcoes para serem exibidos. Opcionalmente pode ser exibida uma legenda

class JFormFieldNobossradioicons extends JFormFieldRadio{
	protected $type = 'nobossradioicons';

	protected function getInput() {
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();

        // Seta classe para ser inserida no fieldset
        $this->class = "nobossradioicons";

        // Tem arquivo de fonte a ser carregado
        if(!empty($this->element->attributes()->familyfilesiconload)){
            $files = explode(',', $this->element->attributes()->familyfilesiconload);
            foreach ($files as $file) {
                // Carrega arquivo de fontes
                NoBossUtilLoadExtensionAssets::loadFamilyIcons($file);
            }
        }
        
        // CSS do field
		$doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobossradioicons.min.css");
        
        return parent::getInput();
	}

    protected function getOptions(){
		$options   = array();

        // Adiciona tamanho para fonte do icone
        $styleIcon = (!empty($this->element->attributes()->fontsize)) ? ' font-size:'.$this->element->attributes()->fontsize : 'font-size:25px';    

        // Percorre cada option para tratamento
		foreach ($this->element->xpath('option') as $option){
			// Obtem o value
            $value = (string) $option['value'];
			
            // Obtem a legenda, caso definida
            $text  = JText::_(trim((string) $option));

            // Obtem o tipo de familia dos icones (por padrao eh fontawesome)
            $familyIcons = !empty($option['familyicon']) ? $option['familyicon'] : 'fontawesome';

            // Obtem o alias do icone 1
            $icon1 = (string) $option['icon1'];

            // Obtem o alias do icone 2: icone 2 eh uma opcao para qnd quisermos, por exemplo, exibir um icone de seta para esquerda e outro para direita
            $icon2 = (string) $option['icon2'];

            // Familia de icones da material-icons
            if($familyIcons == 'material-icons'){
                // Monta html do icone 1
                $contentIcons = (!empty($icon1)) ? "<i class='material-icons' style='{$styleIcon}'>{$icon1}</i>" : "";                
                   
                // Monta html do icone 2
                $contentIcons .= (!empty($icon2)) ? "&nbsp;&nbsp;<i class='material-icons' style='{$styleIcon}'>{$icon2}</i>" : "";
            }
            // Familia de icones da fontawesome ou alguma outra que nao esta definida aqui
            else{
                // Monta html do icone 1
                $contentIcons = (!empty($icon1)) ? "<span class='{$icon1}' style='{$styleIcon}'></span>" : "";
    
                // Monta html do icone 2
                $contentIcons .= (!empty($icon2)) ? "&nbsp;&nbsp;<span class='{$icon2}' style='{$styleIcon}'></span>" : "";
            }

            // Conteudo a ser exibido
            $contentHtml = "<div class=\"nobossradioicons__option-icon\">{$contentIcons}</div>
                            <div class=\"nobossradioicons__option-legend\">{$text}</div>";

			$disabled = (string) $option['disabled'];
			$disabled = ($disabled == 'true' || $disabled == 'disabled' || $disabled == '1');
			$disabled = $disabled || ($this->readonly && $value != $this->value);

			$checked = (string) $option['checked'];
			$checked = ($checked == 'true' || $checked == 'checked' || $checked == '1');

			$tmp = array(
					'value'    => $value,
					'text'     => $contentHtml,
					'disable'  => $disabled,
					'class'    => (string) $option['class'],
					'checked'  => $checked,
			);

			if ((string) $option['showon']){
				$tmp['optionattr'] = " data-showon='" .
					json_encode(
						JFormHelper::parseShowOnConditions((string) $option['showon'], $this->formControl, $this->group)
						)
					. "'";
			}
			
			$options[] = (object) $tmp;
		}

		reset($options);
        
        // echo '<pre>';
        // var_dump($options);
        // exit;

		return $options;

    }
}
