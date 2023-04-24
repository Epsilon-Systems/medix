<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	com_nobosstestimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

// Evita acesso direto ao arquivo.
defined('_JEXEC') or die;

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('nobosstextcounter');

// Caso a library não exista, nem tenta renderizar esse campo
if(!JFolder::exists(JPATH_LIBRARIES.'/noboss')){
    return;
}

/**
 * Classe model de depoimento.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_nobosstestimonials
 */
class JFormFieldTextcounter extends JFormFieldNoBosstextcounter
{
    protected $type = "textcounter";
    
    protected function getInput(){
        //pega o html do parent
        $parentHtml = parent::getInput();
        //carrega a model de grupo do admin
        JLoader::import( 'group', JPATH_ADMINISTRATOR . '/components/com_nobosstestimonials/models');
        $modelGroup = new NobosstestimonialsModelGroup();
        //adiciona os arquivos
        $doc = JFactory::getDocument();
        $doc->addScript(JURI::root()."administrator/components/com_nobosstestimonials/models/fields/assets/js/src/textcounter.js");
        
        $min = $this->element->attributes()->min;
        $default = $this->element->attributes()->min;
        
        //verifica se o contexto atual é de site o admin
        //se for admin 
        $app = JFactory::getApplication();
        if($app->isClient('administrator')) {
            $groupId = $this->form->getData()->get('id_testimonials_group');
            //pega o limit do grupo
            $currentGroup = $modelGroup->getItem($groupId);
            if($groupId == null){
                return $parentHtml;
            }
            $limit = $currentGroup->display_field_number_characters_testimonial;
            //se for site, pega o id do modulo e o grupo
        }else{
            $groupId = $this->group_id;
            $currentGroup = $modelGroup->getParamsTestimonialsGroup($groupId);
            $paramsJson = json_decode($currentGroup->fields_display);
            $limit = $paramsJson->display_field_number_characters_testimonial;
        }
        //caso o id do grupo seja null retorna o html sem alterações
        
        //adiciona o limite setado no componente
        $newHtml = str_replace("data-limit=''", "data-limit='{$limit}'", $parentHtml);

        //retorna o html modificado        
        return $newHtml;
    }
}
