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
 *  Classe Model para edicao de registros que segue 'Metodo No Boss de desenvolvimento'
 *  @author  Johnny Salazar Reidel
 * 
 *  Orientacoes: 
 *    - Estamos utilizando NobossComponentsModelEdit da library da No Boss como Trait.
 *      * Traits servem apenas para reuso de codigo, mas nao para heranca. Ou seja, nao eh possivel estender funcoes definidas em NobossComponentsModelEdit.
 *      * Se houver necessidade de estender alguma funcao de NobossComponentsModelEdit, copie a funcao original para ca e edite conforme necessario. Neste caso, a funcao executada sera a desta classe e nao mais a definida no trait NobossComponentsModelEdit
 *      
 *    - Altere o nome desta classe
 *    - Defina os parametros sinalizados no metodo __construct()
 *    - Prepare os dados a serem salvos no banco usando os meotodos 'save()' e 'prepareTable()'
 *        * Voce pode usar os dois metodos para tratamento de dados antes de serem salvos no banco
 *        * Por padrao, apos a execucao destes dois metodos, o Joomla executa a funcao 'store()' definida na classe Table
 *        * Em resumo, a ordem de exeucacao das funcoes para salvar eh: 1 - save() | 2 - prepareTable() | 3 - store()
 *    - No metodo 'getItem()' sao obtidos os dados do banco
 *        * Esse metodo obtem os dados a serem carregados utilizando a classe Table
 *        * Voce pode aproveitar neste metodo para tratar algum dado vindo do banco antes de ser carregado no formulario
 *    - No metodo 'validate' voce pode validar dados do formulario antes de salvar (funciona apenas a partir do Joomla 3.9.25)
 *    - No metodo 'publish' voce podera executar alguma acao adicional quando usuario solicitar alteracao de status de um ou mais registros na view de listagem
 *    - Voce tambem pode criar outras funcoes conforme a complexidade do seu componente
 */

jimport('noboss.components.model.edit');

class NobosstestimonialsModelGroup extends JModelAdmin {
    use NobossComponentsModelEdit;

    /**
	 * Construtor
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 */
	public function __construct($config = array()){
        $input = JFactory::getApplication()->input;

        // Nome dos fields de titulo e alias que sao exibidos no topo da pagina (qnd nao existir, deixar valor em branco)
        $this->fieldName = 'name_testimonials_group';
        $this->fieldAlias = '';

        // Alias do campo de id do componente
        $this->recordIdAlias = 'id_testimonials_group';

        // Alias do campo de ordenacao (deixar em branco se nao existir)
        $this->fieldOrdering = 'ordering';

        // Nome da tabela do banco
        $this->nameTable = '#__noboss_testimonial_group';

        // Sufixo do nome da classe da Table de edicao dos registros. Ex: se a chasse se chamar 'NobossfaqTableFaqgroup' o valor sera 'Faqgroup' que eh o final do nome da classe
        $this->tableClassNameSuffix = 'Testimonialgroup';

        // Seta no input alguns dos dados declarados para poder usar na view
        $input->set('fieldName', $this->fieldName);
        $input->set('fieldAlias', $this->fieldAlias);
        $input->set('recordIdAlias', $this->recordIdAlias);
        
        parent::__construct($config);
    }

