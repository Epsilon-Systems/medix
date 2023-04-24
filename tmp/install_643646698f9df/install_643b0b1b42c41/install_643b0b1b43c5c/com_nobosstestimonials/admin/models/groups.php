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
 *  Modelo default de model de listagem compativel com J3 e J4
 *  @author  Johnny Salazar Reidel
 * 
 * - Estamos utilizando NobossComponentsModelList da library da No Boss como Trait.
 *      * Traits servem apenas para reuso de codigo, mas nao para heranca. Ou seja, nao eh possivel estender funcoes definidas em NobossComponentsModelList.
 *      * Se houver necessidade de estender alguma funcao de NobossComponentsModelList, copie a funcao original para ca e edite conforme necessario. Neste caso, a funcao executada sera a desta classe e nao mais a definida no trait NobossComponentsModelList
 * 
 *  Orientacao para edicoes minimas necessarias: 
 *      - Edite o nome da classe
 *      - Edite as colunas para ordenacao no metodo '__construct' e informe a ordenacao default da listagem
 *      - Edite a consulta SQL que lista os registros no metodo 'getListQuery'
 */

jimport('noboss.components.model.list');

class NobosstestimonialsModelGroups extends JModelList {
    use NobossComponentsModelList;

	/**
	 * Construtor
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
     * 
	 */
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
            /**
             * Declare cada coluna do banco que permitira ordenacao na listagem
             * Para cada coluna voce ira declarar:
             *     - Na primeira posicao do array apenas o alias da coluna
             *     - Na segunda posicao do array o prefixo da tabela declarado na consulta SQL + '.' + o alias da coluna
             *     - OBS: se for uma coluna renomeada com alias, informe o alias declarado em apenas uma posicao do array
             */
			$config['filter_fields'] = array(
				'id_testimonials_group', 'testimonial_group.id_testimonials_group',
				'name_testimonials_group', 'testimonial_group.name_testimonials_group',
				'language', 'testimonial_group.language',
				'ordering', 'testimonial_group.ordering',
				'state', 'testimonial_group.state'
			);
		}

        // Defina a coluna padrao para ordenacao dos registros (informe o prefixo da tabela declarado na consulta SQL + '.' + o alias da coluna)
        $this->orderingDefault = 'testimonial_group.name_testimonials_group';
    
        // Defina a direcao da ordenacao informando 'asc' ou 'desc'
        $this->directionDefault = 'asc'; 

		parent::__construct($config);
	}

	/**
	 * Metodo para montar a consulta SQL que busca os dados que devem ser listados
	 *
	 * @return  JDatabaseQuery
	 */
	protected function getListQuery() {
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Define os campos de retorno da tabela.
		$query->select(
			$this->getState(
				'list.select',
				"testimonial_group.id_testimonials_group,
				 testimonial_group.name_testimonials_group,
				 testimonial_group.id_module_testimonials_submission,
				 testimonial_group.id_module_testimonials_display,
				 testimonial_group.language,
				 testimonial_group.created_by,
				 testimonial_group.created,
				 testimonial_group.modified_by,
				 testimonial_group.modified,
				 testimonial_group.ordering,
				 testimonial_group.checked_out,
				 testimonial_group.checked_out_time,
				 testimonial_group.state"
			)
		);

		$query->from($db->quoteName('#__noboss_testimonial_group', 'testimonial_group'));

		// Obtem opcao selecionada no filtro de status (caso definido)
		$state = $this->getState('filter.state');

        // Usuario filtrou por um status na listagem
		if (is_numeric($state)) {
			$query->where('testimonial_group.state = '.(int) $state);
		}
        // Nao tem filtro de status definido: traz todos status, menos status de lixeira
        else {
			$query->where('(testimonial_group.state IN (-1,0,1,2))');
		}

		// Obtem opcao selecionada no filtro de idioma (caso definido)
		$language = $this->getState('filter.language');
		if (!empty($language)) {
			$query->where('language = ' . $db->quote($language));
		}
        
        // Realiza join com tabela de idiomas
		$query
        ->select($db->quoteName('language.title', 'language_title'))
        ->select($db->quoteName('language.image', 'language_image'))
        ->join('LEFT', $db->quoteName('#__languages', 'language') . ' ON ' . $db->quoteName('language.lang_code') . ' = ' . $db->quoteName('testimonial_group.language'));

		// Obtem texto pesquisado (caso definido)
		$search = $this->getState('filter.search');
		if (!empty($search)) {
            // Realiza a pesquisa do texto em colunas especificas do banco
            $search = $db->Quote('%'.$db->escape($search, true).'%');
            $query->where("UPPER(testimonial_group.name_testimonials_group) LIKE " . $search);
		}

        // Seta ordenacao conforme solicitado pelo usuario na listagem
		$orderCol  = $this->state->get('list.ordering', 'ordering');
		$orderDirn = $this->state->get('list.direction', 'ASC');
		$query->order($db->escape($orderCol.' '.$orderDirn));

		return $query;
	}

}
