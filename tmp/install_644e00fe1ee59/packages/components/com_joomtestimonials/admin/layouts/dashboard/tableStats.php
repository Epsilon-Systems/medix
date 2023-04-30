<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

extract($displayData);

// add badges to counts
$stats = JoomtestimonialsHelperDashboard::addBadges($stats);

?>

<table class="m-0 table table-striped table-borderless">
	<tr>
		<td class="w-50"><?php echo JText::_('COM_JOOMTESTIMONIALS_TODAY') ?></td>
		<td><?php echo $stats['today'] ?></td>
	</tr>
	<tr>
		<td ><?php echo JText::_('COM_JOOMTESTIMONIALS_YESTERDAY') ?></td>
		<td><?php echo $stats['yesterday'] ?></td>
	</tr>
	<tr>
		<td ><?php echo JText::_('COM_JOOMTESTIMONIALS_THISMONTH') ?></td>
		<td><?php echo $stats['thismonth'] ?></td>
	</tr>
	<tr>
		<td ><?php echo JText::_('COM_JOOMTESTIMONIALS_LASTMONTH') ?></td>
		<td><?php echo $stats['lastmonth'] ?></td>
	</tr>
	<tr>
		<td ><?php echo JText::_('COM_JOOMTESTIMONIALS_THISYEAR') ?></td>
		<td><?php echo $stats['thisyear'] ?></td>
	</tr>
	<tr>
		<td ><?php echo JText::_('COM_JOOMTESTIMONIALS_LASTYEAR') ?></td>
		<td><?php echo $stats['lastyear'] ?></td>
	</tr>
	<tr>
		<td ><?php echo JText::_('COM_JOOMTESTIMONIALS_TOTAL') ?></td>
		<td><?php echo $stats['total'] ?></td>
	</tr>
</table>

