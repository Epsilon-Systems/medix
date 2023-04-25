<?php
/*8
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

$link = JoomtestimonialsFrontendHelper::fixAvatar($displayData['link']);
$name = $displayData['name'];

$avatar	= $link ? JHtml::_('image', $link, $name, null, false, true) : '';

?>
<div class="mb-2 testi-avatar"<?php echo $avatar ? " style='background-image: url(\"$avatar\");'" : ''; ?>></div>
