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
<script type="text/javascript">
	var jsConfig = {};
	jsConfig = <?php echo json_encode($jsConfig); ?>;
	if (moduleList === undefined) {
		var moduleList = [];
	}
	moduleList["<?php echo $module->name . '_' . $module->id; ?>"] = jsConfig;
</script>
<section <?php echo "module-id={$module->name}_{$module->id}"; ?> style="<?php echo $externalArea->external_area_height; ?><?php echo $sectionStyle; ?> <?php if(!empty($testimonialsBackground)){ echo $testimonialsBackground; }?>"
	class="nobossmodule__section <?php echo "{$module->name} {$module->name}--{$theme}"; ?>  <?php if ($testimonialsBackgroundType == 'background-image'){ echo ' testimonials-banner'; } ?> "> 
    <div 
        class="testimonials app-controller"
        data-callback="testimonials"
        style=" "
    >
	<?php if($externalArea->content_display_mode) { ?>
        <div class="nb-container">
            <div class="<?php echo $itemColumns; ?>">
    <?php } ?>
	<?php // Exibe cabeçalho dos depoimentos ?>
	<?php require JModuleHelper::getLayoutPath($extensionName, 'common/external_area');?>

	<?php // Verifica se existe pelo menos 1 depoimento. ?>
	<?php if(count($testimonials) > 1 && $itemsCustomization->show_arrows != 'none'){ 
		require JModuleHelper::getLayoutPath('mod_nobosstestimonials', 'common/arrows');
	} ?>
	<div class="testimonials-container">
		<div data-list data-autoplaystopped="0" class="testimonials-inner nb-container">
			<?php // Exibe template conforme o tipo do depoimento. 
				$count = 1;
				$arraySize = count($testimonials);
				
				foreach($testimonials as $key => $testimonial){ 
					if($count <= 3 || ($arraySize-1 == $key || $arraySize-2 == $key|| $arraySize-3 == $key)) {
						// Renderiza o html do depoimento em texto no modelo atual
						require JModuleHelper::getLayoutPath('mod_nobosstestimonials', 'theme/' . $theme . '_' . $testimonial->display_type);
					}else{
						require JModuleHelper::getLayoutPath('mod_nobosstestimonials', 'common/testimonial_reference'); 
					}
					$count++;
				} ?>
				
		</div>
		<?php // verifica se os dots devem ser exibidos e inclui o arquivo ?>
		<?php if($itemsCustomization->show_dots){ 
			require JModuleHelper::getLayoutPath('mod_nobosstestimonials', 'common/dots');
		} ?>		
    </div>
     <?php if($externalArea->content_display_mode) { ?>
            </div>
        </div>
    <?php } ?>
     </div>
</section>
