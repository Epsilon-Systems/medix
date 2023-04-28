<?php
/**
 * @package         Modules Anywhere
 * @version         7.16.4
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Plugin\System\ModulesAnywhere\Form\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\ChromestyleField as JChromestyleField;
use Joomla\CMS\HTML\HTMLHelper as JHTMLHelper;
use RegularLabs\Library\DB as RL_DB;

class ChromeStyleField extends JChromestyleField
{
    public static function getTemplateStyles()
    {
        $field = new self;

        $field->clientId = 0;

        if (interface_exists('Joomla\Database\DatabaseAwareInterface')
            && $field instanceof \Joomla\Database\DatabaseAwareInterface
        )
        {
            $field->setDatabase(RL_DB::get());
        }

        return $field->getTemplateModuleStyles();
    }

    /**
     * Method to get the list of template chrome style options
     * grouped by template.
     *
     * @return  array  The field option objects as a nested array in groups.
     */
    protected function getGroups()
    {
        $groups = [];

        $templateStyles = $this->getTemplateModuleStyles();

        // Create one new option object for each available style, grouped by templates
        foreach ($templateStyles as $template => $styles)
        {
            $template          = ucfirst($template);
            $groups[$template] = [];

            foreach ($styles as $style)
            {
                $tmp                 = JHTMLHelper::_('select.option', $template . '-' . $style, $style);
                $groups[$template][] = $tmp;
            }
        }

        reset($groups);

        return $groups;
    }
}
