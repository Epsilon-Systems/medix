<?php
/**
 * @copyright	Copyright (c) 2013-2019 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

$layoutparams      = $this->params->get('layoutparams');

$data = array(
    'items' => $this->items,
    'cspan' => $this->cspan,
    'layout'=> $this->layout,
    'gutter'=>$this->gutter
);

?>

<div id="jb_template">
    <div id="jt-menu">
        <div class="defaultTestimonials <?php echo $this->pageclass_sfx;?>">
            <!--  load layout header -->
            <?php echo $this->myLayouts['header']->render(array(
                'hideHeader' => $this->hide_header,
                'showSubmitButton'=>$this->show_submit_button
            )) ?>

            <!--  load list layout  -->
            <?php echo JLayoutHelper::render('list.'.$this->layout.'.'.$this->layout.$this->animated, $data); ?>

            <!-- laod pagination layout  -->
            <?php  echo $this->myLayouts['pagination']->render(array(
                'pagination' => $this->pagination,
            )) ?>
        </div>
    </div>
</div>



