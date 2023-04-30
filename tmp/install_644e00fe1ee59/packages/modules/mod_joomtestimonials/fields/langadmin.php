<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once

require_once JPATH_SITE . '/components/com_joomtestimonials/helpers/joomtestimonials.php';

jimport('joomla.form.formfield');

// The class name must always be the same as the filename (in camel case)
class JFormFieldLangadmin extends JFormField {

    //The field class must know its own type through the variable $type.
    protected $type = 'langadmin';

    public function renderField($options = Array()) {
        JoomtestimonialsFrontendHelper::getLangjt(1);
    }
}