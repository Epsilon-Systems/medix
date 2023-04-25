<?php
/**
 * @copyright    Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;

defined('_JEXEC') or die;

// some inits
$user = JFactory::getUser();
$app = JFactory::getApplication();
$config = ComponentHelper::getParams('com_joomtestimonials');

$customfields = new JLayoutFile('edit.params', JPATH_ROOT . '/components/com_joomtestimonials/layouts');

if (!empty($this->item->id))
    $posturl = 'index.php?option=com_joomtestimonials&view=form&t_id=' . $this->item->id;
else
    $posturl = 'index.php?option=com_joomtestimonials';




JoomTestimonialsHelperWebasset::$wa->useScript('com_joomtestimonials.form');

?>
<div id="jb_template">
    <?php if (JText::_('COM_JOOMTESTIMONIALS_FORM_PRETEXT') != 'COM_JOOMTESTIMONIALS_FORM_PRETEXT'): ?>
        <div class="juit-form-pretext  <?php echo $this->isModal ? 'p-3' : 'mb-3' ?>">
            <?php echo JText::_('COM_JOOMTESTIMONIALS_FORM_PRETEXT'); ?>
        </div>
    <?php endif; ?>
    <form
            method="post"
            action="<?php echo JUri::base() . $posturl; ?>"
            name="adminForm"
            id="adminForm"
            class="form-validate"
            enctype="multipart/form-data"
    >
        <div class="juit-form<?php echo $this->pageclass_sfx; ?> <?php echo $this->isModal ? 'p-3 mb-5' : '' ?>">
            <?php if (!$this->isModule && $this->isModal and !empty($this->item->id)): ?>
                <div class="page-header">
                    <h1><?php echo JText::_('COM_JOOMTESTIMONIALS_FORM_EDIT'); ?></h1>
                </div>
            <?php elseif (!$this->isModule && $this->params->get('show_page_heading', 1) && !$this->isModal) : ?>
                <div class="page-header">
                    <h1>
                        <?php echo $this->escape($this->params->get('page_heading')); ?>
                    </h1>
                </div>
            <?php endif; ?>

            <div class="mb-3 predefined-field-name">
                <?php echo $this->form->getLabel('name'); ?>
                <?php echo $this->form->getInput('name'); ?>

            </div>

            <?php if ($this->params->get('field_email_visible')) : ?>
                <div class="mb-3 predefined-field-email">
                    <?php echo $this->form->getLabel('email'); ?>
                    <?php echo $this->form->getInput('email'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->params->get('field_avatar_visible')) : ?>
                <div class="mb-3 predefined-field-avatar">
                    <?php echo $this->form->getLabel('avatar_file'); ?>
                    <?php echo $this->form->getInput('avatar_file'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->params->get('field_position_visible')) : ?>
                <div class="mb-3 predefined-field-position">
                    <?php echo $this->form->getLabel('position'); ?>
                    <?php echo $this->form->getInput('position'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->params->get('field_company_visible')) : ?>
                <div class="mb-3 predefined-field-company">
                    <?php echo $this->form->getLabel('company'); ?>
                    <?php echo $this->form->getInput('company'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->params->get('field_website_visible')) : ?>
                <div class="mb-3 predefined-field-website">
                    <?php echo $this->form->getLabel('website'); ?>
                    <?php echo $this->form->getInput('website'); ?>
                </div>
            <?php endif; ?>
            <?php if ($this->params->get('field_video_visible')) : ?>
                <div class="mb-3 predefined-field-video">
                    <?php echo $this->form->getLabel('video'); ?>
                    <?php echo $this->form->getInput('video'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->params->get('field_vote_visible')) : ?>
                <div class="mb-3 predefined-field-vote">
                    <?php echo $this->form->getLabel('vote'); ?>
                    <?php echo $this->form->getInput('vote'); ?>
                </div>
            <?php endif; ?>
            <?php
            //  echo JHtml::_('bootstrap.startTabSet');
            echo $customfields->render($this);
            // echo JHtml::_('bootstrap.endTab');
            ?>
            <?php if ($this->params->get('field_catid_visible')) : ?>
                <div class="mb-3 predefined-field-category">
                    <?php echo $this->form->getLabel('catid'); ?>
                    <?php echo $this->form->getInput('catid'); ?>
                </div>
            <?php endif; ?>

            <?php if ($user->authorise('core.edit.state', 'com_joomtestimonials')) : ?>
                <div class="mb-3 predefined-field-state">
                    <?php echo $this->form->getLabel('state'); ?>
                    <?php echo $this->form->getInput('state'); ?>
                </div>
            <?php endif; ?>

            <div class="mb-3 predefined-field-testimonial">
                <?php echo $this->form->getLabel('testimonial'); ?>
                <?php echo $this->form->getInput('testimonial'); ?>
            </div>
            <div class="mb-3 predefined-field-captcha">
                <?php echo $this->form->getLabel('captcha'); ?>
                <?php echo $this->form->getInput('captcha'); ?>
            </div>
        </div>

        <div class="d-flex justify-content-between <?php echo $this->isModal ? 'p-3 bg-light fixed-bottom' : '' ?> ">
            <button type="button"
                    class="btn <?= $this->isModal ? 'btn-sm' : '' ?> btn-success <?php echo $this->isModal ? 'float-right' : '' ?>"
                    onclick="Joomla.submitbutton('testimonial.save');">
                <i class="fas fa-paper-plane"></i> <?php echo JText::_('COM_JOOMTESTIMONIALS_SUBMIT'); ?>
            </button>

            <button type="button"
                    class="btn <?= $this->isModal ? 'btn-sm' : '' ?> btn-danger <?php echo $this->isModal ? 'float-left' : '' ?>"
                    onclick="Joomla.submitbutton('testimonial.cancel');">
                <i class="fas fa-times"></i> <?php echo JText::_('COM_JOOMTESTIMONIALS_CANCEL'); ?>
            </button>
        </div>


        <input type="hidden" name="return" value="<?php echo $this->return_page; ?>"/>
        <input type="hidden" name="task" value=""/>
        <input type="hidden" name="t_id" value="<?php echo Factory::getApplication()->input->get('t_id', 0, 'int') ?>"/>
        <input type="hidden" name="isModal" value="<?php echo $this->isModal; ?>"/>
        <input type="hidden" name="isModule" value="<?php echo $this->isModule; ?>"/>
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
