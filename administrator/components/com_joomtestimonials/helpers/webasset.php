<?php
/**
 * @package        Joommedia
 * @copyright      2013-2020 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
use Joomla\CMS\Form\Form;

defined('_JEXEC') or die;


class JoomTestimonialsHelperWebasset
{

    /**
     * The search tools form
     *
     * @var   \Joomla\CMS\WebAsset\WebAssetManager     *
     */
    static $wa;

    public static function init(){

        static::$wa = \Joomla\CMS\Factory::getApplication()->getDocument()->getWebAssetManager();
        static::$wa->getRegistry()->addExtensionRegistryFile('com_joomtestimonials');
        $wr =  static::$wa->getRegistry();
        $wr->addRegistryFile(JPATH_ROOT.'/media/com_joomtestimonials/joomla.asset.json');

    }

}