<?php

/**
 * @package         Convert Forms
 * @version         4.0.2 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2020 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace ConvertForms\Field;

defined('_JEXEC') or die('Restricted access');

use ConvertForms\Validate;

class Password extends \ConvertForms\Field
{
	protected $inheritInputLayout = 'text';
}

?>