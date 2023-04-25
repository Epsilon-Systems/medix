<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

$doc = JFactory::getDocument();
$canCreate = JtAuhtoriseHelper::canCreate();
$params = LayoutHelper::getListLayoutParams();

$layoutparams = $params->get('layoutparams');
$showSubmitButton = $layoutparams->get('show_submit_button', 1);
$openType = $layoutparams->get('list_main.form_type', 0); // 0 => modal, 1 => new page


// open type from module
if(isset($displayData['params']) && $displayData['params']->get('layout','button') == 'button_new'){
	$openType = 1;
}


if (isset($displayData['customClass']) && !empty($displayData['customClass']))
    $customClass = $displayData['customClass'];
else
    $customClass = 'btn btn-success btn-sm pull-right';


// Load Modal Layout
if ($canCreate && $showSubmitButton)
    echo JLayoutHelper::render('common.form.iframeModal', []);


?>
<?php if ($canCreate && $showSubmitButton): ?>

    <?php if (!$openType): ?>
        <button class="<?php echo $customClass ?> jtModal"
                href="<?php echo JoomtestimonialsHelperRoute::getFormRoute(0, JUri::current(), true); ?>"
        >
            <i class="fas fa-plus"></i>
            <span class="d-none d-sm-inline">
                <?php echo JText::_('COM_JOOMTESTIMONIALS_SUBMIT_TESTIMONIAL'); ?>
            </span>
        </button>
        <div id="jt-form-iframe">
        </div>
    <?php else: ?>
        <a class="<?php echo $customClass ?>"
           href="<?php echo JRoute::_(JoomtestimonialsHelperRoute::getFormRoute(0, JUri::current(), false)); ?>"
        >
            <?php echo JText::_('COM_JOOMTESTIMONIALS_SUBMIT_TESTIMONIAL'); ?>
        </a>
    <?php endif; ?>


<?php endif; ?>

