<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	com_nobosstestimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

/**
 *  Classe Helper principal do componente que segue 'Metodo No Boss de desenvolvimento'
 *  @author  Johnny Salazar Reidel
 * 
 *  Orientacao: 
 *      - Edite o nome da classe
 *      - Edite a funcao 'addSubmenu' sinalizando os submenus a exibir na lateral (executado somente para Joomla 3)
 *      - Nesta classe voce pode adicionar varias funcoes que sirvam para mais de uma view, controller ou model do componente
 *      - Dependendo da complexibidade do componente, podem ser criados mais arquivos helpers
 *      - Nos locais que precisar utilizar o helper, eh necessario declarar ele conforme o exemplo abaixo:
 *          JLoader::register($componentClassPrefix.'Helper', JPATH_ADMINISTRATOR . '/components/' . $componentAlias . '/helpers/'.strtolower($componentClassPrefix).'.php');
 */

class NobosstestimonialsHelper extends JHelperContent{

    /**
	 * Metodo que define os submenus do componente a exibir na lateral (utilizado somente no J3)
     *      - Caso nao queira exibir nenhum submenu, apenas nao declare nenhuma posicao de array para o $submenus
	 *
	 * @param   String  $vName              O nome da view ativa
	 *
	 * @return  Void
	 */
	public static function addSubmenu($vName) {
        $submenus = array();

        $input = JFactory::getApplication()->input;

        // Obtem o alias do componente que esta sendo navegado
        $componentAlias = $input->get('option');

        // Usuario esta no componente de categorias: pega o alias do nosso componente pelo atributo 'extension'
        if($componentAlias == 'com_categories'){
            $componentAlias = $input->get('extension');
        }  

        // Submenus a exibir (declarar para cada submenu 'titulo', 'link' e 'alias da view')
        $submenus[] = array('title' => JText::_('COM_NOBOSSTESTIMONIALS_TITLE_GROUPS'), 'link' => "index.php?option={$componentAlias}&view=groups", 'aliasView' => 'groups');
        $submenus[] = array('title' => JText::_('COM_NOBOSSTESTIMONIALS_TESTIMONIALS'), 'link' => "index.php?option={$componentAlias}&view=testimonials", 'aliasView' => 'testimonials');

        foreach ($submenus as $submenu) {
            JHtmlSidebar::addEntry($submenu['title'], $submenu['link'], $vName == $submenu['aliasView']);
        }
    }

	/**
	 * Metodo pega permissoes de exibicao para os campos de um grupo de depoimentos.
	 *
	 * @param 	Object 	$fieldsDisplay Campo "fields_display" de um grupo de depoimentos.
	 * @return 	array 	Retorna lista com nome do campo e se pode ou não ser exibido no contexto
	 * que foi solicitado.
	 */
	public static function getPermissionsFieldsDisplay($fieldsDisplay) {
		$app    = JFactory::getApplication();
		$contextValidation = ($app->isClient('administrator')) ? 'administrator' : 'site';

		$listFieldNamesMandatory = array('author_name');

		$listPermissionsFieldsDisplay = array();

		foreach ($fieldsDisplay as $fieldNameDisplay => $fieldValue) {
			// Pega o nome do campo que o field controla.
			$fieldName = self::getFieldNameByNameDisplayField($fieldNameDisplay);
			
			// Pega permissão de exibicao do campo e adiciona ao array.
			$listPermissionsFieldsDisplay[$fieldName] = self::checkFieldDisplayPermission($fieldNameDisplay, $fieldValue, $contextValidation, $fieldsDisplay);
			
			// Verifica se o campo atual é display_field_options
			if($fieldNameDisplay == 'display_field_options'){
				switch($fieldValue){
					// Caso esteja setado apenas texto, nega a exibicao dos campos 'Tipo' e 'ID do video'
					case 'only_text':
						$listPermissionsFieldsDisplay['display_type'] = false;
						$listPermissionsFieldsDisplay['video_id'] = false;
						$listPermissionsFieldsDisplay['text_testimonial'] = true;
						break;
					// Caso esteja setado apenas video, nega a exibicao dos campos 'Tipo' e 'Depoimento'
					case 'only_video':
						$listPermissionsFieldsDisplay['display_type'] = false;
						$listPermissionsFieldsDisplay['video_id'] = true;
						$listPermissionsFieldsDisplay['text_testimonial'] = false;
						break;
					// Caso esteja setado os dois tipos de depoimento, permite a exibicao de todos os campos
					case 'text_video':
						$listPermissionsFieldsDisplay['display_type'] = true;
						$listPermissionsFieldsDisplay['video_id'] = true;
						$listPermissionsFieldsDisplay['text_testimonial'] = true;
						break;
				}
				
				// Pula para a próxima iteracao
				continue;
			}

		}

		/* Percorre todos os campos obrigatórios. */
		foreach ($listFieldNamesMandatory as $fieldName) {
			$listPermissionsFieldsDisplay[$fieldName] = true;
		}

		return $listPermissionsFieldsDisplay;
	}

