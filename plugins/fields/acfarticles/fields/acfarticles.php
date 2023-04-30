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

defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');
require_once JPATH_PLUGINS . '/system/nrframework/helpers/fieldlist.php';

class JFormFieldACFArticles extends NRFormFieldList
{
    public function getInput()
    {
        $this->hint = JText::_('ACF_ARTICLES_SELECT_ARTICLES');

        return parent::getInput();
    }
    
    /**
     * Method to get a list of options for a list input.
     *
     * @return  array
	 */
	protected function getOptions()
	{
        // The layout param in the field XML overrides $this->layout and thus we need to set it again.
        $this->layout = 'joomla.form.field.list-fancy-select';

        $query = $this->db->getQuery(true)
            ->select('a.*, c.lft as category_lft, c.title as category_title')
            ->from($this->db->quoteName('#__content', 'a'))
            ->join('LEFT', $this->db->quoteName('#__categories', 'c') . ' ON c.id = a.catid');

        // Get current item id and exclude it from the list
        if ($current_item_id = JFactory::getApplication()->input->getInt('id'))
        {
            $query->where($this->db->quoteName('a.id') . ' != ' . (int) $current_item_id);
        }

        // Add Categories
        if ($filtersCategoryEnabled = (string) $this->element['filters_category_enabled'] === '1' && $categories = (string) $this->element['filters_category_value'])
        {
            $inc_children = (string) $this->element['filters_category_inc_children'];

            if (in_array($inc_children, ['1', '2']))
            {
                $categories = array_map('trim', explode(',', $categories));
                
                $children_categories = $this->getCategoriesChildIds($categories);

                // Also include children categories
                if ($inc_children === '1')
                {
                    $categories = array_unique(array_filter(array_merge($categories, $children_categories)));
                }
                // Use only children categories
                else
                {
                    $categories = $children_categories;
                }

                $categories = implode(',', $categories);
            }

            $query->where($this->db->quoteName('a.catid') . ' IN (' . $categories . ')');
        }

        // Default status is to show published articles
        $status = 1;

        

        // Set articles status
        $query->where($this->db->quoteName('a.state') . ' IN (' . $status . ')');

        // Apply ordering
        $order = (string) $this->element['order'];
        if ($order)
        {
            $order = array_filter(array_map('trim', explode(',', $order)));
            $orders = [];

            foreach ($order as $item)
            {
                $lastUnderscorePos = strrpos($item, '_');
                $part1 = substr($item, 0, $lastUnderscorePos);
                $part2 = substr($item, $lastUnderscorePos + 1);

                if (!$part1 || !$part2)
                {
                    break;
                }
                
                $orders[] = $part1 . ' ' . $part2;
            }

            if ($orders)
            {
                $query->order($this->db->escape(implode(',', $orders)));
            }
        }

        $this->db->setQuery($query);

        // Get all articles
        if (!$items = $this->db->loadObjectList())
        {
            return;
        }

        // Get all dropdown choices
        $options = [];

        foreach ($items as $item)
        {
            $options[] = JHTML::_('select.option', $item->id, $item->title);
        }

        return $options;
    }

    /**
     * Return all categories child ids.
     * 
     * @param   array  $categories
     * 
     * @return  array
     */
    private function getCategoriesChildIds($categories = [])
    {
        $query = $this->db->getQuery(true)
            ->select('a.id')
            ->from($this->db->quoteName('#__categories', 'a'))
            ->where('a.extension = ' . $this->db->quote('com_content'))
            ->where('a.published = 1');

        $children = [];

        while (!empty($categories))
        {
            $query
                ->clear('where')
                ->where($this->db->quoteName('a.parent_id') . ' IN (' . implode(',', $categories) . ')');
            
            $this->db->setQuery($query);

            $categories = $this->db->loadColumn();

            $children = array_merge($children, $categories);
        }

        return $children;
    }
}