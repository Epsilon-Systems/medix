<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

?>

<div class="testimonials-content testimonials-content--text nb-lg-11 nb-md-11 nb-sm-11 nb-xs-11" data-id-testimonial="<?php echo $testimonial->id; ?>">
    <?php // Veririfa se existe foto. ?>
    
	<?php if($paramsTestimonials->displayPhoto && !empty($testimonial->photo) && $paramsTestimonials->imagePosition != 'bottom') { ?>
		<?php $photo = $testimonial->photo; ?>
		<div class="testimonials-photo testimonials-photo--<?php echo $paramsTestimonials->imagePosition; ?>" style="background-image: url(<?php echo $photo->src_image; ?>); <?php echo $paramsTestimonials->imageStyle; ?> background-size: cover; margin: 0.5em auto;">
		</div>
	<?php } ?>
	<div class="testimonials-content__text">
		<?php // Icone de citação ?>
		<?php if($paramsTestimonials->showQuotes) { ?>
			<i class="fa fa-quote-left" aria-hidden="true" style="<?php echo $paramsTestimonials->quotesStyle; ?>"></i>
		<?php } ?>
		<?php // Veririfa se existe depoimento em texto. ?>
		<?php if(!empty(rtrim($testimonial->text_testimonial))) { 
			echo "<{$paramsTestimonials->testimonialTextTagHtml} class='testimonials-text' style='{$paramsTestimonials->testimonialTextStyle}'>{$testimonial->text_testimonial}</{$paramsTestimonials->testimonialTextTagHtml}>";
		} ?>
		<?php // Icone de citação ?>
		<?php if($paramsTestimonials->showQuotes) { ?>
			<i class="fa fa-quote-right" aria-hidden="true" style="float: right; <?php echo $paramsTestimonials->quotesStyle; ?>"></i>
		<?php } ?>
		<?php // Veririfa se existe foto. ?>
		<?php if($paramsTestimonials->displayPhoto && !empty($testimonial->photo) && $paramsTestimonials->imagePosition == 'bottom') { ?>
			<?php // Exibe foto do autor do depoimento ?>
			<?php require JModuleHelper::getLayoutPath($extensionName, 'common/author_photo');?>
		<?php } ?>
        <?php // Exibe dados do autor do depoimento ?>
		<?php require JModuleHelper::getLayoutPath($extensionName, 'common/author_data');?>	
	</div>
</div>
