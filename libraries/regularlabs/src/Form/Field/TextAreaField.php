<?php
/**
 * @package         Regular Labs Library
 * @version         23.3.25449
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library\Form\Field;

defined('_JEXEC') or die;

use Joomla\CMS\Form\Field\TextareaField as JTextareaField;
use RegularLabs\Library\Document as RL_Document;

class TextAreaField extends JTextareaField
{
    protected $layout = 'regularlabs.form.field.textarea';

    protected function getLayoutData()
    {
        RL_Document::script('regularlabs.textarea');

        $data = parent::getLayoutData();

        $extraData = [
            'show_insert_date_name' => (bool) $this->element['show_insert_date_name'] ?? false,
            'add_separator'         => (bool) $this->element['add_separator'] ?? true,
        ];

        return array_merge($data, $extraData);
    }

    protected function getLayoutPaths()
    {
        $paths   = parent::getLayoutPaths();
        $paths[] = JPATH_LIBRARIES . '/regularlabs/layouts';

        return $paths;
    }
}