<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

//JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidator');
JHtml::_('jquery.framework');
?>

<script type="text/javascript">
	Joomla.submitbutton	= function(task) {
		if (task == 'testimonial.cancel' || document.formvalidator.isValid(document.getElementById('testimonial-form'))) {
			<?php // echo $this->form->getField('testimonial')->save(); ?>
			Joomla.submitform(task, document.getElementById('testimonial-form'));
		} else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_joomtestimonials&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="testimonial-form" class="form-validate">
        <div class="row">
            <div class="col-md-10 form-horizontal">
                <fieldset>
                    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
                        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', empty($this->item->id) ? JText::_('COM_JOOMTESTIMONIALS_TESTIMONIAL_NEW') : JText::sprintf('COM_JOOMTESTIMONIALS_TESTIMONIAL_EDIT', $this->item->id)); ?>
                            <div class="row-fluid testiFields mt-3">
                                    <div class="control-group col-md-6 d-flex align-items-center">
                                        <div class="col-md-4"><?php echo $this->form->getLabel('name'); ?></div>
                                        <div class="controls col-md-4"><?php echo $this->form->getInput('name'); ?></div>
                                    </div>
                                    <div class="control-group col-md-6">
                                        <div class="col-md-4"><?php echo $this->form->getLabel('avatar'); ?></div>
                                        <div class="controls"><?php echo $this->form->getInput('avatar'); ?></div>
                                    </div>
                                    <div class="control-group col-md-6 d-flex align-items-center">
                                        <div class="col-md-4"><?php echo $this->form->getLabel('email'); ?></div>
                                        <div class="controls"><?php echo $this->form->getInput('email'); ?></div>
                                    </div>
                                    <div class="control-group col-md-6 d-flex align-items-center">
                                        <div class="col-md-4"> <?php echo $this->form->getLabel('position'); ?></div>
                                        <div class="controls"><?php echo $this->form->getInput('position'); ?></div>
                                    </div>
                                    <div class="control-group col-md-6 d-flex align-items-center">
                                        <div class="col-md-4"><?php echo $this->form->getLabel('company'); ?></div>
                                        <div class="controls"><?php echo $this->form->getInput('company'); ?></div>
                                    </div>
                                    <div class="control-group col-md-6 d-flex align-items-center">
                                        <div class="col-md-4"><?php echo $this->form->getLabel('website'); ?></div>
                                        <div class="controls"><?php echo $this->form->getInput('website'); ?></div>
                                    </div>
                                     <div class="control-group col-md-6 d-flex align-items-center">
                                         <div class="col-md-4"><?php echo $this->form->getLabel('video'); ?></div>
                                    <div class="controls"><?php echo $this->form->getInput('video'); ?></div>
                                     </div>
                                    <div class="control-group col-md-6 d-flex align-items-center">
                                        <div class="col-md-4"><?php echo $this->form->getLabel('vote'); ?></div>
                                        <div class="controls"><?php echo $this->form->getInput('vote'); ?></div>
                                    </div>
                            </div>

                            <div class="control-group">
                                <div class="col-md-2"><?php echo $this->form->getLabel('testimonial'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('testimonial'); ?></div>
                            </div>
                        <?php echo JHtml::_('bootstrap.endTab'); ?>


                        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
                            <div class="control-group">
                                <?php echo $this->form->getLabel('alias'); ?>
                                <div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
                            </div>
                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('id'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
                            </div>
                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('created_by'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
                            </div>
                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('created_by_alias'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('created_by_alias'); ?></div>
                            </div>
                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('created'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('created'); ?></div>
                            </div>
                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('modified_by'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
                            </div>
                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('modified'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
                            </div>

                            <div class="control-group col-md-6 d-flex align-items-center">
                                <div class="col-md-4"><?php echo $this->form->getLabel('ip'); ?></div>
                                <div class="controls"><?php echo $this->form->getInput('ip'); ?></div>
                            </div>
                        <?php echo JHtml::_('bootstrap.endTab'); ?>
                    <?php $this->ignore_fieldsets = array('testimonial', 'publishing'); ?>
                    <?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>
                        <?php $fieldSets = $this->form->getFieldsets('params'); ?>
                        <?php foreach ($fieldSets as $name => $fieldSet) : ?>
                            <?php $paramstabs = 'params-' . $name; ?>
                            <?php echo JHtml::_('bootstrap.addTab', 'myTab', $paramstabs, JText::_($fieldSet->label, true)); ?>
                                <?php echo $this->loadTemplate('params'); ?>
                            <?php echo JHtml::_('bootstrap.endTab'); ?>
                        <?php endforeach; ?>
                    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
                </fieldset>
            </div>
            <div class="col-md-2">
                <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
            </div>
	    </div>

	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo JFactory::getApplication()->input->getCmd('return');?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php
echo JoomtestimonialsFactory::getFooter();