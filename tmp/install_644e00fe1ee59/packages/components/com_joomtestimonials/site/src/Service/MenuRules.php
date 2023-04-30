<?php
/**
 * Joomla! Content Management System
 *
 * @copyright  (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Component\Router\Rules\MenuRules;
/**
 * Rule to identify the right Itemid for a view in a component
 *
 * @since  3.4
 */
class JoomtestimonialsMenuRules extends MenuRules
{

    public function __construct(RouterView $router)
    {


        parent::__construct($router);
    }


    public function build(&$query, &$segments)
    {

        // for testimonial view
        if(isset($query['view']) && $query['view'] == 'testimonial'){
            $segments[] = str_replace(':','-',$query['id']);
            unset($query['id']);
        }

        // for list view
        if(isset($query['view']) && $query['view'] == 'testimonials'){
            unset($query['catids']);
        }


        // if view has item id and not modal (tmpl=component) removed view and layout from query
        if (isset($query['Itemid']) && !isset($query['tmpl']))
        {
            unset($query['view']);
            unset($query['layout']);
        }

    }


    public function parse(&$segments, &$vars)
    {

        // for testimonial view
        if(count($segments) == 1){



            $vars['view'] = 'testimonial';
            $vars['id'] = str_replace('-',':',$segments[0]);

            unset($segments[0]);

        }


    }



}