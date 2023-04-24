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

<?php // Veririfa se existe autor. ?>
<?php if(!empty($testimonial->author_name)) { 
    echo "<{$paramsTestimonials->testimonialAuthorTagHtml} class='testimonials-author-name' style='{$paramsTestimonials->testimonialAuthorStyle}'>{$testimonial->author_name}</{$paramsTestimonials->testimonialAuthorTagHtml}>";
} ?>
<div class="testimonials-personal-data" style="<?php echo $paramsTestimonials->personalDataAlign; ?>">
    <?php // Veririfa se existe email. ?>
    <?php if($paramsTestimonials->displayEmail && !empty($testimonial->email)) { 
        echo "<{$paramsTestimonials->personalDataTagHtml} class='personal-data testimonials-email' style='{$paramsTestimonials->personalDataStyle} display: inline-block;'>{$testimonial->email}</{$paramsTestimonials->personalDataTagHtml}>";
    } ?>
    <?php // Veririfa se exites telefone. ?>
    <?php if($paramsTestimonials->displayTephone && !empty($testimonial->telephone)) { 
        echo "<{$paramsTestimonials->personalDataTagHtml} class='personal-data testimonials-telephone' style='{$paramsTestimonials->personalDataStyle} display: inline-block;'>{$testimonial->telephone}</{$paramsTestimonials->personalDataTagHtml}>";
    } ?>
</div>
<div class="testimonials-profession-data" style="<?php echo $paramsTestimonials->professionalDataAlign; ?>">
    <?php // Verifica se existe profissão.  ?>
    <?php if($paramsTestimonials->displayProfession && !empty($testimonial->profession)) { 
        echo "<{$paramsTestimonials->professionalDataTagHtml} class='profession-data testimonials-profession' style='{$paramsTestimonials->professionalDataStyle} display: inline-block;'>{$testimonial->profession}</{$paramsTestimonials->professionalDataTagHtml}>";
    }; ?>
    <?php // Verifica se existe empresa.  ?>
    <?php if($paramsTestimonials->displayCompany && !empty($testimonial->company)) { 
        echo "<{$paramsTestimonials->professionalDataTagHtml} class='profession-data testimonials-company' style='{$paramsTestimonials->professionalDataStyle} display: inline-block;'>{$testimonial->company}</{$paramsTestimonials->professionalDataTagHtml}>";
    }; ?>
</div>
<div class="testimonials-student-data" style="<?php echo $paramsTestimonials->studentDataAlign; ?>">
    <?php // Verifica se existe curso. ?>
    <?php if($paramsTestimonials->displayCourse && !empty($testimonial->course)) { 
        echo "<{$paramsTestimonials->studentDataTagHtml} class='student-data testimonials-course' style='{$paramsTestimonials->studentDataStyle} display: inline-block;'>{$testimonial->course}</{$paramsTestimonials->studentDataTagHtml}>";
    }; ?>
    <?php // Verifica se existe classe.  ?>
    <?php if($paramsTestimonials->displayClass && !empty($testimonial->class)) { 
        echo "<{$paramsTestimonials->studentDataTagHtml} class='student-data testimonials-class' style='{$paramsTestimonials->studentDataStyle} display: inline-block;'>{$testimonial->class}</{$paramsTestimonials->studentDataTagHtml}>";
    }; ?>
    <?php // Verifica se existe ano de conclusão.  ?>
    <?php if($paramsTestimonials->displayConclusion && !empty($testimonial->conclusion_year)) { 
        echo "<{$paramsTestimonials->studentDataTagHtml} class='student-data testimonials-conclusion-year' style='{$paramsTestimonials->studentDataStyle} display: inline-block;'>{$testimonial->conclusion_year}</{$paramsTestimonials->studentDataTagHtml}>";
    }; ?>
</div>			
