<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (http://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined( '_JEXEC' ) or die( 'Restricted access' );


class pkg_joomtestimonialsInstallerScript
{

    public function preflight($type, $parent)
    {
        // Do not run on uninstall.
        if ($type === 'uninstall')
        {
            return true;
        }

        // Prevent users from installing this on Joomla 3
        if (version_compare(JVERSION, '3.999.999', 'le'))
        {
            $msg = "<p>This version of JoomTestimonials cannot run on Joomla 3. Please download and install JoomTestimonials compatible with Joomla 3 instead. Kindly note that our site's Downloads page clearly indicates which version of our software is compatible with Joomla 3 and which version is compatible with Joomla 4.</p>";

            \Joomla\CMS\Log\Log::add($msg, \Joomla\CMS\Log\Log::WARNING, 'jerror');

            return false;
        }

        return true;
    }

    /**
     * Runs right after any installation action is performed on the component.
     *
     * @param string $type - Type of PostFlight action. Possible values are:
     *                           - * install
     *                           - * update
     *                           - * discover_install
     * @param \stdClass $parent - Parent object calling object.
     *
     * @return void
     */
    public function postflight($type, $parent)
    {
        $app = JFactory::getApplication();

        // don't enable plugins if action type is update
        if ($type == 'update' || $type == 'uninstall') return;


        $db = JFactory::getDBO();

        $manifest = $parent->getManifest();

// Enable Plugins and set Default plugin
        $plugins = array();

        foreach ($manifest->files->folder as $file) {
            $attributes = $file->attributes();

            if ($attributes['enable'] && $attributes['type'] == 'plugin' && $attributes['enable'] == '1') {
                $plugins[] = $db->quote($attributes['id']);
            }
        }

        $query = 'UPDATE #__extensions'
            . ' SET enabled = 1'
            . ' WHERE element IN (' . implode(', ', $plugins) . ') AND type =' . $db->q("plugin");
        $db->setQuery($query);
        if (!$db->execute()) {
            $application = JFactory::getApplication();
            $application->enqueueMessage('Failed to Enable plugins ' . $db->getError(), 'error');
        }

    }
}
