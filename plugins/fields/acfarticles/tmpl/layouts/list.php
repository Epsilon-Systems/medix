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

use Joomla\Component\Content\Site\Helper\RouteHelper;

$html .= '<ul>';

foreach ($articles as $article)
{
	$html .= '<li><a href="' . JRoute::_(RouteHelper::getArticleRoute($article['id'], $article['catid'], $article['language'])) . '">' . $article['title'] . '</a></li>';
}

$html .= '</ul>';