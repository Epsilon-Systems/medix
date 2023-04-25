<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */




defined('_JEXEC') or die('@-_-@');


/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   (C) 2006 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */



\defined('_JEXEC') or die;

JLoader::register('JoomtestimonialsMenuRules',__DIR__.'/src/Service/MenuRules.php');

use Joomla\CMS\Application\SiteApplication;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Menu\AbstractMenu;
use Joomla\Database\DatabaseInterface;
use Joomla\Database\ParameterType;
use Joomla\CMS\Categories\CategoryFactoryInterface;

/**
 * Routing class of com_content
 *
 * @since  3.3
 */
class JoomtestimonialsRouter extends RouterView
{



    /**
     * The db
     *
     * @var DatabaseInterface
     *
     * @since  4.0.0
     */
    private $db;

    /**
     * Content Component router constructor
     *
     * @param SiteApplication $app The application object
     * @param AbstractMenu $menu The menu object to work with
     * @param CategoryFactoryInterface $categoryFactory The category object
     * @param DatabaseInterface $db The database object
     */
    public function __construct(SiteApplication $app, AbstractMenu $menu)
    {


        parent::__construct($app, $menu);

       $this->attachRule(new JoomtestimonialsMenuRules($this));


    }

}

