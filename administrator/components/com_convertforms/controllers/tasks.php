<?php

/**
 * @package         Convert Forms
 * @version         4.0.2 Free
 * 
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2022 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

defined('_JEXEC') or die('Restricted access');

use ConvertForms\Tasks\Tasks;
use ConvertForms\Tasks\Apps;
use ConvertForms\Tasks\Connections;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Response\JsonResponse;

class ConvertFormsControllerTasks extends JControllerAdmin
{
	public function app()
	{
		try
		{
			$this->app = Factory::getApplication();

			if (!$this->appName = $this->app->input->getWord('app'))
			{
				throw new \Exception('Invalid app');
			}

			if (!$methodToRun = $this->app->input->getWord('subtask'))
			{
				throw new \Exception('Please provide a subtask');
			}

			$this->CFApp = Apps::getApp($this->appName, $this->app->input->getArray());
			$this->CFAppName = $this->CFApp->getName();

			$result = method_exists($this, $methodToRun) ? $this->$methodToRun() : (method_exists($this->CFApp, $methodToRun) ? $this->CFApp->$methodToRun() : null);

			if (is_null($result))
			{
				throw new \Exception('Method not found: ' . $methodToRun);
			}
	
			echo new JsonResponse($result);
		}
		catch(Exception $e)
		{
			echo new JsonResponse($e);
		}

		jexit();
	}

	public function apps()
	{
		try
		{
			$this->app = Factory::getApplication();

			if (!$methodToRun = $this->app->input->getWord('subtask'))
			{
				throw new \Exception('Please provide a subtask');
			}

			$result = method_exists($this, $methodToRun) ? $this->$methodToRun() : null;

			if (is_null($result))
			{
				throw new \Exception('Method not found: ' . $methodToRun);
			}
	
			echo new JsonResponse($result);
		}
		catch(Exception $e)
		{
			echo new JsonResponse($e);
		}

		jexit();
	}

	public function addConnection()
	{
		$data = $this->app->input->get('params', null, 'raw');

		if (!$this->CFApp->testConnection($data))
		{
			throw new \Exception('Cannot create connection to ' . $this->CFApp->lang('ALIAS') . '. Please check your credentials.');
		}

		return $this->CFApp->addConnection($data['title'], $data);
	}

	public function updateConnection()
	{
		$data = $this->app->input->get('params', null, 'raw');
		$params = $data;

		if (!$testPass = $this->CFApp->testConnection($data))
		{
			throw new \Exception('Cannot create connection to ' . $this->CFApp->lang('ALIAS') . '. Please check your credentials.');
		}

		unset($params['id']);
		unset($params['title']);

		return $this->CFApp->updateConnection($data['id'], $data['title'], $params);
	}

	public function deleteConnection()
	{
		$connection_id = $this->app->input->getInt('connection_id');
		return $this->CFApp->deleteConnection($connection_id);
	}

	public function appsList()
	{
		$data = $this->app->input->json->getArray();
		return Apps::getList($data);
	}
}