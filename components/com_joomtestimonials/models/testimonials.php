<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\Utilities\ArrayHelper;

defined('_JEXEC') or die;

/**
 * Methods supporting a list of Testtimonial records.
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.Joomtestimonials
 */
class JoomtestimonialsModelTestimonials extends JModelList {

    /**
     * Constructor.
     *
     * @param	array	An optional associative array of configuration settings.
     * @see		JControllerLegacy
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'title', 'a.title',
                'alias', 'a.alias',
                'checked_out', 'a.checked_out',
                'checked_out_time', 'a.checked_out_time',
                'catid', 'a.catid', 'category_title',
                'state', 'a.state',
                'access', 'a.access', 'access_level',
                'created', 'a.created',
                'created_by', 'a.created_by',
                'ordering', 'a.ordering',
                'language', 'a.language',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialize variables.
        $app = JFactory::getApplication();

        // Global params
        $params		= LayoutHelper::getListLayoutParams();
        $list_main = (array)$params->get('layoutparams')->get('list_main');
        if(!isset($list_main['list_limit'])){
            $list_main['list_limit'] = JFactory::getConfig()->get('list_limit');
        }
        // List state information
        $value = $app->input->get('limit', $list_main['list_limit'], 'uint');
        $this->setState('list.limit', $value);

        $value = $app->input->get('limitstart', 0, 'uint');
        $this->setState('list.start', $value);

        $orderCol = $this->_buildContentOrderBy();
        $this->setState('list.ordering', $orderCol);
        $this->setState('list.direction', '');
        $catid	= $app->input->get('catid', 0, 'uint');

        // get cat is
        $menu = \Joomla\CMS\Factory::getApplication()->getMenu()->getActive();

        $catids = isset($menu->query['catids']) ? $menu->query['catids'] : $params->get('catids');

        if ($catid) {
            $this->setState('filter.category_id', $catid);
        } else {
            $this->setState('filter.category_id', $catids);
        }

        // process show_noauth parameter
        if (!$params->get('show_noauth')) {
            $this->setState('filter.access', true);
        } else {
            $this->setState('filter.access', false);
        }

        // Optional filter text
        $this->setState('list.filter', $app->input->getString('filter-search'));

        $this->setState('filter.language', JLanguageMultilang::isEnabled());

        $this->setState('layout', $app->input->get('layout'));
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and different modules
     * that might need different sets of data or different ordering requirements.
     *
     * @param	string	$id	A prefix for the store id.
     * @return	string	A store id.
     */
    protected function getStoreId($id = '') {
        // compile the store id.
        $id .= ':' . $this->getState('list.filter');
        $id .= ':' . $this->getState('filter.access');
        $id .= ':' . $this->getState('filter.published');
        $id .= ':' . serialize($this->getState('filter.testimonial_id'));
        $id .= ':' . serialize($this->getState('filter.category_id'));
        $id .= ':' . $this->getState('filter.language');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
            $this->getState(
                'list.select',
                'a.id, a.checked_out, a.checked_out_time, a.catid,
				a.state, a.access, a.ordering,
				a.language, a.created,
				a.name, a.avatar, a.email, a.position, a.company, a.website, a.vote, a.testimonial,a.video,a.created_by'
			)
		);

        $query->from('#__joomtestimonials AS a');

        // Join over the Categories.
        $query->select('c.title AS category_title, c.alias as category_alias');
        $query->join('LEFT', '#__categories AS c ON c.id = a.catid');

        // Filter by access level.
        if ($access = $this->getState('filter.access')) {
            $user = JFactory::getUser();
            $groups = implode(', ', $user->getAuthorisedViewLevels());
            $query->where('a.access IN (' . $groups . ')');
            $query->where('c.access IN (' . $groups . ')');
        }

        // Filter by published state
        $published = $this->getState('filter.published', 1);

