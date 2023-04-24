<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2019 No Boss Technology. All rights reserved.
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

// Importa os arquivos da llibrary noboss
jimport('noboss.util.loadextensionassets');
jimport('noboss.util.fonts');
// Carrega jQuery.
JHtml::_('jquery.framework');

// Parametro com nome do modulo nao esta definido
if (!isset($module->name)){
    $module->name = str_replace('mod_', '', $module->module);
}
$moduleName = $module->name;
$extensionName = "mod_" . $module->name;

// Pega o módulo.
$moduleNobosstestimonials = $module;

// Pega id do módulo.
$moduleId = $moduleNobosstestimonials->id;

// Carrega helper do módulo de depoimentos para uso em qualquer parte do módulo.
JLoader::register('ModNobosstestimonialsHelper', __DIR__ . '/helper.php');

// Verifica se no boss library esta instalada: se ainda nao estiver, tenta instalar e se ainda nao der retorna false
if(!ModNobosstestimonialsHelper::checkLibraryInstallation()){
    return;
}

// Pega o documento.
$doc = JFactory::getDocument();

// Pega os parametros do module conforme seu grupo associado.
$moduleParams = ModNobosstestimonialsHelper::getParamsModuleByTestimonialsGroup($moduleId);

// Pega o modelo escolhido
$theme = json_decode($moduleParams->testimonials_display_theme)->theme;

// armazema estilo da seçao, elemento mais externo do html 
$sectionStyle = "";
// armazema estilo da seçao para o mobile, elemento mais externo do html 
$sectionStyleMobile = "";

// Cria objeto com parametrizaçao da modal de itens
$itemsCustomizationXml = 'testimonials_display_items_customization_' . $theme;
$itemsCustomization = json_decode($moduleParams->$itemsCustomizationXml);

// Cria objeto com parametrizaçao da modal de area externa
$externalAreaXml = 'testimonials_display_external_area_' . $theme;
$externalArea = json_decode($moduleParams->$externalAreaXml);

if(empty($externalArea)){
	return;
}

// Ajustes manuais da área externa caso exista valor
if (!empty($externalArea->external_area_display_mode) && $externalArea->external_area_display_mode){
    if(!empty($externalArea->external_area_width)){
        $sectionStyle .= 'margin-left: auto !important; margin-right: auto !important; width:' . $externalArea->external_area_width . '%;';
    }
    if(!empty($externalArea->external_area_width_mobile)){
        $sectionStyleMobile .= 'width:' . $externalArea->external_area_width_mobile . '% !important; ';
    }
}
// verifica qual o modo de exibição
// 1: é manual, então exibe container
// 0: é full width 

if($externalArea->content_display_mode){
    $itemColumns = !empty($externalArea->content_columns) ? "nb-lg-{$externalArea->content_columns} nb-md-{$externalArea->content_columns} nb-sm-{$externalArea->content_columns} nb-xs-12" : "";
}

// armazena o estilo do espaçamento interno na variável que é colocada no elemento mais externo
$sectionStyle .= ' padding: ' . implode(' ', (array)$externalArea->external_area_inner_space) . '; ';
// armazena o estilo do espaçamento interno para o mobile na variável que é colocada no elemento mais externo
$sectionStyleMobile .= 'padding: ' . implode(' ', (array)$externalArea->external_area_inner_space_mobile) . ' !important; ';
// armazena o estilo do espaçamento externo na variável que é colocada no elemento mais externo
$sectionStyle .= ' margin: ' . implode(' ', (array)$externalArea->external_area_outer_space) . '; ';
// armazena o estilo do espaçamento externo na variável que é colocada no elemento mais externo
$sectionStyleMobile .= 'margin: ' . implode(' ', (array)$externalArea->external_area_outer_space_mobile) . ' !important;';

// parametros de altura da area externa
$externalArea->external_area_height = 'min-height: ' . ((!empty($externalArea->external_area_height)) ? $externalArea->external_area_height : '650') . 'px;';

$externalArea->external_area_height_mobile = 'min-height: ' . (!empty($externalArea->external_area_height_mobile)) ? $externalArea->external_area_height_mobile : '500' . 'px;';

// parametros de transicao de itens
$jsConfig = new StdClass();
$jsConfig->showDots = $itemsCustomization->show_dots ? true : false;

// se for o model1 que eh o unico que tem video
if($theme == 'model1'){
    //faz requisicao para obter o modo de exibicao
    $displayMode = ModNobosstestimonialsHelper::getTestimonialsDisplay($moduleId);
    $displayMode = json_decode($displayMode->fields_display);

    //verifica se o modo de exibicao eh de texto
    if($displayMode->display_field_options === 'only_text'){
        $jsConfig->autoPlay = $itemsCustomization->enable_auto_play ? true : false;
    }else{
        //se nao, seta o autoplay como false
        $jsConfig->autoPlay = false;
    }
}else{
    $jsConfig->autoPlay = $itemsCustomization->enable_auto_play ? true : false;
}

