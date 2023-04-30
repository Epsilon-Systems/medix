<?php

/**
 * @package         Advanced Custom Fields
 * @version         2.4.0 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2020 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die;

extract($displayData);

$options = isset($options) ? $options : $displayData;

if ($load_css_vars)
{
	JFactory::getDocument()->addStyleDeclaration('
		.nrf-widget.openstreetmap.' . $id . ' {
			--width: ' . $options['width'] . ';
			--height: ' . $options['height'] . ';
		}
	');
}
?>
<div class="nrf-widget openstreetmap nr-lazyload-item nr-address-component<?php echo $options['css_class']; ?>">
	<div class="inner">
		<div class="osm_map_item" data-options="<?php echo htmlspecialchars(json_encode($options)); ?>"></div>
		<?php if ($options['showMarkerTooltip']): ?>
			<div class="marker-tooltip" style="display:none;"><div class="tooltip-body"><?php echo nl2br($options['markerTooltipValue']); ?></div><div class="arrow"></div></div>
		<?php endif; ?>
	</div>
</div>