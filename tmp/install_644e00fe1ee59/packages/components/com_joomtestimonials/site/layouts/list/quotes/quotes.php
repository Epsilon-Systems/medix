<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;
extract($displayData);

$user = JFactory::getUser();
$canCreate = JtAuhtoriseHelper::canCreate();
$canEdit   = JtAuhtoriseHelper::canEdit($user->id);

if ($canCreate || $canEdit) {
    JHtml::_('bootstrap.renderModal', 'a.testi-modal');
}

$layoutparams = LayoutHelper::getListLayoutParams()->get('layoutparams');
$type   = $layoutparams->get('list_type', 'item-normal');
$app = JFactory::getApplication();
$isModule =   $app->input->get('jt_modules_call_for_params', false);
?>

    <?php if(!$isModule)  :?>
    <div class="testimonialsContainer mt-2" id="testimonialsContainer">
        <div class='testiList row <?php echo isset($gutter) ? $gutter : '';?> w-100'>
    <?php endif ;?>
            <?php foreach ($items AS $item){?>
                <div class="<?php echo isset($cspan)?$cspan:'';?>">
                    <?php
                    // load testimonial item layout
                    echo JLayoutHelper::render('list.'.$layout.'.'.$type, array(
                        'item' => $item,
                    ),
                    $basePath = JPATH_SITE.'/components/com_joomtestimonials/layouts'
                    );
                    ?>
                </div>
            <?php } //end of videos loops ?>
    <?php if(!$isModule)  :?>
        </div>
    </div>
    <?php endif ;?>
