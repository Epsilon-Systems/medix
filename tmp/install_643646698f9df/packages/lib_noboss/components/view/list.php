<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

/**
 *  Classe a ser estendida em componentes para view de listagem de registros
 *  @author  Johnny Salazar Reidel
 * 
 *  Observacao: o funcionamento desta classe tem como requisito que o componente seja desenvolvido no modelo No Boss
 */

class NobossComponentsViewList extends JViewLegacy {

	public $items;
	public $pagination;
	public $state;
    public $filterForm;
    public $activeFilters;
    public $isEmptyState = false;

    /**
     * Funcao principal
     */
	public function display($tpl = null) {
		$app = JFactory::getApplication();
		$input = $app->input;
        
        require_once JPATH_LIBRARIES.'/noboss/util/installscript.php';

        // Pasta 'layouts/noboss' nao existe e nao foi possivel cria-la
        if(!NoBossUtilInstallscript::checkLibraryLayoutFolder()){
            return;
        }

		$this->items		      = $this->get('Items');
		$this->pagination	      = $this->get('Pagination');
		$this->state		      = $this->get('State');
        $this->filterForm         = $this->get('FilterForm');
        $this->activeFilters      = $this->get('ActiveFilters');
        
        // Verifica se existe algum erro.
		if (!empty($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors), 500);
		}

        // Model da view
        $this->model = $this->getModel();

        // Nome da view
        $this->viewName = $this->_name;

        // Alias do componente (ex: 'com_nobossfaq') que esta definido no arquivo principal do componente
        $this->componentAlias = JFactory::getApplication()->input->get('option');
        
        // Executa funcao para exibicao das colunas
        if(method_exists($this, 'columnsDisplay')){
            $this->columnsDisplay();
        }
        else{
            throw new Exception('The columnsDisplay function that defines the columns to list is not defined.', 500);
        }

        // Carrega barra de navegacao padrao
        $this->addToolbar();

        // Joomla 3: verifica se deve ser exibido submenus na lateral
        if(version_compare(JVERSION, '4', '<')){
            // Nome da classe helper principal do componente
            $helperClassName = JFactory::getApplication()->input->get('componentClassPrefix').'Helper';
            // Classe e metodo estao definidos
            if(class_exists($helperClassName) && method_exists($helperClassName, 'addSubmenu')){
                $helperClassName::addSubmenu($this->viewName, $this->componentAlias);
                // Submenus foram definidos na classe helper do componente
                if(!empty(JHtmlSidebar::getEntries())){
                    $this->sidebar = JHtmlSidebar::render();
                }
            }
        }

        // Executa funcao para tratamentos especificos desta view
        if(method_exists($this, 'specificTreatments')){
            $this->specificTreatments();
        }

        // Joomla 4
        if(version_compare(JVERSION, '4', '>=')){
            // Soh exibe listagem se nao estiver setado emptystate e que tenha dados a exibir
            if(!$this->displayEmptyState()){
                parent::display($tpl);
            }
        }
        // Joomla 3
        else{
            parent::display($tpl);
        }
	}

    /**
     * Metodo para exibir barra de navegacao padrao
     * 
     * OBS: para carregar uma barra personalizada no template, basta declarar esse mesma funcao dentro da view do componente e colocar o codigo personalizado
     */
    public function addToolbar(){
        jimport('noboss.components.view.toolbar');

        // Carrega barra de navegacao padrao
        NobossComponentsToolbar::addToolbarListView($this->pageTitle, $this->pageIcon, $this->componentAlias, $this->viewName, $this->createViewAlias, $this->get('State'), $this->isEmptyState);
    }

    /**
     * Metodo para exibir conteudo centralizadno quando nenhum registro ainda foi cadastrado (conhecido como 'empty state')
     *      - Essa funcao eh valida somente para o Joomla 4
     */
    public function displayEmptyState($emptyState = array()){
        if(empty($emptyState)){
            return false;
        }

        // Nao ha item cadastrados e IsEmptyState esta definido
        if (!\count($this->items) && $this->get('IsEmptyState') && $emptyState['isEmptyState']){
            $emptyState['formURL'] = "index.php?option={$this->componentAlias}&view={$this->viewName}";               
            if (JFactory::getApplication()->getIdentity()->authorise('core.create', $this->componentAlias)) {
                $emptyState['createURL'] = "index.php?option={$this->componentAlias}&task={$this->createViewAlias}.edit";
            }                
            echo JLayoutHelper::render('joomla.content.emptystate', $emptyState);
            return true;
        }

        return false;
    }
}
