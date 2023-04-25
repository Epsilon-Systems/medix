<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

class JFormFieldVote extends JFormFieldList
{
	
	protected $type = 'Vote';
	protected $layout = 'joomla.form.field.list';

    protected function getInput()
    {
        $doc = JFactory::getDocument();

        $js="
		jQuery(document).ready(function($){
			
			jQuery('#jform_vote').barrating({
        			theme: 'css-stars'
      		});			
	
		});	
		
		";

        $doc->addStyleSheet(JUri::root().'/media/com_joomtestimonials/css/css-stars.css');
        $doc->addScript(JUri::root().'/media/com_joomtestimonials/js/jquery.barrating.min.js');
        $doc->addScriptDeclaration($js);


        // attributes
        $attr = !empty($this->class) ? ' class="' . $this->class . '"' : '';
        $attr .= $this->required ? ' required aria-required="true"' : '';

        $options = (array) $this->getOptions();
        $html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
        return implode($html);
    }
	
}
