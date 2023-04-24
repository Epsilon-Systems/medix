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
 *  Modelo default de view de edicao compativel com J3 e J4 que utiliza a library da No Boss
 *  @author  Johnny Salazar Reidel
 * 
 *  Orientacao: preencha as informacoes corretamente nas funcoes abaixo:
 *      - display(): defina os parametros sinalizados dentro da funcao
 *      - loadExtensionAssets: defina o carregamento de variaveis e arquivos JS e CSS
 *      - specificTreatments(): local para adicionar codigos especificos desta view
 */

jimport('noboss.components.view.edit');

class NobosstestimonialsViewTestimonial extends NobossComponentsViewEdit {

	public function display($tpl = null) {
        // Nome do fieldset principal
        $this->defaultFieldSetName = 'main_data';

        // Titulo da pagina
        $this->pageTitle = 'No Boss Testimonials: '.JText::_('COM_NOBOSSTESTIMONIALS_TESTIMONIALS');

        // Icone exibico junto ao titulo da pagina (sem informar prefixo 'icon-')
        $this->pageIcon = 'quote';

        // Nomes dos fieldsets que devem ser ignorados no foreach que percorre todos fieldsets para exibicao dos fields
        $this->fieldsetsIgnore = array('hidden', 'details', 'intro');

        parent::display($tpl);
    }

    /**
     * Funcao para carregamento de variaveis e arquivos JS e CSS
     */
    public function loadExtensionAssets(){
        /**
         * Ao carregar a funcao parent, sera adicionado na pagina o jquery, variaveis JS (baseNameUrl, majorVersionJoomla, completeVersionJoomla, ira carregar o arquivo JS da extensao (caso esteja definido um no caminho default. Ex: '/administrator/components/com_nobossfaq/assets/admin/js/com_nobossfaq.min.js') e ira carregar o arquivo CSS da extensao (caso esteja definido um no caminho default. Ex: '/administrator/components/com_nobossfaq/assets/admin/css/com_nobossfaq.min.css')
         */
        parent::loadExtensionAssets();
 
        jimport('noboss.util.loadextensionassets');
        
        // Instancia objeto para carregamento de CSS e JS da extensao
        $assetsObject = new NoBossUtilLoadExtensionAssets($this->componentAlias);

        // Obtem a versao da extensao
        $extensionsVersion = $assetsObject->getExtensionVersion($this->componentAlias);

        // Carrega arquivo JS extra da extensao
        $this->document->addScript(JURI::root()."administrator/components/{$this->componentAlias}/assets/admin/js/{$this->componentAlias}_item.min.js?v={$extensionsVersion}");   
    }

    /**
     * Funcao para tratamentos especificos desta view
     */
    public function specificTreatments(){
        // Edicao de registro
        if(!is_null($this->item->{$this->recordIdAlias})){
            // Existe foto cadastrada para depoimento: organiza os dados para carregar o campo
            if(!empty($this->item->content_image)){
                $stringImage = base64_encode($this->item->content_image);
                $imageMime = $this->item->mime_type;
                $this->item->content_image = $stringImage;
                $this->item->src_image="data:". $imageMime . ";base64,$stringImage";
            }
        }

        // Adiciona no description do campo de foto as extensoes que estao permitidas
        $descriptionPhoto = NobosstestimonialsHelper::getPhotoDescriptionHandle();
        $this->form->setFieldAttribute("photo", 'description', $descriptionPhoto);
    }
}
