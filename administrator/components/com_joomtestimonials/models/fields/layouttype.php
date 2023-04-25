<?php

// No direct access.
defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

jimport('joomla.html.html');
jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of Testimonials.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JFormFieldLayoutType extends JFormField {

    /** @var string		The form field type. */
    protected $type	= 'LayoutType';

    /**
     * Method to get the field input markup.
     *
     * @return	string	The field input markup.
     */
    protected function getInput() {

        require_once (JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/layout.php');
        $data = LayoutHelper::getListLayoutTypes();
        $selected = LayoutHelper::getSetLayoutType()->get('list_type', 'item-normal');

        $selectList = HTMLHelper::_('select.genericlist', $data, 'jform[list_type]', 'class="form-select valid"', false, $optText = 'text', $selected, 'testimonials_layout', true);


        $html ='<div class="input-group">' . $selectList . '</div>';

        return $html ;

    }
}