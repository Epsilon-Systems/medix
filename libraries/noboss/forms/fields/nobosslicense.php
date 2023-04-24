<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.comgi
 * @copyright		Copyright (C) 2023 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("_JEXEC") or die('Restricted access');

jimport('joomla.form.helper');
jimport('noboss.util.curl');
jimport('noboss.util.url');
jimport('noboss.forms.fields.nobosslicense.nobosslicensemodel');

JFormHelper::loadFieldClass('hidden');

class JFormFieldNobosslicense extends JFormFieldHidden
{
    /**
     * The form field type.
     *
     * @var    string
     */
    protected $type = "nobosslicense";

    protected function getLabel(){
        $this->view_license_info = (string) $this->element['view_license_info'];
        $this->view_license_info = $this->view_license_info == '' ? true : (bool)$this->view_license_info;
        // Caso view_license_info seja verdadeiro, esconde a label
        if($this->view_license_info){
            parent::getLabel();
        }
    }
    
    protected function getInput(){
        // Adiciona constantes padroes do JS
        jimport('noboss.util.jsconstants');
        NoBossUtilJsconstants::addConstantsDefault();

        $doc = JFactory::getDocument();

        // Usuario esta em um modulo
        if (!empty($this->form->getData()->get('module'))){
            $this->extensionName = $this->form->getData()->get('module');
        }
        // Usuario esta nas configuracoes gloabais de um componente
        else if (!empty(JFactory::getApplication()->input->get->get('component'))) {
            $this->extensionName = JFactory::getApplication()->input->get->get('component');
        }
        // Usuario esta em um template
        else if (!empty($this->form->getData()->get('template'))) {
            $this->extensionName = $this->form->getData()->get('template');
        }
        // Usuario esta em um plugin
        else if(!empty($this->form->getData()->get('element'))){
            $this->extensionName = $this->form->getData()->get('element');
        }
        // Considera que usuario esta em um componente
        else {
            $formNameArray = explode('.', $this->form->getName());
            $this->extensionName = $formNameArray[0];
        }

        $html = '';

        // Obtem o token e plano da base local
        $tokenPlanArray = NobossModelNobosslicense::getLicenseTokenAndPlan($this->extensionName);

        // Cria propriedades no contexto para uso posterior
        $this->token = array_key_exists("token", $tokenPlanArray) ? $tokenPlanArray['token'] : '';
        $this->inside_support_updates_expiration = '';
        $this->inside_support_technical_expiration = '';
        $this->state = '-1'; // status default para qnd nao sabemos o status
        $this->update_site_id = array_key_exists("update_site_id", $tokenPlanArray) ? $tokenPlanArray['update_site_id'] : '';

        $this->view_license_info = (string) $this->element['view_license_info'];
        $this->modal_display_messages = (string) $this->element['modal_display_messages'];
        $this->modal_display_notice_license = (string) $this->element['modal_display_notice_license'];
        
        // Cria valores default
        $this->view_license_info = $this->view_license_info == '' ? true : (bool)$this->view_license_info;
        $this->modal_display_messages = $this->modal_display_messages == '' ? true : (bool)$this->modal_display_messages;
        $this->modal_display_notice_license = $this->modal_display_notice_license == '' ? true : (bool)$this->modal_display_notice_license;

        $flags = new StdClass();
        $flags->modal_display_messages = $this->modal_display_messages;
        $flags->modal_display_notice_license = $this->modal_display_notice_license;

        // Token definido
        if(!empty($this->token)){
            // Busca as informações da licença, mandando o token da licenca
            $this->licenseInfo = $this->getLicenseInfo($this->token, $this->modal_display_messages);

            // Tenta decodificar dados retornados (caso nao esteja em branco)
            $this->licenseInfoData = json_decode($this->licenseInfo->data);

            // Ocorreu um erro na requisicao
            if (empty($this->licenseInfo->data) || (!$this->licenseInfo->success)){
                // Nao ha mensagem definida para o erro da requisao: define msg generica
                if(empty($this->licenseInfo->message)){
                    $this->licenseInfo->message = "The server's IP address could not be found or the data could not be retrieved from the database.";
                }

                // Exibe mensagem na aba licenca com detalhes do erro
                echo  "<div class='alert alert-error' style='max-width: 800px;'><span class='icon-joomla icon-info'></span>".JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INITIAL_CONNECTION_ERROR_DESC').JText::sprintf('LIB_NOBOSS_ERROR_DETAILS_TITLE', $this->licenseInfo->message)."</div>";

                // Define retorno a enviar para JS
                $dataValue = 'CONNECTION_ERROR';
            }
            else{
                // Token invalido
                if($this->licenseInfo->data == 'INVALID_TOKEN'){
                    $dataValue = 'INVALID_TOKEN';
                }
                // Informacoes foram obtidas do servidor
                else if(!empty($this->licenseInfoData)){
                    $this->state = $this->licenseInfoData->state;

                    // Licenca esta despublicada
                    if($this->state === '0'){
                        $dataValue = 'INACTIVE_LICENSE';
                    }
                    // Licensa publicada
                    else{
                        $this->inside_support_updates_expiration = $this->licenseInfoData->inside_support_updates_expiration;
                        $this->inside_support_technical_expiration = $this->licenseInfoData->inside_support_technical_expiration;
                        $this->updates_near_to_expire = $this->licenseInfoData->days_to_expire_support_updates < 7 && $this->licenseInfoData->days_to_expire_support_updates > 0;
                        $this->has_parent_license = !empty($this->licenseInfoData->id_parent_license);
                        $this->licenseInfoData->siteUrl = base64_encode(str_replace(array('https://www.', 'http://www.', 'https://', 'http://'), '', JURI::root()));
                        $this->licenseInfoData->view_license_info = $this->view_license_info;
                        $this->licenseInfoData->authorized_url = $this->licenseInfoData->authorized_url;
                        $this->license_has_errors = !$this->inside_support_updates_expiration || !$this->licenseInfoData->state || !$this->licenseInfoData->isAuthorizedUrl;
                        $flags->license_has_errors = $this->license_has_errors;
                        $flags->has_parent_license = $this->has_parent_license;

                        // Url de instalacao / update da extensao
                        $this->licenseInfoData->url_installation =  NoBossUtilUrl::getUrlNbExtensions().'/installation/'.$this->licenseInfoData->repository_folder.'/'.$this->licenseInfoData->token;
                        
                        // Dados da licenca que poderao ser salvos no banco para recuperar qnd comunicacao nao funcionar com servidor
                        $objLicenseSave = new stdClass();
                        $objLicenseSave->themes_alias = $this->licenseInfoData->themes_alias;
                        $objLicenseSave->fields_block = $this->licenseInfoData->fields_block;
                        $objLicenseSave->loadmode_alias = $this->licenseInfoData->loadmode_alias;
                        $objLicenseSave->isAuthorizedUrl = $this->licenseInfoData->isAuthorizedUrl;
                        // Converte o obejto para json e adiciona no value do campo para passar depois no input hidden
                        $this->value = json_encode($objLicenseSave);

                        // Salva numa em uma variavel para passar para o js depois
                        $dataValue = $this->licenseInfoData;
                        // Verifica se deve exibir as informações da licença
                        if($this->view_license_info){
                            // Inclui o html da modal de tema, escondida
                            ob_start();
                            require("nobosslicense/nobosslicenselayout.php");
                            $html .= ob_get_clean();
                        }
                        JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UNAUTHORIZED_URL_DESC', $this->licenseInfoData->authorized_url, NoBossUtilUrl::getUrlNbExtensions(), $this->licenseInfoData->id_license, array('script' => true));  
                    }          
                }
            }
        } else {
            $dataValue = 'TOKEN_OR_PLAN_NOT_FOUND';
        }

        // Adiciona as variáveis ao js
        $doc->addScriptOptions('nobosslicense', array(
            'data' => $dataValue,
            'flags' => $flags
        ));

        $html .= "<input type='hidden' id='license_token' name='license_token' value='{$this->token}'>";
        $html .= "<input type='hidden' id='license_update_support_period' name='license_update_support_period' value='{$this->inside_support_updates_expiration}'>";
        // Campo para atualizar o plano no banco depois de um update
        $html .= "<input type='hidden' id='update_site_id' name='update_site_id' value='{$this->update_site_id}'>";
        // Campo para manter armazenado no banco dados mais importantes da licenca para qnd falhar comunicacao
        $html .= "<input type='hidden' name='{$this->name}' value='{$this->value}'>";

        // Adiciona as constantes de tradução para o JS
        JText::sprintf('NOBOSS_EXTENSIONS_URL_SITE', NoBossUtilUrl::getUrlNbExtensions(), array('script' => true));
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_CHANGE_LICENSE_URL');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_AUTHORIZED_URL');

