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
 *  Classe com metodos para exibir barra de navegacao nos componentes
 *  @author  Johnny Salazar Reidel
 * 
 *  Observacao: essa classe pode ser utilizado em qualquer componente, sem necessidade de seguir o modelo No Boss
 */

class NobossComponentsToolbar{
    /**
	 * Metodo que adiciona botoes e titulo na view de edicao
	 *
     * @param   String      $viewTitle              Titulo da view
     * @param   String      $viewIcon               Icone para exibir junto com o titulo
	 * @param   String      $recordIdAlias          Alias do campo de id do componente
     * @param   String      $componentAlias         Alias do componente
     * @param   String      $viewAlias              Alias da view
     * @param   Object      $item                   Item com os dados
	 *
	 */
	public static function addToolbarEditView($viewTitle, $viewIcon, $recordIdAlias, $componentAlias, $viewAlias, $item) {
		// Desabilita menu principal.
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user       = JFactory::getUser();
		$userId     = $user->get('id');
		$isNew		= ($item->{$recordIdAlias} == 0);
		$checkedOut	= !($item->checked_out == 0 || $item->checked_out == $userId);

        // Obtem permissoes do componente
		$canDo = JHelperContent::getActions($componentAlias);
		
		// Titulo da pagina com icone
		JToolbarHelper::title($viewTitle, $viewIcon);

		// Novo registro e usuario tem permissao de criacao
		if ($isNew && $canDo->get('core.create')) {
			JToolbarHelper::apply($viewAlias.'.apply');

            // Joomla 3
            if (version_compare(JVERSION, "4", '<')) {
                JToolbarHelper::save($viewAlias.'.save');
			    JToolbarHelper::save2new($viewAlias.'.save2new');
            }
            // Joomla 4
            else {
                JToolbarHelper::saveGroup(
                    [
                        ['save', $viewAlias.'.save'],
                        ['save2new', $viewAlias.'.save2new']
                    ],
                    'btn-success'
                );
            }

            JToolbarHelper::cancel($viewAlias.'.cancel');
		}
        // Edicao de registro
		else {
            $toolbarButtonsJ4 = [];

			// Registro nao esta bloqueado e usuario tem permissao de edicao
			if ((!$checkedOut) && ($canDo->get('core.edit'))){
                JToolbarHelper::apply($viewAlias.'.apply');

                // Joomla 3
                if (version_compare(JVERSION, "4", '<')) {
                    JToolbarHelper::save($viewAlias.'.save');
                }
                // Joomla 4
                else {
                    $toolbarButtonsJ4[] = ['save', $viewAlias.'.save'];
                }
			}

			// Usuario possui permissao de criacao: adiciona botao de salvar novo
            if ($canDo->get('core.create')){
                // Joomla 3
                if (version_compare(JVERSION, "4", '<')) {
                    JToolbarHelper::save2new($viewAlias.'.save2new');
                    JToolbarHelper::save2copy($viewAlias.'.save2copy');
                }
                // Joomla 4
                else {
                    $toolbarButtonsJ4[] = ['save2new', $viewAlias.'.save2new'];
                    $toolbarButtonsJ4[] = ['save2copy', $viewAlias.'.save2copy'];
                }
            }

            // Joomla 4
            if(version_compare(JVERSION, '4', '>=')){
                JToolbarHelper::saveGroup(
                    $toolbarButtonsJ4,
                    'btn-success'
                );
            }

            // TODO: criar recurso generico ainda para botao de versionamento (qnd possuir)
            // if (JComponentHelper::isEnabled('com_contenthistory') && $state->params->get('save_history', 0) && $itemEditable){
			// 	JToolbarHelper::versions('com_tags.tag', $this->item->id);
			// }

			JToolbarHelper::cancel($viewAlias.'.cancel', 'JTOOLBAR_CLOSE');
		}

        JToolbarHelper::divider();
	}

