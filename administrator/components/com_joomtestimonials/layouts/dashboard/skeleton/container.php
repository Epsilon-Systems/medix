<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

extract($displayData);

?>



<div class="row">
	<div class="col-md-8">

        <div class="form-row mb-3">
            <div class="container p-0 m-0">
                <div class="row">
                    <?php
                    foreach ($counts as $countCard){
                        echo JLayoutHelper::render('dashboard.skeleton.countCard', $countCard);
                    }
                    ?>
                </div>
            </div>
        </div>

		<?php
		foreach ($left as $widget){
			echo JLayoutHelper::render('dashboard.skeleton.widgetCard', $widget);
		}
		?>

	</div>

	<div class="col-md-4">

		<?php
		foreach ($right as $widget){
			echo JLayoutHelper::render('dashboard.skeleton.widgetCard', $widget);
		}
		?>

	</div>
</div>