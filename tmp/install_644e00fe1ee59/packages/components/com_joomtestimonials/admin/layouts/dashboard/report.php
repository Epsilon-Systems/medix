<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JLoader::register('JoomtestimonialsHelperReport', JPATH_ADMINISTRATOR . '/components/com_joomtestimonials/helpers/report.php');
// get component config
$config = $GLOBALS['com_joomtestimonials_data']['config'];

// get reporting data
$upcoming_events = JoomtestimonialsHelperReport::getUpcomingEvents();
$pending_events = JoomtestimonialsHelperReport::getPendingEvents();
$calendars_utilisation = JoomtestimonialsHelperReport::getCalendarsUtilisation();
$last_syncs = JoomtestimonialsHelperReport::getLastSyncEvents();
$i = 0; // just to detect if there is no syncs , temporary solution
?>

<div class="row">
    <div class="col-md-6  mb-3">
        <div class="bg-light rounded p-3 h-100">
            <h4 class="mb-3 border-bottom pb-2">
                <i class="fas fa-fire text-danger"></i> <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_UPCOMING_BOOKINGS'); ?>
            </h4>

            <div>
                <?php if (count($upcoming_events) > 0) : ?>
                    <table class="table table-hover table-borderless">
                        <tbody>
                        <?php foreach ($upcoming_events as $event) : ?>
                            <?php $ev_obj = new \Joomtestimonials\Model\Eventv4($event->id); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo JURI::root(false); ?>administrator/index.php?option=com_joomtestimonials&view=manage&dateparam=<?php echo $ev_obj->dtstart->format('Y-m-d'); ?>">
                                        <div class="mb-1"><?php echo $ev_obj->getFirstName(); ?><?php echo $ev_obj->getLastName(); ?></div>
                                        <div class="text-muted"><?php echo $ev_obj->getService()->name; ?></div>
                                    </a>
                                </td>
                                <td>
                                    <?php if ($ev_obj->dtstart): ?>
                                        <?php echo JHtml::_('date', $ev_obj->dtstart->format(DATE_ATOM), JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_DTFORMAT')); ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="p-0 text-muted"><?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_NOTHING_FOUND'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php if ($config->disable_pending_bookings != 1) : ?>
        <div class="col-md-6 mb-3">
            <div class="bg-light rounded p-3 h-100">
                <h4 class="mb-3 border-bottom pb-2">
                    <i class="fas fa-clock-o text-warning"></i> <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_LATEST_PENDING_BOOKINGS'); ?>
                </h4>
                <div>
                    <?php if (count($pending_events) > 0) : ?>
                        <table class="table table-hover table-borderless">
                            <tbody>
                            <?php foreach ($pending_events as $event): ?>
                                <?php $ev_obj = new \Joomtestimonials\Model\Eventv4($event->id); ?>
                                <tr>
                                    <td>
                                        <div class="mb-1"><?php echo $ev_obj->getFirstName(); ?><?php echo $ev_obj->getLastName(); ?></div>
                                        <div class="text-muted"><?php echo $ev_obj->getService()->name; ?></div>
                                    </td>
                                    <td>
                                        <?php if ($ev_obj->dtstart): ?>
                                            <?php echo JHtml::_('date', $ev_obj->dtstart->format(DATE_ATOM), JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_DTFORMAT')); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="p-0 text-muted">
                            <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_NOTHING_FOUND'); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-md-6 mb-3">
        <div class="bg-light rounded p-3 h-100">
            <h4 class="mb-3 border-bottom pb-2">
                <i class="fas fa-chart-pie text-info"></i> <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_CALENDAR_UTILIZATION_CURRENT_WEEK'); ?>
            </h4>
            <div>
                <?php if (count($calendars_utilisation) > 0) : ?>
                    <table class="table table-hover table-borderless">
                        <tbody>
                        <?php foreach ($calendars_utilisation as $cal): ?>
                            <tr>
                                <td width="50%">
                                    <span class="fas fa-dot-circle mr-2"
                                          style="color: <?php echo !empty($cal->color) ? $cal->color : 'white' ?>"></span>
                                    <?php echo $cal->name; ?>
                                </td>
                                <td>

                                    <div class="progress mb-1">
                                        <div class="progress-bar progress-bar-animated progress-bar-striped "
                                             role="progressbar" style="width: <?php echo $cal->precent ?>"
                                             aria-valuenow="<?php echo $cal->precent ?>" aria-valuemin="0"
                                             aria-valuemax="100">

                                        </div>

                                    </div>
                                    <small><?php echo $cal->precent; ?></small>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="p-0 text-muted">
                        <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_NOTHING_FOUND'); ?>
                    </p>
                <?php endif; ?>
            </div>


        </div>
    </div>
    <div class="col-md-6 mb-3">

        <div class="bg-light rounded p-3 h-100">
            <h4 class="mb-3 border-bottom pb-2">
                <i class="fas fa-sync-alt text-success"></i> <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_LATEST_SYNCS'); ?>
            </h4>
            <div>
                <?php if (count($last_syncs) > 0) : ?>
                    <table class="table table-hover table-borderless">
                        <tbody>
                        <?php foreach ($last_syncs as $sync): ?>
                            <?php $event = new \Joomtestimonials\Model\Eventv4(json_decode($sync->data, true)['id']); ?>
                            <?php if (!empty($event->id)): // make sure event exist ?>
                                <?php $i++; ?>
                                <tr>
                                    <td width="40%">
                                        <div class="mb-1"><?php echo $event->getFirstName(); ?><?php echo $event->getLastName(); ?></div>
                                        <div class="text-muted"><?php echo $event->getService()->name; ?></div>
                                    </td>
                                    <td>
                                        <?php if ($event->dtstart): ?>
                                            <?php echo JHtml::_('date', $event->dtstart->format(DATE_ATOM), JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_DTFORMAT')); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $sync->action; ?></td>
                                    <td>
                                <span class="label label-<?php echo $sync->status; ?>">
                                    <?php if ($sync->status && $sync->status !== ""): ?>
                                        <?php echo $sync->status; ?>
                                    <?php else : ?>
                                        <?php echo JText::_('COM_JOOMTESTIMONIALS_CAL_SYNC_PENDING'); ?>
                                    <?php endif; ?>
								</span>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if ($i == 0): // temporary solution ?>
                        <p class="p-0 text-muted">
                            <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_NOTHING_FOUND'); ?>
                        </p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="p-0 text-muted">
                        <?php echo JText::_('COM_JOOMTESTIMONIALS_DASHBOARD_NOTHING_FOUND'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>


    </div>

</div>

