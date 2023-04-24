<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Testimonials
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2018 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

require JModuleHelper::getLayoutPath($extensionName, 'style/dots');

?>
<?php // arquivo em comum para exibicao dos dots (pontos de navegacao) ?>
<div data-id="nb-nav-dots" class="<?php echo $module->name; ?>__dots noboss-nav-dots <?php echo $module->name.'_'.$module->id.'--dots' ?> "></div>
