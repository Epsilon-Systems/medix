<?php
/**
 * @copyright	Copyright (c) 2013-2015 JoomBoost (https://www.joomboost.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Testimonial Controller
 *
 * @package		Joomla.Site
 * @subpakage	JoomlaUI.JOOMTestimonials
 */
class JoomtestimonialsControllerTestimonial extends JControllerForm {
	protected $view_item	= 'form';
	protected $view_list	= 'testimonials';
	protected $testimonial	= 'testimonial';

	/** @var string The URL edit variable. */
	protected $urlVar		= 'a.id';

	/**
	 * Method to add a new record.
	 *
	 * @return  boolean  True if the testimonial can be added, false if not.
	 */
	public function add() {
		if (!parent::add()) {
			// Redirect to the return page.
			$this->setRedirect($this->getReturnPage());
		}
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string	$key	The name of the primary key of the URL variable.
	 *
	 * @return  Boolean	True if access level checks pass, false otherwise.
	 */
	public function cancel($key = 't_id') {
		parent::cancel($key);

		// Redirect to the return page.
		$this->setRedirect($this->getReturnPage());
	}

	/**
	 * Method to edit an existing record.
	 *
	 * @param   string	$key	The name of the primary key of the URL variable.
	 * @param   string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  Boolean	True if access level check and checkout passes, false otherwise.
	 */
	public function edit($key = null, $urlVar = 't_id') {
		$result = parent::edit($key, $urlVar);

		return $result;
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string	$name	The model name. Optional.
	 * @param   string	$prefix	The class prefix. Optional.
	 * @param   array  $config	Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 */
	public function getModel($name = 'form', $prefix = '', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param   integer  $recordId	The primary key id for the item.
	 * @param   string	$urlVar		The name of the URL variable for the id.
	 *
	 * @return  string	The arguments to append to the redirect URL.
	 */
	protected function getRedirectToItemAppend($recordId = null, $urlVar = null) {
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);
		$itemId	= $this->input->getInt('Itemid');
		$return	= $this->getReturnPage();

		if ($itemId) {
			$append .= '&Itemid=' . $itemId;
		}

		if ($return) {
			$append .= '&return=' . base64_encode($return);
		}

		if ($this->input->get('isModal')) {
			$append .= '&tmpl=component';

		}

		return $append;
	}

	/**
	 * Get the return URL.
	 *
	 * If a "return" variable has been passed in the request
	 *
	 * @return  string	The return URL.
	 */
	protected function getReturnPage() {

		$return = $this->input->get('return', null, 'base64');
		$isModule = $this->input->get('isModule', 0, 'int');

		// redirect for form in module
		if($isModule == 1 && !empty($return)){
			return base64_decode($return);
		}

		if (empty($return) || !JUri::isInternal(base64_decode($return))) {
			
			return JURI::getInstance()->toString();
			
		} else {
			return base64_decode($return);
		}
	}

	/**
	 * Function that allows child controller access to model data after the data has been saved.
	 *
	 * @param   JModelLegacy  $model      The data model object.
	 * @param   array         $validData  The validated data.
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array()) {

		$data	= array();
		$config		= JComponentHelper::getParams('com_joomtestimonials');
        $isNew = $model->getState('form.new');
		
		if(!$config->get('picture_field_type')){ // if upload field

				$ip			= $this->input->server->get('REMOTE_ADDR');
				$data['ip']	= $ip;

				// process upload avatar
				$files = $this->input->files->get('jform', '', 'array');

				if (isset($files['avatar_file'])) {
					$file		= $files['avatar_file'];

					$extension	= JFile::getExt($file['name']);
	
				if (in_array(strtolower($extension), array('gif', 'png', 'jpg', 'jpeg'))) {
					$fileName	= JFile::makeSafe(JFile::stripExt($file['name']) . '_' . time() . '.' . $extension);
					$path		= JPath::clean(JPATH_ROOT . '/images/avatar');
					$filePath	= JPath::clean($path . '/' . $fileName);
	
					if (JFile::upload($file['tmp_name'], $filePath)) {
						$data['avatar']		= '/images/avatar/' . $fileName;
					}
				}
			}
			
		}else{ // image picker		
			
			$formData = new JInput($this->input->get('jform', '', 'array')); 
			$picname = $formData->getString('avatar_file', '');
			if(!empty($picname))
				$data['avatar'] = JURI::base().$config->get('picture_dir').'/'.$picname;
			else
				$data['avatar'] = '';
		}

        if($isNew){ // is new then set cat and autoapprive
            if (!$config->get('field_catid_visible')) {
                $data['catid']	= $config->get('default_category');
            }

            if ($config->get('auto_approve')) {
                $data['state']	= 1;
            }
        }

        // save image
        $model->save($data);

		// no need to send email if not new
		if (!$isNew)
            return;


        $search			= array('{name}', '{email}', '{position}', '{company}', '{website}', '{testimonial}', '{ip}');
        $replace		= array($validData['name'], @$validData['email'], @$validData['position'], @$validData['company'], @$validData['website'], $validData['testimonial'], $ip);

        $app			= JFactory::getApplication();
        $email_to		= $config->get('email_notification');
        $email_from		= $app->get('mailfrom');
        $email_fromname	= $app->get('fromname');
        $email_subject	= $config->get('email_subject');
        $email_body		= str_replace($search, $replace, $config->get('email_body'));

        // dont send email if info are not set
        if(empty($email_to) && empty($email_from) && $email_fromname)
            return;

        $recipients = explode(',', $email_to);
        if (!empty($recipients)) {
            foreach ($recipients as $recipient) {
                if (!empty($recipient)) {
                    JFactory::getMailer()->sendMail($email_from, $email_fromname, $recipient, $email_subject, $email_body, 1);
                }
            }
        }


	}

	/**
	 * Method to save a record.
	 *
	 * @param   string	$key	The name of the primary key of the URL variable.
	 * @param   string	$urlVar	The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  Boolean	True if successful, false otherwise.
	 */
	public function save($key = null, $urlVar = 't_id') {

		$result = parent::save($key, $urlVar);

		// If ok, redirect to the return page.
		if ($result) {

			$app		= JFactory::getApplication();
			$config		= JComponentHelper::getParams('com_joomtestimonials');

			if ($config->get('auto_approve')) {
				$message	= JText::_('COM_JOOMTESTIMONIALS_SUBMIT_THANKS');
			} else {
				$message	= JText::_('COM_JOOMTESTIMONIALS_SUBMIT_PENDING_THANKS');
			}

			$app->enqueueMessage($message, 'success');

			// for modal
			if ($this->input->get('isModal')) {
				$this->closeModal();
			}

			$this->setRedirect($this->getReturnPage());

		}else{ // submit form not success in modal

			if ($this->input->get('isModal')) {
				return $result;
			}

		}

		if ($this->input->get('isModal')) {
			$this->closeModal();
		}

		if ($this->input->get('isModule')) {
			
			$this->setRedirect($this->getReturnPage());
		}

		return $result;
	}

	protected function closeModal() {
		echo 	'<script>
					parent.window.location.reload();
					parent.document.querySelector(".iziModal-button-close").click()
				</script>
		';

		$session = JFactory::getSession();
		$session->set('application.queue', JFactory::getApplication()->getMessageQueue());

		exit;
	}

	/**
	 * Gets the URL arguments to append to a list redirect.
	 *
	 * @return  string  The arguments to append to the redirect URL.
	 *
	 * @since   1.6
	 */
	protected function getRedirectToListAppend()
	{

		if ($this->input->get('isModal')) {
			$this->getRedirectToItemAppend();

		}else{
			parent::getRedirectToItemAppend();
		}


	}


}