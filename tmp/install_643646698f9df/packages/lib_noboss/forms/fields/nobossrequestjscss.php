<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2023 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

class JFormFieldNobossrequestjscss extends JFormField
{
  /**
   * The form field type.
   *
   * @var    string
   * @since  3.2
   */
  protected $type = "nobossrequestjscss";

    protected function getInput(){
      $doc = JFactory::getDocument();

      // Caminho do arquivo CSS ou JS desde o diretório raiz do projeto
      $file     = $this->getAttribute('file');
      // Tipo do arquivo que pode ser 'css' ou 'js'
      $fileType   = $this->getAttribute('filetype');
      // Informa se deve ser concatenada a url do site na requisicao ('internal' ou 'external')
      $prefixUrlSite  = $this->getAttribute('prefixurlsite', 'internal');
      // Obtem a versao principal do Joomla que deve ser carregada (se aplica somente qnd nao deve usar em todas versoes)
      $majorVersionJoomlaAccept   = $this->getAttribute('majorVersionJoomlaAccept');

      // Versao principal do Joomla (ex: '3', '4')
      $majorVersionJoomla = substr(JVERSION, 0, 1);

      // Definido que arquivo soh deve ser carregado em uma das versoes (3 ou 4) e essa versao eh diferente da atual
      if(!empty($majorVersionJoomlaAccept) && ($majorVersionJoomlaAccept != $majorVersionJoomla)){
        return;
      }

      if($fileType == 'jquery'){
        JHtml::_('jquery.framework');
      }

      // Parametros file não informado
      if (!isset($file) || $file==''){
        return false;
      }

      // Concatenar url do site na requisicao
      if ($prefixUrlSite == 'internal'){
        // Requisicao eh de JS
        if($fileType=='js'){
            // Adiciona constantes padroes do JS
            jimport('noboss.util.jsconstants');
            NoBossUtilJsconstants::addConstantsDefault();
        }

        $file = JURI::root() . $file;

        $input = JFactory::getApplication()->input;

        // Obtem a versao da extensao
        $extensionsVersion = $input->get('nbExtensionVersion');

        // Adiciona a versao da extensao no final da url para controle de cache
        if(!empty($extensionsVersion)){
            $file .= "?v={$extensionsVersion}";
        }


      }

      // Requiseção CSS
      if ($fileType=='css'){
        $doc->addStyleSheet($file);
      }
      // Requisição JS
      else if ($fileType=='js'){
        $doc->addScript($file);
      }
      // Parametro fileType não definido ou definido incorretamente
      else{
        return false;
      }
    }
}
