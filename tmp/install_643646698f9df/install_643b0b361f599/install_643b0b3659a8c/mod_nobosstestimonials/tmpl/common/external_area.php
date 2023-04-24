<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2019 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

?>
<?php // carrega arquivo de estilo da area externa ?>
<?php require JModuleHelper::getLayoutPath($extensionName, 'style/external_area');?>
<?php
    // Exibir título 
    if ($showTitle && !empty($title) || $showSubtitle && !empty($subtitle)) { 
?>
        <div class="nb-testimonials-header">
            <?php
                // Exibir título 
                if ($showTitle && !empty($title)) {
                    echo "<{$titleTagHtml} class='testimonials-title' style='{$titleStyle} '>{$title}</{$titleTagHtml}>";
                }
            ?>
            <?php
                // Exibir texto de apoio
                if ($showSubtitle && !empty($subtitle)) {
                    echo "<{$subtitleTagHtml} class='testimonials-subtitle' style='{$subtitleStyle}'>{$subtitle}</{$subtitleTagHtml}>";
                }
            ?>
        </div>
<?php 
    }
?>
