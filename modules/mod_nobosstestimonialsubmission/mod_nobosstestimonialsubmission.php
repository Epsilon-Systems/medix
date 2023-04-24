<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

jimport('joomla.filesystem.folder');

$app = JFactory::getApplication();
// pega o template vinculado a pagina
$tmpl = $app->getTemplate(true);
// pega os parametros do template
$tmplParams = $tmpl->params;
// pega a cor primaria setada nos parametros do template
$tmplPrimaryColor = $tmplParams->get('primary_color');
// pega a cor secundaria setada nos parametros do template
$tmplSecondaryColor = $tmplParams->get('secondary_color');

jimport('noboss.util.loadextensionassets');
jimport('noboss.util.fonts');

// Importa arquivo de traducao da library
JFactory::getLanguage()->load('lib_noboss', JPATH_SITE . '/libraries/noboss/');

// Parametro com nome do modulo nao esta definido
if (!isset($module->name)){
    $module->name = str_replace('mod_', '', $module->module);
}
$moduleName = $module->name;
$extensionName = "mod_" . $module->name;

// Pega o id do módulo.
$moduleId = $module->id;

// Adiciona o caminho do campo personalizado contido no componente com_nobosstestimonials
JForm::addFieldPath(JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/models/fields');
// Carrega helper do componente de depoimentos.
JLoader::register('NobosstestimonialsHelper', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/helpers/nobosstestimonials.php');

// Carrega helper do módulo de depoimentos.
JLoader::register('ModNobosstestimonialsubmissionHelper', __DIR__ . '/helper.php');

// Verifica se no boss library esta instalada: se ainda nao estiver, tenta instalar e se ainda nao der retorna false
if(!ModNobosstestimonialsubmissionHelper::checkLibraryInstallation()){
    return;
}

// Adiciona mais um a variável de controle de módulos carregados.
ModNobosstestimonialsubmissionHelper::$countModulesLoad++;

// Pega o documento.
$doc = JFactory::getDocument();

// Pega os parâmetros do module conforme seu grupo associado.
$paramsModule = ModNobosstestimonialsubmissionHelper::getParamsModuleByTestimonialsGroup($moduleId);

// Parametros da modal de personalização do formulário
$submissionForm = json_decode($paramsModule->testimonials_submission_form);

// armazema estilo da seçao, elemento mais externo do html 
$sectionStyle = "";

// armazema estilo da seçao para o mobile, elemento mais externo do html 
$sectionStyleMobile = "";

// Parâmetros para título do formulário
$headerTitle = new stdClass();
$headerTitle->show_title = $paramsModule->testimonials_submission_show_title;
$headerTitle->title = rtrim($paramsModule->testimonials_submission_title);
$headerTitle->title_tag_html = $submissionForm->header_title_tag_html;
$headerTitle->style = "";
$headerTitle->style .= NoBossUtilFonts::importNobossfontlist($submissionForm->header_title_font);
$headerTitle->style .= " text-align: " . $submissionForm->header_title_alignment . ";";
$headerTitle->style .= " text-transform: " . $submissionForm->header_title_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->header_title_color = !empty($submissionForm->header_title_color) ? $submissionForm->header_title_color : $tmplPrimaryColor;
$headerTitle->style .= " color: " . $submissionForm->header_title_color . ";";
$headerTitle->style .= !empty($submissionForm->header_title_space) ? ' padding-top: ' . $submissionForm->header_title_space[0] . '; padding-bottom: ' . $submissionForm->header_title_space[1] . '; ' : '';
$headerTitleSize = $submissionForm->header_title_size;
$headerTitleSizeMobile = !empty($submissionForm->header_title_size_mobile) ? $submissionForm->header_title_size_mobile : '';
$headerTitleStyleMobile = "";
if(!empty($headerTitleSize)){
	$headerTitleSizeEm = $headerTitleSize/16;
	$headerTitle->style .= " font-size: {$headerTitleSize}px; font-size: {$headerTitleSizeEm}em;";
}
if(!empty($headerTitleSizeMobile)){
	$headerTitleSizeMobileEm = $headerTitleSizeMobile/16;
	$headerTitleStyleMobile .= " font-size: {$headerTitleSizeMobile}px; font-size: {$headerTitleSizeMobileEm}em !important;";
}

// Parâmetros para subtítulo do formulário
$headerSubtitle = new stdClass();
$headerSubtitle->show_subtitle = $paramsModule->testimonials_submission_show_subtitle;
$headerSubtitle->subtitle = rtrim($paramsModule->testimonials_submission_subtitle);
$headerSubtitle->subtitle_tag_html = $submissionForm->header_subtitle_tag_html;
$headerSubtitle->style = "";
$headerSubtitle->style .= NoBossUtilFonts::importNobossfontlist($submissionForm->header_subtitle_font);
$headerSubtitle->style .= " text-align: " . $submissionForm->header_subtitle_alignment . ";";
$headerSubtitle->style .= " text-transform: " . $submissionForm->header_subtitle_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->header_subtitle_color = !empty($submissionForm->header_subtitle_color) ? $submissionForm->header_subtitle_color : $tmplPrimaryColor;
$headerSubtitle->style .= " color: " . $submissionForm->header_subtitle_color . ";";
$headerSubtitle->style .= !empty($submissionForm->header_subtitle_space) ? ' padding-top: ' . $submissionForm->header_subtitle_space[0] . '; padding-bottom: ' . $submissionForm->header_subtitle_space[1] . '; ' : '';
$headerSubtitleSize = $submissionForm->header_subtitle_size;
$headerSubtitleSizeMobile = !empty($submissionForm->header_subtitle_size_mobile) ? $submissionForm->header_subtitle_size_mobile : '';
$headerSubitleStyleMobile = "";
if(!empty($headerSubtitleSize)){
	$headerSubtitleSizeEm = $headerSubtitleSize/16;
	$headerSubtitle->style .= " font-size: {$headerSubtitleSize}px; font-size: {$headerSubtitleSizeEm}em;";
}
if(!empty($headerSubtitleSizeMobile)){
	$headerSubtitleSizeMobileEm = $headerSubtitleSizeMobile/16;
	$headerSubitleStyleMobile .= " font-size: {$headerSubtitleSizeMobile}px; font-size: {$headerSubtitleSizeMobileEm}em !important;";
}

// Parâmetros para título das seções
$sectionsTitle = new stdClass();
$sectionsTitle->show_title = $paramsModule->testimonials_submission_show_title;
$sectionsTitle->title = rtrim($paramsModule->testimonials_submission_title);
$sectionsTitle->title_tag_html = $submissionForm->sections_title_tag_html;
$sectionsTitle->style = "";
$sectionsTitle->style .= NoBossUtilFonts::importNobossfontlist($submissionForm->sections_title_font);
$sectionsTitle->style .= " text-align: " . $submissionForm->sections_title_alignment . ";";
$sectionsTitle->style .= " text-transform: " . $submissionForm->sections_title_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->sections_title_color = !empty($submissionForm->sections_title_color) ? $submissionForm->sections_title_color : $tmplPrimaryColor;
$sectionsTitle->style .= " color: " . $submissionForm->sections_title_color . ";";
$sectionsTitle->style .= !empty($submissionForm->sections_title_space) ? ' padding-top: ' . $submissionForm->sections_title_space[0] . '; padding-bottom: ' . $submissionForm->sections_title_space[1] . '; ' : '';
$sectionTitleSize = $submissionForm->sections_title_size;
$sectionTitleSizeMobile = !empty($submissionForm->sections_title_size_mobile) ? $submissionForm->sections_title_size_mobile : '';
$sectionTitleStyleMobile = "";
if(!empty($sectionTitleSize)){
	$sectionTitleSizeEm = $sectionTitleSize/16;
	$sectionsTitle->style .= " font-size: {$sectionTitleSize}px; font-size: {$sectionTitleSizeEm}em;";
}
if(!empty($sectionTitleSizeMobile)){
	$sectionTitleSizeMobileEm = $sectionTitleSizeMobile/16;
	$sectionTitleStyleMobile .= " font-size: {$sectionTitleSizeMobile}px; font-size: {$sectionTitleSizeMobileEm}em !important;";
}

// Parâmetros para subtítulo das seções
$sectionsSubtitle = new stdClass();
$sectionsSubtitle->show_subtitle = $paramsModule->testimonials_submission_show_subtitle;
$sectionsSubtitle->subtitle = rtrim($paramsModule->testimonials_submission_subtitle);
$sectionsSubtitle->subtitle_tag_html = $submissionForm->sections_subtitle_tag_html;
$sectionsSubtitle->style = "";
$sectionsSubtitle->style .= NoBossUtilFonts::importNobossfontlist($submissionForm->sections_subtitle_font);
$sectionsSubtitle->style .= " text-align: " . $submissionForm->sections_subtitle_alignment . ";";
$sectionsSubtitle->style .= " text-transform: " . $submissionForm->sections_subtitle_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->sections_subtitle_color = !empty($submissionForm->sections_subtitle_color) ? $submissionForm->sections_subtitle_color : $tmplPrimaryColor;
$sectionsSubtitle->style .= " color: " . $submissionForm->sections_subtitle_color . ";";
$sectionsSubtitle->style .= !empty($submissionForm->sections_subtitle_space) ? ' padding-top: ' . $submissionForm->sections_subtitle_space[0] . '; padding-bottom: ' . $submissionForm->sections_subtitle_space[1] . '; ' : '';
$sectionsSubtitleSize = $submissionForm->sections_subtitle_size;
$sectionSubtitleSizeMobile = !empty($submissionForm->sections_subtitle_size_mobile) ? $submissionForm->sections_subtitle_size_mobile : '';
$sectionSubtitleStyleMobile = "";
if(!empty($sectionsSubtitleSize)){
	$sectionsSubtitleSizeEm = $sectionsSubtitleSize/16;
	$sectionsSubtitle->style .= " font-size: {$sectionsSubtitleSize}px; font-size: {$sectionsSubtitleSizeEm}em;";
}
if(!empty($sectionSubtitleSizeMobile)){
	$sectionSubtitleSizeMobileEm = $sectionSubtitleSizeMobile/16;
	$sectionSubtitleStyleMobile .= " font-size: {$sectionSubtitleSizeMobile}px; font-size: {$sectionSubtitleSizeMobileEm}em !important;";
}

// Ajustes manuais da área externa caso exista valor
if ($submissionForm->external_area_display_mode){
    if(!empty($submissionForm->external_area_width)){
        $sectionStyle .= 'margin-left: auto !important; margin-right: auto !important; width:' . $submissionForm->external_area_width . '%;';
    }
    if(!empty($submissionForm->external_area_width_mobile)){
        $sectionStyleMobile .= 'width:' . $submissionForm->external_area_width_mobile . '% !important; ';
    }
}

// verifica qual o modo de exibição
// 1: é manual, então exibe container
// 0: é full width 
if($submissionForm->content_display_mode){
    $itemColumns = !empty($submissionForm->content_columns) ? "nb-lg-{$submissionForm->content_columns} nb-md-{$submissionForm->content_columns} nb-sm-{$submissionForm->content_columns} nb-xs-12" : "";
}

// armazena o estilo do espaçamento interno na variável que é colocada no elemento mais externo
$sectionStyle .= ' padding: ' . implode(' ', $submissionForm->external_area_inner_space) . '; ';
// armazena o estilo do espaçamento interno para o mobile na variável que é colocada no elemento mais externo
$sectionStyleMobile .= 'padding: ' . implode(' ', $submissionForm->external_area_inner_space_mobile) . ' !important; ';
// armazena o estilo do espaçamento externo na variável que é colocada no elemento mais externo
$sectionStyle .= ' margin: ' . implode(' ', $submissionForm->external_area_outer_space) . '; ';
// armazena o estilo do espaçamento externo na variável que é colocada no elemento mais externo
$sectionStyleMobile .= 'margin: ' . implode(' ', $submissionForm->external_area_outer_space_mobile) . ' !important;';

// Cor de fundo do formulário
$sectionStyle .= $submissionForm->show_external_area_background ? 'background-color: ' . $submissionForm->external_area_background_color . ';' : '';

$submissionForm->inputStyle = "";
$submissionForm->inputStyle .= NoBossUtilFonts::importNobossfontlist($submissionForm->inputs_text_font);
$submissionForm->inputStyle .= " text-align: " . $submissionForm->inputs_text_alignment . ";";
$submissionForm->inputStyle .= " text-transform: " . $submissionForm->inputs_text_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->inputs_text_color = !empty($submissionForm->inputs_text_color) ? $submissionForm->inputs_text_color : $tmplPrimaryColor;
$submissionForm->inputStyle .= " color: " . $submissionForm->inputs_text_color . ";";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->inputs_background_color = !empty($submissionForm->inputs_background_color) ? $submissionForm->inputs_background_color : $tmplPrimaryColor;
$submissionForm->inputStyle .= " background-color: " . $submissionForm->inputs_background_color . ";";
$inputSize = $submissionForm->inputs_text_size;
if(!empty($inputSize)){
	$inputSizeEm = $inputSize/16;
	$submissionForm->inputStyle .= " font-size: {$inputSize}px; font-size: {$inputSizeEm}em;";
}

// Guarda estilo dos botões
$submissionForm->buttonStyle = "";
// Guarda estilo dos botões no hover
$submissionForm->buttonStyleHover = "";
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->buttons_background_color = !empty($submissionForm->buttons_background_color) ? $submissionForm->buttons_background_color : $tmplPrimaryColor;
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->buttons_text_color = !empty($submissionForm->buttons_text_color) ? $submissionForm->buttons_text_color : $tmplPrimaryColor;
// pega a cor definida no modulo ou a cor primaria do template
$submissionForm->buttons_border_color = !empty($submissionForm->buttons_border_color) ? $submissionForm->buttons_border_color : $tmplPrimaryColor;
// pega a cor definida no modulo ou a cor secundaria do template
$submissionForm->buttons_background_hover_color = !empty($submissionForm->buttons_background_hover_color) ? $submissionForm->buttons_background_hover_color : $tmplSecondaryColor;
// pega a cor definida no modulo ou a cor secundaria do template
$submissionForm->buttons_hover_text_color = !empty($submissionForm->buttons_hover_text_color) ? $submissionForm->buttons_hover_text_color : $tmplSecondaryColor;
// pega a cor definida no modulo ou a cor secundaria do template
$submissionForm->buttons_hover_border_color = !empty($submissionForm->buttons_hover_border_color) ? $submissionForm->buttons_hover_border_color : $tmplSecondaryColor;

// Verifica o modelo do botão
switch ($submissionForm->buttons_style) {
	// Botão quadrado
	case 'squared-button':
		$submissionForm->checkboxColor = $submissionForm->buttons_background_color;
		$submissionForm->buttonStyle = "color: {$submissionForm->buttons_text_color}; background-color: {$submissionForm->buttons_background_color};";
		$submissionForm->buttonStyleHover = "background-color: {$submissionForm->buttons_background_hover_color} !important;";
		break;
	// Botão arredondado
	case 'rounded-button':
		$submissionForm->checkboxColor = $submissionForm->buttons_background_color;
		$submissionForm->buttonStyle = "color: {$submissionForm->buttons_text_color}; background-color: {$submissionForm->buttons_background_color}; border-radius: {$submissionForm->buttons_border_radius_size}px;";
		$submissionForm->buttonStyleHover = "background-color: {$submissionForm->buttons_background_hover_color} !important;";
		break;
	// Botão transparente quadrado
	case 'ghost-squared-button':
		$submissionForm->checkboxColor = $submissionForm->buttons_border_color;
		$submissionForm->buttonStyle = "background-color: transparent; border: 1px solid;  color: {$submissionForm->buttons_text_color}; border-color: {$submissionForm->buttons_border_color};";
		$submissionForm->buttonStyleHover = "color: {$submissionForm->buttons_hover_text_color} !important; border-color: {$submissionForm->buttons_hover_border_color} !important; background-color: {$submissionForm->buttons_background_hover_color} !important;";
		break;
	// Botão transparente arredondado
	case 'ghost-rounded-button':
		$submissionForm->checkboxColor = $submissionForm->buttons_border_color;
		$submissionForm->buttonStyle = "background-color: transparent; border: 1px solid; color: {$submissionForm->buttons_text_color}; border-color: {$submissionForm->buttons_border_color}; border-radius: {$submissionForm->buttons_border_radius_size}px;";
		$submissionForm->buttonStyleHover = "color: {$submissionForm->buttons_hover_text_color} !important; border-color: {$submissionForm->buttons_hover_border_color} !important; background-color: {$submissionForm->buttons_background_hover_color} !important;";
		break;
	default:
		$submissionForm->buttonStyle = "color: {$submissionForm->buttons_text_color};";
		break;
}

// Alinhamento do botão 
if($submissionForm->buttons_position == "left" || $submissionForm->buttons_position == "right"){
	$submissionForm->buttons_position = " float: {$submissionForm->buttons_position}; ";
}else{
	$submissionForm->buttons_position = " margin: auto; display: table; ";
}
$submissionForm->buttonStyle .= NoBossUtilFonts::importNobossfontlist($submissionForm->buttons_font);
$submissionForm->buttonStyle .= " text-transform: {$submissionForm->buttons_text_transform};";
$buttonsSize = $submissionForm->buttons_text_size;
if(!empty($buttonsSize)){
	$buttonsSizeEm = $buttonsSize/16;
	$submissionForm->buttonStyle .= " font-size: {$buttonsSize}px; font-size: {$buttonsSizeEm}em;";
}

$submissionForm->buttonStyle .= isset($submissionForm->buttons_space) ? ' padding: '.implode(' ', $submissionForm->buttons_space).';' : ' padding: 0.5em 2em;';

// Estilo das labels dos campos 
$submissionForm->labelStyle = "";
if($submissionForm->show_label_and_placeholder == 'label' || $submissionForm->show_label_and_placeholder == 'both'){
	$submissionForm->labelStyle .= NoBossUtilFonts::importNobossfontlist($submissionForm->label_font);
    $submissionForm->labelStyle .= " text-transform: " . $submissionForm->label_transform . ";";
    // pega a cor definida no modulo ou a cor primaria do template
    $submissionForm->label_color = !empty($submissionForm->label_color) ? $submissionForm->label_color : $tmplPrimaryColor;
	$submissionForm->labelStyle .= " color: " . $submissionForm->label_color . ";";
	$labelSize = $submissionForm->label_size;
	if(!empty($labelSize)){
		$labelSizeEm = $labelSize/16;
		$submissionForm->labelStyle .= " font-size: {$labelSize}px; font-size: {$labelSizeEm}em;";
	}
}

$submissionForm->borderStyle = '';
// Verifica se deve exibir borda
if($submissionForm->inputs_show_border){
	// Verifica se deve exibir borda com apenas uma linha embaixo do campo
	if($submissionForm->inputs_one_line_border){
		$submissionForm->borderStyle .= "padding-left: 0px; border-radius: 0px; border-bottom: " . $submissionForm->inputs_border_size . "px solid " . $submissionForm->inputs_border_color . ";";
	}else{
		$submissionForm->borderStyle .= "padding: .5em 1em; border: " . $submissionForm->inputs_border_size . "px solid " . $submissionForm->inputs_border_color . ";";
		$submissionForm->borderStyle .= " \n border-radius: " . $submissionForm->inputs_border_radius . "px;";
	}
}

// Define prefixo a ser utilizado na insercao de codigos inline para CSS e JS
$prefixCodeJsAndCss = "[module-id={$module->name}_{$module->id}]";

// Obtem informacoes de codigos JS e CSS a serem inseridos
$loadJs	 		= $paramsModule->testimonials_submission_load_js;
$overwritingJs	= $paramsModule->testimonials_submission_overwriting_js;
$loadCss 		= $paramsModule->testimonials_submission_load_css;
$overwritingCss	= $paramsModule->testimonials_submission_overwriting_css;

// Instancia objeto passando o nome da extensao com prefixo (ex: 'mod_nobossbanners')
$assetsObject = new NoBossUtilLoadExtensionAssets($extensionName, $prefixCodeJsAndCss);
// Adiciona arquivos e codigos JS (se definido para exibir)
$assetsObject->loadJs($loadJs, array('code' => $overwritingJs));

// Adiciona arquivos e codigos CSS (se definido para carregar)
$assetsObject->loadCss($loadCss, array('code' => $overwritingCss));

// adiciona css dos icones font-awesome
$assetsObject->loadFamilyIcons('font-awesome');

// Carrega constantes conforme linguagem de navegação do usuário.
$lang = JFactory::getLanguage();
$extensionPath = $assetsObject->getDirectoryExtension(true);
$lang->load('com_nobosstestimonials', 'administrator/components/com_nobosstestimonials/');

// Pega o formulário para exibição.
$testimonial = ModNobosstestimonialsubmissionHelper::getFormTestimonialSubmissionByGroup($moduleId);
// Se o campo 'display_type' estiver setado 
if(isset($testimonial->display_type)){
	// Adiciona ao nome do campo o id do módulo para que se torne único na página.
	$testimonial->display_type->__set("name", $testimonial->display_type->name . "_" . ModNobosstestimonialsubmissionHelper::$countModulesLoad);
	
	/* Cria um método anônimo para acessar e tratar atributo protegido showon,
	   permitindo que funcione com vários módulos na página. */
	$anonymousFunctionHandleShowon = function (JFormField $jFormField, $countModulesLoad) {
		$showon = $jFormField->element['showon'];
		$showon = explode(":", $showon);
		$showon[0] = $showon[0] . "_" . $countModulesLoad;
		$showon = implode(":", $showon);
		$jFormField->element['showon']  = $showon;
		// seta o atributo showon do field com o novo valor do showon 
		$jFormField->showon = $showon;
	};
	
	// Faz uso de Closure para sobrescrever e acessar atributo protegido campo de depoimento em texto.
	$handleTextTestimonail = Closure::bind($anonymousFunctionHandleShowon, null, $testimonial->text_testimonial);
	
	// Faz uso de Closure para sobrescrever e acessar atributo protegido campo de depoimento em vídeo.
	$handleVideoTestimonail = Closure::bind($anonymousFunctionHandleShowon, null, $testimonial->video_id);
	
	// Trata o showon do campo de texto
	$handleTextTestimonail($testimonial->text_testimonial, ModNobosstestimonialsubmissionHelper::$countModulesLoad);
	
	// Configura depoimento em texto como obrigátório.
	$testimonial->text_testimonial->__set("required", "required");
	
	// Trata o showon do campo de ID do video
	$handleVideoTestimonail($testimonial->video_id, ModNobosstestimonialsubmissionHelper::$countModulesLoad);
	
	// Configura id do video como obrigátório.
	$testimonial->video_id->__set("required", "required");

}else{
	// Caso 'display_type' não estiver setado e o campo de texto estiver
	if(isset($testimonial->text_testimonial)){
		// Seta o campo de texto como required
		$testimonial->text_testimonial->__set("required", "required");
	}else{
		// Caso contrário, seta o campo de ID do video como required
		$testimonial->video_id->__set("required", "required");
	}
}

// Pega descrição da foto com informações sobre extensões e tamanhos permitidos.
$descriptionPhoto = NobosstestimonialsHelper::getPhotoDescriptionHandle();

// Checkbox de autorização de depoimento.
// Verifica se foi informado uma mensagem personalizada.
if(empty(rtrim($paramsModule->testimonials_submission_text_authorize_testimonial))){
	// Pega uma valor padrão para a mensagem.
	$messageAuthorizeTestimonial = JText::_("COM_NOBOSSTESTIMONIALS_TEXT_AUTHORIZE_TESTIMONIAL_DEFAULT");
}else{
	// Configura mensagem personaliza do usuário.
	$messageAuthorizeTestimonial = rtrim($paramsModule->testimonials_submission_text_authorize_testimonial);
}
// Limitador de caracteres.
$caracterLimitation = $paramsModule->display_field_number_characters_testimonial;

// Flag que controla para que a exibição da seção ocorra apenas uma vez.
$hasSectionPersonalData = false;

// se o formulario deve ser exibido
if($paramsModule->testimonials_submission_show_form){
    
	// rendereriza o estilo e a tmpl do modulo
	require JModuleHelper::getLayoutPath($extensionName, 'style/model1');
	require JModuleHelper::getLayoutPath($extensionName, $params->get('layout', 'theme/model1'));
}