        /* TODO: qnd token e/ou id do plano nao eh localizado na base local ou eh invalido, a constante abaixo eh exibida. 
                    * Podemos melhorar para ter um mini formulario que o usuario digite o ID do plano e o token para atualizar na base local.
                    * Para atualizar na base, podemos aproveitar a funcao ja existente:
                        NobossModelNobosslicense::updateUserLocalPlan($updateSiteId, $extra_query)
                    * Para conseguir o dados a serem inseridos, o usuario continuara tendo que entrar em contato para obte-los com a gente
         */
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INVALID_TOKEN_TITLE');
        JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INVALID_TOKEN_DESC', JText::_('NOBOSS_EXTENSIONS_URL_SITE_CONTACT'), array('script' => true));
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UNPUBLISHED_LICENSE_TITLE');
        JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UNPUBLISHED_LICENSE_DESC', JText::_('NOBOSS_EXTENSIONS_URL_SITE_CONTACT'), array('script' => true));
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UNAUTHORIZED_URL_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_ALERT_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_BUTTON_CONFIRM');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_BUTTON_CANCEL');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_UPDATE_ERROR_TITLE');
        JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_UPDATE_ERROR_DESC', NoBossUtilUrl::getUrlNbExtensions(), array('script' => true));
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_UPDATE_SUCESS_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_CHANGE_LICENSE_URL_UPDATE_SUCESS_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UNAUTHORIZED_URL_BUTTON_KEEP_URL');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UNAUTHORIZED_URL_BUTTON_UPDATE_URL');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_CONFIRM_ACTION_BUTTON_CANCEL');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_CONFIRM_ACTION_BUTTON_CONFIRM');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_AVAILABLE_DOWNLOAD_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_CONFIRM_ACTION_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_CONFIRM_ACTION_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_AVAILABLE_DOWNLOAD_NOW_BUTTON');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_AVAILABLE_DOWNLOAD_LATER_BUTTON');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INITIAL_CONNECTION_ERROR_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INITIAL_CONNECTION_ERROR_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_UPGRADE_PLAN_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INSTALL_NEW_CONFIRM_ACTION_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INSTALL_NEW_CONFIRM_ACTION_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_INSTALL_NEW_CONFIRM_ACTION_BUTTON_CONFIRM');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRED_LICENSE_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRED_LICENSE_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRED_LICENSE_CLOSE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRED_LICENSE_RENEW');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRING_LICENSE_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRING_LICENSE_DESC');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRING_LICENSE_CLOSE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_EXPIRING_LICENSE_RENEW');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_ALERT_HAS_ERRORS_MODULE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_ALERT_HAS_ERRORS_MODULE_LINK');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_ALERT_HAS_ERRORS_COMPONENT');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_ALERT_HAS_ERRORS_COMPONENT_LINK');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_ALERT_HAS_ERRORS_GLOBAL_COMPONENT');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_ALERT_HAS_ERRORS_GLOBAL_COMPONENT_LINK');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_PAGE_REFRESH_ALERT_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_PAGE_REFRESH_ALERT_DESC');
        JText::script('LIB_NOBOSS_BLOCK_FIELD_SIDE_FIELD');
        JText::script('LIB_NOBOSS_BLOCK_FIELD_MODAL_COMPLETE_SIDE_FIELD');
        JText::script('LIB_NOBOSS_BLOCK_FIELD_SUBFORM_HEADER');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_REINSTALL_LINK');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_REINSTALL_CONFIRM_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_REINSTALL_CONFIRM_CONTENT');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_REINSTALL_MODAL_SUCCESS_TITLE');
        JText::script('LIB_NOBOSS_FIELD_NOBOSSLICENSE_REINSTALL_MODAL_SUCCESS_CONTENT');
        JText::script('NOBOSS_EXTENSIONS_GLOBAL_BT_CANCEL');
        JText::script('NOBOSS_EXTENSIONS_GLOBAL_BT_UPDATE');

        if(!empty($this->licenseInfoData->url_installation)){
            JText::sprintf('LIB_NOBOSS_FIELD_NOBOSSLICENSE_MODAL_UPGRADE_AVAILABLE_DOWNLOAD_DESC', $this->licenseInfoData->url_installation, JURI::base().'index.php?option=com_installer&view=install', array('script' => true));
        }

        // Carrega os js e css
        $doc->addStylesheet(JURI::root()."libraries/noboss/forms/fields/assets/stylesheets/css/nobosslicense.min.css");
        $doc->addScript(JURI::root()."libraries/noboss/forms/fields/assets/js/min/nobosslicense.min.js");      

        // retorna o html do campo
        return $html;
    }

    /**
     * Busca através de requisição as informações relacionadas a uma determinada licença
     *
     * @param String $extensionToken Token da licença que será buscado
     * @param Boolean $modalDisplayMessages Flag que informa se deve trazar as mensagens personalizadas da licença
     * 
     * @return Object Retorna um objeto com as informações da licença e o array de mensagens
     */
    private function getLicenseInfo($extensionToken,  $modalDisplayMessages = true){
        // Url requisicao
        $url = NoBossUtilUrl::getUrlNbExtensions().'/index.php?option=com_nbextensoes&task=externallicenses.getLicenseInfo&format=raw';

        // Obtem dominio da url atual
        $siteUrl = str_replace(array('https://www.', 'http://www.', 'https://', 'http://'), '', JURI::root());
       
        // Identifica o idioma que esta sendo navegado para enviar junto na requisicao
        $currentLanguage = JFactory::getLanguage()->getTag();
        
        // Prepara dados a enviar via post
        $dataPost = array('token' => $extensionToken, 'modal_display_message' => $modalDisplayMessages, 'site_url' => $siteUrl, 'language' => $currentLanguage);

        // Realiza a requisição
        $tokenInfo = NobossUtilCurl::request("GET", $url, $dataPost, null, 20);

        // echo '<pre>';
        // var_dump($tokenInfo);
        // exit;

        // echo '<pre>';
        // var_dump(json_decode($tokenInfo->data));
        // exit;

        return $tokenInfo;
    }
}