	/**
	 * Metodo que lê o nome de um parâmetro do tipo "controle de exibicao de campo" e traz o nome
	 * do campo que é controlado pelo parâmetro.
	 *
	 * @param 	string 	$fieldNameDisplay Nome de um campo de "configuracao de exibicao de campo".
	 * @return 	string 	Retorna o nome do campo que é controlado pela parâmetro.
	 */
	public static function getFieldNameByNameDisplayField($fieldNameDisplay) {
		// Remove a string "display_field_" do nome do campo.
		$fieldName = str_replace("display_field_", "", $fieldNameDisplay);
		// Pega secao através do nome do campo.
		$sectionName = self::getFieldSectionByNameDisplayField($fieldNameDisplay);

		// Veririca se encontrou secao pelo nome do campo.
		if(!empty($sectionName)){
			// Remove a string da secao do grupo.
			$fieldName = str_replace(self::getFieldSectionByNameDisplayField($fieldNameDisplay) . "_", "", $fieldName);
		}else{
			// Se o primeiro caracter da string for "_" vai remove-lo.
			$fieldName = ltrim($fieldName, "_");
		}

		return $fieldName;
	}

	/**
	 * Metodo que lê o nome de um parâmetro do tipo "controle de exibicao de campo" e identifica
	 * o grupo/secao ao qual o ele pertence.
	 *
	 * @param 	string 	$fieldNameDisplay Nome de um campo de "configuracao de exibicao de campo".
	 * @return 	string 	Retorna o nome da secao, se não for encontrado retorna uma string vazia.
	 */
	public static function getFieldSectionByNameDisplayField($fieldNameDisplay){

		// Verifica se existe a string "personal_data" no nome do campo.
		if(strpos($fieldNameDisplay, "personal_data") !== false){
			return "personal_data";
		}

		// Verifica se existe a string "student_data" no nome do campo.
		if(strpos($fieldNameDisplay, "student_data") !== false){
			return "student_data";
		}

		// Verifica se existe a string "professional_data" no nome do campo.
		if(strpos($fieldNameDisplay, "professional_data") !== false){
			return "professional_data";
		}

		// Verifica se existe a string "testimonial_data" no nome do campo.
		if(strpos($fieldNameDisplay, "testimonials_data") !== false){
			return "testimonials_data";
		}

		return "";
	}

	/**
	 * Metodo que verifica se um campo pode ou não ser exibido.
	 *
	 * @param 	string 	$fieldNameDisplay Nome do campo a ser validado.
	 * @param 	int 	$fieldValue Valor da configuracao de exibicao do campo.
	 * @param 	string 	$contextValidation Valor da contexto onde o campo foi solicitado
	 * @param 	array 	$listFieldsDisplay Lista com todos os valores dos campos.
	 * (administrator ou site).
	 * @return 	boolean Retorna true se o campo pode ser exibido ou false se não pode ser
	 * exibido.
	 */
	public static function checkFieldDisplayPermission($fieldNameDisplay, $fieldValue, $contextValidation, $listFieldsDisplay){
		// Flag que guarda o resultado da validacao.
		$validateResult = false;

		// Flag que guarda resultado se um campo pode ser exibido no contexto que foi chamado.
		$contextValidationResult = false;

        // Verifica se o campo pode ser exibido.
        if($fieldValue == 1 || $fieldValue == 2){
            $contextValidationResult = true;
        }else{
            $contextValidationResult = false;
        }

		// // Verifica conforme o contexto da validacao.
		// switch ($contextValidation) {
		// 	// Contexto de administrator (backend).
		// 	case 'administrator':
				
		// 		// Verifica se o campo pode ser exibido.
		// 		if($fieldValue == 1 || $fieldValue == 2){
		// 			$contextValidationResult = true;
		// 		}else{
		// 			$contextValidationResult = false;
		// 		}
		// 		break;

		// 	// Contexto de site (frontend).
		// 	case 'site':
		// 		if($fieldValue == 2){
		// 			$contextValidationResult = true;
		// 		}else{
		// 			$contextValidationResult = false;
		// 		}
		// 		break;
		// 	default:
		// 		break;
		// }

		// Verifica se o contexto do campo é permitido.
		if($contextValidationResult){
			// Verifica se existe dependência de outros campos.
			$hasDependencies = self::checkFieldDependencies($fieldNameDisplay, $listFieldsDisplay);
			// Verifica não existem dependências de outros campos.
			if(!$hasDependencies){
				$validateResult = true;
			}
		}
		
		return $validateResult;
	}

