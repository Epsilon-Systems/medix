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

$s .=
".{$module->name} .testimonial-form .file-upload-context .simple-link:before{
    color: {$submissionForm->buttons_text_color};
}
.{$module->name} .testimonial-form .tooltip-image:after{
    border-top: 8px solid {$submissionForm->buttons_background_color};
}
.{$module->name} .testimonial-form input[type=checkbox]+label:before, .{$module->name} .testimonial-form .file-upload-context .simple-link:before{
    color: {$submissionForm->checkboxColor};
}
.{$module->name} [type=submit],
.{$module->name} .file-upload,
.{$module->name} .tooltip-image{
    {$submissionForm->buttonStyle}
}
.{$module->name} .tooltip-image{
    padding: 7px;
}
.{$module->name} [type=submit]:hover,
.{$module->name} .file-upload:hover {
    {$submissionForm->buttonStyleHover}
}
.{$module->name} [type=submit]:disabled, .{$module->name} [type=submit]:hover:disabled {
    background-color: #ccc !important;
    color: #696969 !important; 
    border: {$submissionForm->inputs_border_size}px solid transparent !important;
}
.{$module->name} .list select,
.{$module->name} [type=text],
.{$module->name} [type=email],
.{$module->name} [type=tel],
.{$module->name} [type=number],
.{$module->name} [type=password],
.{$module->name} select,
.{$module->name} textarea {
    {$submissionForm->inputStyle}
    {$submissionForm->borderStyle}
    max-width: initial;
}
.{$module->name} input:focus:invalid:focus,
.{$module->name} textarea:focus:invalid:focus,
.{$module->name} select:focus:invalid:focus{
    {$submissionForm->borderStyle}
}
.{$module->name} .nobosstextcounter-wrapper,
.{$module->name} .testimonial-form .nb-checkbox label{
    {$submissionForm->inputStyle}
    background-color: transparent;
}
.{$module->name} .control-group{
   color: {$submissionForm->inputs_text_color};
}";

if($submissionForm->show_label_and_placeholder == 'label' || $submissionForm->show_label_and_placeholder == 'both'){
    $s .=
    ".{$module->name} .control-label label{
        {$submissionForm->labelStyle}
    }";
}

$s .=
    "@media screen and (max-width: 767px){
        .{$module->name}{
            {$sectionStyleMobile}
        }

        .{$module->name} .testimonials-title{
            {$headerTitleStyleMobile}
        }

        .{$module->name} .testimonials-subtitle{
            {$headerSubitleStyleMobile}
        }

        .{$module->name} .testimonial-section-title{
            {$sectionTitleStyleMobile}
        }

        .{$module->name} .testimonial-section-subtitle{
            {$sectionSubtitleStyleMobile}
        }
        ";
$s .= "}";

$assetsObject->addStyleWithPrefix($s);

?>
