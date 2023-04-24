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

<div class="testimonials-content testimonials-content--video nb-lg-10 nb-md-10 nb-sm-10 nb-xs-12" data-id-testimonial="<?php echo $testimonial->id; ?>">
	<div class="nb-embed-container nb-lg-10 nb-md-10 nb-sm-10 nb-xs-10">
  	  <div class="nb-embed-responsive ">
            <!-- <div class="nb-embed-responsive" 
            data-video-id="<?php //echo $testimonial->video_id; ?>" 
            style="background-image: url(https://img.youtube.com/vi/<?php //echo $testimonial->video_id?>/0.jpg);"
            > -->
			<?php // carrega iframe para exibir o video do depoimento ?>
  	    	<iframe
				src="https://www.youtube.com/embed/<?php echo $testimonial->video_id; ?>?controls=2&theme=light"
  				frameborder="0"
                allowfullscreen>
  			</iframe>
  		</div>
		<?php // Exibe dados do autor do depoimento ?>
		<?php require JModuleHelper::getLayoutPath($extensionName, 'common/author_data');?>	
    </div>	
</div>
