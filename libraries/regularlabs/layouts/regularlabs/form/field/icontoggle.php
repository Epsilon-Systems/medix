<?php
/**
 * @package         Regular Labs Library
 * @version         23.3.25449
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://regularlabs.com
 * @copyright       Copyright © 2023 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text as JText;
use RegularLabs\Library\Document as RL_Document;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string $id    DOM id of the field.
 * @var   string $icon1 Icon to show when the field is off.
 * @var   string $icon2 Icon to show when the field is on.
 * @var   string $name  Name of the input field.
 */

RL_Document::useScript('showon');
?>

<fieldset>
    <input type="hidden" name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="0">
    <div data-showon='[{"field":"<?php echo $name; ?>","values":["0"],"sign":"=","op":""}]' class="hidden">
        <span class="icon-<?php echo $icon1; ?>" role="button"
              onclick="el=document.getElementById('<?php echo $id; ?>');el.value = 1;el.dispatchEvent(new Event('change'));"
              aria-label="<?php echo JText::_('JSHOW'); ?>"></span>
    </div>

    <div data-showon='[{"field":"<?php echo $name; ?>","values":["1"],"sign":"=","op":""}]' class="hidden">
        <span class="icon-<?php echo $icon2; ?>" role="button"
              onclick="el=document.getElementById('<?php echo $id; ?>');el.value = 0;el.dispatchEvent(new Event('change'));"
              aria-label="<?php echo JText::_('JHIDE'); ?>"></span>
    </div>
</fieldset>
