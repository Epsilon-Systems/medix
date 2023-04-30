<?php
/**
 * @copyright	Copyright (c) 2013-2018 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;
/**
 *JoomTestimonials Component - Testimonial Table Class.
 *
 * @package		Joomla.Administrator
 * @subpakage	JoomBoost.Joomtestimonials
 */
class JoomtestimonialsTableTestimonial extends JTable {

	/**
	 * Constructor.
	 *
	 * @param	JDatabase	A database connector object.
	 */
	public function __construct(&$db) {
		parent::__construct('#__joomtestimonials', 'id', $db);
		$this->setColumnAlias('published','state');
	}

	/**
	 * Overloaded bind function to pre-process the params.
	 *
	 * @param	array		Named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error.
	 * @see		JTable:bind
	 */
	public function bind($array, $ignore = '') {
		if (isset($array['params']) && is_array($array['params'])) {
			$registry			= new JRegistry();
			$registry->loadArray($array['params']);
			$array['params']	= (string) $registry;
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Overload the store method for the Testimonial table.
	 *
	 * @param	boolean	Toggle whether null values should be updated.
	 * @return	boolean	True on success, false on failure.
	 */
	public function store($updateNulls = false) {
		$date	= JFactory::getDate();
		$user	= JFactory::getUser();

        // cast some columns
        $this->vote = (int) $this->vote;

		if ($this->id) {
			// Existing item
			$this->modified		= $date->toSql();
			$this->modified_by	= $user->get('id');
		} else {
			// New Testimonial. A Testimonial created and created_by field can be set by the user,
			// so we don't touch either of these if they are set.
			if (! (int) $this->created) {
				$this->created	= $date->toSql();
			}

			if (empty($this->created_by)) {
				$this->created_by	= $user->get('id');
			}

		}

		// Attempt to store the user data.
		return parent::store($updateNulls);
	}

	/**
	 * Overloaded check method to ensure data integrity.
	 *
	 * @return	boolean		True on success.
	 */
	public function check() {
		// check for valid name
		if (trim($this->name) == '') {
			$this->setError(JText::_('COM_JOOMTESTIMONIALS_TESTIMONIAL_ERROR_TABLES_NAME'));
			return false;
		}

		if (trim($this->testimonial) == '') {
			$this->setError(JText::_('COM_JOOMTESTIMONIALS_TESTIMONIAL_ERROR_TABLES_TESTIMONIAL'));
			return false;
		}

		return true;
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table. The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update. If not
	 * 					set the instance property value is used.
	 * @param	int		The publishing state. eg. [0 = unpublished, 1 = published]
	 * @param	int		The user id of the user performing the operation.
	 * @return	bool	True on success.
	 */
	public function publish($pks = null, $state = 1, $userId = 0) {
		// Initialize variables.
		$k = $this->_tbl_key;

		// Sanitize input.
		ArrayHelper::toInteger($pks);
		$userId		= (int) $userId;
		$state		= (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks)) {
			if ($this->$k) {
				$pks	= array($this->$k);
			} else {
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Build the WHERE clause for the primary keys.
		$where	= $k . ' = ' . implode(' OR ' . $k . ' = ', $pks);

		// Determine if there is checkin support for the table.
		if (!property_exists($this, 'checked_out') || !property_exists($this, 'checked_out_time')) {
			$checkin	= '';
		} else {
			$checkin	= ' AND (checked_out = 0 OR checked_out = ' . (int) $userId . ')';
		}

		// UPdate the publishing state for rows with the given primary keys.
		$query = 'UPDATE `' . $this->_tbl . '`'
				. ' SET `state` = ' . (int) $state
				. ' WHERE (' . $where . ')'
				. $checkin
		;
		$this->_db->setQuery($query);

		try {
			$this->_db->execute();
		} catch (RuntimeException $e) {
			$this->setError($e->getMessage());
			return false;
		}
/*
		// Check for a database error.
		if ($this->_db->getErrorNum()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
*/
		// If checkin is supported and all rows were adjusted, check them in.
		if ($checkin && (count($pks) == $this->_db->getAffectedRows())) {
			// Checkin the rows.
			foreach ($pks as $pk) {
				$this->checkin($pk);
			}
		}

		// If the JTable instance value is in the list of primary keys that were set, set the instance.
		if (in_array($this->$k, $pks)) {
			$this->state = $state;
		}

		$this->setError('');
		return true;
	}
}