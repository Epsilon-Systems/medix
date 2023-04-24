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

<?php /* Template de message de sucesso. */ ?>
<?php if($resultInsertTestimonial["result"] == true){ ?>
	<div data-id="return-testimonial-success-message" class="alert alert-success" rel="envio_sucesso" >
	    <?php echo $resultInsertTestimonial["message"]; ?>
	    <span class="close" data-dismiss="alert">
	        <span class="fa fa-times-circle"></span>
	    </span>
	</div>
<?php /* Template de message de erro. */ ?>
<?php } else { ?>
	<div data-id="return-testimonial-error-message" class="alert alert-alert" rel="envio_sucesso" >
	    <?php echo $resultInsertTestimonial["message"]; ?>
	    <span class="close" data-dismiss="alert">
	        <span class="fa fa-times-circle"></span>
	    </span>
	</div>
<?php } ?>
