<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
use Joomla\CMS\MVC\View\GenericDataException;

defined('_JEXEC') or die;

/**
 * Methods supporting a list of Testtimonial records.
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.Joomtestimonials
 */

class JoomtestimonialsModelTestimonial extends JModelItem {
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_joomtestimonials.testimonial';

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication('site');

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('testimonial.id', $pk);

		$this->setState('filter.access', false);

		$this->setState('filter.language', JLanguageMultilang::isEnabled());

		// TODO: Tune these values based on other permissions.
		$user = JFactory::getUser();

	}


	/**
	 * Method to get testimonial data.
	 *
	 * @param   integer  $pk  The id of the testimonial.
	 *
	 * @return  object|boolean|JException  Menu item data object on success, boolean false or JException instance on error
	 */
	public function getItem($pk = null)
	{
		$user = JFactory::getUser();

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('testimonial.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
				$db = $this->getDbo();
				$query = $db->getQuery(true)
					->select(
						$this->getState(
							'item.select', 'a.id, a.checked_out, a.checked_out_time, a.catid,
								a.state, a.access, a.ordering,
								a.language, a.created,
								a.name, a.avatar, a.email, a.position, a.company, a.website, a.vote, a.video, a.testimonial,a.created_by'
						)
					);
				$query->from('#__joomtestimonials AS a')
					->where('a.id = ' . (int) $pk);

				// Join on category table.
				$query->select('c.title AS category_title, c.alias AS category_alias, c.access AS category_access')
					->innerJoin('#__categories AS c on c.id = a.catid')
					->where('c.published > 0');

				// Join on user table.
				$query->select('u.name AS author')
					->join('LEFT', '#__users AS u on u.id = a.created_by');

				// Filter by language
				if ($this->getState('filter.language'))
				{
					$query->where('a.language in (' . $db->quote(JFactory::getLanguage()->getTag()) . ',' . $db->quote('*') . ')');
				}

				// Join over the categories to get parent category titles
				$query->select('parent.title as parent_title, parent.id as parent_id, parent.path as parent_route, parent.alias as parent_alias')
					->join('LEFT', '#__categories as parent ON parent.id = c.parent_id');



				// Filter by published state.
				$published = $this->getState('filter.published');
				$archived = $this->getState('filter.archived');

				if (is_numeric($published))
				{
					$query->where('(a.state = ' . (int) $published . ' OR a.state =' . (int) $archived . ')');
				}

				$db->setQuery($query);

				$data = $db->loadObject();
				if (empty($data))
				{

                    throw new GenericDataException(JText::_('COM_JOOMTESTIMONIAL_ERROR_TESTIMONIAL_NOT_FOUND'), 404);
				}


				// Check for published state if filter set.
				if ((is_numeric($published) || is_numeric($archived)) && (($data->state != $published) && ($data->state != $archived)))
				{

                    throw new GenericDataException(JText::_('COM_JOOMTESTIMONIAL_ERROR_TESTIMONIAL_NOT_FOUND'), 404);

				}

				$data->params = LayoutHelper::getListLayoutParams();

				// Technically guest could edit an testimonial, but lets not check that to improve performance a little.

				// Compute view access permissions.
				if ($access = $this->getState('filter.access'))
				{
					// If the access filter has been set, we already know this user can view.
					$data->params->set('access-view', true);
				}
				else
				{
					// If no access filter is set, the layout takes some responsibility for display of limited information.
					$user = JFactory::getUser();
					$groups = $user->getAuthorisedViewLevels();

					if ($data->catid == 0 || $data->category_access === null)
					{
						$data->params->set('access-view', in_array($data->access, $groups));
					}
					else
					{
						$data->params->set('access-view', in_array($data->access, $groups) && in_array($data->category_access, $groups));
					}
				}

				$this->_item[$pk] = $data;
				$this->_item[$pk]->text = "";
				$this->_item[$pk];

			}
			catch (Exception $e)
			{
				if ($e->getCode() == 404)
				{

                    throw new GenericDataException($e->getMessage(), 404);
				}
				else
				{
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}

		return $this->_item[$pk];
	}

}