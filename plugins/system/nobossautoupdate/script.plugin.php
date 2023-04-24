<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die('Restricted access');

/**
 * Script de instalação da library utilizada por todas extensoes da No Boss
 * - Esse script normalmente é executado após o script de instalacao do pacote
 * 
 * - Formatos para retornar mensagens de erro / warning:
 *     // Mensagem de erro (fundo vermelho), sem interromper a instalacao
 *     JFactory::getApplication()->enqueueMessage(JText::_("Aqui mensagem"), 'Error');
 *           
 *     // Mensagem de warning (fundo amarelo), sem interromper a instalacao
 *     JFactory::getApplication()->enqueueMessage(JText::_("Aqui mensagem"), 'Warning');
 *           
 *     // Mensagem de warning (fundo amarelo), interrompendo a instalacao (Joomla tb exibe mensagem de erro da instalacao)
 *     throw new RuntimeException(JText::_("Aqui mensagem"));
 *     return false;
 * 
 * 
 * - Exemplos de usos do $parent que é recebido como parametro nas funções:
 *     // Obter nova versao recem instalada
 *     $parent->get('manifest')->version;
 * 
 *     // Obter alias da extensao (Ex: 'mod_nobosscalendar)
 *     $parent->manifest->name;
 *       
 *     // Redirecionar usuario apos a instalacao (interessante usar no metodo install na instalacao de componentes nossos para redirecionar o usuario para a pagina principal do componente apos a instalacao)
 *     $parent->getParent()->setRedirectURL('index.php?option=com_helloworld');*
 *
 * 
 * - Sobre uso de constantes de tradução
 *    - Se você deseja que as KEYs desses idiomas sejam usadas na primeira instalação do componente, o arquivo de idioma .sys.ini deve ser armazenado na pasta do componente (admin/language/en-GB/en-GB.com_helloworld.sys.ini)
 *    - Quando ja temos a library instalada, podemos forcar o carregamento do idioma da library e usar as constantes dela
 */
class plgSystemNobossautoupdateInstallerScript{

    /**
     * Evento executado antes de qualquer outro no processo de instalacao / update
     *  - Esse é o momento que a instalacao / update pode ser cancelado
     *  - Antes dessa funcao, apenas o preflight do script de instalacao do pacote é executado
     *
     * @param   string     $type        Tipo de intalações (install, update, discover_install)
     * @param   JInstaller $parent      Classe que chama esse metodo (pode acessar funcoes dela)
     *
     * @return  boolean  true caso deva ser instalada, false para cancelar a instalação
     */
    function preflight($type, $parent){
        if($type == 'uninstall'){
            return;
        }

        jimport('joomla.filesystem.folder');

        // Library nao foi instalado
        if(!JFolder::exists(JPATH_LIBRARIES.'/noboss')) {
            throw new RuntimeException('In order to install the extension, first install No Boss Library using the url https://www.nobossextensions.com/en/installation/nobosslibrary', 500);
        }
        // No Boss Ajax nao foi instalado
        else if(!JFolder::exists(JPATH_ROOT.'/components/com_nobossajax/')){
            throw new RuntimeException('In order to install the extension, first install No Boss Ajax using the url https://www.nobossextensions.com/en/installation/nobossajax', 500);
        }

        // Classe com funcoes de apoio para instalacao
        require_once JPATH_SITE."/libraries/noboss/util/installscript.php";

        // Arquivo do zip de instalacao / update com o token da licenca
        $extraInfoPath = __DIR__ . '/extra-info.json';

        // Confirma se arquivo existe no zip de instalacao
        if(JFile::exists($extraInfoPath)){
            // Lê o conteudo do json que contem o token
            $this->extraInfo = json_decode(file_get_contents($extraInfoPath), true);
            // Monta um array apenas com as informações que serão salvas na coluna extra_query do banco
            $extraQueryArray = array('token' => $this->extraInfo['token']);

            // Salva o token na coluna extra_query do banco
            NoBossUtilInstallscript::updateExtraQuery($parent, http_build_query($extraQueryArray));
        }
    }

