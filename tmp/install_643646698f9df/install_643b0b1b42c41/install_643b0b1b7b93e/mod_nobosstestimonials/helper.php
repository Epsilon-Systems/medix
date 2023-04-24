<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

// Evita acesso direto ao arquivo
defined('_JEXEC') or die;
jimport('noboss.util.url');
jimport('noboss.util.fonts');
/**
 * Helper para o módulo No Boss Testimonials.
 */
class ModNobosstestimonialsHelper
{


	/**
	 * Função que trabalha junto com o script Ajax do módulo, carregando um depoimento específico
	 */
	public static function loadTestimonialAjax(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Tratamento do Joomla com requisições.
		$input = JFactory::getApplication()->input;
		// Realiza o decode JSON dos dados enviados pelo script Ajax.
		$data = json_decode($input->get->get('data', '0', 'json'));

		$idCurrentTestimonial = $data->id;
        
		// Realiza inclusão do template do depoimento.
		self::loadTestimonialById($idCurrentTestimonial);
	}
	
	/**
	 * Busca um ou mais depoimentos aleatóriamente no banco de dados filtrando campos conforme
	 * o grupo de depoimentos do módulo.
	 *
	 * @param 	int 	$idModule Id do módulo que será utilizado filtro de grupo, apenas depoimentos
	 * associados ao mesmo grupo do módulo serão retornados.
	 * @param 	int 	$qtd Quantidade de depoimentos que serão retornados
	 *
	 * @return  Array	Retorna um array com os depoimentos ou vazio caso não encontre nenhum
	 */
	public static function getItemsTestimonials($idModule, $qtd = null){
		// Pega o dados do grupo de depoimentos a qual o módulo está associado.
        $testimonialsGroup = self::getTestimonialsGroup("module", $idModule);
        
		// Verifica se foi encontrado grupo associado ao módulo.
		if(empty($testimonialsGroup)){
			// Não foi encontrado grupo associado ao módulo.
			return null;
		}
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$language = JFactory::getApplication()->getLanguage()->getTag();
		// armazena o tipo de depoimento aceito pelo grupo
		$groupTestimonialsType = json_decode($testimonialsGroup->fields_display)->display_field_options;
		// parametros de exibicao configurados no grupo
		$displayParams = json_decode($testimonialsGroup->config_module_testimonials_display);
		$itensCostumization = json_decode($displayParams->{'testimonials_display_items_customization_'.json_decode($displayParams->testimonials_display_theme)->theme});

        // Usuario ainda esta com versao antiga de campo salvo no banco para qnt de depoimentos
        // @TODO: a partir de jan/2020 essa verificacao pode ser removida, deixando apenas a versao do else
        if (empty($displayParams->testimonials_display_qtd)){
            // Carrega a partir do parametro antigo que esta em cache ainda
            $qtd = $itensCostumization->testimonial_display_qtd;
        }
        else{
            // Carrega a partir do novo parametro
            $qtd = $displayParams->testimonials_display_qtd;
        }

		if(empty($qtd) && $displayParams->testimonials_display_theme == 'model1'){
			$qtd = 1;
		} else if(empty($qtd)) {
			$qtd = 3;
        }

		// Query que pega aleatóriamente um registro na tabela de depoimentos de um determinado grupo.
		$query
			->select("testimonials.*")
			->from("#__noboss_testimonial AS testimonials")
			->where( "testimonials.state = 1", "AND")
			->where( "testimonials.language IN ('{$language}', '*')", "AND")
            ->where("testimonials.id_testimonials_group = '{$testimonialsGroup->id_testimonials_group}'");
		
		// Verifica tipo de depoimento aceito pelo grupo e filtra apenas por depoimentos que são desse tipo
		if($groupTestimonialsType == 'only_text'){
			// apenas texto
			$query->where("testimonials.display_type = 'text'");
		}elseif($groupTestimonialsType == 'only_video'){
			// apenas video
			$query->where("testimonials.display_type = 'video'");
		}else{
			// filtro para quando o grupo aceito ambos
			$query->where("testimonials.display_type IN ('text', 'video')");
		}			

		// Verifica a ordem de exibição escolhida
		if($displayParams->testimonials_display_order == 'shuffle'){
			$query->order("rand()");
		} else if ($displayParams->testimonials_display_order == 'created'){
			$query->order("testimonials.created DESC");
		} else {
			$query->order("testimonials.ordering ASC");
		}

		$query->setLimit("{$qtd}");

        $db->setQuery($query);

        //echo str_replace('#__', 'ext_', $query); exit;

        $testimonials = $db->loadObjectList();

		$testimonial = array();
		// Carrega helper do componente de depoimentos.
		JLoader::register('NobosstestimonialsHelper', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/helpers/nobosstestimonials.php');
		
		// Percorre todos os depoimentos para fazer os tratamentos individuais em cada um
		foreach($testimonials as $testimonialItem){
			// Verifica se 
			if(isset($testimonialItem)){
				// Pega parâmetro de exibição de campos.
				$fieldsDisplay = $testimonialsGroup->fields_display;
				// Realiza decode dos dados.
				$fieldsDisplay = json_decode($fieldsDisplay);

				// Pega lista de permissões de exibições dos campos.
				$permissionsFieldsDisplay = NobosstestimonialsHelper::getPermissionsFieldsDisplay($fieldsDisplay);
				// Tenta pegar foto do depoimento.
				$photo = self::getPhoto($testimonialItem->id);

				// Valida se é um depoimento de texto e reduz para o máximo de caracteres
				if($testimonialItem->display_type == "text"){
					$testimonialItem->text_testimonial = JHtml::_('string.truncate', $testimonialItem->text_testimonial, $fieldsDisplay->display_field_number_characters_testimonial); 
				}
				// Verifica se existe foto.
				if(!is_null($photo)){
					// Gera src para tag <img>.
					$srcImage = self::getSrcImage($photo->content_image, $photo->mime_type);
					// Adiciona propriedade $srcImage a foto.
					$photo->src_image = $srcImage;
					// Adiciona foto ao depoimento.
					$testimonialItem->photo = $photo;
				}

				$permissionsFieldsDisplay['display_type'] = true;
				// Remove campos não permitidos para exibição.
				NobosstestimonialsHelper::filterTestimonialFieldsGranted($testimonialItem, $permissionsFieldsDisplay);
			}

			$testimonial[] = $testimonialItem;
			
		}

		return $testimonial;
	}

	/**
	 * Função que pega dados da foto
	 *
	 * @param int $idTestimonial Id do depoimento para buscar a foto.
	 *
	 * @return Object Retorna dados da foto ou null caso nenhum registro seja encontrado.
	 */
	public static function getPhoto($idTestimonial){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Query para pegar dados da foto.
		$query
			->select("photo.*")
			->from("#__noboss_testimonial_photo AS photo")
            ->where("photo.id_testimonial = '{$idTestimonial}'");
		$db->setQuery($query);

		return $db->loadObject();
	}


	/**
	 * Função que navega entre os depoimentos.
	 *
	 * @param 	int 	$idCurrentTestimonial Id do depoimento atual.
	 * @param 	string 	$direction Direcão da navegação do depoimento, "right" carrega o próximo depoimento
	 * e "left" carrega o depoimento anterior.
	 *
	 * @return 	string 	Retorna template do depoimento.
	 */
	public static function loadTestimonialById($idCurrentTestimonial){
		$db = JFactory::getDbo();

		// Pega uma nova query.
		$query = $db->getQuery(true);
		// Query para pega dados do depoimento atual.
		$query
			->select("testimonials.*")
 			->from("#__noboss_testimonial AS testimonials")
 			->where("testimonials.state = 1", "AND")
            ->where("testimonials.id = '{$idCurrentTestimonial}'");
 		$db->setQuery($query);
		$testimonial = $db->loadObject();

		// Carrega helper do componente de depoimentos.
		JLoader::register('NobosstestimonialsHelper', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/helpers/nobosstestimonials.php');

		// Pega o dados do grupo de depoimentos a qual o depoimento está associado.
		$testimonialsGroup = self::getTestimonialsGroup("testimonial", $testimonial->id_testimonials_group);
		// Pega parâmetro de exibição de campos.
		$fieldsDisplay = $testimonialsGroup->fields_display;
		// Realiza decode dos dados.
		$fieldsDisplay = json_decode($fieldsDisplay);
		// Pega lista de permissões de exibições dos campos.
		$permissionsFieldsDisplay = NobosstestimonialsHelper::getPermissionsFieldsDisplay($fieldsDisplay);
		$permissionsFieldsDisplay["display_type"] = true;
		// Tenta pega foto do depoimento.
		$photo = self::getPhoto($testimonial->id);

		if($testimonial->display_type == "text"){
			$testimonial->text_testimonial = JHtml::_('string.truncate', $testimonial->text_testimonial, $fieldsDisplay->display_field_number_characters_testimonial); 
		}
		// Verifica se existe foto.
		if(!is_null($photo)){
			// Gera src para tag <img>.
			$srcImage = self::getSrcImage($photo->content_image, $photo->mime_type);
			// Adiciona propriedade $srcImage a foto.
			$photo->src_image = $srcImage;
			// Adiciona foto ao depoimento.
			$testimonial->photo = $photo;
		}

		// Remove campos não permitidos para exibição.
		NobosstestimonialsHelper::filterTestimonialFieldsGranted($testimonial, $permissionsFieldsDisplay);
		$paramsTestimonials = new stdClass();
		$paramsTestimonials = self::getTestimonialsParams($testimonialsGroup->id_module_testimonials_display);
		
		// Cria que armazena todas as variáveis utilizadas no módulo.		
		$paramsModule = json_decode($testimonialsGroup->config_module_testimonials_display);
        // define variavel novamente pois este arquivo eh carregado via ajax, caso contrario daria erro de variavel indefinida
        $extensionName = "mod_nobosstestimonials";  
		// Realizar required do template do depoimento conforme o tipo.
		require_once JModuleHelper::getLayoutPath('mod_nobosstestimonials', 'theme/' . $paramsTestimonials->theme . '_' . $testimonial->display_type);
	}
	
	/**
	 * Função que pega todas as parametrizações dos depoimentos que são usadas por partes recarregáveis por ajax.
	 * 
	 *
	 * @return Object Objeto com todos os parametros
	 */
	public static function getTestimonialsParams($idModule){
        $app = JFactory::getApplication();
        // pega o template vinculado a pagina
        $tmpl = $app->getTemplate(true);
        // pega os parametros do template
        $tmplParams = $tmpl->params;
        // pega a cor primaria setada nos parametros do template
        $tmplPrimaryColor = $tmplParams->get('primary_color');
        // pega a cor secundaria setada nos parametros do template
        $tmplSecondaryColor = $tmplParams->get('secondary_color');
        
		// Pega o dados do grupo de depoimentos a qual o depoimento está associado.
		$testimonialsGroup = self::getTestimonialsGroup("module", $idModule);
		
		$fields = json_decode($testimonialsGroup->fields_display);
		$fieldsDisplay = new StdClass();
		
		// verifica se deve ou não exibir os campos da seção de dados pessoais
		$fieldsDisplay->displayPhoto = $fields->display_field_personal_data_show_section && $fields->display_field_personal_data_photo == 2 ?  1 : 0;
		$fieldsDisplay->displayEmail = $fields->display_field_personal_data_show_section && $fields->display_field_personal_data_email == 2 ? 1 : 0;
		$fieldsDisplay->displayTephone = $fields->display_field_personal_data_show_section && $fields->display_field_personal_data_telephone == 2 ? 1 : 0;
		
		// verifica se deve ou não exibir os campos da seção de dados do estudante
		$fieldsDisplay->displayCourse = $fields->display_field_student_data_show_section && $fields->display_field_student_data_course == 2 ? 1 : 0;
		$fieldsDisplay->displayClass = $fields->display_field_student_data_show_section && $fields->display_field_student_data_class == 2 ? 1 : 0;
		$fieldsDisplay->displayConclusion = $fields->display_field_student_data_show_section && $fields->display_field_student_data_conclusion_year == 2 ? 1 : 0;

		// verifica se deve ou não exibir os campos da seção de dados profissionais
		$fieldsDisplay->displayCompany = $fields->display_field_professional_data_show_section && $fields->display_field_professional_data_company == 2 ? 1 : 0;
		$fieldsDisplay->displayProfession = $fields->display_field_professional_data_show_section && $fields->display_field_professional_data_profession == 2 ? 1 : 0;

		// parametrizacoes de estilo da exibicao dos depoimentos
		$paramsModule = json_decode($testimonialsGroup->config_module_testimonials_display);
		$paramsTestimonials = new StdClass();
		$paramsTestimonials->theme = json_decode($paramsModule->testimonials_display_theme)->theme;
		$itemsCustomizationXml = 'testimonials_display_items_customization_' . $paramsTestimonials->theme;
		$itemsCustomization = json_decode($paramsModule->$itemsCustomizationXml);
		if($paramsTestimonials->theme != 'model1'){
            $paramsTestimonials->itemsBorderRadius = " border-radius: " . $itemsCustomization->items_border_radius . "px;";
            // pega a cor definida no modulo ou a cor primaria do template
            $itemsCustomization->items_background_color = !empty($itemsCustomization->items_background_color) ? $itemsCustomization->items_background_color : $tmplPrimaryColor;
			$paramsTestimonials->itemsBackgroundColor = "background-color: " . $itemsCustomization->items_background_color . ";";
			$paramsTestimonials->itemsOrientation = !empty($itemsCustomization->items_orientation) ? $itemsCustomization->items_orientation : '';
			$paramsTestimonials->itemsHeight = !empty($itemsCustomization->items_height) && $itemsCustomization->items_height ? 'items--flex' : '';
		}

		// verifica se deve ou não exibir as aspas de citação e armazena os dados de estilo 
		$paramsTestimonials->showQuotes = $itemsCustomization->show_quotes;
		if($itemsCustomization->show_quotes){
			$paramsTestimonials->quotesStyle = "";
			$quotesIconSize = $itemsCustomization->quotes_icon_size;
			if(!empty($quotesIconSize)){
				$quotesIconSizeEm = $quotesIconSize/16;
				$paramsTestimonials->quotesStyle .= "font-size: {$quotesIconSize}px; font-size: {$quotesIconSizeEm}rem;";
			}
			if (!empty($itemsCustomization->quotes_color)){
                // pega a cor definida no modulo ou a cor primaria do template
                $itemsCustomization->quotes_color = !empty($itemsCustomization->quotes_color) ? $itemsCustomization->quotes_color : $tmplPrimaryColor;
				$paramsTestimonials->quotesStyle .= ' color:' . $itemsCustomization->quotes_color . ';';
			}
		}

		// Parametros para imagem do autor
		$paramsTestimonials->imageStyle = "";
		$paramsTestimonials->imagePosition = !empty($itemsCustomization->image_position) ? $itemsCustomization->image_position : '' ;
		$paramsTestimonials->imageStyle .= $itemsCustomization->show_rounded_image ? 'border-radius: 100%;' : '';
		$paramsTestimonials->imageStyle .= ' width: ' . $itemsCustomization->image_width . 'px;';
		$paramsTestimonials->imageStyle .= ' height: ' . $itemsCustomization->image_height . 'px;';
		
		// Parametros para estilo do texto do depoimento
		$paramsTestimonials->testimonialTextStyle = "";
		$paramsTestimonials->testimonialTextStyle .= NoBossUtilFonts::importNobossfontlist($itemsCustomization->testimonial_text_font);
		$paramsTestimonials->testimonialTextStyle .= " text-align: " . $itemsCustomization->testimonial_text_alignment . ";";
        $paramsTestimonials->testimonialTextStyle .= " text-transform: " . $itemsCustomization->testimonial_text_transform . ";";
        // pega a cor definida no modulo ou a cor primaria do template
        $itemsCustomization->testimonial_text_color = !empty($itemsCustomization->testimonial_text_color) ? $itemsCustomization->testimonial_text_color : $tmplPrimaryColor;
		$paramsTestimonials->testimonialTextStyle .= " color: " . $itemsCustomization->testimonial_text_color . ";";
		$paramsTestimonials->testimonialTextStyle .= !empty($itemsCustomization->testimonial_text_space) ? ' padding: ' . implode(' ', (array)$itemsCustomization->testimonial_text_space) . '; ' : '';
		$paramsTestimonials->testimonialTextTagHtml	= $itemsCustomization->testimonial_text_tag_html;
		$testimonialTextSize = $itemsCustomization->testimonial_text_size;
		$testimonialTextSizeMobile = !empty($itemsCustomization->testimonial_text_size_mobile) ? $itemsCustomization->testimonial_text_size_mobile : '';
		$paramsTestimonials->testimonialTextStyleMobile = "";
		if(!empty($testimonialTextSize)){
			$paramsTestimonials->testimonialTextSizeEm = $testimonialTextSize/16;
			$paramsTestimonials->testimonialTextStyle .= " font-size: {$testimonialTextSize}px; font-size: {$paramsTestimonials->testimonialTextSizeEm}em; line-height: 1.5em;";
		}
		if(!empty($testimonialTextSizeMobile)){
			$paramsTestimonials->testimonialTextSizeMobileEm = $testimonialTextSizeMobile/16;
			$paramsTestimonials->testimonialTextStyleMobile .= " font-size: {$testimonialTextSizeMobile}px; font-size: {$paramsTestimonials->testimonialTextSizeMobileEm}em !important;";
		}
		// Parametros para estilo do nome do autor
		$paramsTestimonials->testimonialAuthorStyle = " ";
		$paramsTestimonials->testimonialAuthorStyle .= NoBossUtilFonts::importNobossfontlist($itemsCustomization->testimonial_author_font);
		$paramsTestimonials->testimonialAuthorStyle .= " text-align: " . $itemsCustomization->testimonial_author_alignment . ";";
        $paramsTestimonials->testimonialAuthorStyle .= " text-transform: " . $itemsCustomization->testimonial_author_transform . ";";
        // pega a cor definida no modulo ou a cor primaria do template
        $itemsCustomization->testimonial_author_color = !empty($itemsCustomization->testimonial_author_color) ? $itemsCustomization->testimonial_author_color : $tmplPrimaryColor;
		$paramsTestimonials->testimonialAuthorStyle .= " color: " . $itemsCustomization->testimonial_author_color . ";";
		$paramsTestimonials->testimonialAuthorStyle .= !empty($itemsCustomization->testimonial_author_space) ? ' padding-top: ' . $itemsCustomization->testimonial_author_space[0] . '; padding-bottom: ' . $itemsCustomization->testimonial_author_space[1] . '; ' : '';
		$paramsTestimonials->testimonialAuthorTagHtml	= $itemsCustomization->testimonial_author_tag_html;
		$testimonialAuthorSize = $itemsCustomization->testimonial_author_size;
		if(!empty($testimonialAuthorSize)){
			$paramsTestimonials->testimonialAuthorSizeEm = $testimonialAuthorSize/16;
			$paramsTestimonials->testimonialAuthorStyle .= " font-size: {$testimonialAuthorSize}px; font-size: {$paramsTestimonials->testimonialAuthorSizeEm}em;";
		}
		// Parametros para estilo dos dados pessoais (email e telefone)
		$paramsTestimonials->personalDataStyle = "";
		$paramsTestimonials->personalDataStyle .= NoBossUtilFonts::importNobossfontlist($itemsCustomization->personal_data_font);
        $paramsTestimonials->personalDataStyle .= " text-transform: " . $itemsCustomization->personal_data_transform . ";";
        // pega a cor definida no modulo ou a cor primaria do template
        $itemsCustomization->personal_data_color = !empty($itemsCustomization->personal_data_color) ? $itemsCustomization->personal_data_color : $tmplPrimaryColor;
		$paramsTestimonials->personalDataStyle .= " color: " . $itemsCustomization->personal_data_color . ";";
		$paramsTestimonials->personalDataStyle .= !empty($itemsCustomization->personal_data_space) ? ' padding-top: ' . $itemsCustomization->personal_data_space[0] . '; padding-bottom: ' . $itemsCustomization->personal_data_space[1] . '; ' : '';
		$paramsTestimonials->personalDataAlign = " text-align: " . $itemsCustomization->personal_data_alignment . ";";
		$paramsTestimonials->personalDataTagHtml = $itemsCustomization->personal_data_tag_html;
		$personalDataSize = $itemsCustomization->personal_data_size;
		if(!empty($personalDataSize)){
			$paramsTestimonials->personalDataSizeEm = $personalDataSize/16;
			$paramsTestimonials->personalDataStyle .= " font-size: {$personalDataSize}px; font-size: {$paramsTestimonials->personalDataSizeEm}em;";
		}
		
		// Parametros para estilo dos dados de estudante
		$paramsTestimonials->studentDataStyle = "";
		$paramsTestimonials->studentDataStyle .= NoBossUtilFonts::importNobossfontlist($itemsCustomization->student_data_font);
        $paramsTestimonials->studentDataStyle .= " text-transform: " . $itemsCustomization->student_data_transform . ";";
        // pega a cor definida no modulo ou a cor primaria do template
        $itemsCustomization->student_data_color = !empty($itemsCustomization->student_data_color) ? $itemsCustomization->student_data_color : $tmplPrimaryColor;
		$paramsTestimonials->studentDataStyle .= " color: " . $itemsCustomization->student_data_color . ";";
		$paramsTestimonials->studentDataStyle .= !empty($itemsCustomization->student_data_space) ? ' padding-top: ' . $itemsCustomization->student_data_space[0] . '; padding-bottom: ' . $itemsCustomization->student_data_space[1] . '; ' : '';
		$paramsTestimonials->studentDataAlign = " text-align: " . $itemsCustomization->student_data_alignment . ";";
		$paramsTestimonials->studentDataTagHtml	= $itemsCustomization->student_data_tag_html;
		$studentDataSize = $itemsCustomization->student_data_size;
		if(!empty($studentDataSize)){
			$paramsTestimonials->studentDataSizeEm = $studentDataSize/16;
			$paramsTestimonials->studentDataStyle .= " font-size: {$studentDataSize}px; font-size: {$paramsTestimonials->studentDataSizeEm}em;";
		}
		
		// Parametros para estilo dos dados profissionais
		$paramsTestimonials->professionalDataStyle = "";
		$paramsTestimonials->professionalDataStyle .= NoBossUtilFonts::importNobossfontlist($itemsCustomization->professional_data_font);
        $paramsTestimonials->professionalDataStyle .= " text-transform: " . $itemsCustomization->professional_data_transform . ";";
        // pega a cor definida no modulo ou a cor primaria do template
        $itemsCustomization->professional_data_color = !empty($itemsCustomization->professional_data_color) ? $itemsCustomization->professional_data_color : $tmplPrimaryColor;
		$paramsTestimonials->professionalDataStyle .= " color: " . $itemsCustomization->professional_data_color . ";";
		$paramsTestimonials->professionalDataStyle .= !empty($itemsCustomization->professional_data_space) ? ' padding-top: ' . $itemsCustomization->professional_data_space[0] . '; padding-bottom: ' . $itemsCustomization->professional_data_space[1] . '; ' : '';
		$paramsTestimonials->professionalDataAlign = " text-align: " . $itemsCustomization->professional_data_alignment . ";";
		$paramsTestimonials->professionalDataTagHtml	= $itemsCustomization->professional_data_tag_html;
		$professionalDataSize = $itemsCustomization->professional_data_size;
		if(!empty($professionalDataSize)){
			$paramsTestimonials->professionalDataSizeEm = $professionalDataSize/16;
			$paramsTestimonials->professionalDataStyle .= " font-size: {$professionalDataSize}px; font-size: {$paramsTestimonials->professionalDataSizeEm}em;";
		}
		return (object) array_merge(array_merge((array) $paramsTestimonials, (array) $fieldsDisplay));
	}
	
	/**
	 * Método que busca dados do grupo de um depoimentos a qual um módulo está associado
	 *
	 * @param 	string 		$filter Filtro para a busca do grupo de depoimentos.
	 * @param 	int 		$valueFilter Valor do filtro.
	 *
	 * @return 	object|null Retorna registro dos dados do grupo do módulo ou null caso o módulo não possua
	 * grupo associado.
	 */
	public static function getTestimonialsGroup($filter, $valueFilter){
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		$query
			->select("testimonials_group.*")
			->from("#__noboss_testimonial_group AS testimonials_group");

		// Se o filtro é para modulo.
		if($filter == "module"){
            $query->where("testimonials_group.id_module_testimonials_display = '{$valueFilter}'");
		}

		// Se o filtro é para depoimento
		if($filter == "testimonial"){
            $query->where("testimonials_group.id_testimonials_group = '{$valueFilter}'");
        }

        $db->setQuery($query);
        
        //echo str_replace('#__', 'ext_', $query); exit;

		$result = $db->loadObject();

		return $result;
    }
    
    /**
     * Pega o tipo de display do testimonial
     *
     * @param int $idModule id do modulo
     * @return object|null objeto com o tipo de display do testimonial
     */
    public static function getTestimonialsDisplay($idModule){
        $db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select("testimonials_group.fields_display")
            ->from("#__noboss_testimonial_group AS testimonials_group")
            ->where("testimonials_group.id_module_testimonials_display = '{$idModule}'");

        $db->setQuery($query);
        $result = $db->loadObject();
        return $result;
    }

	/**
	 * Método que parâmetros do módulo conforme seu grupo de depoimentos associado.
	 *
	 * @param 	int 	$idModule Id do módulo para buscar os parâmetros.
	 *
	 * @return 	mixed 	Retorna objeto com os parâmetros caso sucesso, retornará false caso
	 * o módulo não possua grupo associado.
	 */
	public static function getParamsModuleByTestimonialsGroup($idModule){
		// Pege o grupo de depoimentos associado ao módulo.
		$testimonialGroup = self::getTestimonialsGroup("module", $idModule);

		// Verifica existe grupo de depoimentos associado ao modulo.
		if(empty($testimonialGroup)){
			return false;
		}

		// Pega campo de configurações do módulo.
		$configModuleTestimonialsDisplay = $testimonialGroup->config_module_testimonials_display;
		// Realiza decode dos dados.
		$moduleParams = json_decode($configModuleTestimonialsDisplay);
		
		return $moduleParams;
	}

	/**
	 * Função que monta src para tag imga do HTML.
	 *
	 * @param 	string 	$stringImage Conteúdo em string da imagem.
	 * @param 	string 	$imageMime  Mimetype da imagem.
	 *
	 * @return 	string 	Retorna conteúdo src para tag img.
	 */
	public static function getSrcImage($stringImage, $imageMime){
		$stringImage = base64_encode($stringImage);
		$imageMime = $imageMime;
		return "data:". $imageMime . ";base64," . $stringImage;
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
