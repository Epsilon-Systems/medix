<?php
/**
 * @package			No Boss Extensions
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("_JEXEC") or die;

// Field que verifica se No Boss Library e No Boss Ajax estao instalados (se nao estiver, exibe erro na tela orientando usuario)
class JFormFieldNobosshaslibrary extends JFormField{
	protected $type = "nobosshaslibrary";

	protected function getInput(){  
        jimport('joomla.filesystem.folder');

        // Verifica se a pasta da library e do nobossajax existe
        $librayFolderExists = JFolder::exists(JPATH_LIBRARIES.'/noboss');
        $nobossAjaxFolderExists = JFolder::exists(JPATH_SITE.'/components/com_nobossajax');

        // Diretorio da 'No boss library' e 'No Boss Ajax' existem
        if($librayFolderExists && $nobossAjaxFolderExists) {
            return;
        }
        
        // Inicia instalacao forcada da library e/ou ajax
        try {
            // Adiciona diretorio de models do componente installer do Joomla
            JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_installer/models');
            // Instancia model de extensoes
            $modelInstaller = JModelLegacy::getInstance('install', 'InstallerModel');
            $input = JFactory::getApplication()->input;
            // Seta para utilizar metodo de instalacao via url
            $input->set('installtype', 'url');

            // Library nao esta instalada
            if(!$librayFolderExists){
                // Seta a url de instalacao da library
                $input->set('install_url', 'https://www.nobossextensions.com/installation/nobosslibrary/');
                // Executa metodo de instalacao
                $modelInstaller->install();
            }

            // No Boss Ajax nao esta instalada
            if(!$nobossAjaxFolderExists){
                // Seta a url de instalacao do noboss ajax
                $input->set('install_url', 'https://www.nobossextensions.com/installation/nobossajax/');
                // Executa metodo de instalacao
                $modelInstaller->install();
            }
        } catch (Exception $e) {
            // Nao tem tratamento de erro pq o Joomla joga diversas vezes a falta de permissoes como erro sendo que ocorreu tudo certo
        }

        // Verifica novamente se a pasta da library e do nobossajax existe
        $librayFolderExists = JFolder::exists(JPATH_LIBRARIES.'/noboss');
        $nobossAjaxFolderExists = JFolder::exists(JPATH_SITE.'/components/com_nobossajax');

        // Verifica se No Boss Ajax esta instalado no banco (ja ocorreu de instalar diretorio e nao registrar no banco e assim impede o funcionamento)
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select("*")->from("#__extensions")->where("element = 'com_nobossajax'");
        $db->setQuery($query);
        $result = $db->loadResult();
        $nobossAjaxDatabaseExists = (!empty($result)) ? true : false;
       
        // Ambas extensoes agora estao instaladas corretamente
        if($librayFolderExists && $nobossAjaxFolderExists && $nobossAjaxDatabaseExists) {
            // Esconde o form para nao aparecer quebrado na tela
            echo '<style>.info-labels, .controls, .control-label{ display: none; } </style>';
            // Exibe mensagem que No Boss Library esta sendo atualizada e a pagina sera recarregada
            echo "<span style='text-align: center; font-size: 18px; width: 100%; position: absolute; font-weight: 600;'>The library used by No Boss Extensions is being updated... <br> Please wait for page to reload in 5 seconds.</span>";
            // Recarrega a pagina com a library ja instalada
            header("Refresh:5");
            exit;
        }

        // Links para download das extensoes
        $linkNoBossLibrary = "<a href='https://www.nobossextensions.com/installation/nobosslibrary/' target='_blank'>https://www.nobossextensions.com/installation/nobosslibrary/</a>";
        $linkNobossAjax = "<a href='https://www.nobossextensions.com/installation/nobossajax/' target='_blank'>https://www.nobossextensions.com/installation/nobossajax/</a>";

        // As duas extensoes nao estao instaladas
        if(!$librayFolderExists && !$nobossAjaxFolderExists){
            $errorTitle = "No Boss Ajax and No Boss Library extensions are not installed";
            $errorMessage = "Corrija o problema instalando as duas extensões a partir das url's abaixo: <br><br> {$linkNoBossLibrary} <br> {$linkNobossAjax}";
        }
        // Somente No Boss Library nao esta instalado
        else if(!$librayFolderExists){
            $errorTitle = "No Boss Library extension is not installed";
            $errorMessage = "Correct the problem by installing the extension from the url below: <br><br> {$linkNoBossLibrary}";
        }
        // Somente No Boss Ajax nao esta instalado
        else if(!$nobossAjaxFolderExists){
            $errorTitle = "No Boss Ajax extension is not installed";
            $errorMessage = "Correct the problem by installing the extension from the url below: <br><br> {$linkNoBossAjax}";
        }
        // No Boss Ajax esta com diretorio instalado, mas nao esta instalado no banco
        else if(!$nobossAjaxDatabaseExists){
            $errorTitle = "The No Boss Ajax extension is not correctly installed on the website.";
            $errorMessage = "To solve the problem, go to the <a href='index.php?option=com_installer&view=discover' target='_blank'>pending installations</a> page and install the No Boss Ajax extension.";
        }
        
        // Monta html a ser exibido
        $html = "<div class='message-box col-lg-10 col-md-10 col-sm-10 col-xs-10'><span class='alert-icon fa fa-exclamation-triangle' aria-hidden='true'></span> <h3>{$errorTitle}</h3><br> <p>{$errorMessage}</p> </div>";
        
        // INICIA PREPARACAO PARA ESCONDER TODOS CAMPOS DA TELA DA EXTENSAO E EXIBIR MENSAGEM PERSONALIZADA

        $template = $this->form->getData()->get('template');  

        $formDataModule = $this->form->getData()->get('module');
        // Pega o nome do componente da url caso esteja nas configurações globais
        $componentNameGlobalConfig = JFactory::getApplication()->input->get->get('component');
        // Pega o nome da extensao 
        if (!empty($componentNameGlobalConfig)) {
            // pega o nome de nas configuraçoes globais
            $this->type = 'global';
        // Caso seja um template 
        } else if (!empty($template)) {
            // Pega a variavel template do form
            $this->type = 'template';
        }
        else if (empty($formDataModule)){
            // pega o nome de componentes
            $formNameArray = explode('.', $this->form->getName());
            $this->type = 'component';
        } 
        else {
            // Pega o nome em casos de modulo
            $this->type = 'module';
        }

        if($this->type == 'module'){
            // Cria um objeto vazio
            $params = new stdClass();
            // Substitui os parametros que estão para ser carregados por um objeto vazio (Ocorria um bug com campos com value json que tinham showon)
            $this->form->getData()->set('params', $params);
            
            // Busca o xml do form
            $xml = $this->form->getXml();
            $countFieldsets = count($xml->config->fields->fieldset);
            // Percorre cada fieldset
            for ($i=1; $i <= $countFieldsets; $i++) {
                // Apaga o fieldset
                unset($xml->config->fields->fieldset[$i]);
            }
        } else if ($this->type == 'component') {
            // Pega todos os dados
            $data = $this->form->getData();
            // Limpa cada um dos campos
            foreach($data->flatten() as $key => $item){
                $data->set("$key", '');
            }

            $xml = $this->form->getXml();
            $countFieldsets = count($xml->fieldset);
            // Percorre cada fieldset
            for ($i=1; $i <= $countFieldsets; $i++) {
                // Apaga o fieldset
                unset($xml->fieldset[$i]);
            }
        }
        
        JFactory::getDocument()->addScriptDeclaration("
            jQuery(document).ready(function(){
                var extraFields = jQuery('form').find('[name=task]').siblings('[type=hidden]').clone();
            
                jQuery('form').html(\"{$html}\");
                jQuery('form').append('<input type=\"hidden\" name=\"task\" value=\"\" />');
                jQuery('form').append(extraFields);

                jQuery('#system-message-container').remove();
                jQuery('.btn-toolbar').find('.btn-wrapper:not(#toolbar-cancel, #toolbar-help) button').prop('disabled', true);
            })
        ");

        JFactory::getDocument()->addStyleDeclaration("
            .message-box {
                padding: 8em 5em;
                font-size: 40px;
                font-size: 0.9375em;
                line-height: 1.2;
                color: #777;
                text-align: center;
            }

            .message-box .alert-icon {
                font-size: 60px;
            }

            .message-box h3 {
                line-height: 28px;
                font-size: 30px;
            }

            .message-box p {
                font-size: 20px;
            }
            
            .message-box {
                background-color: #eee;
                margin: auto;
                float: none;
                border-radius: 30px;
            }
        ");
    }
}
