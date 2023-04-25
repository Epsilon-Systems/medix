<?php
/**
 * @copyright      Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;


$uri    = (string) JUri::getInstance();
$return = urlencode(base64_encode($uri));

$user = JFactory::getUser();
?>
    <div class="row">
        <div id="j-sidebar-container"  class="col-md-2"  style="height: max-content;">
            <?php echo $this->sidebar; ?>
        </div>

        <div id="j-main-container" class="col-md-10">
            <div id="jb_template">
                <?php echo JoomtestimonialsHelperDashboard::getSkeleton(); ?>
            </div>
        </div>

        <form action="<?php echo JRoute::_('index.php?option=com_joomtestimonials&view=dashboard'); ?>"
              method="post"
              name="adminForm"
              id="adminForm"
        >
            <input type="hidden" name="task" value=""/>
        </form>
    </div>

	