        if (is_numeric($published)) {
            $query->where('a.state = ' . $published);
        } else if (is_array($published)) {
            ArrayHelper::toInteger($published);
            $published = implode(', ', $published);
            $query->where('a.state IN (' . $published . ')');
        }

        // Filter by single or group of testimonials.
        $testimonialId = $this->getState('filter.testimonial_id');

        if (is_numeric($testimonialId)) {
            $type = $this->getState('filter.testimonial_id.include', true) ? '= ' : '<> ';
            $query->where('a.id ' . $type . (int)$testimonialId);
        } else if (is_array($testimonialId)) {
            ArrayHelper::toInteger($testimonialId);
            $testimonialId = implode(', ', $testimonialId);
            $type = $this->getState('filter.testimonial_id.include', true) ? 'IN ' : 'NOT IN';
            $query->where('a.id ' . $type . '(' . $testimonialId . ')');
        }

        // Filter by signle or group of categories
        $categoryId = $this->getState('filter.category_id',[]);
        if(is_array($categoryId) && count($categoryId) == 1)
            $categoryId = $categoryId[0];

        if (is_numeric($categoryId)) {
            $type = $this->getState('filter.category_id.include', true) ? '= ' : '<> ';

            // Add subcategory check
            $includeSubcategories = $this->getState('filter.subcategories', true);
            $categoryEquals = 'a.catid ' . $type . (int)$categoryId;


            if ($includeSubcategories) {

                $levels = (int)$this->getState('filter.max_category_levels', '1');
                // Create a subquery for the subcategory list
                $subQuery = $db->getQuery(true);
                $subQuery->select('sub.id');
                $subQuery->from('#__categories as sub');
                $subQuery->join('INNER', '#__categories as this ON sub.lft > this.lft AND sub.rgt < this.rgt');
                $subQuery->where('this.id = ' . (int)$categoryId);

                if ($levels >= 0) {
                    $subQuery->where('sub.level <= this.level + ' . $levels);
                }

                // Add the subquery to the main query
                $query->where('(' . $categoryEquals . ' OR a.catid IN (' . $subQuery->__toString() . '))');
            } else {
                $query->where($categoryEquals);
            }


        } else if (is_array($categoryId) && (count($categoryId) > 0)) {
            ArrayHelper::toInteger($categoryId);
            $categoryId = implode(', ', $categoryId);
            if (!empty($categoryId)) {
                $type = $this->getState('filter.category_id.include', true) ? 'IN' : 'NOT IN';
                $query->where('a.catid ' . $type . ' (' . $categoryId . ')');
            }
        }

        // Filter on the language.
        if ($language = $this->getState('filter.language')) {
            $query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
        }


        // Add the list ordering clause.
        $query->order($this->getState('list.ordering', 'a.ordering') . ' ' . $this->getState('list.direction', 'ASC'));

        return $query;
    }

    /**
     * Build the orderby for the query
     *
     * @return	string	$orderby portion of query
     */
    protected function _buildContentOrderBy() {
        $app		= JFactory::getApplication('site');
        $params		= LayoutHelper::getListLayoutParams();
        $list_main   = (array)$params->get('layoutparams')->get('list_main');
        $itemid 	= $app->input->get('id', 0, 'int') . ':' . $app->input->get('Itemid', 0, 'int');
        $orderCol	= $app->getUserStateFromRequest('com_joomtestimonials.testimonials.' . $itemid . '.filter_order', 'filter_order', '', 'string');
        $orderDirn	= $app->getUserStateFromRequest('com_joomtestimonials.testimonials.' . $itemid . '.filter_order_Dir', 'filter_order_Dir', '', 'cmd');

        if (!in_array($orderCol, $this->filter_fields)) {
            $orderCol = null;
        }

        if (!in_array(strtoupper($orderDirn), array('ASC', 'DESC', ''))) {
            $orderDirn = 'ASC';
        }

        $orderby = isset($list_main['orderby'])?$list_main['orderby'] : 'rand';

        switch ($orderby) {
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