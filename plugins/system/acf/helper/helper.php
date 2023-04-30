<?php

/**
 * @package         Advanced Custom Fields
 * @version         2.4.0 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2019 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

/**
 *  Advanced Custom Fields Helper
 */
class ACFHelper
{
    /**
     *  Check field publishing assignments.
     *  The field will not show up on front-end if it doesn't pass the checks.
     *  
     *  Note: Field is passed by reference.
     *
     *  @param   object  $field  The field object
     *
     *  @return  void
     */
	public static function checkConditions($field)
	{
        // Skip fields with an empty value. 
        // The Fields component removes them from the front-end by default.
        if (empty($field->value))
        {
            return;
        }

        // Convert object to array recursively
        $rules = json_decode(json_encode($field->params->get('rules', [])), true);
        $pass = \NRFramework\Conditions\ConditionBuilder::pass($rules);

        if (!$pass)
        {
            // According to the components/com_fields/layouts/fields/render.php file, if the field's value is empty it won't shgow up in the front-end.
            $field->value = '';

            // Unset rawvalue too, as it may be used in template overrides.
            $field->rawvalue = '';
        }
	}

    public static function getFileSources($sources, $allowedExtensions = null)
    {
        if (!$sources)
        {
            return;
        }

        // Support comma separated values
        $sources = is_array($sources) ? $sources : explode(',', $sources);
        $result  = array();

        foreach ($sources as $source)
        {
            if (!$pathinfo = pathinfo($source))
            {
                continue;
            }

            if ($allowedExtensions && !in_array($pathinfo['extension'], $allowedExtensions))
            {
                continue;
            }

            // Add root path to local source
            if (strpos($source, 'http') === false)
            {
                $source = JURI::root() . ltrim($source, '/');
            }

            $result[] = array(
                'ext'  => $pathinfo['extension'],
                'file' => $source
            );
        }

        return $result;
    }
}