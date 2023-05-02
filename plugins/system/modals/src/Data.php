<?php
/**
 * @package         Modals
 * @version         12.3.4
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Plugin\System\Modals;

defined('_JEXEC') or die;

use Joomla\CMS\Factory as JFactory;
use RegularLabs\Library\RegEx as RL_RegEx;
use RegularLabs\Library\Uri as RL_Uri;

class Data
{

    public static function createDataAttribute($key, $value)
    {
        $key = RL_RegEx::replace('^data-', '', $key);

        return 'data-modals-' . $key . '="' . $value . '"';
    }

    public static function createTagAttribute($key, $value)
    {
        if ($value === '<empty>')
        {
            return $key;
        }

        if (in_array($key, ['title', 'alt']))
        {
            $value = htmlentities(strip_tags($value));
        }

        return $key . '="' . $value . '"';
    }

    public static function flattenAttributeList($attributes)
    {
        $params = Params::get();

        $string = '';
        foreach ($attributes as $key => $value)
        {
            $key = trim($key);

            // Ignore attributes when key is empty
            if ($key == '')
            {
                continue;
            }

            $value = trim($value);

            // Ignore attributes when value is empty, but not a title or alt attribute
            if ($value == '' && ! in_array($key, ['alt', 'title']))
            {
                continue;
            }

            if (is_bool($value) && in_array($key, $params->booleans))
            {
                $value = $value ? 'true' : 'false';
            }

            $string .= ' ' . $key . '="' . $value . '"';
        }

        return $string;
    }

    public static function flattenMixedAttributeList($settings)
    {
        $params = Params::get();

        $tag_attributes  = [];
        $data_attributes = [];

        foreach ($settings as $key => $value)
        {
            $key = trim($key);

            if ( ! in_array($key, $params->valid_attribute_keys)
                && ! in_array($key, $params->valid_data_keys))
            {
                continue;
            }

            $value = self::prepareAttributeValue($key, $value);

            if (is_null($value))
            {
                continue;
            }

            if (in_array($key, $params->valid_attribute_keys))
            {
                $i = array_search($key, $params->valid_attribute_keys);

                $tag_attributes[$i] = self::createTagAttribute($key, $value);
            }

            if (in_array($key, $params->valid_data_keys))
            {
                $i = array_search($key, $params->valid_data_keys);

                $data_attributes[$i] = self::createDataAttribute($key, $value);
            }
        }

        ksort($tag_attributes);
        ksort($data_attributes);

        $attributes = array_merge(['data-modals'], $tag_attributes, $data_attributes);

        return implode(' ', array_unique($attributes));
    }

    public static function getIsOpenFromValue($value, $opentype, $cookie_id = '', $cookie_ttl = 0)
    {
    }

    public static function isOpen($values, $opentype, $cookie_id = '', $cookie_ttl = 0)
    {
    }

    public static function prepareAttributeValue($key, $value)
    {
        $params = Params::get();

        if (is_null($value))
        {
            $value = '';
        }

        if (is_bool($value) && in_array($key, $params->booleans))
        {
            $value = $value ? 'true' : 'false';
        }

        $value = trim($value);

        if ($value == '' && ! in_array($key, $params->include_empty_attributes))
        {
            return null;
        }

        return str_replace('"', '&quot;', $value);
    }

    public static function setDataAxis(&$data, $isexternal, $axis = 'width')
    {
        if ( ! empty($data->{$axis}))
        {
            return;
        }

        $params = Params::get();

        $data->{$axis} = $params->{$axis} ?: '95%';
    }

    public static function setDataOpen(&$data)
    {
    }

    public static function setDataWidthHeight(&$data, $isexternal)
    {
        self::setDataAxis($data, $isexternal, 'width');
        self::setDataAxis($data, $isexternal, 'height');
    }

    private static function getOpenCount($type = '', $cookie_id = '', $cookie_ttl = 0)
    {
    }
}