    /**
     * Funcao que salva um registro instanciando a classe Table
     *
     * @param array     $data   Dados a serem salvos
     * 
     * @return boolean  true ou false
     */
    public function save($data){
        jimport('noboss.forms.fields.nobossmodulesposition.helper');

        $input = JFactory::getApplication()->input;

        // Usuario solicitou clone de outro registro
		if ($input->get('task') == 'save2copy')	{
			// Executa metodo para incrementar um numero no final do nome e alias
            $data = $this->incrementNameAndAlias($data, $this->fieldName, $this->fieldAlias);

            // Deixa registro despublicado
            $data['state'] = 0;

			// Zera o ID dos modulos vinculados (nao pode referenciar o mesmo)
			$data["id_module_testimonials_submission"] = '';
			$data["id_module_testimonials_display"] = '';
		}

		// Variavel que armazena os campos disponiveis nos depoimentos do grupo
		$data["fields_display"] = array();

		// Variavel que armazena configuracaes do modulo de exibicao dos depoimentos
		$data["config_module_testimonials_display"] = array();

		// Variavel que armazena configuracoes do modulo de submissao de depoimentos.
		$data["sections_public_form_submission"] = array();

		// Variavel que armazena configuracoes de e-mail de moderacao de depoimentos.
		$data["config_moderate_testimonials"] = array();

		// Percorre todos os campos do form para tratar os que sao do modulo
		foreach ($data as $keyField => $valueField) {
            // Campo inicia com name "display_field_": reorganiza o campo no array $data
			if(strpos($keyField, "display_field_") === 0){
				$data["fields_display"]["$keyField"] = $valueField;
				unset($data[$keyField]);
			}

			// Verifica se campo possui a string "testimonials_display_" no inicio da sua chave.
			if(strpos($keyField, "testimonials_display_") === 0){
				// Adiciona ao array config_module_testimonials_display o valor do campo.
				$data["config_module_testimonials_display"]["$keyField"] = $valueField;

				// Remove elemento da posicao original no array $data.
				unset($data[$keyField]);
			}

			// Verifica se campo possui a string "testimonials_submission_"no inicio da sua chave.
			if(strpos($keyField, "testimonials_submission_") === 0){
				// Adiciona ao array sections_public_form_submission o valor do campo.
				$data["config_module_testimonials_submission"]["$keyField"] = $valueField;
				// Remove elemento da posicao original no array $data.
				unset($data[$keyField]);
			}

			// Verifica se campo possui a string "moderate_testimonials_" no inicio da sua chave.
			if(strpos($keyField, "moderate_testimonials_") === 0){
				// Adiciona ao array config_moderate_testimonials o valor do campo.
				$data["config_moderate_testimonials"]["$keyField"] = $valueField;
				// Remove elemento da posicao original no array $data.
				unset($data[$keyField]);
			}
		}

		// Realiza encode dos dados de "exibicao dos campos" para JSON.
		$data["fields_display"] = json_encode($data["fields_display"]);

		// Realiza encode dos dados de "configuracao do modulo de exibicao de depoimenteos" para JSON.
		$data["config_module_testimonials_display"] = json_encode($data["config_module_testimonials_display"]);

		// Realiza encode dos dados de "configuracao do modulo de submissao de depoimenteos" para JSON.
		$data["config_module_testimonials_submission"] = json_encode($data["config_module_testimonials_submission"]);

		// Realiza encode dos dados de "email de moderacao de depoimentos" para JSON.
		$data["config_moderate_testimonials"] = json_encode($data["config_moderate_testimonials"]);

        // Titulo do modulo
        $titleModule = '[No Boss Testimonials] '.$data[$this->fieldName];

        // Define os campos que serao salvos no modulo para columa params
        $moduleDisplayConfig = json_decode($data['config_module_testimonials_display']);
        $moduleSubmissionConfig = json_decode($data['config_module_testimonials_submission']);
        $generalDisplayConfig = json_decode($data['fields_display']);
        $theme = json_decode($moduleDisplayConfig->testimonials_display_theme)->theme;
        $exampleModals = array("testimonials_display_external_area_{$theme}", "testimonials_display_items_customization_{$theme}", "testimonials_submission_form");
        $exampleDataTabs = array($moduleDisplayConfig, $moduleSubmissionConfig, $generalDisplayConfig);
        $ignoreFields = array('testimonials_display_theme');

        // Inicia transacao do banco de dados
        $this->_db->transactionStart();

        // Salva dados do modulo de submissao de depoimentos.
        $idModuleSubmission = NobossModulePositionHelper::saveModule(
            "mod_nobosstestimonialsubmission",
            $data["id_module_testimonials_submission"],
            $titleModule,
            $data["position_module_testimonials_submission"],
            $data["assignment_module_testimonials_submission"],
            $data["assigned_module_testimonials_submission"],
            ($data["state"] != 1) ? $data["state"] : $moduleSubmissionConfig->testimonials_submission_show_form,
            $data["language"],
            $exampleModals,
            $exampleDataTabs, 
            $ignoreFields
        );

        // Salva dados do modulo de exibicao de depoimentos.
        $idModuleTestimonialsDisplay = NobossModulePositionHelper::saveModule(
            "mod_nobosstestimonials",
            $data["id_module_testimonials_display"],
            $titleModule,
            $data["position_module_testimonials_display"],
            $data["assignment_module_testimonials_display"],
            $data["assigned_module_testimonials_display"],
            ($data["state"] != 1) ? $data["state"] : $moduleDisplayConfig->testimonials_display_show_testimonial,
            $data["language"],
            $exampleModals,
            $exampleDataTabs, 
            $ignoreFields
        );

        // Ocorreu erro ao salvar modulos
        if(!$idModuleSubmission || !$idModuleTestimonialsDisplay){
            // Desfaz transacao do banco de dados
            $this->_db->transactionRollback();
            return false;
        }

        // Armazena os ids dos modulos
        $data["id_module_testimonials_submission"] = $idModuleSubmission;
        $data["id_module_testimonials_display"] = $idModuleTestimonialsDisplay;

        // Salva dados do registro
        $isSaved = parent::save($data);

        // Ocorreu erro ao salvar registro
        if(!$isSaved){
            // Desfaz transacao do banco de dados
            $this->_db->transactionRollback();
            return false;
        }

        // Deu tudo certo: commita transacao do banco e retorna true
        $this->_db->transactionCommit();
        return true;
	}

