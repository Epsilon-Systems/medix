<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\HTML\Helpers\UiTab;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;

$fieldSets   = $this->form->getFieldsets();

JFactory::getDocument()->addScriptDeclaration('
            jQuery(document).ready(function($)
            {
                var type = parent.document.querySelector(".ItemIdHolder");
                if(type.hasAttribute("data-menuid")){
                    $("#id").attr("value" ,type.getAttribute("data-menuid"));
                    $("#type").attr("value" ,"menu");
                }
                if(type.hasAttribute("data-moduleid")){
                    $("#id").attr("value" ,type.getAttribute("data-moduleid"));
                    $("#type").attr("value" , "module");
                }
                              
                var save = parent.document.querySelector("#saveModal");
                $(save).click( function(e){
                    e.preventDefault;
                    SubmitForm(\'testimonials.saveModal\');
                });

                var reset = parent.document.querySelector("#ResetOptions");
                $(reset).click( function(e){
                    e.preventDefault;
                    SubmitForm(\'testimonials.resetOptions\');

                });
            })
');
?>

<script type="text/javascript">
    SubmitForm	= function(task) {
        if (task =='testimonials.saveModal' || task =='testimonials.resetOptions') {
            document.getElementById('taskHolder').setAttribute("value", task);
            document.getElementById("adminForm").submit();
        }
    }
</script>

<form action="<?php echo $this->action; ?>" method="post" name="adminForm" enctype="multipart/form-data" id="adminForm">
    <?php echo UiTab::startTabSet('layout_tabs'); ?>

    <?php echo UiTab::addTab('layout_tabs', 'Information',  Text::_('Information')); ?>
        <?php  echo JLayoutHelper::render('common.form.information',array('layout'=>$this->layout), JPATH_SITE.'/components/com_joomtestimonials/layouts'); ?>
    <?php echo UiTab::endTab(); ?>

    <?php foreach ($fieldSets as $name => $fieldset) : ?>
        <?php echo UiTab::addTab('layout_tabs', $name,  Text::_($fieldset->title)); ?>
            <?php echo $this->form->renderFieldset($name, $options = array()); ?>
        <?php echo UiTab::endTab(); ?>
    <?php endforeach; ?>

    <input type="hidden" name="task" value="" id="taskHolder"/>
    <input type="hidden" name="layout" value="<?php echo $this->layout ?>" />
    <input type="hidden" name="id" value="-1" id="id"/>
    <input type="hidden" name="type" value="" id="type"/>
    <input type="hidden" name="option" value="com_joomtestimonials" />
    <?php  echo JHtml::_('form.token'); ?>

</form>
