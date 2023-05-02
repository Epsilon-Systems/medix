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

use ContentHelperRoute;
use Joomla\CMS\Factory as JFactory;
use Joomla\CMS\Language\Text as JText;
use RegularLabs\Library\File as RL_File;
use RegularLabs\Library\Html as RL_Html;
use RegularLabs\Library\ObjectHelper as RL_Object;
use RegularLabs\Library\PluginTag as RL_PluginTag;
use RegularLabs\Library\RegEx as RL_RegEx;
use RegularLabs\Library\StringHelper as RL_String;

class Link
{
    public static function build($settings, $content = '')
    {
        $params = Params::get();

        if (isset($settings->theme) && $settings->theme == 'classic'
            || empty($settings->theme) && $params->theme == 'classic'
        )
        {
            $settings->legacy = true;
        }


        self::setVideoUrl($settings);

        if (empty($settings->href))
        {
            return '';
        }

        $isexternal = RL_File::isExternal($settings->href);
        $ismedia    = isset($settings->image) || RL_File::isMedia($settings->href, $params->mediafiles);
        $isvideo    = ! empty($settings->video) || File::isVideo($settings->href, $settings);
        $fullpage   = (empty($settings->fullpage) || $isexternal) ? false : (bool) $settings->fullpage;
        $isinline   = ($settings->href && $settings->href[0] == '#') || $ismedia;

        $settings->class          = Helper::removeClassname($settings->class ?? '', 'modal');
        $settings->{'data-class'} = $settings->classname ?? '';


        if ($ismedia && ! isset($settings->title))
        {
            $auto_titles = $settings->{'auto-titles'} ?? $params->auto_titles;
            $title_case  = $settings->{'title_case'} ?? $params->title_case;
            if ($auto_titles)
            {
                $settings->title = File::getTitle($settings->href, $title_case);
            }
        }

        if ($settings->href && $settings->href[0] != '#' && ! $isexternal && ! $ismedia && ! $isvideo)
        {
            $settings->href = Document::addUrlAttributes($settings->href, $fullpage, ! empty($settings->print));
        }


        

        if ( ! empty($settings->theme))
        {
            $settings->theme = RL_String::toDashCase($settings->theme, true);
        }

        // Add aria label for empty links for accessibility
        if (empty($content))
        {
            $label = isset($settings->title)
                ? self::cleanTitle($settings->title)
                : '';

            $settings->{'aria-label'} = $label ?: 'Popup link';
        }

        if (empty($settings->width))
        {
            $settings->width = $params->width_urls;
        }

        if (empty($settings->height))
        {
            $settings->height = $params->height_urls;
        }

        return
            '<a '
            . Data::flattenMixedAttributeList($settings)
            . '>'
            . $content;
    }

    public static function get($string, $link = '', $content = '')
    {
        [$settings, $extra_html] = self::getData($string, $link);

        $link = self::build($settings, $content);
        $link .= $link ? '</a>' : '';

        return [$link, $extra_html];
    }

    public static function getAttributeList($string)
    {
        $attributes = (object) [];

        if ( ! $string)
        {
            return $attributes;
        }

        $attribute_string = RL_RegEx::replace('^<[a-z]+ (.*)>', '\1', trim($string));

        return RL_PluginTag::getAttributesFromString($attribute_string);
    }

    public static function getData($string, $link = '')
    {
        $params = Params::get();

        $link_settings = self::getAttributeList(trim($link));

        // Get the values from the tag
        $settings = RL_PluginTag::getAttributesFromString(
            $string,
            'url',
            $params->booleans,
            'dash'
        );

        $settings = RL_Object::replaceKeys($settings, $params->key_aliases);

        $settings->href  = $settings->href ?? $link_settings->href ?? '';
        $settings->class = $settings->class ?? $link_settings->class ?? '';

        foreach ($link_settings as $key => $value)
        {
            if ($key == 'class')
            {
                $settings->class .= ' ' . $value;
                continue;
            }

            if ( ! isset($settings->{$key}))
            {
                $settings->{$key} = $value;
            }
        }

        if ( ! empty($settings->url))
        {
            $settings->href = self::cleanUrl($settings->url);
        }

        if ( ! empty($settings->target))
        {
            $settings->target = $settings->target;
        }

        $extra_html = '';


        if ( ! empty($settings->title))
        {
            $settings->title = self::translateString($settings->title);
            $settings->title = RL_String::removeHtml($settings->title);
        }

        if ( ! empty($settings->description))
        {
            $settings->description = self::translateString($settings->description);
        }

        return [$settings, $extra_html];
    }

    private static function addUrlParameter($url, $key, $value = '')
    {
        if (empty($key))
        {
            return $url;
        }

        $key = ltrim($key, '?&');

        if (RL_RegEx::match('[\?&]' . $key . '=', $url))
        {
            return $url;
        }

        $query = $key;

        if ($value)
        {
            $query .= '=' . $value;
        }

        return $url . (strpos($url, '?') === false ? '?' : '&') . $query;
    }

    private static function cleanTitle($string)
    {
        $string = str_replace('<div class="modals_description">', ' - ', $string);

        return RL_String::removeHtml($string);
    }

    private static function cleanUrl($url)
    {
        return RL_RegEx::replace('<a[^>]*>(.*?)</a>', '\1', $url);
    }

    private static function fixUrlVimeo($url)
    {
        $regex = '(?:^vimeo=|vimeo\.com/(?:video/)?)(?<id>[0-9]+)(?<query>.*)$';

        if ( ! RL_RegEx::match($regex, trim($url), $match))
        {
            return $url;
        }

        $url = 'https://player.vimeo.com/video/' . $match['id'];

        $url = self::addUrlParameter($url, $match['query']);

        return $url;
    }

    private static function fixUrlYoutube($url)
    {
        $regex = '(?:^youtube=|youtu\.be/?|youtube\.com/embed/?|youtube\.com\/watch\?v=)(?<id>[^/&\?]+)(?:\?|&amp;|&)?(?<query>.*)$';

        if ( ! RL_RegEx::match($regex, trim($url), $match))
        {
            return $url;
        }

        $url = 'https://www.youtube.com/embed/' . $match['id'];

        $url = self::addUrlParameter($url, $match['query']);
        $url = self::addUrlParameter($url, 'wmode', 'transparent');

        return $url;
    }

    private static function fixVideoUrl($url, &$setting)
    {
        switch (true)
        {
            case(
                strpos($url, 'youtu.be') !== false
                || strpos($url, 'youtube.com') !== false
            ) :
                $setting->video = 'true';

                return self::fixUrlYoutube($url);

            case(
                strpos($url, 'vimeo.com') !== false
            ) :
                $setting->video = 'true';

                return self::fixUrlVimeo($url);

            default:
                return $url;
        }
    }

    private static function setVideoUrl(&$settings)
    {

        $settings->href = self::fixVideoUrl($settings->href, $settings);
    }

    private static function translateString($string = '')
    {
        if (empty($string) || ! RL_RegEx::match('^[A-Z][A-Z0-9_]+$', $string))
        {
            return $string;
        }

        return JText::_($string);
    }
}
