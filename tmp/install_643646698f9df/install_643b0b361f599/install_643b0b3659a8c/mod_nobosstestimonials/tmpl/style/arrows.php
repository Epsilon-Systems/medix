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

if ($showBackgroundArrows){
    $s .=
    ".{$module->name} .testimonials-controls:hover span{
        background-color: {$arrowsBackgroundHoverColor} !important;
    }";
}

if($showArrows){
    $s .= "
    @media screen and (max-width: 767px){
        .{$module->name} .nb-arrows{
            {$arrowsStyleMobile}
        }
    }";
}

$assetsObject->addStyleWithPrefix($s);

?>
