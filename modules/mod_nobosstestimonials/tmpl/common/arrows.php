<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

require JModuleHelper::getLayoutPath($extensionName, 'style/arrows');

?>
<?php // arquivo em comum para exibicao as setas ?>
<a data-navigation-direction="left" class="nb-arrows nb-arrows--<?php echo $itemsCustomization->show_arrows; ?> testimonials-controls left nb-testimonials__prev js_prev prev" href="#" data-slide="prev" role="button" title="<?php echo JText::_("MOD_NOBOSSTESTIMONIALS_GO_TO_PREVIOUS"); ?>" style="<?php echo $arrowsIconSize; ?>">
    <span class="fa <?php echo (!empty($itemsCustomization->arrows_icon)) ? $itemsCustomization->arrows_icon . '-left' : '';  ?>" style="<?php echo $arrowsStyle; ?> <?php echo $arrowsBorderRadius; ?>">
    </span>
    <span class="sr-only"><?php echo JText::_("MOD_NOBOSSTESTIMONIALS_GO_TO_PREVIOUS"); ?></span>
</a>
<a data-navigation-direction="right"  class="nb-arrows nb-arrows--<?php echo $itemsCustomization->show_arrows; ?> testimonials-controls right testimonials__next js_next next" href="#" data-slide="next" role="button" title="<?php echo JText::_("MOD_NOBOSSTESTIMONIALS_GO_TO_NEXT"); ?>" style="<?php echo $arrowsIconSize; ?>">
    <span class="fa <?php echo (!empty($itemsCustomization->arrows_icon)) ?  $itemsCustomization->arrows_icon . '-right' : '';  ?>" style="<?php echo $arrowsStyle; ?> <?php echo $arrowsBorderRadius; ?>">
    </span>
    <span class="sr-only"><?php echo JText::_("MOD_NOBOSSTESTIMONIALS_GO_TO_NEXT"); ?></span>
</a>
