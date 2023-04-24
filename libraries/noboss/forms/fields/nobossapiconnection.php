  <?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

class JFormFieldNobossapiconnection extends JFormField
{

    protected $type = "nobossapiconnection";

    protected function getLabel(){
        return '';
    }
    
  	protected function getInput(){
        // Inicia quebrando a div para nao ter o espaco do label na tela
        $html = "</div><div style='margin-top: 0px;'>";
        
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();
		$post = $app->input->post;

        //Verifica se já tem uma basenameUrl
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], "baseNameUrl =")) {
            //Adiciona basenameurl
            $doc->addScriptDeclaration('var baseNameUrl =  "'.JUri::root().'";');
        }

        // Obtem informacao se modal deve ser bloqueada por causa da licenca (se definido, bloqueamos o campo)
        $blockModal = $post->get('blockModal', 0, 'INT');

        $doc->addScript(JURI::root()."libraries/noboss/forms/fields/assets/js/min/nobossapiconnection.min.js");
		$doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobossapiconnection.min.css");

        $decodedValue = json_decode($this->value);

        if(empty($decodedValue->client_id)){
            $decodedValue = new stdClass();
            $decodedValue->client_id = '';
            $decodedValue->client_secret = '';
        }

        // Obtem o alias da api que deseja requisicao
        $api = $this->element->attributes()->api;

        // Url de geracao de token e redirecionamento da api
        $urlReturn = JURI::root()."administrator/index.php?option=com_nobossajax&library=noboss.forms.fields.nobossapiconnection.nobossapiconnectionhelper&method=generateToken&api={$api}&format=raw";

        // Url da pagina de documentacao sobre criacao das credenciais
        $urlDoc = "https://docs.nobosstechnology.com/api/external-credentials/#{$api}";

        $html .='<div class="control-group '.$this->class.'" style="display: inherit;">
                    '.JText::sprintf("LIB_NOBOSS_API_CONNECTION_INTRO_DOC", $urlDoc).'<br />
                    '.JText::sprintf("LIB_NOBOSS_API_CONNECTION_INTRO_URL_REDIRECT", $urlDoc).'<br />
                    <span class="apiconnection__doc-url">'.$urlReturn.'</span>
                </div>';
                
        // Declara div mais externa colocando como attr o alias da api requisitada e a url de redirecionamento
        $html .= '<div class="nobossapiconnection form-grid" data-api="'.$api.'" data-api-redirect="'.$urlReturn.'">';

        $classJ4 = '';

        // Joomla 4
        if(version_compare(JVERSION, '4', '>=')){
            $classJ4 = 'stack span-3';
        }

        // Cliente ID
        $html .= "<div class='control-group {$classJ4}'>
                    <div class='control-label'>
                        <label>".JText::_('LIB_NOBOSS_API_CONNECTION_CLIENT_ID_LABEL')."</label>
                    </div>
                    <div class='controls'>
                        <input type='text' class='form-control' value='{$decodedValue->client_id}' data-id='client_id' ".(($blockModal) ? 'disabled' : '')." />
                    </div>
                </div>";

        // Secret
        $html .= "<div class='control-group {$classJ4}'>
                    <div class='control-label'>
                        <label>".JText::_('LIB_NOBOSS_API_CONNECTION_CLIENT_SECRECT_LABEL')."</label>
                    </div>
                    <div class='controls'>
                        <input type='text' class='form-control' value='{$decodedValue->client_secret}' data-id='client_secret' ".(($blockModal) ? 'disabled' : '')." />
                    </div>
                </div>";

        if(!$blockModal){
            // Armazena os dados da conexao (chave, secret, tokens)
            $html .= "<input type='hidden' name='{$this->name}' data-id='apiconnection_hidden' value='{$this->value}' />";
        }

        // Exibe informacao sobre o status (conteudo atualizado via JS)
        $html .= ' <div data-api-status="" class="apiconnection__status">
                   '.JText::_('NOBOSS_EXTENSIONS_PUBLICATION_STATUS').': <span data-api-status-text></span>
                </div>';

        // Botao para conectar com api
        $html .= "<a class='btn btn-nb apiconnection__btn-connect' ".((!$blockModal) ? "data-id='api-btn-connect'" : "")." ".(($blockModal) ? 'disabled' : '').">
                    <span>".JText::_('LIB_NOBOSS_API_CONNECTION_BTN_CONNECT')."</span>
                </a>";
                
        $html .= '</div>';

        // Obtem a tag do idioma que esta sendo navegado
        $currentLanguage = JFactory::getLanguage()->getTag();

        /* TODO: modificado para pegar sef do idioma direto no idioma corrente cortando estring (ex: extraimos 'pt' de 'pt-BR')
                - Anteriormente buscavamos o sef dos idiomas de conteúdo instalados, mas isso poderia dar problema pq eles podem estar desabilitados sem que o acesso pelo idioma esteja desabilitado
        */
        // $languages = JLanguageHelper::getLanguages('lang_code');
        // $langSef = $languages[$currentLanguage];
        // $langSef = $langSef->sef;
        $langSef = substr($currentLanguage, 0, 2);

        // Define sefLanguage caso ja nao definido
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], "sefLanguage")) {
            $doc->addScriptDeclaration('var sefLanguage =  "'.$langSef.'";');
        }

        return $html;
    }
}
