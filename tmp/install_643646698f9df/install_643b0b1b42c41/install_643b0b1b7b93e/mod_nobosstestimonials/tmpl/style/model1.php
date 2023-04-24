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

if($testimonialsBackgroundType == "background-image" && !empty($backgroundImageSrc) && $testimonialsFilter){
    $s .=
    ".{$module->name}:before {
        content: '';
        {$testimonialsBackgroundColor}            
    }";
}

$s .= 
"@media screen and (max-width: 767px){";
    $s .=
    ".{$module->name}{
        {$sectionStyleMobile}
    }
    .{$module->name}{
        {$externalArea->external_area_height_mobile}
    }
    ";

    $s .=
    ".{$module->name} .testimonials-content__text .testimonials-text{
        {$paramsTestimonials->testimonialTextStyleMobile}
    }";
$s .= "}";

$assetsObject->addStyleWithPrefix($s);

?>



