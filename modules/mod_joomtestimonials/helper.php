<?php
/**
 * @copyright      Copyright (c) 2013 - 2016 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license        http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

/**
 * JoomTestimonials Helper Class.
 *
 * @package        Joomla.Site
 * @subpakage      JoomLa.JoomTestimonials
 */
class modJoomtestimonialsHelper
{

	public static function getVoteLayout($number, $params)
	{

		$icolor = $params->get('inactivestar_color', '#d2d2d2');
		$acolor = $params->get('activestar_color', '#edb867');


		$style = '
			span.joomstar:after {
    			content: "\2605";
    			color: ' . $icolor . ';
				font-size: 20px;
			}
    					
			span.joomstar.joomactivestar:after{
				color: ' . $acolor . ';
			}
		';

		JFactory::getDocument()->addStyleDeclaration($style);

		$number = (int) $number;

		$vote = '<div class="joomstars">';

		for ($x = 1; $x <= $number; $x++)
		{
			$vote .= '<span class="joomstar joomactivestar"></span>';
		}

		while ($x <= 5)
		{
			$vote .= '<span class="joomstar joominactivestar"></span>';
			$x++;
		}

		$vote .= '</div>';

		return $vote;


	}

	public static function getItems($params)
	{
		JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_joomtestimonials/models');

		// Get an instance of the generic articles model
		$model     = JModelLegacy::getInstance('Testimonials', 'JoomtestimonialsModel', array('ignore_request' => true));
		$list_main = (array) $params->get('layoutparams')->get('list_main');

		// Set the filters based on the module params
		$model->setState('list.start', 0);

		$list_limit = isset($list_main['list_limit']) ? $list_main['list_limit'] : JFactory::getConfig()->get('list_limit');
		$model->setState('list.limit', (int) $list_limit);

		$model->setState('filter.state', 1);
		$model->setState('filter.archived', 0);

		// filter by category or id
		$source = $params->get('source');

		if ($source)
		{
			$ids = explode(',', $params->get('ids'));
			$model->setState('filter.testimonial_id', $ids);
		}
		else
		{
			$catids = $params->get('catids',[]);


			$model->setState('filter.category_id', $catids);
		}

		// order
		$Orderby = isset($list_main['orderby']) ? $list_main['orderby'] : 'rdate';
		$orderby = self::getOrderBy($Orderby);

		$model->setState('list.ordering', $orderby);
		$model->setState('list.direction', '');

		$model->setState('list.select', 'a.*');

		// Filter by language
		$model->setState('filter.language', JFactory::getApplication()->getLanguageFilter());

		$items = $model->getItems();

		return $items;
	}

	protected static function getOrderBy($orderby = 'rdate')
	{
		switch ($orderby)
		{
			case 'date':
				$orderby = 'a.created';
				break;

			case 'rdate':
				$orderby = 'a.created DESC ';
				break;

			case 'rand':
				$orderby = 'RAND()';
				break;

			case 'order':
			default :
				$orderby = 'c.lft, a.ordering';
				break;
		}

		return $orderby;
	}
}