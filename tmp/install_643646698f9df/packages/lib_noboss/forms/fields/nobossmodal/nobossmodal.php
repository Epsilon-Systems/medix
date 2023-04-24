<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

/**
 * Classe de campo personalizado para exibir uma modal.
 */
class NobossNobossmodal {


    /**
	 * Método carrega o php da modal recebendo uma requisição ajax
	 */
	public static function loadModal() {
		jimport('noboss.util.loadextensionassets');

		$app = JFactory::getApplication();
		$post = $app->input->post;
        // Obtem os dados que vieram no post e seta como uma variavel
        $data = json_decode($post->get('data', '', "STRING"), true);
        // Obtem o nome da modal
		$modalName = $post->get('modalName', '', "STRING");
		// Obtem o caminho do xml que será buscado
        $xmlPath = $post->get('xmlPath', '', 'STRING');
        // Obtem informacao se modal deve ser bloqueada por causa da licenca
        $blockModal = $post->get('blockModal', 0, 'INT');
        // Obtem o tema selecionado (quando definido)
        $theme = $post->get('theme', '', 'STRING');
        // Obtem idioma que usuario esta navegando no site
		$langCode = $app->input->get('lang');

		// Instancia o formulário
		try{
			$form = JForm::getInstance($modalName, JPATH_ROOT.'/'.$xmlPath, array('control' => $modalName));
		} catch (Exception $e){
			exit($e);
        }
        
        // Joomla 3
        if(version_compare(JVERSION, '4', '<')){
            // Instancia objete de linguagem
            $lang = JFactory::getLanguage();
            // seta o idioma de acordo com o configurado
            $lang->setLanguage($langCode);
        }
        // Joomla 4
        else{
            $language = JFactory::getLanguage();
            $lang = JLanguage::getInstance($langCode, (bool) $app->get('debug_lang'));
            JFactory::$language = $lang;
            $app->loadLanguage($lang);
        }
        
        // Carrega arquivo tradução da library no boss
        $lang->load('lib_noboss', JPATH_SITE.'/libraries/noboss');

        // Alias da extensao definido
        if(!empty($form->getAttribute('extension'))){
            // Alias da extensao
            $extension = $form->getAttribute('extension');

            // Instancia objeto da classe para obter o diretorio da extensao
            $assetsObject = new NoBossUtilLoadExtensionAssets($extension);
            // Obtem diretorio da extensao
            $extensionPath = $assetsObject->getDirectoryExtension($form->getAttribute('admin') == 'true');
            // Carrega arquivo tradução da extensao em que a modal está sendo chamada
            $lang->load($extension, $extensionPath);

            // Extensao tem fields proprios: adiciona chamada do diretorio
            if(is_dir($extensionPath.'fields')){
                $form->addFieldPath($extensionPath.'fields');
            }
        }

		// Obtem os fieldsets do formulario
        $fieldsets = $form->getFieldsets();
        
        // Percorre todos os fieldsets do formulário
        foreach ($fieldsets as $key => &$fieldset){
            // Existe campo tema na pagina e ele esta selecionado && fieldset possui limitacao por tema && tema selecionado nao esta autorizado a carregar o fieldset
            if((!empty($theme)) && (!empty($fieldset->limitationtheme)) && (!in_array($theme, explode(",", $fieldset->limitationtheme)))){
                // Remove fieldset do formulario
                unset($fieldsets[$fieldset->name]);
                // // Sai do foreach
                continue;
            }    

            // Percorre os campos do fieldset para carregar os dados
            foreach ($form->getFieldset($key) as $field) {
                $tmpArray = array();
                preg_match('/'.$modalName.'\[(.*?)\]/', $field->name, $tmpArray);
                $fieldName = $tmpArray[1];

                // Existe campo tema na pagina e ele esta selecionado && field possui limitacao por tema && tema selecionado nao esta autorizado a carregar o field
                if((!empty($theme)) && (!empty($field->getAttribute('limitationtheme'))) && (!in_array($theme, explode(",", $field->getAttribute('limitationtheme'))))){
                    // Remove field do formulario
                    $form->removeField($fieldName);
                    // Sai do foreach
                    continue;
                }                

                // Valor definido para o campo
                if (!empty($data) && (isset($data[$fieldName]))){
                    $form->setValue($fieldName, null, $data[$fieldName]);
                }
                
                // Campo deve ser bloqueado para edicao
                if ($blockModal){
                    $form->setFieldAttribute($fieldName, 'readonly', 'true');
                }
            }
		}
		// Renderiza a modal
        include(__DIR__.'/nobossmodallayout.php');
    }
}
