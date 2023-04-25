<?php
/**
 * @copyright	Copyright (c) 2013 - 2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

?>

<div class="jtstats" id="jtstat-<?php echo $module->id ?>">
    <table class="<?php echo $tableclass ?>">
        <thead>
        <th>Period</th>
        <th>Count</th>
        </thead>
        <tbody>

        <?php
        if($todayoption){ ?>
            <tr>
                <td>Today:</td>
                <td><?php echo $stats['today']?></td>
            </tr>
        <?php } ?>

        <?php
        if($yesterdayoption){ ?>
            <tr>
                <td>Yesterday:</td>
                <td><?php echo $stats['yesterday']?></td>
            </tr>
        <?php } ?>

        <?php
        if($thismonthoption){ ?>
            <tr>
                <td>This Month:</td>
                <td><?php echo $stats['thismonth']?></td>
            </tr>

        <?php } ?>

        <?php
        if($lastmonthoption){ ?>
            <tr>
                <td>Last Month:</td>
                <td><?php echo $stats['lastmonth']?></td>
            </tr>
        <?php } ?>

        <?php
        if($thisyearoption){ ?>
            <tr>
                <td>This Year:</td>
                <td><?php echo $stats['thisyear']?></td>
            </tr>
        <?php } ?>

        <?php
        if($lastyearoption){ ?>
            <tr>
                <td>Last Year:</td>
                <td><?php echo $stats['today']?></td>
            </tr>
        <?php } ?>

        <?php
        if($totaloption){ ?>
            <tr>
                <td>Total:</td>
                <td><?php echo $stats['total']?></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>
</div>


