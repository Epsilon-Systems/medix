<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

/**
 * Helper para o módulo No Boss Testimonial Submission.
 */
class ModNobossTestimonialSubmissionHelper
{
	/**
	 * @var Váriável que controla quantos módulos foram carregados na página.
	 */
	public static $countModulesLoad = 0;

	/**
	 * Método que carrega um formulário de um componente.
	 *
	 * @param 	string 	$componentName Nome do componente.
	 * @param 	bool 	$isComponentAdmin Flag que informa se o componente é admin ou não.
	 * @param 	string 	$formName O nome do formulário.
	 *
	 * @return 	JForm 	Retorna o formulário.
	 */
	public static function loadFormComponent($componentName, $formName, $isComponentAdmin = true){
		// Cria um formulário formulário vazio.
		$form = new JForm("com_nobosstestimonials.{$formName}");

		// Caminho base do componente.
		$rootPath = ($isComponentAdmin) ? JPATH_ADMINISTRATOR : JPATH_SITE;

		// Constroí caminho para o xml de depoimentos no componnente No Boss Testimonials
		$pathXml = $rootPath . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . $componentName . DIRECTORY_SEPARATOR .'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . "{$formName}.xml";

		// Carrega o formulário xml do componente No Boss Depoimentos.
		$form->loadFile($pathXml);
		
		return $form;
	}

	/**
	 * Método que pega formulário de submissão de depoimentos filtrando os campos conforme
	 * o grupo do módulo.
	 *
	 * @param 	int 	$moduleId Id do módulo para buscar informações do grupo.
	 *
	 * @return 	object 	Retorna o formulário com os campos filtrados conforme o grupo associado.
	 */
	public static function getFormTestimonialSubmissionByGroup($moduleId){

		// Pega o formulário de depoimentos do componente de depoimentos.
		$formTestimonialSubmission = self::loadFormComponent("com_nobosstestimonials", "testimonial", true);
        
		// Pega fieldset com dados do depoimento.
		$fieldsTestimonial = $formTestimonialSubmission->getFieldset('main_data');

		// Carrega helper do componente No Boss Testimonials.
		JLoader::register('NobosstestimonialsHelper', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/helpers/nobosstestimonials.php');

		// Pega o dados do grupo de depoimentos a qual o módulo está associado.
		$testimonialsGroup = self::getTestimonialsGroup($moduleId);
	
		// Pega parâmetro de exibição de campos.
		$fieldsDisplay = $testimonialsGroup->fields_display;
		// Realiza decode dos dados.
		$fieldsDisplay = json_decode($fieldsDisplay);

		// Pega lista de permissões de exibições dos campos.
		$permissionsFieldsDisplay = NobosstestimonialsHelper::getPermissionsFieldsDisplay($fieldsDisplay);
		
		// Pega os parâmetros de configuração do módulo de submissão.
		$params = self::getParamsModuleByTestimonialsGroup($moduleId);
		
		// Se o campo 'display_type' não deve ser exibido
		if(!$permissionsFieldsDisplay['display_type']){			
			// Tira o showon do campo de texto e de ID do video, uma vez que o 'display_type' não será exibido
			$fieldsTestimonial['text_testimonial']->showon = '';
			$fieldsTestimonial['video_id']->showon = '';

			// e se o campo de id do video não deve ser exibido, eh porque o grupo so aceita depoimento em texto
			if(!$permissionsFieldsDisplay['video_id']){
				// entao tira o showon do campo de foto
				$fieldsTestimonial['photo']->showon = '';
			}
		}
		
		//  Verifica se a seção de dados pessoais deve ser exibida.
		if($fieldsDisplay->display_field_personal_data_show_section == true){
			/* Verifica se o parâmetro de "título de seção de dados pessoais" não é vazio. */
			if($params->testimonials_submission_personal_data_show_title_section && !empty(rtrim($params->testimonials_submission_personal_data_title_section))){
				$titleSectionPersonalData = array("section_title_personal_data" => $params->testimonials_submission_personal_data_title_section);
				// Insere antes do campo "author_name".
				$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "author_name", $titleSectionPersonalData);
			}

			/* Verifica se o parâmetro de "texto de apoio de seção de dados pessoais" não é vazio. */
			if($params->testimonials_submission_personal_data_show_subtitle_section && !empty(rtrim($params->testimonials_submission_personal_data_subtitle_section))){
				$subtitleSectionPersonalData = array("section_subtitle_personal_data" => $params->testimonials_submission_personal_data_subtitle_section);
				// Insere antes do campo "author_name".
				$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "author_name", $subtitleSectionPersonalData);
			}
		}

