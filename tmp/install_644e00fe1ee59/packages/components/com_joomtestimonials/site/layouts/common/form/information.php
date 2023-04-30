<?php
/*8
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Form\Form;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

extract($displayData);

$path_to_xml = JPATH_SITE . '/components/com_joomtestimonials/layouts/list';
$xml = new SimpleXMLElement($path_to_xml .'/'. $layout .'/'. $layout . '.xml', $options = 0, $data_is_url = true);
$form = new Form('myLayoutForm');
$form->load($xml);
$data = $form->getXml();

?>
    <div class="row shadow-sm">
        <?php $link = 'media/com_joomtestimonials/list/'.$layout.'/'.$layout.'.jpg';?>
        <div class="col" >
            <img src="<?php echo $link ? JHtml::_('image', $link, 'img', null, false, true) : ''; ?>" style="max-width: 100%;"/>
        </div>

        <div class="col">
            <table class="table table-borderless">
                <tr>
                    <th scope="row"><?php echo Text::_('Title :'); ?></th>
                    <td><?php echo $data->name ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo Text::_('Version :'); ?></th>
                    <td><?php echo $data->version ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo Text::_('Creation date :'); ?></th>
                    <td><?php echo $data->creationDate ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo Text::_('Autor :'); ?></th>
                    <td><?php echo $data->author ?></td>
                </tr>
                <tr>
                    <th scope="row"><?php echo Text::_('Link :'); ?></th>
                    <td><a href="<?php echo $data->authorUrl ?>"><?php echo $data->authorUrl ?></a></td>
                </tr>
                <tr>
                    <td colspan="2" scope="row">
                        <span style="font-weight: bold"><?php echo Text::_('Description :'); ?></span><br>
                        <?php echo $data->description ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <br>

