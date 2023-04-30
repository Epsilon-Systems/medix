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

$mapWrapperClass = '';
if (!$map)
{
	$mapWrapperClass .= ' no-map';
}

if (empty(array_filter($address)))
{
	$mapWrapperClass .= ' clear-is-hidden';
}
?>
<div class="nrf-widget tf-mapaddress-editor<?php echo $css_class; ?>">
	<?php if ($required) { ?>
		<!-- Make Joomla client-side form validator happy by adding a fake hidden input field when the Gallery is required. -->
		<input type="hidden" required class="required" id="<?php echo $id; ?>"/>
	<?php } ?>

	<div class="tf-mapaddress-map-wrapper<?php echo $mapWrapperClass; ?>">
		<?php if (!$required): ?>
		<a href="#" class="tf-mapaddress-editor-clear"><?php echo JText::_('NR_CLEAR'); ?></a>
		<?php endif; ?>
		<?php echo $map; ?>
	</div>
	<div class="tf-mapaddress-field-location-details">
		<?php
		foreach ($showAddressDetails as $key => $show)
		{
			$lang_key = 'NR_' . strtoupper($key);
			$placeholder = $lang_key;

			if ($key === 'address')
			{
				$placeholder .= '_ADDRESS_HINT';
			}

			$input_type = $show ? 'text' : 'hidden';
			$visibility_class = $show ? 'visible' : 'hidden';
			?>
			<div class="control-group stack <?php echo $key; ?> is-<?php echo $visibility_class; ?>">
				<div class="control-label"><label for="<?php echo $id ?>-field-address-field-<?php echo $key ?>"><?php echo JText::_($lang_key); ?></label></div>
				<div class="controls">
					<input
						type="<?php echo $input_type; ?>"
						id="<?php echo $id; ?>-field-address-field-<?php echo $key ?>"
						class="form-control w-100 tf-mapaddress-field-<?php echo $key ?>"
						name="<?php echo $name; ?>[address][<?php echo $key; ?>]"
						placeholder="<?php echo JText::_($placeholder); ?>"
						value="<?php echo isset($address[$key]) ? $address[$key] : ''; ?>"
						autocomplete="off"
						<?php if ($key === 'address' && $autocomplete): ?>
							data-autocomplete="true"
						<?php endif; ?>
					/>
					<?php if ($key === 'address'): ?>
						<div class="tf-mapaddress-field-autocomplete-results"></div>
						<svg width="22" height="22" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
							<circle cx="14" cy="14" r="8.48528" transform="rotate(-45 14 14)" stroke-width="2"></circle>
							<path d="M19.9995 20L24.4995 24.5" stroke-width="2" stroke-linecap="round"></path>
						</svg>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>