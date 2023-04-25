<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

JHtml::_('dropdown.init');

$user		= JFactory::getUser();
$userId		= $user->get('id');
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$archived	= $this->state->get('filter.published') == 2 ? true : false;
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$canOrder	= $user->authorise('core.edit.state', 'com_joomtestimonials.category');
$saveOrder	= $listOrder == 'a.ordering';

if ($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_joomtestimonials&task=testimonials.saveOrderAjax&tmpl=component';
    HTMLHelper::_('draggablelist.draggable');
}


?>

<form action="<?php echo JRoute::_('index.php?option=com_joomtestimonials&view=testimonials'); ?>" method="post" name="adminForm" id="adminForm">
        <div class="row">
            <?php if (!empty($this->sidebar)) : ?>
                <div id="j-sidebar-container" class="col-md-2" style="height: max-content;">
                    <?php echo $this->sidebar; ?>
                </div>
                <div id="j-main-container" class="col-md-10">
            <?php else : ?>
                <div id="j-main-container">
            <?php endif; ?>
                <div class="tableContainer">
                    <?php  echo LayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array('selectorFieldName' => 'category'))); ?>
                    <div class="clearfix"></div>

                    <table class="table table-striped table-list" id="testimonialList">

                    <thead>
                        <tr>
                            <th scope="col" class="nowrap center hidden-phone">
                                <?php echo HTMLHelper::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder); ?>
                            </th>
                            <th width="1%" class="hidden-phone">
                                <input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
                            </th>
                            <th scope="col" style="min-width:55px" class="w-1 text-center">
                                <?php echo HTMLHelper::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
                            </th>
                            <th>
                                <?php echo HTMLHelper::_('searchtools.sort', 'COM_JOOMTESTIMONIALS_LIST_NAME', 'a.name', $listDirn, $listOrder); ?>
                            </th>
                            <th class="hidden-phone">
                                <?php echo JText::_('COM_JOOMTESTIMONIALS_LIST_TESTIMONIAL'); ?>
                            </th>
                            <th width="10%" class="nowrap hidden-phone">
                                <?php echo HTMLHelper::_('searchtools.sort', 'COM_JOOMTESTIMONIALS_LIST_CATEGORY', 'category_title', $listDirn, $listOrder); ?>
                            </th>
                            <th width="5%" class="nowrap hidden-phone">
                                <?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ACCESS', 'a.access', $listDirn, $listOrder); ?>
                            </th>
                            <th width="5%" class="nowrap hidden-phone">
                                <?php echo HTMLHelper::_('searchtools.sort', 'JDATE', 'a.created', $listDirn, $listOrder); ?>
                            </th>
                            <th class="nowrap hidden-phone">
                                <?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_LANGUAGE', 'a.language', $listDirn, $listOrder); ?>
                            </th>
                            <th width="5%" class="nowrap hidden-phone">
                                <?php echo HTMLHelper::_('searchtools.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody <?php if ($saveOrder) :?> class="js-draggable" data-url="<?php echo $saveOrderingUrl; ?>" data-direction="<?php echo strtolower($listDirn); ?>" data-nested="false"<?php endif; ?>>

                    <?php foreach ($this->items as $i => $item) :


                        // fix avatar link
                        $item->avatar = JoomtestimonialsFrontendHelper::fixAvatar($item->avatar);

                        $canCreate		= $user->authorise('core.create',			'com_joomtestimonials' . '.category.' . $item->catid);
                        $canEdit		= $user->authorise('core.edit',				'com_joomtestimonials' . '.category.' . $item->catid);
                        $canCheckin		= $user->authorise('core.manage',			'com_checkin') || $item->checked_out == $user->get('id') || $item->checked_out == 0;
                        $canChange		= $user->authorise('core.edit.state',		'com_joomtestimonials' . '.category.' . $item->catid) && $canCheckin;
                        $testimonial	= strip_tags($item->testimonial);
                        $testimonial	= strlen($testimonial) > 100 ? substr($testimonial, 0, 97) . '...' : $testimonial;
                        ?>

                        <tr class="row<?php echo $i % 2; ?>" data-draggable-group="<?php echo $item->catid; ?>"
                            data-item-id="<?php echo $item->id ?>" data-parents=""
                            data-level="<?php echo $item->level ?>">

                            <td class="order nowrap center hidden-phone">
                            <?php if ($canChange) :
                                $disableClassName = '';
                                $disabledLabel	  = '';
                                if (!$saveOrder) :
                                    $disabledLabel    = JText::_('JORDERINGDISABLED');
                                    $disableClassName = ' inactive tip-top';
                                endif; ?>

                                <span class="sortable-handler hasTooltip<?php echo $disableClassName; ?>" title="<?php echo $disabledLabel; ?>">
                                    <i class="icon-menu"></i>
                                </span>
                                <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order" />
                            <?php else : ?>
                                <span class="sortable-handler ">
                                    <i class="icon-menu"></i>
                                </span>
                            <?php endif; ?>

                            </td>

                            <td class="center hidden-phone">
                                <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->state, $i, 'testimonials.', $canChange, 'cb'); ?>
                            </td>
                            <td>

                                <div class="d-flex align-items-center">
                                    <div>
                                        <?php  if ($item->avatar && $avatar = JHtml::_('image', $item->avatar, $item->avatar, 'class="avatar"')) : ?>
                                            <?php  echo $avatar; ?>
                                        <?php else : ?>
                                            <div class="avatar">
                                                <?php echo JHtml::_('image', 'media/com_joomtestimonials/images/noavatar.svg', 'no-avatar', 'style="background: #ddd;"'); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div>
                                        <?php if ($item->checked_out) : ?>
                                            <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'testimonials.', $canCheckin); ?>
                                        <?php endif; ?>

                                        <?php if ($canEdit) : ?>
                                            <a href="<?php echo JRoute::_('index.php?option=com_joomtestimonials&task=testimonial.edit&id=' . (int) $item->id); ?>">
                                                <?php echo $this->escape($item->name); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo $this->escape($item->name); ?>
                                        <?php endif; ?>
                                        <!--
                                    <?php if(!empty($item->email)):?>
                                    <br>
                                    <div class="badge bg-success small">
                                        <span class="fas fa-envelope"></span> <?php echo $this->escape($item->email); ?>
                                    </div>
                                    <?php endif;?>
                                    -->
                                    </div>
                                </div>


                            </td>
                            <td class="small hidden-phone">
                                <?php echo $testimonial; ?>
                            </td>
                            <td class="small nowrap hidden-phone">
                                <?php echo $this->escape($item->category_title); ?>
                            </td>
                            <td class="small hidden-phone">
                                <?php echo $this->escape($item->access_level); ?>
                            </td>
                            <td class="nowrap small hidden-phone">
                                <?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC4')); ?>
                            </td>
                            <td class="center nowrap hidden-phone">
                                <?php if ($item->language == '*') : ?>
                                <?php echo JText::alt('JALL', 'language'); ?>
                                <?php else : ?>
                                <?php echo $item->language_title ? $this->escape($item->language_title) : JText::_('JUNDEFINED'); ?>
                                <?php endif; ?>
                            </td>
                            <td class="center hidden-phone">
                                <?php echo (int) $item->id; ?>
                            </td>
                        </tr>

                        <?php endforeach; ?>
                    </tbody>
                    </table>

                   <?php echo $this->pagination->getListFooter(); ?>

                   <?php  if ($this->canDo->get('core.edit')) { ?>
                        <?php echo HTMLHelper::_(
                            'bootstrap.renderModal',
                            'collapseModal',
                            array(
                                'title'  => Text::_('COM_JOOMTESTIMONIALS_TESTIMONIALS_BATCH_OPTIONS'),
                                'footer' => $this->loadTemplate('batch_footer')
                            ),
                            $this->loadTemplate('batch')
                        ); ?>
                   <?php } ?>

                    <input type="hidden" name="task" value="" />
                    <input type="hidden" name="boxchecked" value="0" />
                    <?php echo JHtml::_('form.token'); ?>
                 </div>
                <?php echo JoomtestimonialsFactory::getFooter(); ?>
            </div>
        </div>
</form>