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
 *  Classe View para listagem de registros que segue 'Metodo No Boss de desenvolvimento'
 *  @author  Johnny Salazar Reidel
 * 
 *  Orientacao: preencha as informacoes corretamente nas funcoes abaixo:
 *      - display(): defina os parametros sinalizados dentro da funcao
 *      - columnsDisplay(): defina as colunas que serao listadas
 *      - displayEmptyState(): defina o conteudo a ser exibido centralizado quando nenhum registro ainda foi cadastrado (Joomla 4)
 *      - specificTreatments(): local para adicionar codigos especificos desta view
 */

jimport('noboss.components.view.list');

class NobosstestimonialsViewTestimonials extends NobossComponentsViewList {
	/**
     * Metodo principal
     */
	public function display($tpl = null) {
        // Nome da view de edicao dos registros
        $this->createViewAlias = 'testimonial';
        
        // Alias do campo de id do componente
        $this->recordIdAlias = 'id';
        
        // Titulo da pagina
        $this->pageTitle = 'No Boss Testimonials: '.JText::_('COM_NOBOSSTESTIMONIALS_TESTIMONIALS');
        
        // Icone exibico junto ao titulo da pagina Z(sem informar prefixo 'icon-')
        $this->pageIcon = 'quote';
        
        // Texto a exibir como introducao em uma caixa de notice no topo da pagina
        $this->noticeIntro = JText::_('');
        
        parent::display($tpl);
	}

	/**
     * Funcao que define as colunas a serem exibidas na listagem
     */
    public function columnsDisplay(){
        // Inicio dos parametros que definem exibicao de colunas globais (deixe em branco os que nao desejar exibir ou nao existir)

        // Prefixo utilizado para as colunas na consulta sql que traz os items (no exemplo a seguir o valor seria 'faqs_group': SELECT * FROM noboss_faq as faqs_group)
        $this->prefixColumns = 'a';

        // Alias da coluna principal (exibe titulo, nome ou algo similar)
        $this->mainColumn = 'author_name';
        // Titulo da coluna princpal (informar apenas a constante)
        $this->mainColumnName = 'COM_NOBOSSTESTIMONIALS_TESTIMONIAL_AUTHOR_NOTE_LABEL';
        // Texto adicional pequeno (small) ao lado do conteudo da coluna principal
        $this->mainColumnSmall = '';
        // Largura da coluna principal
        $this->mainColumnWidth = '';

        // Alias da coluna de ordenacao
        $this->orderingColumn = 'ordering';

        // Alias da coluna de idioma
        $this->languageColumn = '';

        // Alias da coluna de status
        $this->statusColumn = 'state';

        // Alias das colunas de inicio e fim de publicacao
        $this->publishUpColumn = '';
        $this->publishDownColumn = '';


        // Inicio dos parametros para definir as colunas customizadas a exibir (cada coluna deve ser um objeto '$column' sendo adicionado no array $this->customColumns)

        // Array para armazenar como objeto cada coluna personalizada a ser exibida
        $this->customColumns = array();

        // Coluna para coluna de 'Modulo'
        $column = new stdClass();
        // Alias da coluna
        $column->alias = 'text_testimonial';
        // Titulo da coluna (informar apenas a constante)
        $column->title = 'COM_NOBOSSTESTIMONIALS_TEXT_TESTIMONIAL_LABEL';
        // Flag p/ determinar se coluna permitira ordenacao
        $column->allowOrdering = 1;
        // Html de retorno (pode colocar html setando '%VALUE%' para onde deve ser inserido o valor do item)
        $column->returnHtml = "%VALUE%";
        // Html de retorno quando valor nulo p/ o item corrente
        $column->returnHtmlWhenNull = JText::_('JNONE');
        // Largura da coluna (ex: '20%')
        $column->width = "35%";
        // Armazena valor no array
        $this->customColumns[] = $column;

        // Coluna para coluna de 'Categoria'
        $column = new stdClass();
        // Alias da coluna
        $column->alias = 'name_testimonials_group';
        // Titulo da coluna (informar apenas a constante)
        $column->title = 'COM_NOBOSSTESTIMONIALS_TESTIMONIALS_GROUP_LABEL';
        // Flag p/ determinar se coluna permitira ordenacao
        $column->allowOrdering = 1;
        // Html de retorno (pode colocar html setando '%VALUE%' para onde deve ser inserido o valor do item)
        $column->returnHtml = "%VALUE%";
        // Html de retorno quando valor nulo p/ o item corrente
        $column->returnHtmlWhenNull = JText::_('JNONE');
        // Largura da coluna (ex: '20%')
        $column->width = "20%";
        // Armazena valor no array
        $this->customColumns[] = $column;
    }

