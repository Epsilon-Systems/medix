<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

$params = LayoutHelper::getListLayoutParams();
$layoutparams = $params->get('layoutparams');
$list_main          = (array)$layoutparams->get('list_main');
$pagination     = $displayData['pagination'];

?>
<?php if (($layoutparams->def('show_pagination', 1) == 1 || ($list_main['show_pagination'] == 2)) && ($pagination->pagesTotal > 1)) : ?>
    <div class="pagination d-flex mt-3">
        <div class="flex-grow-1">
			<?php echo $pagination->getPagesLinks(); ?>
        </div>
		<?php if ($layoutparams->def('show_pagination_results', 1)) : ?>
            <div class="item-s align-self-center"> <?php echo $pagination->getPagesCounter(); ?> </div>
		<?php endif; ?>
    </div>
<?php endif; ?>