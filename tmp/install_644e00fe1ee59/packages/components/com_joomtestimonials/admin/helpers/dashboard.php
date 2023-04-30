<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die;

JLoader::register('JoomtestimonialsHelperStats',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/stats.php');

JLoader::register('JoomtestimonialsHelperVersion',JPATH_ADMINISTRATOR.'/components/com_joomtestimonials/helpers/version.php');


class JoomtestimonialsHelperDashboard
{

	public static function addBadges($stats){

		foreach ($stats as &$stat){
			if($stat == 0)
				$stat = "<span class='badge bg-secondary'>$stat</span>";
			else
				$stat = "<span class='badge bg-success'>$stat</span>";
		}

		return $stats;

	}

	static public function getLeftWidgets(){

		//inits
		$leftWidgets = [];
		$recently = JoomtestimonialsHelperStats::getRecently();

		// recent bookings graph
		$leftWidgets[] = [
			'title'       => 'COM_JOOMTESTIMONIALS_GRAPH_RECENTLY',
			'icon'        => 'chart-line',
			'bodyContent' => JLayoutHelper::render('dashboard.recently', ['recent' => $recently])
		];


		if(JFactory::getUser()->authorise('core.admin'))
		{
			// only super user can see update widget
			// left widgets
			$leftWidgets[] = [
				'title'       => 'COM_JOOMTESTIMONIALS_CONFIGURATION',
				'icon'        => 'list',
				'bodyContent' => JLayoutHelper::render('dashboard.config'),
			];

			$leftWidgets[] = [
				'title'       => 'COM_JOOMTESTIMONIALS_PRODUCT_INFO',
				'icon'        => 'info',
				'bodyContent' => JLayoutHelper::render('dashboard.productInfo'),
			];

			$leftWidgets[] = [
				'title'       => 'COM_JOOMTESTIMONIALS_FOLLOWUS',
				'icon'        => 'share',
				'bodyContent' => JLayoutHelper::render('dashboard.socialLinks'),
			];
		}



		$leftWidgets[] = [
			'bodyContent' => JLayoutHelper::render('dashboard.copyright'),
		];



		return $leftWidgets;
	}



	static public function getRightWidgets(){

		// inits
		$rightWidgets = [];


		$testiStats = JoomtestimonialsHelperStats::getTestiStats();

		$rightWidgets[] = [
			'title'       => 'COM_JOOMTESTIMONIALS_TESTIMONIALS_STATS',
			'icon'        => 'chart-bar',
			'bodyContent' => JLayoutHelper::render('dashboard.tableStats', ['stats' => $testiStats])

		];

		if(JFactory::getUser()->authorise('core.admin')){ // only super user can see joomboost company social widgets

			$rightWidgets[] = [
				'bodyContent' => JLayoutHelper::render('dashboard.facebookPage')
			];

			$rightWidgets[] = [
				'bodyContent' => JLayoutHelper::render('dashboard.twitterFollow')
			];


		}

		return $rightWidgets;

	}


	static public function getCountCards(){

        // Total Testimonials
        $buttons[] = array(
            'title' => 'COM_JOOMTESTIMONIALS_DASHBOARD_TESTIMONIALS',
            'link'  => 'index.php?option=com_joomtestimonials&view=testimonials',
            'iconName' => 'list', // for count card
            'iconClass' => 'bg-primary text-white', // for count card
            'countClass' => 'text-primary', // for count card
            'count' => JoomtestimonialsHelperStats::getCount(null,'joomtestimonials')
        );

		// Total Categories
		$buttons[] = array(
			'title' => 'COM_JOOMTESTIMONIALS_DASHBOARD_CATEGORIES',
			'link'  => 'index.php?option=com_categories&extension=com_joomtestimonials',
			'iconName' => 'folder-open', // for count card
			'iconClass' => 'bg-warning text-white', // for count card
			'countClass' => 'text-warning', // for count card
			'count' => JoomtestimonialsHelperStats::getCount('extension = "com_joomtestimonials"','categories')
		);

		// Total Custom Fields
		$buttons[] = array(
			'title' => 'COM_JOOMTESTIMONIALS_DASHBOARD_CUSTOM_FIELDS',
			'link'  => 'index.php?option=com_fields&context=com_joomtestimonials.testimonial',
			'iconName' => 'cubes', // for count card
			'iconClass' => 'bg-danger text-white', // for count card
			'countClass' => 'text-danger', // for count card
			'count' => JoomtestimonialsHelperStats::getCount('context = "com_joomtestimonials.testimonial"','fields')
		);




		return $buttons;
	}




	static public function getSkeleton(){
		return JLayoutHelper::render(
			'dashboard.skeleton.container',
			[
				'counts' => self::getCountCards(),
				'left'   => self::getLeftWidgets(),
				'right'  => self::getRightWidgets()
			]
		);
	}


}