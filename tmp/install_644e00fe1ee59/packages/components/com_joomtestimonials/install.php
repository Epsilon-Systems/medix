<?php
/**
 * @copyright    Copyright (c) 2013 - 2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die();

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Installer\Adapter\ComponentAdapter;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Plugin\PluginHelper;

/**
 * JoomTestimonials Installer Script
 *
 * @package        Joomla.Install
 * @subpakage    Joomla.JoomTestimonials
 */
class Com_JoomtestimonialsInstallerScript
{


    protected $release = '';
    protected $extension = 'com_joomtestimonials';
    protected $oldRelease = '';

    protected function _install($parent, $update = false)
    {
        $manifest = $parent->getManifest();
        $this->release = $manifest->version;
    }

    /**
     * Install.
     *
     * @param    $parent
     */
    public function install($parent)
    {
        $this->_install($parent);
    }

    /**
     * Update.
     *
     * @param    $parent
     */
    public function update($parent)
    {
        $this->_install($parent, true);
    }

    /**
     * Runs after an install/update/uninstall method
     *
     * @return void
     */
    public function preflight($type, ComponentAdapter $adapter)
    {

        // Abort if the module being installed is not newer than the currently installed version
        if (strtolower($type) == 'update')
        {

            // component manifest file version
            $this->release = (string) $adapter->getParent()->get('manifest')->version;

            // get installed version
            $this->oldRelease = $this->getParam('version');


            // don't allow update to lower versions
            if (version_compare($this->release, $this->oldRelease, '<'))
            {
                JFactory::getApplication()->enqueueMessage(JText::sprintf('YOU_CANT_UPDATE_TO_A_LOWER_VERSION', $this->oldRelease, $this->release), 'error');
                return false;
            }

            // refresh files structure if version is older than 4.0
            if (version_compare($this->oldRelease, '4.0', '<'))
            {
                $this->removeOldFolder();
            }

        }


    }

    /**
     * Runs after an install/update/uninstall method
     *
     * @return void
     */
    public function postflight($type, ComponentAdapter $adapter)
    {

        // Create configs folder
        jimport('joomla.filesystem.folder');
        $folder = JPATH_SITE . '/components/com_joomtestimonials/configs';

        if (!JFolder::exists($folder)) {
            JFolder::create($folder);
        }

        $result = '';

        if ($type == 'update') {

            //Migration
            JLoader::register('JoomTestimonialsMigrateHelper', JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/helpers/migrateHelper.php');

            if (version_compare($this->oldRelease, '4.0', '<')) {
                $result = JoomTestimonialsMigrateHelper::migrateJ4();
            }

            // refresh xml cache
            /** @var  Joomla\Component\Installer\Administrator\Model\ManageModel $manageModel */
            $manageModel = Factory::getApplication()->bootComponent('com_installer')
                ->getMVCFactory()->createModel('Manage', 'Administrator', ['ignore_request' => true]);

            $ids = [
                ComponentHelper::getComponent('com_joomtestimonials')->id
            ];

            $manageModel->refresh($ids);

            // rebuild update sites
            /** @var  Joomla\Component\Installer\Administrator\Model\UpdatesitesModel $updateSiteModel */
            $updateSiteModel = Factory::getApplication()->bootComponent('com_installer')
                ->getMVCFactory()->createModel('Updatesites', 'Administrator', ['ignore_request' => true]);

            $updateSiteModel->rebuild();


        }

        JFactory::getApplication()->enqueueMessage($result, 'success');
    }

    public function getParam($name)
    {
        $db = JFactory::getDbo();
        $db->setQuery("SELECT manifest_cache FROM #__extensions WHERE element = '$this->extension'");
        $manifest = json_decode($db->loadResult(), true);

        return $manifest[$name];
    }

    private function removeOldFolder()
    {
        $paths =
            [
                JPATH_ADMINISTRATOR . '/components/com_joomtestimonials',
                JPATH_SITE . '/components/com_joomtestimonials',
                JPATH_SITE . '/modules/mod_joomtestimonials'
            ];

        foreach ($paths as $path) {
            if (Folder::exists($path)) {
                Folder::delete($path);
            }
        }
    }


}