$jsConfig->autoPlayInterval = intval($itemsCustomization->auto_play_interval) * 1000;
// unico modelo que nao permite arrastar eh o modelo 1
if($theme != 'model1'){
	$jsConfig->mouseDrag = $itemsCustomization->enable_dragging ? true : false;
}

// configuracao dos dots
$showDots = $jsConfig->showDots;
$dotsStyle = "";
// pega a cor definida no modulo ou a cor primaria do template
$itemsCustomization->dots_color = !empty($itemsCustomization->dots_color) ? $itemsCustomization->dots_color : $tmplPrimaryColor;
$dotsStyle .= "background-color: " . $itemsCustomization->dots_color . "; ";
$dotsStyle .= "width: calc({$itemsCustomization->dots_size[0]} + {$itemsCustomization->dots_size[1]});";
$dotsStyle .= "padding: " . implode(' ', (array)$itemsCustomization->dots_size) . "; ";
$dotsStyle .= "margin: 0 " . $itemsCustomization->dots_spacing_items . "px; ";
$dotsShowBorder = $itemsCustomization->show_dots_border;
$dotsStyle .= $dotsShowBorder ? "border: 2px solid " . $itemsCustomization->dots_border_color . "; " : "";
$dotsStyle .= $dotsShowBorder ? "border-radius: {$itemsCustomization->dots_border_radius_size}px; " : "";
$dotsActiveStyle = "";
// pega a cor definida no modulo ou a cor secundaria do template
$itemsCustomization->dots_active_color = !empty($itemsCustomization->dots_active_color) ? $itemsCustomization->dots_active_color : $tmplSecondaryColor;
$dotsActiveStyle .= "background-color:  " . $itemsCustomization->dots_active_color . "; ";
$dotsActiveStyle .="width: calc({$itemsCustomization->dots_active_size[0]} + {$itemsCustomization->dots_active_size[1]});";
$dotsActiveStyle .= "padding: " . implode(' ', (array)$itemsCustomization->dots_active_size) . "; ";

// configuracao das setas
$arrowsStyle = "";
$description = "";
$showArrows = $itemsCustomization->show_arrows != 'none';
if($showArrows){
	$arrowsIconSize = $itemsCustomization->arrows_icon_size;
	$arrowsSpacing = implode(' ', (array)$itemsCustomization->arrows_spacing);
	$arrowsStyle .= "padding: " . $arrowsSpacing . ";";
	if(!empty($arrowsIconSize)){
		$arrowsIconSizeEm = $arrowsIconSize/16;
		$arrowsIconSize = "font-size: {$arrowsIconSize}px; font-size: {$arrowsIconSizeEm}em;";
	}

	$arrowsStyleMobile = "";
	if(isset($itemsCustomization->arrows_icon_size_mobile)){
		$arrowIconSizeMobile = $itemsCustomization->arrows_icon_size_mobile;
		$arrowIconSizeMobileEm = $arrowIconSizeMobile/16;
		$arrowsStyleMobile =  "font-size: {$arrowIconSizeMobile}px; font-size: {$arrowIconSizeMobileEm}em !important;";
	}
    // pega a cor definida no modulo ou a cor primaria do template
    $itemsCustomization->arrows_color = !empty($itemsCustomization->arrows_color) ? $itemsCustomization->arrows_color : $tmplPrimaryColor;
	$arrowsColor = $itemsCustomization->arrows_color;
    $showArrowsBorder = $itemsCustomization->show_arrows_border;
    // pega a cor definida no modulo ou a cor primaria do template
    $itemsCustomization->arrows_border_color = !empty($itemsCustomization->arrows_border_color) ? $itemsCustomization->arrows_border_color : $tmplPrimaryColor;
	$arrowsBorderColor = $itemsCustomization->arrows_border_color;
	$showBorderRadius = $itemsCustomization->show_arrows_border_radius;
    $arrowsBorderRadiusSize = $itemsCustomization->arrows_border_radius;
    
    $showBackgroundArrows = $itemsCustomization->show_arrows_background;
    
    // pega a cor definida no modulo ou a cor primaria do template
    $itemsCustomization->arrows_background = !empty($itemsCustomization->arrows_background) ? $itemsCustomization->arrows_background : $tmplPrimaryColor;
    $arrowsBackgroundColor = $itemsCustomization->arrows_background;
    // pega a cor definida no modulo ou a cor secundaria do template
    $itemsCustomization->arrows_background_hover = !empty($itemsCustomization->arrows_background_hover) ? $itemsCustomization->arrows_background_hover : $tmplSecondaryColor;
	$arrowsBackgroundHoverColor = $itemsCustomization->arrows_background_hover;
	$arrowsBorderRadius = "";
	// verifica se as bordas das setas sao arredondadas
	if ($showBorderRadius && !empty($arrowsBorderRadiusSize)){
		$arrowsBorderRadius = 'border-radius:' . $arrowsBorderRadiusSize . 'px;';
	}
	// cor de fundo das setas
	if ($showBackgroundArrows && !empty($arrowsBackgroundColor)){
		$arrowsStyle .= 'background-color:' . $arrowsBackgroundColor . '; ';
	}
	// borda das setas
	if ($showArrowsBorder && !empty($arrowsBorderColor)){
		$arrowsStyle .= 'border: 1px solid ' . $arrowsBorderColor . ';';
	}
	// cor das setas
	if (!empty($arrowsColor)){
		$arrowsStyle .= ' color:' . $arrowsColor . ';';
	}
}

