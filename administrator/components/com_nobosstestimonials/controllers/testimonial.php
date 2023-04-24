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
 *  Classe Controller para edicao de registros que segue 'Metodo No Boss de desenvolvimento'
 *  @author  Johnny Salazar Reidel
 * 
 *  Orientacao: 
 *      - Edite o nome da classe
 *      - Nesta classe voce pode adicionar metodos especificos de controle, incluindo metodos para requisicoes ajax
 *      - Tambem eh possivel sobreescrever metodos da classe estendida
 */

 // Carrega arquivo helper principal
JLoader::register($input->get('componentClassPrefix').'Helper', JPATH_ADMINISTRATOR . '/components/' . $input->get('option') . '/helpers/'.strtolower($input->get('componentClassPrefix')).'.php');

class NobosstestimonialsControllerTestimonial extends JControllerForm {

	/**
	 * Funcaoo ajax para buscar campos permitidos para exibicao nos depoimentos conforme
	 * categoria.
	 *
	 * @return array Retorna lista de permissões de exibicaoo de campos.
	 */
	public function getDisplayFieldsByTestimonialsGroupAjax() {
		// Pega o id do grupo de depoimento recebido via requisicaoo.
		$idTestimonialsGroup = $this->input->getInt("idTestimonialsGroup");

		// Pega as configurações para cada campo.
		$listDisplayFields = self::getDisplayFieldsByTestimonialsGroup($idTestimonialsGroup);

		// Realiza encode da informacaoo e devolve informacaoo para requisicaoo.
		exit(json_encode($listDisplayFields));
	}


	/**
	 * Funcaoo que pega as configurações de exibições de campos conforme o grupo do depoimento.
	 *
	 * @param int $idTestimonialsGroup Id do grupo de depoimentos.
	 * @return array Retorna lista com as permissões de exibicaoo dos campos.
	 */
	public function getDisplayFieldsByTestimonialsGroup($idTestimonialsGroup) {
		// Pega parâmetros do grupo de depoimentos.
		$paramsTestimonialsGroup = NobosstestimonialsHelper::getParamsTestimonialsGroup($idTestimonialsGroup);

		// Pega parâmetro de exibicaoo de campos.
		$fieldsDisplay = $paramsTestimonialsGroup->fields_display;

		// Realiza decode dos dados.
		$fieldsDisplay = json_decode($fieldsDisplay);

		// Pega lista de permissões de exibições dos campos.
		return NobosstestimonialsHelper::getPermissionsFieldsDisplay($fieldsDisplay);
	}

	/**
	 * Funcaoo ajax para buscar campo de limite de caracteres do grupo selecionado
	 *
	 * @return int Retorna limite de caracteres
	 */
	public function getGroupCharacterLimitAjax() {
		$input = JFactory::getApplication()->input;   

		// Pega o id do grupo de depoimento recebido via requisicaoo.
		$groupId = $input->get("groupId");
		$model = $this->getModel("Group", "NobosstestimonialsModel");
		$group = $model->getItem($groupId);
		$charactersLimit = $group->display_field_number_characters_testimonial;

		// Realiza encode da informacaoo e devolve informacaoo para requisicaoo.
		exit(json_encode(intval($charactersLimit)));
	}
}