    /**
	 * Metodo que adiciona botoes e titulo na view de listagem
	 *
     * @param   String      $viewTitle              Titulo da view
     * @param   String      $viewIcon               Icone para exibir junto com o titulo
     * @param   String      $componentAlias         Alias do componente
     * @param   String      $viewAlias              Alias da view
     * @param   String      $createViewAlias        Alias da view de criacao de novos registros
     * @param   Object      $state                  Objeto com informacoes de status da view
     * @param   Boolean     $isEmptyState           Informa se esta sendo exibida tmpl emptystate
	 *
	 */
	public static function addToolbarListView($viewTitle, $viewIcon, $componentAlias, $viewAlias, $createViewAlias, $state, $isEmptyState) {
		// Joomla 3
        if (version_compare(JVERSION, "4", '<')) {
            $user = JFactory::getUser();
        }
        // Joomla 4
        else{
            $user  = JFactory::getApplication()->getIdentity();
        }

        // Obtem permissoes do componente
		$canDo = JHelperContent::getActions($componentAlias);

        // Instancia objeto toolbar
        $toolbar = JToolbar::getInstance('toolbar');
		
		// Titulo da pagina com icone
		JToolbarHelper::title($viewTitle, $viewIcon);

		// Usuario tem permissao de criacao
		if ($canDo->get('core.create')) {
			JToolbarHelper::addNew($createViewAlias.'.add');
        }

        // Joomla 3
        if (version_compare(JVERSION, "4", '<')) {
            // Usuario tem permissao de edicao
            if ($canDo->get('core.edit')){
                JToolbarHelper::editList($createViewAlias.'.edit');
            }

            // Usuario tem permissao de editar status
            if ($canDo->get('core.edit.state')){
                JToolbarHelper::publish($viewAlias.'.publish', 'JTOOLBAR_PUBLISH', true);
                JToolbarHelper::unpublish($viewAlias.'.unpublish', 'JTOOLBAR_UNPUBLISH', true);
                JToolbarHelper::archiveList($viewAlias.'.archive');
            }

            // Usuario tem permissao admin: botao para desbloquear itens
            if ($canDo->get('core.admin')){
                JToolbarHelper::checkin($viewAlias.'.checkin');
            }

            // TODO: precisa ser visto mais alguma coisa para que funcione o botao de lote
            // // Usuario tem permissao de criacao, edicao e alteracao de status: botao de lote
            // if ($user->authorise('core.create', $componentAlias) && $user->authorise('core.edit', $componentAlias) && $user->authorise('core.edit.state', $componentAlias)){
            //     $title = JText::_('JTOOLBAR_BATCH');
            //     // Instantiate a new JLayoutFile instance and render the batch button
            //     $layout = new JLayoutFile('joomla.toolbar.batch');
            //     $dhtml = $layout->render(array('title' => $title));
            //     $toolbar->appendButton('Custom', $dhtml, 'batch');
            // }

            // Filtro de status esta com opcao lixeira selecionada e usuario tem permissao de remocao: botao de deletar
            if ((!empty($state)) && $state->get('filter.state') == -2 && $canDo->get('core.delete')){
                JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', $viewAlias.'.delete', 'JTOOLBAR_EMPTY_TRASH');
                
            }
            // Usuario tem permissao para editar status e filtro nao esta selecionado para lixeira: botao de lixeira
            elseif ($canDo->get('core.edit.state')){
                JToolbarHelper::trash($viewAlias.'.trash');
            }
        }
        // Joomla 4
        else{
            // Nao esta setado status vazio e usuario tem permissao de alterar status OU usuario tem permissao admin
            if (!$isEmptyState && ($canDo->get('core.edit.state') || $user->authorise('core.admin'))){
                // Cria botao 'actions' que ira agrupar os demais botoes de acao
                $dropdown = $toolbar->dropdownButton('status-group')
                    ->text('JTOOLBAR_CHANGE_STATUS')
                    ->toggleSplit(false)
                    ->icon('icon-ellipsis-h')
                    ->buttonClass('btn btn-action')
                    ->listCheck(true);

                $childBar = $dropdown->getChildToolbar();

                // Usuario tem permissao de alterar status
                if ($canDo->get('core.edit.state')){
                    $childBar->publish($viewAlias.'.publish')->listCheck(true);
                    $childBar->unpublish($viewAlias.'.unpublish')->listCheck(true);
                    $childBar->archive($viewAlias.'.archive')->listCheck(true);
                }

                // Usuario tem permissao de admin: botao para desbloquear itens
                if ($user->authorise('core.admin')){
                    $childBar->checkin($viewAlias.'.checkin')->listCheck(true);
                }

                // Usuario tem permissao para editar status e filtro nao esta selecionado para lixeira: botao de lixeira
                if ($canDo->get('core.edit.state') && $state->get('filter.state') != -2){
                    $childBar->trash($viewAlias.'.trash')->listCheck(true);
                }

                // TODO: precisa ser visto mais alguma coisa para que funcione o botao de lote
                // // Usuario tem permissao de criacao, edicao e alteracao de status: botao de lote
                // if ($canDo->get('core.create') && $canDo->get('core.edit') && $canDo->get('core.edit.state')){
                //     $childBar->popupButton('batch')
                //         ->text('JTOOLBAR_BATCH')
                //         ->selector('collapseModal')
                //         ->listCheck(true);
                // }
            }

            // Nao esta setado status vazio e filtro de status esta selecionado na lixeira e usuario tem permissao de remover: botao de deletar
            if (!$isEmptyState && $state->get('filter.state') == -2 && $canDo->get('core.delete')){
                $toolbar->delete($viewAlias.'.delete')
                    ->text('JTOOLBAR_EMPTY_TRASH')
                    ->message('JGLOBAL_CONFIRM_DELETE')
                    ->listCheck(true);
            }
        }

        // Usuario tem permissao de admin ou de edicao das opcoes globais
        if ($canDo->get('core.admin') || $canDo->get('core.options')){
			JToolbarHelper::preferences($componentAlias);
		}
	}
}
