<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

$s = "";

// Estilo dos dots 
if ($showDots) {
    $s .=
        ".{$module->name} .{$module->name}__dots .dot{
            {$dotsStyle}
        }
        .{$module->name} .{$module->name}__dots .dot.active{
            {$dotsActiveStyle}
        }
    ";
}

$assetsObject->addStyleWithPrefix($s);

?>
