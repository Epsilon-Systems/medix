<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;

class NoBossUtilJsconstants {

    public static function addConstantsDefault(){
        $doc = JFactory::getDocument();

        // Define variavel JS 'basenameUrl' caso ja nao esteja definido
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], "baseNameUrl =")) {
            $doc->addScriptDeclaration('var baseNameUrl =  "'.JUri::root().'";');
        }
        // Define variavel JS 'majorVersionJoomla' (versao macro do Joomla. ex: '4') caso ja nao esteja definido
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], "majorVersionJoomla")) {
            $doc->addScriptDeclaration('var majorVersionJoomla =  "'.substr(JVERSION, 0, 1).'";');
        }
        // Define variavel JS 'completeVersionJoomla' (versao completa do Joomla. ex: '4.0.1') caso ja nao esteja definido
        if ((version_compare(JVERSION, '4', '>=')) || @!strpos($doc->_script["text/javascript"], "completeVersionJoomla")) {
            $doc->addScriptDeclaration('var completeVersionJoomla =  "'.JVERSION.'";');
        }

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
    }
}