    /**
	 * Prepare e higieniza os dados antes de salvar usando a table
	 *
	 * @param   JTable  $table  Objeto com os dados que serao salvos
	 *
	 * @return  void
	 */
	protected function prepareTable($table) {
        // Limpa caracteres invalidos do titulo e gera alias no formato correto
        $table = $this->treatmentNameAndAlias($table, $this->fieldName, $this->fieldAlias);

        // Seta valor para o campo de ordenacao (qnd existir e ja nao tiver valor definido)
        $table = $this->setOrdering($table, $this->fieldOrdering, $this->nameTable);

        // Seta valores para os campos 'created', 'created_by', 'modified' e 'modified_by' (quando existirem)
        $table = $this->setCreatedModified($table, $this->recordIdAlias);
	}

    /**
     * Metodo para obter os dados de um registro
     *
     * @param   integer     Id do registro
     * @return  mixed  Objeto caso sucesso, ou false caso falhe.
     */
    public function getItem($pk = null) {
        jimport('noboss.forms.fields.nobossmodulesposition.helper');

        $item = parent::getItem($pk);

        // Eh edicao de registro
        if(!empty($item->{$this->recordIdAlias})){
            // Carrega dados do modulo de submissao de depoimentos.
			$dataModuleTestimonialsSubmission = NobossModulePositionHelper::getDataModule($item->id_module_testimonials_submission);
			$item->client_id_module_testimonials_submission = $dataModuleTestimonialsSubmission['client_id'];
			$item->published_module_testimonials_submission = $dataModuleTestimonialsSubmission['published'];
			$item->position_module_testimonials_submission = $dataModuleTestimonialsSubmission['position'];
			$item->assignment_module_testimonials_submission = $dataModuleTestimonialsSubmission['assignment'];
			$item->assigned_module_testimonials_submission = $dataModuleTestimonialsSubmission['assigned'];

			// Carrega dados do modulo de exibicao de depoimentos.
			$dataModuleTestimonialsDisplay = NobossModulePositionHelper::getDataModule($item->id_module_testimonials_display);
			$item->client_id_module_testimonials_display = $dataModuleTestimonialsDisplay['client_id'];
			$item->published_module_testimonials_display = $dataModuleTestimonialsDisplay['published'];
			$item->position_module_testimonials_display = $dataModuleTestimonialsDisplay['position'];
			$item->assignment_module_testimonials_display = $dataModuleTestimonialsDisplay['assignment'];
			$item->assigned_module_testimonials_display = $dataModuleTestimonialsDisplay['assigned'];

			// Realiza decode das opcoes de visualizacao dos campos.
			$fieldsDisplay = json_decode($item->fields_display, true);

			// Realiza decode dos dados de configuracao do modulo de exibicao de depoimentos.
			$configModuleTestimonialsDisplay = json_decode($item->config_module_testimonials_display, true);
			// Realiza decode dos dados de configuracao do modulo de submissao de depoimentos.
			$configModuleTestimonialsSubmission = json_decode($item->config_module_testimonials_submission, true);
			// Realiza decode dos dados de e-mail de moderacao de depoimentos.
			$configModerateTestimonials = json_decode($item->config_moderate_testimonials, true);

			// Junta array de dados decodificados para percorre-las com apenas um foreach.
			$allDecodedData = array_merge($fieldsDisplay, $configModuleTestimonialsDisplay,  $configModuleTestimonialsSubmission, $configModerateTestimonials);

            // Percorre opcoes de visualizacoo.
            foreach ($allDecodedData as $configName => $configValue) {
                // Insere opcao de visualizacao como propriedade no item.
                $item->$configName = $configValue;
            }
        }
    

        return $item;
    }

