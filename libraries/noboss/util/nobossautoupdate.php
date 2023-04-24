<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */
defined('_JEXEC') or die;

jimport('noboss.util.loadextensionassets');
jimport('noboss.email.send');
jimport('joomla.filesystem.folder');

/**
 * Classe para o plugin nobossautoupdate
 */
class NobossNobossautoupdate {

    /**
	 * Realiza atualizacoes conforme regras definidas no parametro do plugin
	 */
	public static function update() {
        $config = JFactory::getConfig();

        // Instancia o model de instalacao do Joomla
        JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_installer/models');
        $model = JModelLegacy::getInstance("Update", "InstallerModel");

        // Pega os parametros do plugin de autoupdate para saber se deve enviar
        $plugin = JPluginHelper::getPlugin('system', 'nobossautoupdate');
        $params = new JRegistry($plugin->params);

        // Carrega arquivo traducao para extensao de instalacao
        JFactory::getLanguage()->load('com_installer', JPATH_ADMINISTRATOR);

        // Nao foi definido nenhum email nos parametros do plugin: pega das configuracoes globais
        if(empty($params->get('user_email'))) {
            $recipientEmail = $config->get('mailfrom');
        }
        // Email definido nos parametros do plugin
        else {
            $recipientEmail = $params->get('user_email');
        }

        // Array para armazenar mensagens de cada extensao atualizada ou com erro
        $messagesReturn = array();
        
        // Busca todos updates disponiveis no Joomla (é um processo demorado)
        $model->findUpdates(0, 0);

        // Obtem extensoes disponiveis para atualizacao
        $updates = $model->getItems();

        // Nao tem nenhum update disponivel
        if(empty($updates)){
            return;
        }

        // Setado para atualizar somente extensoes da no boss extensoes
        if($params->get('update_type_extension', 'only_noboss') == 'only_noboss'){
            // Array com extensoes da no boss
            $updates = array_filter($updates, function($k) {
                return strpos($k->element, 'noboss') !== false || strpos($k->element, 'nb') !== false;
            });
        }

        // Array com extensoes que nao devem ser atualizadas
        $extensionsIgnore = $params->get('extensions_ignore');

        // Adiciona 'No Boss Library' no array a ignorar (a extensão da no boss ja atualiza a library e se atualizar direto, o usuario pode estar sem licenca em dia que impede atualizacao da extensao e assim atualizaria a library podendo gerar erros)
        $extensionsIgnore[] = 'noboss';

        // Percorre cada extensao disponivel para atualizacao
        foreach ($updates as $update) {
            // Extensao esta no array a ignorar: pula extensao
            if(in_array($update->element, $extensionsIgnore)){
                continue;
            }

            // Atualiza a extensao uma a uma para controlar melhor os erros
            @$model->update(array($update->update_id));

            // Obtem retorno da funcao de update
            $result = $model->getState('result');

            // Ocorreu um erro
            if (!$result){
                // Mensagem de inicio do erro             
                $messageHeader = "* The extension '{$update->name}' cannot be updated. Error Details: <br />";

                $messageError = '';
                // Obtem mensagens geradas pela funcao de update
                $messages = JFactory::getApplication()->getMessageQueue();
                if (count($messages) > 0){
                    foreach ($messages as $message) {
                        // Diretorios sem permissao de escrita: muda mensagem exibida
                        if ($message['message'] == 'Copy file failed'){
                            $message['message'] = "Directories where the extension is to be installed do not have write permission.";
                        }
                        // Armazena mensagem retornada do Joomla
                        $messageError .= $message['message'].'<br />';
                    }
                }

                $session = JFactory::getSession();
                $session->set('application.queue', null);

                $messagesReturn['error'][] = $messageHeader.$messageError;
            }
            // Extensao foi atualizada
            else{
                // Mensagem de sucesso       
                $messagesReturn['success'][] = "* The extension '{$update->name}' was successfully updated. <br />";
            }
        }

        // Obtem o nome do site das configuracoes globais
        $sitename = $config->get('sitename');
        
        // Houve atualizacao de extensao no boss
        if (count($updatesNoBoss) > 0){
            // Verifica se a pasta da library existe
            $librayFolderExists = JFolder::exists(JPATH_LIBRARIES.'/noboss');
            
            // Library nao esta instalada (pode ter ocorrido erro na atualizacao): forca uma nova instalacao para resolver
            if(!$librayFolderExists) {
                // Adiciona diretorio de models do componente installer do Joomla
                JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_installer/models');
                // Instancia model de extensoes
                $modelInstaller = JModelLegacy::getInstance('install', 'InstallerModel');
                $input = JFactory::getApplication()->input;
                // Seta para utilizar metodo de instalacao via url
                $input->set('installtype', 'url');
                // Seta a url de instalacao da library
                $input->set('install_url', 'https://www.nobossextensions.com/en/installation/nobosslibrary/');
                // Executa metodo de instalacao
                $modelInstaller->install();
            }
        }

        if(empty($messagesReturn['error'])){
            $totalError = 0;
            $messagesError = '';
        }
        else{
            $totalError = count($messagesReturn['error']);
            $messagesError = implode('<br /><br />', $messagesReturn['error']);
        }

        if(empty($messagesReturn['success'])){
            $totalSuccess = 0;
            $messagesSuccess = '';
        }
        else{
            $totalSuccess = count($messagesReturn['success']);
            $messagesSuccess = implode('<br /><br />', $messagesReturn['success']);
        }

        // Opcao de envio de email
        switch ($params->get('send_user_email', 'not')) {
            // Somente em caso de erros
            case 'error':
                if ($totalError > 0){
                    // Assunto do email
                    $subject = JText::sprintf('PLG_NOBOSSAUTOUPDATE_EMAIL_ERROR_SUBJECT', $sitename, $totalError);
                    // Conteudo do email
                    $content = JText::sprintf('PLG_NOBOSSAUTOUPDATE_EMAIL_ERROR_CONTENT', $sitename, $totalError, $messagesError);
                    // Envio do email
                    NoBossEmailSend::sendEmail($subject, $content, array(), $recipientEmail);
                }
                break;
            // Em todos os casos
            case 'ever':
                if (($totalError > 0) || ($totalSuccess > 0)){
                    // Assunto do email
                    $subject = JText::sprintf('PLG_NOBOSSAUTOUPDATE_EMAIL_EVER_SUBJECT', $sitename, $totalSuccess, $totalError);
                    // Conteudo do email
                    $content = JText::sprintf('PLG_NOBOSSAUTOUPDATE_EMAIL_EVER_CONTENT', $sitename, $totalSuccess, $totalError, $messagesError, $messagesSuccess);
                    // Envio do email
                    NoBossEmailSend::sendEmail($subject, $content, array(), $recipientEmail);
                }
                break;
        }

        // Exibe na tela os erros
        echo $messagesError.'<br />';
        // Exibe na tela os sucessos
        echo $messagesSuccess;
    }

    /**
	 * Redireciona para funcao 'update()'
     *      - Mantido apenas pq usuarios antigos podem estar apontando para essa funcao ainda na url
	 */
	public static function updateNobossExt() {
        return self::update();
    }
}