	/**
	 * Metodo que verifica se um campo possui dependência de outros campos e se  pode ser exibido.
	 *
	 * @param 	string 	$fieldNameDisplay Nome do campo de configuracao de exibicao.
	 * @param 	array 	$listFieldsDisplay Lista com todos os valores dos campos de exibicao.
	 * @return 	boolean Retorna true se o campo não pode ser exibido devido alguma dependência ou false
	 *  caso o campo tenha dependências satisfeitas e pode ser exibido.
	 */
	public static function checkFieldDependencies($fieldNameDisplay, $listFieldsDisplay){

		// Flag que informa se o campo possui dependencia.
		$checkResult = false;

		// Pega o nome da secao do campo.
		$sectionName = self::getFieldSectionByNameDisplayField($fieldNameDisplay);
		// Pega o nome do campo que a configuracao controla.
		$fieldName = self::getFieldNameByNameDisplayField($fieldNameDisplay);

		// Verifica se existe secao para o campo.
		if(!empty($sectionName)){
			// Verifica se a secao do campo deve ser exibida.
			$nameConfigDisplaySection = "display_field_".$sectionName."_show_section";
		 	$valueConfigDisplaySection = $listFieldsDisplay->$nameConfigDisplaySection;
		 	if($valueConfigDisplaySection == false){
		 		return true;
		 	}
		}

		return $checkResult;
	}

	/**
	 * Metodo filtra campos removendo todos os campos não permitidos.
	 *
	 * @param 	object 	&$testimonial Objeto com os campos do depoimento.
	 * @param 	array 	$listPermissionsFieldsDisplay Lista de permissoes para cada campo
	 * @return 	void
	 */
	public static function filterTestimonialFieldsGranted($testimonial, $listPermissionsFieldsDisplay){
		// $ignoredFields = array("author_name", "display_type", "video_id", "text_testimonial");
		$ignoredFields = array("author_name");
		
		// Percorre toda a lista de permissoes.
		foreach ($listPermissionsFieldsDisplay as $fieldKey => $value){			
			// Ignora o campo se estiver na lista.
			if(in_array($fieldKey, $ignoredFields)){
				continue;
			}
			
			if(array_key_exists($fieldKey, (array)$testimonial) && $value == false){
				unset($testimonial->$fieldKey);
			}
		}
	}