        /**
	 * Metodo para validar os dados do formulário 
     * 
     * Funciona apenas para versoes do Joomla a partir de 3.9.25
	 *
	 * @param   JForm   $form   The form to validate against.
	 * @param   array   $data   The data to validate.
	 * @param   string  $group  The name of the field group to validate.
	 *
	 * @return  array|boolean  Array of filtered data if valid, false otherwise.
	 */
	public function validate($form, $data, $group = null) {
		// Exemplo que impede alteracao do 'created_by' (usuario que criou o registro) qnd usuario nao tiver permissoes de acessar o componente com_users
		// if (!JFactory::getUser()->authorise('core.manage', 'com_users')){
		// 	if (isset($data['created_by'])) {
		// 		unset($data['created_by']);
		// 	}
		// }

		return parent::validate($form, $data, $group);
	}

    /**
     * Metodo que altera status do registro
     * 
     * OBS: apesar de estar no model de edicao de registros, essa funcao eh executada na alteracao de status da view de listagem
     *
     * @param   array   &$pks     Ids dos registros a mudar o status
     * @param   int     $value    Id do status
     * 
     * @return  boolean  true ou false
     */
    public function publish(&$pks, $value = 1) {
        jimport('noboss.forms.fields.nobossmodulesposition.helper');

        $table = $this->getTable();

        // Percorre os itens que tiveram alteracao de status para modificar tb o status do modulo vinculado
        foreach ($pks as $pk) {
            $table->load($pk, true);
            $item = parent::getItem($pk);
            // pega o id do modulo de exibicao
            $displayModuleId = $item->id_module_testimonials_display;
            // pega o id do modulo de submissao
            $submissionModuleId = $item->id_module_testimonials_submission;
            // altera o estado dos modulos
            NobossModulePositionHelper::publishModule($displayModuleId, $value);
            NobossModulePositionHelper::publishModule($submissionModuleId, $value);
        }

        return parent::publish($pks, $value);
    }

    /**
     * Metodo para remover um ou mais grupos, removendo junto os modulos gerados
     *
     * @param   int     &$pks   Ids dos registros a remover
     * 
     * @return boolean  true ou false
     */
    public function delete(&$pks) {
        jimport('noboss.forms.fields.nobossmodulesposition.helper');

        $table = $this->getTable();

        // Percorre cada registro solicitado a ser removido
        foreach ((array) $pks as $pk) {
            // Carrega dados do registro para pegar id do modulo
            if ($table->load($pk)){
                // Deleta modulos associados ao grupo de depoimentos.
                NobossModulePositionHelper::deleteModuleGroup($table->id_module_testimonials_submission);
                NobossModulePositionHelper::deleteModuleGroup($table->id_module_testimonials_display);

                // Remove o grupo de todos os depoimentos associados a ele.
                self::clearRegistersIdGroup($table->id_testimonials_group);
            }
        }

        // Remove registro chamando funcao parent
        return parent::delete($pks);
    }


    /**
     * Metodo que limpa todos os registros nas FAQs que possuam o id do grupo.
     *
     * @param int $idGroup Id do grupo.
     * @return boolean Retorna true se sucesso ou false caso falha.
     */
    public function clearRegistersIdGroup($idGroup) {
        $db = $this->_db;
        // Pega uma nova query.
        $query = $db->getQuery(true);

        // Apaga todos os id do grupos nas FAQs.
        $query
  			->update("#__noboss_testimonial")
  	   		->set( "id_testimonials_group = NULL")
   			->where("id_testimonials_group = " . (int) $idGroup);
   		$db->setQuery($query);

        return $db->execute();
    }

    /**
	 * Metodo que pega todas as configuracoes de um grupo de depoimentos.
	 *
	 * @param 	int 	$idTestimonialsGroup Id do grupo de depoimentos.
	 * @return 	array 	Retorna lista com todos os parametros do grupo de depoimentos.
	 */
	public function getParamsTestimonialsGroup($idTestimonialsGroup) {
		$db =  $this->_db;
		$query = $db->getQuery(true);

		$query
   			->select(
				"testimonials_group.id_testimonials_group,
				testimonials_group.id_module_testimonials_submission,
				testimonials_group.id_module_testimonials_display,
				testimonials_group.config_module_testimonials_display,
				testimonials_group.config_module_testimonials_submission,
				testimonials_group.config_moderate_testimonials,
				testimonials_group.language,
				testimonials_group.fields_display"
   			)
   			->from($db->quoteName("#__noboss_testimonial_group", "testimonials_group"))
    		->where("testimonials_group.id_testimonials_group = " . (int) $idTestimonialsGroup);

		$db->setQuery($query);

		return $db->loadObject();
    }
}
