<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

// Adicionado para Joomla 4
use Joomla\CMS\Factory;
use Joomla\CMS\Form\FormField;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\LanguageHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\Database\ParameterType;
// Modal de artigos do Joomla p/ J4
use Joomla\Component\Content\Administrator\Field\Modal\ArticleField;

// Joomla 3
if(version_compare(JVERSION, '4', '<')){
    // Carrega arquivo do field original do Joomla que eh estendido
    require_once JPATH_ADMINISTRATOR.'/components/com_content/models/fields/modal/article.php';

    class JFormFieldNobossmodalarticles extends JFormFieldModal_Article {
        protected $type = "nobossmodalarticles";

    }
}
// Joomla 4
else{
    class JFormFieldNobossmodalarticles extends ArticleField {
        protected $type = "nobossmodalarticles";

        protected function getInput() {

            $modalId = 'Article_' . $this->id;
            $modalName = 'ModalEdit' . $modalId;

            // Evento para quando usuario clicar no botao 'editar' para que mude a url do iframe da modal
            // TODO: pelo menos ateh marco de 2021 o Joomla estava com problema no field para editar um artigo selecionado (quebrava a url do iframe e nao abria o artigo para edicao). Por isso fizemos o codigo abaixo para corrigir a url do iframe
            JFactory::getDocument()->addScriptDeclaration('
                jQuery(function($) {
                    jQuery(document).on("click", "#' . $this->id . '_edit", function(e) {
                        var articleID = jQuery("#'.$this->id.'_id").val();
                        var url = "' . JURI::base() . 'index.php?option=com_content&view=article&layout=modal&tmpl=component&'.Session::getFormToken().'=1&task=article.edit&id=" + articleID;
                        jQuery("#' . $modalName . ' iframe").attr("src", url);
                    });
                });

            ');

            return parent::getInput();
        }
    } 
}
