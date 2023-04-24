<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2019 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

// Chama biblioteca do Jquery do Joomla.
JHtml::_('jquery.framework');
// Chama script de "user interface" do Joomla.
JHtml::_('script', 'jui/cms.js', false, true);
//adiciona o arquivo de helper
require_once dirname(__FILE__ . '/helper.php');

?>
<script>
    <?php /* Estrutura HTML das mensagens de erro */ ?>
    var htmlErrorMessageMandatoryField = '<div class="alert alert-danger">'+"<?php echo JText::_("MOD_NOBOSSTESTIMONIALS_MESSAGE_MANDATORY_FIELD");?>"+'</div>';
    var htmlErrorMessageInvalidField = '<div class="alert alert-danger">'+"<?php echo JText::_("MOD_NOBOSSTESTIMONIALS_MESSAGE_INVALIDO_FIELD");?>"+'</div>';
    
    </script>


<section 
    <?php echo "module-id={$module->name}_{$module->id}"; ?>
    class="nobossmodule__section <?php echo "{$module->name}"; ?> <?php echo "{$module->name}"; ?>--model1 app-controller"
    data-callback="testimonialsSubmission"
    style="<?php echo $sectionStyle; ?>"
>
    <?php if($submissionForm->content_display_mode) { ?>
        <div class="nb-container">
            <div class="<?php echo $itemColumns; ?>">
    <?php } ?>
    <?php
        // Exibir título 
        if ($headerTitle->show_title && !empty($headerTitle->title) || $headerSubtitle->show_subtitle && !empty($headerSubtitle->subtitle)) {
    ?>
            <div class="nb-testimonials-header">
                <?php
                    // Exibir título 
                    if ($headerTitle->show_title && !empty($headerTitle->title)) {
                        echo "<{$headerTitle->title_tag_html} class='testimonials-title' style='{$headerTitle->style}'>{$headerTitle->title}</{$headerTitle->title_tag_html}>";
                    }
                ?>
                <?php
                    // Exibir texto de apoio
                    if ($headerSubtitle->show_subtitle && !empty($headerSubtitle->subtitle)) {
                        echo "<{$headerSubtitle->subtitle_tag_html} class='testimonials-subtitle' style='{$headerSubtitle->style}'>{$headerSubtitle->subtitle}</{$headerSubtitle->subtitle_tag_html}>";
                    }
                ?>
            </div>
    <?php } ?>
        <?php /* Verifica se foi configurado para exibir título no módulo e se não é vazio. */ ?>
        <div data-id="testimonial-submission-form-<?php echo $moduleId; ?>" id="testimonial-form" class="testimonial-base-form testimonial-submission-form--<?php echo $submissionForm->columns; ?>">
            <div class="testimonial-form-box">
                <form data-id="form-data-testimonial-submission-<?php echo $moduleId; ?>" class="testimonial-form testimonial-label--<?php echo $submissionForm->label_alignment; ?>" method="post">
                    <?php  /* Percorre todos os campos. */ ?>
                    <?php foreach ($testimonial as $keyField => $field){
                        
                        if($keyField == "photo"){
                            $field->description = $descriptionPhoto;
                        } 
                        // Se a chave do campo tem o prefixo "section_"
                        if(strpos($keyField, "section_title") === 0){
                            echo "<div class='testimonial-header-section testimonial-header-title'>";
                            echo "<{$sectionsTitle->title_tag_html} class='testimonial-section-title' style='{$sectionsTitle->style}'>{$field}</{$sectionsTitle->title_tag_html}>";
                            echo "</div>";
                            continue;
                        }
    
                        $group = ModNobossTestimonialSubmissionHelper::getTestimonialsGroup($moduleId);
                        $groupId = $group->id_testimonials_group;
                        if(gettype($field) != "string"){
    
                            if($field->getAttribute("type") == "textcounter"){
                                $field->__set('group_id', $groupId);
                            }
                        }
                       
                        // Se a chave do campo tem o prefixo "section_"
                        if(strpos($keyField, "section_subtitle") === 0){
                            echo "<div class='testimonial-header-section testimonial-header-subtitle'>";
                            echo "<{$sectionsSubtitle->subtitle_tag_html} class='testimonial-section-subtitle' style='{$sectionsSubtitle->style}'>{$field}</{$sectionsSubtitle->subtitle_tag_html}>";
                            echo "</div>";
                            continue;
                        }

                        // verifica se é um campo de licenca para pular a exibicao dele
                        if($field->getAttribute("type") == "nobosslicense"){
                            continue;
                        }

                        // verifica se é um campo de arquivo css ou js para pular a exibicao dele
                        if($field->getAttribute("type") == "nobossrequestjscss"){
                            continue;
                        }
    
                        // Se apenas os placeholders devem ser exibidos, seta a propria label como placeholder
                        if($submissionForm->show_label_and_placeholder == 'placeholder'){
                            $field->__set('hint', $field->getAttribute('label'));
                        }
                        
                        // Se apenas as labels devem ser exibidas, limpa o valor que estava setado como placeholder
                        if($submissionForm->show_label_and_placeholder == 'label'){
                            $field->__set('hint', '');
                        }
    
                        // Renderiza o campo.
                        echo $field->renderField(
                            array(
                                "type" => $field->getAttribute("type"),
                                "class" => $field->getAttribute("type"),
                                "hiddenLabel" => $submissionForm->show_label_and_placeholder == 'placeholder'
                            )
                        );
                    }?>
                    <div class="control-group nb-checkbox">
                        <input type="checkbox" name="authorize-testimonial" id="authorize-testimonial-<?php echo $moduleId; ?>" value="0">
                        <label id="authorize-testimonial-<?php echo $moduleId; ?>-lbl" for="authorize-testimonial-<?php echo $moduleId; ?>" class="">
                            <?php echo $messageAuthorizeTestimonial ?>
                        </label>
                    </div>
                    <div class="testimonial-form-footer">
                        <button type="submit" data-id="send-testimonial-<?php echo $moduleId; ?>" style="<?php echo $submissionForm->buttons_position; ?>">
                            <?php echo JText::_("COM_NOBOSSTESTIMONIALS_submission_SEND_FORM_BUTTON_LABEL"); ?>
                        </button>
                    </div>
                    <input type="hidden" name="idModule" data-id="id-module" value="<?php echo $moduleId; ?>">
                </form>
            </div>
        </div>
    <?php if($submissionForm->content_display_mode) { ?>
            </div>
        </div>
    <?php } ?>
</section>
<script>
    <?php // Remove as classes hasPopover que abriam o tooltip nas labels  ?>
    jQuery(".hasPopover").removeClass("hasPopover");
</script>