    /**
     * Metodo executado após o término da instalação / update
     * 
     * @param   string     $type        Tipo de intalações (install, update, discover_install)
     * @param   JInstaller $parent      Classe que chama esse metodo (pode acessar funcoes dela)
     */
    public function postflight($type, $parent) {
        if($type == 'uninstall'){
            return;
        }
        
        // Classe com funcoes de apoio para instalacao
        require_once JPATH_SITE."/libraries/noboss/util/installscript.php";

        // Eh uma nova instalação
        if($type == 'install'){
            // Manda a url do site que está sendo instalado para o servidor
            NoBossUtilInstallscript::saveAuthorizedUrl($this->extraInfo['token']);
        }

        // Eh Update
        if($type == 'update'){
            // Verifica se a library esta na lista de atualizacoes pendentes
            $libUpdateId = NoBossUtilInstallscript::getLibraryUpdateId($parent);

            // Library precisa ser atualizada
            if(!empty($libUpdateId)){
                // Diretorios da library estao sem permissao de escrita
                if(!JPath::canChmod(JPATH_SITE.'/libraries/noboss/') || !JPath::canChmod(JPATH_SITE.'/layouts/noboss/')){
                    // Seta mensagem a ser exibida orientando sobre o problema
                    $urlLibrary = 'https://www.nobossextensions.com/installation/nobosslibrary';
                    $urlDocPermission = 'https://docs.nobosstechnology.com/extensoes-joomla/ajustando-permissoes-de-diretorios-e-arquivos-no-joomla';
                    $message = "It was not possible to update No Boss Library (library used by the extension) due to lack of permissions in the '/libraries/noboss/' and '/layouts/noboss/' directories. <br> <br> Correct the permissions of the directories and after updating the library on the page of <a href='index.php?option=com_installer&view=update' target='_blank'>extension updates</a>. It is also possible to update by installing the library again from the url <a href='{$urlLibrary}' target='_blank'>{$urlLibrary}</a>. <br> <br> For information on how to fix permissions, access the <a href='{$urlDocPermission}' target='_blank'>documentation on setting Joomla file and directory permissions</a>.";

                    // Exibe mensagem como warning (fundo amarelo)
                    JFactory::getApplication()->enqueueMessage($message, 'Warning');
                }
                // Realiza atualizacao da library
                else{
                    // Adiciona diretorio de models do admin
                    JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_installer/models');
                    // Instancia model de extensoes
                    $updateModel = JModelLegacy::getInstance('update', 'InstallerModel');
                    // Realiza o update da library usando o id dela
                    $updateModel->update(array($libUpdateId));
                }
            }
        }
    }
    
    /**
     * Metodo executado apos a instalacao
     *  - Aqui podemos exibir textos fora de notices / warnings utilizanco 'echo' ou html direto
     * 
     * @param   JInstaller $parent      Classe que chama esse metodo (pode acessar funcoes dela)
     */
	function install($parent) {
        // Habilita plugin
        $this->activatePlugin();
	}
    
    /**
     * Metodo executado apos a atualizacao
     * - OBS: aqui nao pega warning ou 'echo'
     * - Utilizar para colocar atualizacoes especificas de versoes (Ex: migrar dado no banco de estrutura antiga para nova)
     * - Para qual versao foi instalada (usar em alguma condicao), utilize $parent->get('manifest')->version
     * 
     * @param   JInstaller $parent      Classe que chama esse metodo (pode acessar funcoes dela)
     */
	function update($parent) {
    }

    /**
     * Método  de desistalação  da  extensão
     *
     * @param   \JInstallerAdapterPackage   $parent é a classe chamando esse método
     *
     * @return void
     */
    function uninstall($parent){
        
    }

    /**
     * Metodo que habilita a extensao apos a instalacao
     */
    private function activatePlugin(){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        //Monta a query para buscar na tabela extension
        $query->update('#__extensions')
            ->set('enabled = 1')
            ->where("element = 'nobossautoupdate'");

        $db->setQuery($query);
        $db->execute();
    }
}
