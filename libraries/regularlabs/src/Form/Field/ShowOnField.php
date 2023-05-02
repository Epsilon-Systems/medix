<?php
/**
 * @package         Regular Labs Library
 * @version         23.4.18579
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library\Form\Field;

defined('_JEXEC') or die;

use RegularLabs\Library\Form\FormField as RL_FormField;
use RegularLabs\Library\ShowOn as RL_ShowOn;
use RegularLabs\Library\RegEx as RL_RegEx;

class ShowOnField extends RL_FormField
{
    protected function getInput()
    {
        $value = (string) $this->get('value');
        $class = $this->get('class', '');

        if ( ! $value)
        {
            return $this->getControlGroupEnd()
                . RL_ShowOn::close()
                . $this->getControlGroupStart();
        }

        $formControl = $this->get('form', $this->formControl);
        $formControl = $formControl == 'root' ? '' : $formControl;

        while (substr($value, 0, 3) == '../')
        {
            $value = substr($value, 3);
            if (strpos($formControl, '[') !== false)
            {
                $formControl = RL_RegEx::replace('^(.*)\[.*?\]$', '\1', $formControl);
            }
        }

        return $this->getControlGroupEnd()
            . RL_ShowOn::open($value, $formControl, $this->group, $class)
            . $this->getControlGroupStart();
    }

    protected function getLabel()
    {
        return '';
    }
}
