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
 * Script de instalação do pacote de mais de uma extensao de um mesmo produto (ex: FAQ que possui modulo e componente)
 * - Esse script é executado antes do script de instalacao de cada extensao do produto
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
class pkg_NobosstestimonialsInstallerScript{
    /**
     * Evento executado antes de qualquer outro no processo de instalacao / update
     *  - Esse é o momento que a instalacao / update pode ser cancelado
     *  - Essa funcao eh executada antes da preflight do script de instalacao de cada extensao do pacote
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

        // Caso seja uma instalação
        if($type == 'install'){
            // Manda a url do site que está sendo instalado para o servidor
            NoBossUtilInstallscript::saveAuthorizedUrl($extraInfo['token']);
        }
    }

    /**
     * Metodo executado apos a instalacao
     *  - Aqui podemos exibir textos fora de notices / warnings utilizanco 'echo' ou html direto
     * 
     * @param   JInstaller $parent      Classe que chama esse metodo (pode acessar funcoes dela)
     */
	function install($parent) {
	}
    
    /**
     * Metodo executado apos a atualizacao
     * - Aqui podemos exibir textos fora de notices / warnings utilizanco 'echo' ou html direto
     * - Utilizar tambem para colocar atualizacoes especificas de versoes (Ex: migrar dado no banco de estrutura antiga para nova)
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
}
