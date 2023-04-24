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

<?php $photo = $testimonial->photo; ?>
<div class="testimonials-photo testimonials-photo--<?php echo $paramsTestimonials->imagePosition; ?>" style="background-image: url(<?php echo $photo->src_image; ?>); <?php echo $paramsTestimonials->imageStyle; ?> background-size: cover; margin: 0 auto 1em;"></div>
