<?php
/*8
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

// item vote number
$vote       = (int) $displayData['vote'];

// item id
$icolor     = $displayData['inactivestar_color'];
$acolor     = $displayData['activestar_color'];

$style = '
			span.joomstar:after {
    			content: "\2605";
    			color: '.$icolor.';
				font-size: 20px;
			}
				
			span.joomstar.joomactivestar:after{	
				color: '.$acolor.';
			}			
		';

JFactory::getDocument()->addStyleDeclaration($style);
?>
<div class="joomstars">
	<?php for($x=1;$x<=$vote;$x++) { ?>
		<span class="joomstar joomactivestar"></span>
	<?php } ?>
	<?php while ($x<=5) { ?>
		<span class="joomstar joominactivestar"></span>
	<?php $x++; } ?>
</div>