// Busca os depoimentos relacionados a esse modulo
$testimonials = ModNobosstestimonialsHelper::getItemsTestimonials($moduleId);

// Array que armazena todas as variáveis utilizadas no módulo.
$paramsTestimonials = ModNobosstestimonialsHelper::getTestimonialsParams($moduleId);

// Dados sobre fundo da area externa
$testimonialsBackgroundType = $externalArea->external_area_background_type;
$backgroundImageSrc = $externalArea->external_area_background_image;
$backgroundImageMobileSrc = $externalArea->external_area_background_image_mobile;
$testimonialsFilter = $externalArea->external_area_filter;
// Verifica se foi configurado filtro para o fundo da area externa
if($testimonialsFilter){
	// filtro transparente
	if($testimonialsFilter == "transparent"){
		$transparentFilter = $externalArea->external_area_transparent_filter;
		$testimonialsBackgroundColor = "background-color: {$transparentFilter};";
	}else{
		// filtro de gradiente
		$gradient1 = $externalArea->external_area_gradient_filter_1;
		$gradient2 = $externalArea->external_area_gradient_filter_2;
		$testimonialsBackgroundColor = "background: -webkit-linear-gradient(right, {$gradient1} 0%,{$gradient2} 100%);";
	}
}
// Verifica se vai exibir imagem de fundo ou cor
if($testimonialsBackgroundType == "background-image" && !empty($backgroundImageSrc)){
	// configuracao para exibir imagem de fundo
	$sectionStyle .= "background-image: url('" . $backgroundImageSrc . "'); background-size: cover; background-position: center; position: relative;";
	if(!empty($backgroundImageMobileSrc)){
		if (filter_var($backgroundImageMobileSrc, FILTER_VALIDATE_URL)) { 
			$sectionStyleMobile .= "background-image: url('" . $backgroundImageMobileSrc . "') !important;";
		}else{
			$sectionStyleMobile .= "background-image: url('" . JURI::root() . $backgroundImageMobileSrc . "') !important;";
		}
	}
}elseif($testimonialsBackgroundType == "background-color"){
    // pega a cor definida no modulo ou a cor primaria do template
    $externalArea->external_area_background_color = !empty($externalArea->external_area_background_color) ? $externalArea->external_area_background_color : $tmplPrimaryColor;
    // configuracao para exibir cor de fundo
	$sectionStyle .= "background-color: {$externalArea->external_area_background_color};";
}

// Parametros para titulo da area externa
$showTitle = $moduleParams->testimonials_display_show_title;
$title = rtrim($moduleParams->testimonials_display_title);
$titleTagHtml	= $externalArea->title_tag_html;
$titleStyle = "";
$titleStyle .= NoBossUtilFonts::importNobossfontlist($externalArea->title_font);
$titleStyle .= " text-align: " . $externalArea->title_alignment . ";";
$titleStyle .= " text-transform: " . $externalArea->title_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$externalArea->title_color = !empty($externalArea->title_color) ? $externalArea->title_color : $tmplPrimaryColor;
$titleStyle .= " color: " . $externalArea->title_color . ";";
$titleStyle .= !empty($externalArea->title_space) ? ' padding-top: ' . $externalArea->title_space[0] . '; padding-bottom: ' . $externalArea->title_space[1] . '; ' : '';
$titleSize = $externalArea->title_size;
$titleSizeMobile = !empty($externalArea->title_size_mobile) ? $externalArea->title_size_mobile : '';
$titleStyleMobile = "";
if(!empty($titleSize)){
	$titleSizeEm = $titleSize/16;
	$titleStyle .= " font-size: {$titleSize}px; font-size: {$titleSizeEm}em;";
}
if(!empty($titleSizeMobile)){
	$titleSizeMobileEm = $titleSizeMobile/16;
	$titleStyleMobile .= " font-size: {$titleSizeMobile}px; font-size: {$titleSizeMobileEm}em !important;";
}