    /**
     * Funcao para exibir conteudo centralizadno quando nenhum registro ainda foi cadastrado (conhecido como 'empty state')
     *      - Essa funcao eh valida somente para o Joomla 4
     */
    public function displayEmptyState($emptyState = array()){
        // Defina a seguir os parametros para exibicao da mensagem
        
        // Habilitar / desabilitar exibicao da mensagem de empty state (true / false)
        $emptyState['isEmptyState'] = true;
        // Titulo
        $emptyState['title'] = JText::_('COM_NOBOSSTESTIMONIALS_TESTIMONIAL_EMPTY_STATE_TITLE');
        // Texto de apoio
        $emptyState['content'] = JText::_('COM_NOBOSSTESTIMONIALS_TESTIMONIAL_EMPTY_STATE_CONTENT');
        // Texto do botao de adicionar novo item
        $emptyState['btnadd'] = JText::_('COM_NOBOSSTESTIMONIALS_TESTIMONIAL_EMPTY_STATE_BTN_ADD');
        // Icone
        $emptyState['icon'] = 'icon-list-view';
        // Link do botao para pagina de documentacao 'leia mais' (deixe em branco para nao exibir o botao)
        $emptyState['helpURL'] = '';

        return parent::displayEmptyState($emptyState);
    }
    
    /**
     * Funcao para tratamentos especificos desta view
     */
    public function specificTreatments(){       
        // Nao existem grupos de modulos de faq publicados
		if(!$this->model->isGroupPublished()){
            // Seta mensagem para exibir no topo da pagina
            $this->noticeIntro = str_replace("#link#", JRoute::_('index.php?option=com_nobosstestimonials&view=groups'), JText::_('COM_NOBOSSTESTIMONIALS_ALERT_NO_GROUPS'));
        }
        // Existem depoimentos a serem moderados
        else if ($pendingTestimonials = $this->model->getPendingTestimonials()){
            // Importa arquivo de traducao da library
            JFactory::getLanguage()->load('lib_noboss', JPATH_SITE . '/libraries/noboss/');
            
            // Seta para exibir depoimentos a serem moderados no topo da pagina
            $this->noticeIntro = JText::_('COM_NOBOSSTESTIMONIALS_ALERT_PENDING_TESTIMONIALS');
            $this->noticeIntro .= '<ul>';

            // Percorre depoimentos a serem moderados para listar
            foreach($pendingTestimonials as $pendingTestimony) {
                $this->noticeIntro .= '<li>';
                $this->noticeIntro .= JText::_('COM_NOBOSSTESTIMONIALS_ITEM_PENDING_TESTIMONIALS');
                $this->noticeIntro = str_replace("#author_name#", $pendingTestimony->author_name, $this->noticeIntro);
                $this->noticeIntro = str_replace("#link#", JRoute::_('index.php?option=com_nobosstestimonials&task=testimonial.edit&id=' . $pendingTestimony->id), $this->noticeIntro);
                $this->noticeIntro = str_replace("#data#", date_format(date_create($pendingTestimony->created),JText::_('NOBOSS_EXTENSIONS_GLOBAL_DATE_FORMAT')), $this->noticeIntro);
                $this->noticeIntro .= '</li>';
            }
            $this->noticeIntro .= '</ul>';
        }        

        // Percorre todos os items para tratar valor a ser exibido na coluna de depoimentos
        foreach ($this->items as $item) {
            // Depoimento do tipo texto: limita quantidade de caracteres a exibir
            if($item->display_type == 'text'){
                $item->text_testimonial = JHtml::_('string.truncate', $item->text_testimonial, 100);
            }
            // Depoimento em video: exibe sinalizacao especifica para videos
            else{
                $item->text_testimonial = "<span class='icon-youtube fab fa-youtube' style='font-size: 16px; vertical-align: middle; margin-right: 10px; margin-top: -2px;'></span> ".JText::_("COM_NOBOSSTESTIMONIALS_TESTIMONIALS_VIDEO");
            }
        }
    }
}
