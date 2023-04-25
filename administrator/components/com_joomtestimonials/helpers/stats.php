<?php
/**
 * @package        JoomProject
 * @copyright      2013-2019 JoomBoost, joomboost.com
 * @license        GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

// No direct access
defined('_JEXEC') or die;


class JoomtestimonialsHelperStats
{


	public static function getQuery($query)
	{

		$count = self::getQueryResult($query);

		return self::bdNiceNumber($count);
	}


	/**
	 * Get Projects Stats array
	 *
	 * @return array
	 * @since 1.0
	 */
	public static function getTestiStats()
	{

		// get dates
		$currentDate = JFactory::getDate()->format('Y-m-d');
		$currentYear = JFactory::getDate()->format('Y');
		$now         = JFactory::getDate()->toSql();
		$lastmonth   = JFactory::getDate('now -1 month')->toSql();
		$lastyear    = JFactory::getDate('now -1 year')->format('Y');

		// build wheres
		$todayWhere     = "DATE_FORMAT(created, '%Y-%m-%d') = '$currentDate'";
		$yesterdayWhere = "(created BETWEEN DATE_ADD('$currentDate', INTERVAL -1 day) AND '$currentDate')";
		$thismonthWhere = "(created BETWEEN DATE_SUB('$currentDate',INTERVAL (DAY('$currentDate')-1) DAY) AND LAST_DAY('$now'))";
		$lastmonthWhere = "(created BETWEEN DATE_SUB('$lastmonth',INTERVAL (DAY('$lastmonth')-1) DAY) AND LAST_DAY('$lastmonth')) ";
		$thisyearWhere  = "DATE_FORMAT(created, '%Y') = '$currentYear'";
		$lastyearWhere  = "DATE_FORMAT(created, '%Y') = '$lastyear'";

		// get counts
		$_stats['total']     = self::getCount();
		$_stats['today']     = self::getCount($todayWhere);
		$_stats['yesterday'] = self::getCount($yesterdayWhere);
		$_stats['thismonth'] = self::getCount($thismonthWhere);
		$_stats['lastmonth'] = self::getCount($lastmonthWhere);
		$_stats['thisyear']  = self::getCount($thisyearWhere);
		$_stats['lastyear']  = self::getCount($lastyearWhere);

		// return all stats
		return $_stats;
	}

	private static function getQueryResult($query)
	{

		$db = JFactory::getDbo();

		$db->setQuery($query);
		$db->execute();

		$count = $db->loadResult();

		return $count;


	}


	public static function bdNiceNumber($n)
	{
		// first strip any formatting;
		$n = (0 + str_replace(",", "", $n));

		// is this a number?
		if (!is_numeric($n)) return false;

		// now filter it;
		if ($n > 1000000000000) return round(($n / 1000000000000), 1) . 'T';
		else if ($n > 1000000000) return round(($n / 1000000000), 1) . 'G';
		else if ($n > 1000000) return round(($n / 1000000), 1) . 'M';
		else if ($n > 1000) return round(($n / 1000), 1) . 'K';

		return number_format($n);
	}

	/**
	 * method return counts for a given where and table
	 *
	 * @return int
	 * @since 1.0
	 */
	public static function getCount($where = null, $table = 'joomtestimonials')
	{

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		if (is_null($where))
			$query->select('*')->from("#__$table");
		else
			$query->select('*')->from("#__$table")->where($where);

		$db->setQuery($query)->execute();

		$result = $db->getNumRows();

		$result = self::bdNiceNumber($result);

		return $result;
	}

	public static function getRecent($type,$column='created',$filterByUser = false,$customWhere = null)
	{
		// if user connected from frontend or admin
		$user_id = JFactory::getApplication()->isClient('site') ? (int) JFactory::getUser()->id : null;

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("$column ,DATE_FORMAT($column,{$db->quote('%Y-%m-%d')}) AS date, COUNT(*) AS total");
		$query->from("#__{$type}");
		$query->where("$column > (NOW() - INTERVAL 30 DAY)");

		// filter by user id
		if ($user_id > 0 && !is_null($user_id) && $filterByUser)
		{
			$query->where("user_id ={$user_id}");
		}

		// filter by custom where
		if($customWhere){
            $query->where($customWhere);
        }

		$query->group("DATE_FORMAT($column,{$db->quote('%Y-%m-%d')})");
		$query->order("$column DESC");
		$db->setQuery($query);

		$rows = $db->loadAssocList();

		return $rows;
	}

	public static function getRecently()
	{

		$recently = [];

		$recently['publishedTestimonials'] = [
			'title' => JText::_('COM_JOOMTESTIMONIALS_PUBLISHED_TESTIMONIALS'),
			'data' => self::adaptToLineChart(
			    self::getRecent(
			        'joomtestimonials',
                    'created',
                    false,
				    'state = 1'
                )
            ),
			'color' => 'green'
		];

		$recently['pendingTestimonials'] = [
			'title' => JText::_('COM_JOOMTESTIMONIALS_PENDING_TESTIMONIALS'),
			'data' => self::adaptToLineChart(
			    self::getRecent(
			        'joomtestimonials',
                    'created',
                    false,
				    'state = 0'
			    )
            ),
			'color' => 'red'
		];


		return $recently;

	}

	protected static function adaptToLineChart($data)
	{

		$newData = $return = [];

		// transform array
		foreach ($data as $item){
			if(isset($item['date']) && isset($item['total']))
				$newData[$item['date']] = $item['total'];
		}

		for ($i = 1; $i <= 30; $i++)
		{
			$date = JFactory::getDate('tomorrow')->sub(new DateInterval("P{$i}D"))->format('Y-m-d');
			$return[$date] = array_key_exists($date,$newData) ? (int) $newData[$date] : 0;

		}

		return array_reverse($return);

	}

}
