<?php

/**
 * @package         Convert Forms
 * @version         4.0.2 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2023 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldInputMask extends JFormFieldList
{
    protected function getInput()
    {
        // Reference: https://github.com/RobinHerbots/Inputmask/tree/5.x/lib/extensions
        $xml = new SimpleXMLElement('
            <fields name="inputmask">
                <field name="options" type="list"
                    hiddenLabel="true">
                    <option value="">JDISABLED</option>
                    <option value="ip">NR_IPADDRESS</option>
                    <option value="email">NR_EMAIL</option>
                    <option value="url">NR_URL</option>
                    <option value="numeric">NR_NUMERIC</option>
                    <option value="currency">NR_CURRENCY</option>
                    <option value="decimal">NR_DECIMAL</option>
                    <option value="integer">NR_INTEGER</option>
                    <option value="percentage">NR_PERCENTAGE</option>
                    <option value="datetime">NR_DATETIME</option>
                    <option value="custom">NR_CUSTOM</option>
                </field>
                <field name="custom" type="text"
                    hiddenLabel="true"
                    hint="(999) 999-9999"
                    showon="options:custom"
                />
            </fields>'
        );

        $this->form->setField($xml);

        foreach ($xml->field as $key => $field)
        {
            $name = $field->attributes()->name;
            $html[] = $this->form->renderField($name, 'inputmask');
        }

        JFactory::getDocument()->addStyleDeclaration('
            .inputmask {
                display:flex;
                gap:10px;
            }
            .inputmask > * {
                flex:1;
                margin-bottom: 0 !important;
            }
            .inputmask .controls {
                min-width:auto;
            }
        ');

        return '<div class="inputmask">' . implode('', $html) . '</div>';
    }
}