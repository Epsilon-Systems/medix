<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined("JPATH_PLATFORM") or die;

jimport('noboss.util.loadextensionassets');

// Obter a versao da extensao informada e seta no input para poder ser obtido em outros locais via php
class JFormFieldNobossextensionversion extends JFormField
{

protected $type = "nobossextensionversion";

    protected function getInput(){
        $doc = JFactory::getDocument();
        // Nome da extensao (ex: mod_nobosscalendar)
        $extension     = $this->getAttribute('extension');

        if(empty($extension)){
            return;
        }
        // Obtem versao da extensao
        $extensionsVersion = NoBossUtilLoadExtensionAssets::getExtensionVersion($extension);

        if(empty($extensionsVersion)){
            return;
        }

        $input = JFactory::getApplication()->input;

        // Seta versao no input para poder ser obtido em codigos PHP que forem executados na sequencia
        $input->set('nbExtensionVersion', $extensionsVersion);

        // Armazena versao em constante JS, caso ainda nao definido
        // OBS: qnd tem mais de uma extensao da no boss na mesma pagina (situacao de front-end), ira colocar no JS a versao da primeira extensao
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], "nbExtensionVersion")) {
            $doc->addScriptDeclaration('var nbExtensionVersion =  "'.$extensionsVersion.'";');
        }
    }
}
