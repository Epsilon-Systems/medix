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

// Sobreescreve o field do joomla para permitir o uso facilitado de imagens como opcoes e, opcionalmente, uma legenda;
// O primeiro local a utilizar esse field foi a extensao Video Gallery
class JFormFieldNobossradioimage extends JFormFieldRadio{
	protected $type = 'nobossradioimage';

	protected function getInput() {
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();

        // Seta classe para ser inserida no fieldset
        $this->class = "nobossradioimage";

        // Classe css adicional foi definida, acrescenta junto no fieldset
        if(!empty($this->element->attributes()->class)){
            $this->class .= " ".$this->element->attributes()->class;
        }

        // CSS do field
		$doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobossradioimage.min.css");
        
        return parent::getInput();
	}

    protected function getOptions(){
		$options   = array();

        // Adiciona altura maxima para imagem, caso definido
        $styleImage = (!empty($this->element->attributes()->maxheight)) ? ' max-height:'.$this->element->attributes()->maxheight : '';

        // Adiciona largura maxima para imagem, caso definido
        $styleImage .= (!empty($this->element->attributes()->maxwidth)) ? ' max-width:'.$this->element->attributes()->maxwidth : '';        

        // Percorre cada option para tratamento
		foreach ($this->element->xpath('option') as $option){
			// Obtem o value
            $value = (string) $option['value'];
			
            // Obtem a legenda da imagem, caso definida
            $text  = JText::_(trim((string) $option));

            // Obtem o endereco da imagem
            $src = (string) $option['src'];

            // Url da imagem nao eh completa (nao possui o '://' do 'http://' ou 'https://): adiciona url base do site
            $src = (!empty($src) && (strpos($src, '://') === false)) ? JUri::root().$src : $src;

            // Monta elemento html da imagem, caso src tenha sido definido
            $contentImage = (!empty($src)) ? "<img src='{$src}' style='{$styleImage}' />" : "";

            // Conteudo a ser exibido
            $contentHtml = "<div class=\"nobossradioimage__option-image\">{$contentImage}</div>
                            <div class=\"nobossradioimage__option-legend\">{$text}</div>";

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