		//  Verifica se a seção de dados de estudantes deve ser exibida.
		if($fieldsDisplay->display_field_student_data_show_section == true){
			/* Verifica se o parâmetro de "título de seção de dados de estudantes" não é vazio. */
			if($params->testimonials_submission_student_data_show_title_section && !empty(rtrim($params->testimonials_submission_student_data_title_section))){
				$titleSectionStudentData = array("section_title_student_data" => $params->testimonials_submission_student_data_title_section);
				// Insere antes do campo "course".
				$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "course", $titleSectionStudentData);
			}

			/* Verifica se o parâmetro de "texto de apoio de seção dados de estudantes" não é vazio. */
			if($params->testimonials_submission_student_data_show_subtitle_section && !empty(rtrim($params->testimonials_submission_student_data_subtitle_section))){
				$subtitleSectionStudentData = array("section_subtitle_student_data" => $params->testimonials_submission_student_data_subtitle_section);
				// Insere antes do campo "course".
				$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "course", $subtitleSectionStudentData);
			}
		}

		//  Verifica se a seção de dados de profissionais deve ser exibida.
		if($fieldsDisplay->display_field_professional_data_show_section == true){
			/* Verifica se o parâmetro de "título de seção de dados de profissionais" não é vazio. */
			if($params->testimonials_submission_professional_data_show_title_section && !empty(rtrim($params->testimonials_submission_professional_data_title_section))){
				$titleSectionProfessionalData = array("section_title_professional_data" => $params->testimonials_submission_professional_data_title_section);
				// Insere antes do campo "company".
				$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "company", $titleSectionProfessionalData);
			}

			/* Verifica se o parâmetro de "texto de apoio de seção dados de profissionais" não é vazio. */
			if($params->testimonials_submission_professional_data_show_subtitle_section && !empty(rtrim($params->testimonials_submission_professional_data_subtitle_section))){
				$subtitleSectionProfessionalData = array("section_subtitle_professional_data" => $params->testimonials_submission_professional_data_subtitle_section);
				// Insere antes do campo "company".
				$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "company", $subtitleSectionProfessionalData);
			}
		}
		/* Verifica se o parâmetro de "título de seção de dados de depoimentos" não é vazio. */
		if($params->testimonials_submission_testimonials_data_show_title_section && !empty(rtrim($params->testimonials_submission_testimonials_data_title_section))){
			$titleSectionTestimonialsData = array("section_title_testimonials_data" => $params->testimonials_submission_testimonials_data_title_section);
			// Insere antes do campo "display_type".
			$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "display_type", $titleSectionTestimonialsData);
		}

		/* Verifica se o parâmetro de "texto de apoio de seção dados de depoimentos" não é vazio. */
		if($params->testimonials_submission_testimonials_data_show_subtitle_section && !empty(rtrim($params->testimonials_submission_testimonials_data_subtitle_section))){
			$subtitleSectionTestimonialsData = array("section_subtitle_testimonials_data" => $params->testimonials_submission_testimonials_data_subtitle_section);
			// Insere antes do campo "display_type".
			$fieldsTestimonial = self::insertBeforeKey($fieldsTestimonial, "display_type", $subtitleSectionTestimonialsData);
		}

		// Converte array com os campos para um objeto.
		$fieldsTestimonial = (object) $fieldsTestimonial;
		
		// Remove campos não permitidos para exibição.
		NobosstestimonialsHelper::filterTestimonialFieldsGranted($fieldsTestimonial, $permissionsFieldsDisplay);

		// Remove campo de grupo de depoimentos.
		unset($fieldsTestimonial->id_testimonials_group);
				
		return $fieldsTestimonial;
	}

	/**
	 * Método para pegar o grupo de depoimentos do módulo de submissão de depoimentos.
	 *
	 * @param 	int 	$moduleId Id do módulo para buscar o grupo de depoimentos.
	 *
	 * @return 	Object 	Retorna registro do grupo de depoimentos caso não encontre retorna null.
	 */
	public static function getTestimonialsGroup($moduleId){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select("testimonials_group.*")
			->from("#__noboss_testimonial_group AS testimonials_group")
			->where('testimonials_group.id_module_testimonials_submission = ' . (int) $moduleId);
		$db->setQuery($query);
		$result = $db->loadObject();

		return $result;
	}

	/**
	 * Método que parâmetros do módulo de submissão conforme seu grupo de depoimentos associado.
	 *
	 * @param 	int 	$moduleId Id do módulo para buscar os parâmetros.
	 *
	 * @return 	mixed 	Retorna objeto com os parâmetros caso sucesso, retornará false caso
	 * o módulo não possua grupo associado.
	 */
	public static function getParamsModuleByTestimonialsGroup($moduleId){
		// Pega o grupo de depoimentos associado ao módulo.
		$testimonialGroup = self::getTestimonialsGroup($moduleId);

		// Verifica existe grupo de depoimentos associado ao modulo.
		if(empty($testimonialGroup)){
			return false;
		}

		// Pega campo de configurações do módulo.
		$configModuleTestimonialsSubmission = $testimonialGroup->config_module_testimonials_submission;
		// Realiza decode dos dados.
		$moduleParams = json_decode($configModuleTestimonialsSubmission);

		// Pega campo de exibição de campos.
		$fieldsDisplay = $testimonialGroup->fields_display;
		// Realiza decode dos dados.
		$fieldsDisplay = json_decode($fieldsDisplay);
		$batata = array();
		// Percorre todos os valores de exibição de campos.
		foreach ($fieldsDisplay as $fieldName => $fieldValue) {
			// Procura por campos que tenham no nome determinado padrão.
			if(
				strpos($fieldName, "show_section") !== false ||
				strpos($fieldName, "title_section") !== false ||
				strpos($fieldName, "subtitle_section") !== false){
				// Adiciona aos parâmetros.
				$batata[$fieldName] = $fieldValue;
				$moduleParams->reginaldo = $fieldValue;
			}
			// Adiciona aos parâmetros.
		}
		// exit(var_dump($moduleParams));
		return $moduleParams = (object) array_merge((array) $fieldsDisplay, (array) $moduleParams);
	}

	/**
	 * Método que insere um elemento antes de uma chave específica.
	 *
	 * @param 	array 		$array O array que terá o elemento inserido.
	 * @param 	string 		$key Chave a qual o elemento será inserido antes.
	 * @param 	type|null 	$data A informação que será inserida.
	 *
	 * @return 	array 		Retorna um novo array com o elemento inserido.
	 */
	public static function insertBeforeKey($array, $key, $data = null)
	{
	    // Se a chave não existe.
	    if (($offset = array_search($key, array_keys($array))) === false) 
	    {
	        $offset = count($array);
	    }

	    return array_merge(array_slice($array, 0, $offset), (array) $data, array_slice($array, $offset));
	}

	public static function receiveTestimonialAjax() {
		// Pega aplicação Joomla.
		$app  = JFactory::getApplication();
		// Pega os dados do post.
		$input = $app->input;

		// Pega dados do formulário de submissão de depoimentos.
		$dataTestimonialSubmission = $input->getString("dataTestimonialSubmission");
		$dataSerializedFormTestimonialsSubmission = $dataTestimonialSubmission[0];

		// Lista com dados do formulário.
		$dataTestimonialsSubmission = array();
		parse_str($dataSerializedFormTestimonialsSubmission, $dataTestimonialsSubmission);
		// Retorna resultado da inserção do depoimento.
		return self::insertTestimonial($dataTestimonialsSubmission);
	}

	/**
	 * Método para encontrar um chave, pegar seu valor e remove-la do array.
	 *
	 * @param 	array 	$array O array a ser percorrido e removida a chave
	 * @param 	string 	$keyName Parte do nome da chave para procurar.
	 *
	 * @return 	mixed 	Retorna o valor da chave se encontrado, ou false caso não 
	 * tenha encontrado.
	 */
	public static function removeValueByKey(&$array, $keyName){
		foreach($array as $key => $value){
			if (strpos($key, $keyName) !== false){
				// Remove do array.
				unset($array[$key]);
				// Retorna o valor.
				return $value;
			}
		}

		// Não encontrou a chave.
		return false;
	}

	public static function insertTestimonial($dataTestimonialsSubmission)
	{
		// Array de dados retornados do método.
		$resultInsertTestimonial = array();
        // guarda o tipo de depoimento ou false caso o tipo nao esteja setado
        $dataTestimonialsSubmission["display_type"] = self::removeValueByKey($dataTestimonialsSubmission, "display_type");
        // se o tipo nao esta setado
        if(!$dataTestimonialsSubmission['display_type']){
            // verifica se ha o campo de texto
			if(isset($dataTestimonialsSubmission['text_testimonial'])){
                // define o tipo como texto
				$dataTestimonialsSubmission['display_type'] = "text";
			}else{
                // caso contrario, define o tipo como video
				$dataTestimonialsSubmission['display_type'] = "video";
			}
		}

        // Verifica se o campo de texto existe no formulario
		if(isset($dataTestimonialsSubmission["text_testimonial"])){
			// Verifica se existe a configuração de limite de caracteres.
			if(!empty($limitCharacteresTestimonial)){
				// Valida se depoimento está dentro do limite especificado.
				if(strlen($dataTestimonialsSubmission["text_testimonial"]) > $limitCharacteresTestimonial){
					// Corta o depoimento conforme o limite.
					$dataTestimonialsSubmission["text_testimonial"] = substr($dataTestimonialsSubmission["text_testimonial"], 0, $limitCharacteresTestimonial);
				}
			}
		}

		// Pega dados do grupo de depoimentos associado ao módulo.
		$moduleId = $dataTestimonialsSubmission["idModule"];

		// Pega o dados do grupo de depoimentos a qual o módulo está associado.
		$testimonialsGroup = self::getTestimonialsGroup($moduleId);

		// Pega campo de exibição de campos e realiza decode dos dados.
		$fieldsDisplay = json_decode($testimonialsGroup->fields_display);

		// Pega configurações de moderação de depoimentos.
		$configModerateTestimonials = json_decode($testimonialsGroup->config_moderate_testimonials);

		// Pega configurações de módulo de submissão de depoimentos.
		$configModuleTestimonialsSubmission = json_decode($testimonialsGroup->config_module_testimonials_submission);

		// Pega configuração de limitação de caracteres.
		$limitCharacteresTestimonial = $fieldsDisplay->display_field_number_characters_testimonial;
		
		// Verifica se o campo de texto existe no formulario
		if(isset($dataTestimonialsSubmission["text_testimonial"])){
			// Verifica se existe a configuração de limite de caracteres.
			if(!empty($limitCharacteresTestimonial)){
				// Valida se depoimento está dentro do limite especificado.
				if(strlen($dataTestimonialsSubmission["text_testimonial"]) > $limitCharacteresTestimonial){
					// Corta o depoimento conforme o limite.
					$dataTestimonialsSubmission["text_testimonial"] = substr($dataTestimonialsSubmission["text_testimonial"], 0, $limitCharacteresTestimonial);
				}
			}
		}

		// Pega dados do grupo de depoimento.
		$idTestimonialsGroup = $testimonialsGroup->id_testimonials_group;
		$dataTestimonialsSubmission["id_testimonials_group"] = $idTestimonialsGroup;
		$language = $testimonialsGroup->language;
		$dataTestimonialsSubmission["language"] = $language;
		$dataTestimonialsSubmission["checked_out"] = 0;

		// Verifica se existe moderação para os depoimentos.
		if($configModerateTestimonials->moderate_testimonials_active){
			// Depoimento como status inativo/pendente de mpderação.
			$dataTestimonialsSubmission["state"] = 0;

			// Verifica se existe um e-mail para envio dos depoimentos pendentes.
			if(!empty($configModerateTestimonials->moderate_testimonials_email_moderator)){
				// Configura objeto mailer.
				$mailer 	= JFactory::getMailer();
				/// Objeto de configs default do joomla.
				$config 	= JFactory::getConfig();
				// Configura remetente.
				$sender 	= array($config->get('mailfrom'), $config->get('fromname'));
                $mailer->setSender($sender);
                
                // Assunto do email nao esta definido: fixa mensagem
                if(empty($configModerateTestimonials->moderate_testimonials_email_subject)){
                    $configModerateTestimonials->moderate_testimonials_email_subject = "A new testimonial was sent by the site";
                }

				// Configura assunto do e-mail.
                $mailer->setSubject($configModerateTestimonials->moderate_testimonials_email_subject);
                
                // Conteudo do email nao esta definido: seta o assunto como conteudo
                if(empty(rtrim($configModerateTestimonials->moderate_testimonials_email_content))){
                    $configModerateTestimonials->moderate_testimonials_email_content = $configModerateTestimonials->moderate_testimonials_email_subject;
                }
                // Configura mensagem do corpo do e-mail.
                $mailer->setBody(rtrim($configModerateTestimonials->moderate_testimonials_email_content));
				// Informa que o e-mail possui código HTML.
				$mailer->isHTML(true);
				// Adiciona destinatário.
				$mailer->addRecipient($configModerateTestimonials->moderate_testimonials_email_moderator);
				//Realiza o envio do e-mail.
				$mailer->Send();
			}
		}else{
			// Depoimento como status ativo.
			$dataTestimonialsSubmission["state"] = 1;
		}

		// Converte email para minúsculo.
		$dataTestimonialsSubmission["email"] = !empty($dataTestimonialsSubmission["email"]) ? strtolower($dataTestimonialsSubmission["email"]) : "";

		// Inclui caminho das tabelas do componente No Boss Testimonials.
		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/tables');

		// Pega tabela de depoimentos.
		$testimonial = JTable::getInstance('testimonial', 'NobosstestimonialsTable');
		
		// Realiza bind dos valores.
		$testimonial->bind($dataTestimonialsSubmission);

        // Carrega model do componente No Boss Testimonials.
        JLoader::import( 'testimonial', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/models');

        // Instância uma model NobosstestimonialsModel.
        $modelTestimonial = new NobosstestimonialsModelTestimonial();

        // Seta valores para os campos 'created', 'created_by', 'modified' e 'modified_by' (quando existirem)
        $testimonial = $modelTestimonial->setCreatedModified($testimonial, 'id');

		// Flag que pega resultado de inserção do depoimento no banco de dados.
		$isSavedTestimonial = $testimonial->store();

		// Se o depoimento foi salvo
		if($isSavedTestimonial){

			// Flag que contém status da tarefa de armazenar a foto.
			$isPhotoSaved = false;

			// Verifica se a photo não é vazia.
			if(!empty($dataTestimonialsSubmission["photo"])){
				// Pega o id do depoimento.
				$idTestimonial = $testimonial->id;

				// Pega os dados da foto.
				$dataPhoto = json_decode($dataTestimonialsSubmission["photo"]);

				// Pega dados da foto.
				$imageString = base64_decode($dataPhoto->stringFile);
				$mimeTypeImage = $dataPhoto->mimeTypeFile;

				// Salva a foto no banco de dados.
				$isPhotoSaved = $modelTestimonial->insertPhoto($idTestimonial, $imageString, $mimeTypeImage);


				// Verifica se foto não foi salva.
				if(!$isPhotoSaved){
					$resultInsertTestimonial["result"] = false;
					$resultInsertTestimonial["message"] = JText::_("MOD_NOBOSSTESTIMONIALS_MESSAGE_SEND_TESTIMONIAL_ERROR_PHOTO");
				}
			}
		}else{
			$resultInsertTestimonial["result"] = false;
			$resultInsertTestimonial["message"] = JText::_("MOD_NOBOSSTESTIMONIALS_MESSAGE_SEND_TESTIMONIAL_ERROR_TESTIMONIALS");
		}

		// Verifica se não foi encontrado  nenhum erro.
		if(empty($resultInsertTestimonial)){
			$resultInsertTestimonial["result"] = true;
			$resultInsertTestimonial["message"] = JText::_("MOD_NOBOSSTESTIMONIALS_MESSAGE_SEND_TESTIMONIAL_SUCCESS");
		}

		// Retorna o template de mensagens.
		return require "tmpl/common/message.php";
    }
    
    /**
	 * Verifica se No Boss Library esta instalada no site e caso nao esteja, forca uma atualizacao e recarrega a pagina
     * 
     * OBS: essa acao eh necessaria para contornar problema em atualizacoes da library no processo do Joomla que as vezes mantem ela removida
	 *
	 * @return  void
	 */
    public static function checkLibraryInstallation(){
        // Library da No Boss nao localizada: inicia instalacao forcada da library
        if(!JFolder::exists(JPATH_LIBRARIES.'/noboss')) {
            try {
                // Adiciona diretorio de models do componente installer do Joomla
                JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_installer/models');
                // Instancia model de extensoes
                $modelInstaller = JModelLegacy::getInstance('install', 'InstallerModel');
                $input = JFactory::getApplication()->input;
                // Seta para utilizar metodo de instalacao via url
                $input->set('installtype', 'url');
                // Seta a url de instalacao da library
                $input->set('install_url', 'https://www.nobossextensions.com/en/installation/nobosslibrary/');
                // Executa metodo de instalacao
                $modelInstaller->install();
            } catch (Exception $e) {
                // Nao tem tratamento de erro pq o Joomla joga diversas vezes a falta de permissoes como erro sendo que ocorreu tudo certo
            }

            // Library foi instalada com sucesso
            if(JFolder::exists(JPATH_LIBRARIES.'/noboss')) {
                // Recarrega a pagina
                header("Refresh:0");
                exit;
            }
            else{
                return false;
            }
        }
        return true;
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