	/**
	 * Metodo que traz os parâmetros configurados para um grupo de depoimentos.
	 *
	 * @param 	int 	$idTestimonialsGroup Id do grupo de depoimentos.
	 * @return 	Object 	Retorna objeto com os parâmetros do grupo de depoimentoss.
	 */
	public static function getParamsTestimonialsGroup($idTestimonialsGroup) {
		// Importa arquivo da model de grupo de depoimentos.
		JLoader::import( 'group', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/models');

		// Instância uma model NobosstestimonialsModelGroup.
		$modelGroup = new NobosstestimonialsModelGroup();

		// Pega parâmetros do grupo de depoimentos.
		$paramsTestimonialsGroup = $modelGroup->getParamsTestimonialsGroup($idTestimonialsGroup);

		return $paramsTestimonialsGroup;
	}

	/**
	 * Metodo que trata a description para a campo de foto fornecendo informaçoes de tamanho
	 * e extensoes permitidas. Eh executado no form do front e no form de edicao do back
	 *
	 * @return 	string 	Retorna description para uso no campo.
	 */
	public static function getPhotoDescriptionHandle() {
        jimport("noboss.file.sizescale");
        
        if(class_exists('NoBossFileSizeScale')){
            // Pega parâmetros do componente.
            $componentParams = JComponentHelper::getParams("com_nobosstestimonials");
            
            // Lê configuracao de extensoes permitidas.
            $fileExtensionsGranted = implode(", ", $componentParams->get('file_upload_extensions_granted', array('.jpg', '.png', '.gif')));
            
            // Importa biblioteca da NoBoss para conversão de grandezas.
            // Pega valor da configuracao de "limite de upload de arquivos" do PHP.ini.
            $phpUploadMaxSize =  ini_get('upload_max_filesize');

            // Remove espaços do valor.
            $phpUploadMaxSize = trim($phpUploadMaxSize);

            // Pega o valor removendo o último caracter da configuracao.
            $valueUploadMaxSize = substr($phpUploadMaxSize, 0, -1);

            // Pega último caractere da configuracao que corresponde a grandeza de entrada.
            $scaleInput = strtolower($phpUploadMaxSize[strlen($phpUploadMaxSize)-1]);

            // Limite de upload em bytes.
            $phpPostMaxSizeInBytes = NoBossFileSizeScale::convertScale($valueUploadMaxSize, $scaleInput, 'b');

            // Pega configuracao de upload parametrizado no componente.
            $sizeLimitUploadPhotoInBytes = $componentParams->get('size_limit_upload_file', 6291456);

            // Verifica se a configuracao de upload do php.ini é menor que a configuracao parametrizada.
            if($phpPostMaxSizeInBytes < $sizeLimitUploadPhotoInBytes){
                // Utiliza a configuracao do php para validar.
                $maxSizePhotoInBytes = $phpPostMaxSizeInBytes;
            }else{
                // Utiliza a configuracao do parâmetro para validar.
                $maxSizePhotoInBytes = $sizeLimitUploadPhotoInBytes;
            }

            // Pega valor máximo de upload da foto em Megabytes para exbicao no description da foto.
            $maxSizePhotoMegabytes = number_format(NoBossFileSizeScale::convertScale($maxSizePhotoInBytes, "b", 'm'), 2, ",", ".");

            // Realiza substituiçoes na constantes de descricao do campo foto.
            $descriptionPhoto = JText::_("COM_NOBOSSTESTIMONIALS_PHOTO_DESC");
            $descriptionPhoto = str_replace("#file_extensions_granted#", "$fileExtensionsGranted", $descriptionPhoto);
            $descriptionPhoto = str_replace("#max_file_size#", "$maxSizePhotoMegabytes", $descriptionPhoto);

            // Acesso admin: concatena informacao extra para exibir no componente
            if(JFactory::getApplication()->isClient('administrator')){
                $descriptionPhoto .= JText::_("COM_NOBOSSTESTIMONIALS_PHOTO_DESC_EXTRA_COMP");
            }

            return $descriptionPhoto;
        } 
        return false;
	}

    /**
	 * Funcao executada antes de qualquer acao de update do joomla
     * 
	 * @param   JUpdate       $update  An update definition
     * @param   JTableUpdate  $table   The update instance from the database
	 */
    public static function prepareUpdate($update, $table){
        jimport('noboss.util.installscript');

        // Token da licenca
        $token = str_replace('token=', '', $update->get('extra_query'));

        if (method_exists('NoBossUtilInstallscript','updateLicenseIsValid')){
            // Busca no servidor da No Boss se extensao possui permissao para update
            $return = NoBossUtilInstallscript::updateLicenseIsValid($token);
            
            // Token nao localizado
            if ($return == 'INVALID_TOKEN'){
                $msg = "<b>There are problems with the extension license:</b> <br /><br /> &bull; Your extension token was not found on the No Boss Extensions platform. <br /><br />";
                JFactory::getApplication()->enqueueMessage($msg, 'error');
                return false;
            }
            // Extensao nao possui suporte valido
            else if($return == 'INVALID'){
                $msg = "<b>License with expired update period:</b> <br /><br /> &bull; To update the extension, it is necessary to renew the license support period. <br /> &bull; You can renew the support time by accessing the tab called 'License' available within the edition of any extension registration. <br /><br />";
                JFactory::getApplication()->enqueueMessage($msg, 'error');
                return false;
            }
        }
    }
}
