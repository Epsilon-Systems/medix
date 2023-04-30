<?php

/**
 * @package         Advanced Custom Fields
 * @version         2.4.0 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2023 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die;

if (!$articles = $field->value)
{
	return;
}

// Get the layout
$layout = $fieldParams->get('layout', 'media/plg_fields_acfarticles/img/alist.svg');
$layout = str_replace(['media/plg_fields_acfarticles/img/', '.svg'], '', $layout);
$layout = ltrim($layout, 'a');
$customLayout = $fieldParams->get('custom_layout', '');

if ($layout === 'custom' && !$customLayout)
{
    return;
}

use Joomla\Component\Content\Site\Helper\RouteHelper;

$id  = 'acf_articles_' . $item->id . '_' . $field->id;

// Set the wrapper classes
$classes = [];
$classes[] = $id;
$classes[] = 'layout-' . $layout;

if (in_array($layout, ['stylea', 'styleb']))
{
    $classes[] = 'layout-grid';
}

// Set columns and gap
if (in_array($layout, ['stylea', 'styleb']))
{
    // Get columns and gap
    $columns = $fieldParams->get('devices_columns.columns', []);
    $gap = $fieldParams->get('devices_gap.gap', []);
    
	JFactory::getDocument()->addStyleDeclaration('
		.acfarticles-field-wrapper.' . $id . ' {
			--columns: ' . $columns['desktop'] . ';
			--gap: ' . $gap['desktop'] . 'px;
		}

        @media only screen and (max-width: 991px) {
            .acfarticles-field-wrapper.' . $id . ' {
                --columns: ' . $columns['tablet'] . ';
                --gap: ' . $gap['tablet'] . 'px;
            }
        }

        @media only screen and (max-width: 575px) {
            .acfarticles-field-wrapper.' . $id . ' {
                --columns: ' . $columns['mobile'] . ';
                --gap: ' . $gap['mobile'] . 'px;
            }
        }
	');
}

$html = '<div class="acfarticles-field-wrapper ' . implode(' ', $classes) . '">';

$path = __DIR__ . '/layouts/' . $layout . '.php';
if (file_exists($path))
{
    require $path;
}

$html .= '</div>';

echo $html;