// Parametros para texto de apoio da area externa
$showSubtitle = $moduleParams->testimonials_display_show_subtitle;
$subtitle = rtrim($moduleParams->testimonials_display_subtitle);
$subtitleTagHtml = $externalArea->subtitle_tag_html;
$subtitleStyle = "";
$subtitleStyle .= NoBossUtilFonts::importNobossfontlist($externalArea->subtitle_font);
$subtitleStyle .= " text-align: " . $externalArea->subtitle_alignment . ";";
$subtitleStyle .= " text-transform: " . $externalArea->subtitle_transform . ";";
// pega a cor definida no modulo ou a cor primaria do template
$externalArea->subtitle_color = !empty($externalArea->subtitle_color) ? $externalArea->subtitle_color : $tmplPrimaryColor;
$subtitleStyle .= " color: " . $externalArea->subtitle_color . ";";
$subtitleStyle .= !empty($externalArea->subtitle_space) ? ' padding-top: ' . $externalArea->subtitle_space[0] . '; padding-bottom: ' . $externalArea->subtitle_space[1] . '; ' : '';
$subtitleSize = $externalArea->subtitle_size;
$subtitleSizeMobile = !empty($externalArea->subtitle_size_mobile) ? $externalArea->subtitle_size_mobile : '';
$subtitleStyleMobile = "";
if(!empty($subtitleSize)){
	$subtitleSizeEm = $subtitleSize/16;
	$subtitleStyle .= " font-size: {$subtitleSize}px; font-size: {$subtitleSizeEm}em;";
}
if(!empty($subtitleSizeMobile)){
	$subtitleSizeMobileEm = $subtitleSizeMobile/16;
	$subtitleStyleMobile .= " font-size: {$subtitleSizeMobile}px; font-size: {$subtitleSizeMobileEm}em !important;";
}

// Verifica se existe um depoimento.
if ($testimonials){
	// Define prefixo a ser utilizado na insercao de codigos inline para CSS e JS
	$prefixCodeJsAndCss = "[module-id={$module->name}_{$module->id}]";

	// Obtem informacoes de codigos JS e CSS a serem inseridos
	$loadJs	 		= $moduleParams->testimonials_display_load_js;
	$overwritingJs	= rtrim($moduleParams->testimonials_display_overwriting_js);
	$loadCss 		= $moduleParams->testimonials_display_load_css;
	$overwritingCss	= rtrim($moduleParams->testimonials_display_overwriting_css);
	// Instancia objeto passando o nome da extensao com prefixo (ex: 'mod_nobossbanners')
	$assetsObject = new NoBossUtilLoadExtensionAssets($extensionName, $prefixCodeJsAndCss);
	
	switch ($theme) {
		case 'model1':
			if(count($testimonials) > 1){
				// Adiciona arquivos e codigos JS (se definido para exibir)
				$assetsObject->loadJs($loadJs, array('code' => $overwritingJs));	
			}
			break;
		case 'model2':
			if($itemsCustomization->items_orientation != "vertical" && count($testimonials) > 3){
				// Adiciona arquivos e codigos JS (se definido para exibir)
				$assetsObject->loadJs($loadJs, array('code' => $overwritingJs));		
			}
			break;
		case 'model3':
			if(count($testimonials) > 3){
				// Adiciona arquivos e codigos JS (se definido para exibir)
				$assetsObject->loadJs($loadJs, array('code' => $overwritingJs));
			}
			break;
		default:
			// Adiciona arquivos e codigos JS (se definido para exibir)
			$assetsObject->loadJs($loadJs, array('code' => $overwritingJs));
			break;
	}

	// Adiciona arquivos e codigos CSS (se definido para carregar)
    $assetsObject->loadCss($loadCss, array('code' => $overwritingCss));	
    
    // adiciona css dos icones font-awesome
    $assetsObject->loadFamilyIcons('font-awesome');
    
    /* Desabilita o plugin que faz cloak nos emails da pagina, causando um problema de performance 
    como esta no formato de comentario html nao aparece na pagina :) */
    echo "<!--{emailcloak=off}-->";

	// Adiciona template default dos depoimentos.
	require JModuleHelper::getLayoutPath($extensionName, 'style/' . $theme);
	require JModuleHelper::getLayoutPath($extensionName, 'theme/'. $params->get('layout', $theme));
}
