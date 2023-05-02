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

use RegularLabs\Library\Html as RL_Html;
use RegularLabs\Library\Protect as RL_Protect;
use RegularLabs\Library\RegEx as RL_RegEx;
use RegularLabs\Library\StringHelper as RL_String;

class Replace
{
    public static function replaceTags(&$string, $area = 'article', $context = '')
    {
        if ( ! is_string($string) || $string == '')
        {
            return false;
        }

        // Check if tags are in the text snippet used for the search component
        if (strpos($context, 'com_search.') === 0)
        {
            $limit = explode('.', $context, 2);
            $limit = (int) array_pop($limit);

            $string_check = substr($string, 0, $limit);

            if ( ! RL_String::contains($string_check, Params::getTags(true)))
            {
                return false;
            }
        }

        $params = Params::get();

        RL_Protect::removeFromHtmlTagAttributes(
            $string,
            [
                $params->tag,
            ]
        );

        // allow in component?
        if (RL_Protect::isRestrictedComponent($params->disabled_components ?? [], $area))
        {

            Protect::_($string);

            $regex = Params::getRegex();

            $string = RL_RegEx::replace($regex, '\4', $string);

            Clean::cleanFinalHtmlOutput($string);

            RL_Protect::unprotect($string);

            return true;
        }

        Protect::_($string);

        self::replaceLinks($string);

        // tag syntax inside links
        self::replaceTagSyntaxInsideLinks($string);

        [$start_tags, $end_tags] = Params::getTags();

        [$pre_string, $string, $post_string] = RL_Html::getContentContainingSearches(
            $string,
            $start_tags,
            $end_tags
        );

        // tag syntax
        self::replaceTagSyntax($string, $area);

        $string = $pre_string . $string . $post_string;


        Clean::cleanFinalHtmlOutput($string);

        RL_Protect::unprotect($string);

        return true;
    }

    // add ml to internal links

    private static function replaceContentTag(&$string, $match)
    {
    }

    private static function replaceContentTags(&$string)
    {
    }

    private static function replaceImage(&$string, $match)
    {
    }

    private static function replaceImages(&$string)
    {
    }

    private static function replaceLink(&$string, $match)
    {
        if (strpos($match[0], ' data-modals ') !== false)
        {
            return;
        }

        // get the link attributes
        $settings = Link::getAttributeList($match[0]);

        if ( ! Pass::passLinkChecks($settings))
        {
            return;
        }

        foreach ($settings as $key => $value)
        {
            // check if key begins with data-modals-
            if (strpos($key, 'data-modals-') !== 0)
            {
                continue;
            }

            // remove the data-modals- prefix
            $key = substr($key, 12);

            // set the value to the settings
            $settings->{$key} = $value;
        }

        $link = Link::build($settings);

        $params = Params::get();

        if ($params->place_comments)
        {
            $link = Protect::wrapInCommentTags($link);
        }

        self::replaceOnce($match[0], $link, $string);
    }

    private static function replaceLinks(&$string)
    {
        $params = Params::get();

        if (
            (
                empty($params->classnames)
                && ! RL_RegEx::match('class\s*=\s*(?:"[^"]*|\'[^\']*)(?:' . implode('|', $params->classnames) . ')', $string)
            )
        )
        {
            return;
        }

        $regex = Params::getRegex('link');

        RL_RegEx::matchAll($regex, $string, $matches);

        if (empty($matches))
        {
            return;
        }

        foreach ($matches as $match)
        {
            self::replaceLink($string, $match);
        }
    }

    private static function replaceOnce($search, $replace, &$string, $extra_html = '')
    {
        if ( ! $extra_html
            || ! RL_RegEx::match(RL_RegEx::quote($search) . '(?<post>.*?</(?:div|p)>)', $string, $match)
        )
        {
            $string = RL_String::replaceOnce($search, $replace . $extra_html, $string);

            return;
        }

        // Place the extra div stuff behind the first ending div/p tag
        $string = RL_String::replaceOnce(
            $match[0],
            $replace . $match['post'] . $extra_html,
            $string
        );
    }

    private static function replaceTagSyntax(&$string, $area = '')
    {
        $regex = Params::getRegex();

        RL_RegEx::matchAll($regex, $string, $matches);

        if (empty($matches))
        {
            return;
        }

        $params = Params::get();

        foreach ($matches as $match)
        {
            $tags = RL_Html::cleanSurroundingTags(
                [
                    'end_pre'    => $match['end_pre'],
                    'start_post' => $match['start_post'],
                ]
            );
            $tags = RL_Html::cleanSurroundingTags(
                [
                    'end_pre'    => $tags['end_pre'],
                    'pre'        => $match['pre'],
                    'post'       => $match['post'],
                    'start_post' => $tags['start_post'],
                ],
                ['p']
            );

            [$link, $extra_html] = Link::get($match['data'], '', trim($tags['pre'] . $match['text'] . $tags['post']));

            if ($params->place_comments)
            {
                $link = Protect::wrapInCommentTags($link);
            }

            $html = $match['start_pre'] . $tags['start_post']
                . $link
                . $tags['end_pre'] . $match['end_post'];

            self::replaceOnce($match[0], $html, $string, $extra_html);
        }
    }

    private static function replaceTagSyntaxInsideLinks(&$string)
    {
        $regex = Params::getRegex('inlink');

        RL_RegEx::matchAll($regex, $string, $matches);

        if (empty($matches))
        {
            return;
        }

        $params = Params::get();

        foreach ($matches as $match)
        {
            $content = trim($match['image_pre'] . $match['text'] . $match['image_post']);

            [$link, $extra] = Link::get($match['data'], $match['link_start'], $content);

            if ($params->place_comments)
            {
                $link = Protect::wrapInCommentTags($link);
            }

            self::replaceOnce($match[0], $link, $string, $extra);
        }
    }
}
