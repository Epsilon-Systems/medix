<?php

/**
 * @author          Tassos Marinos <info@tassos.gr>
 * @link            http://www.tassos.gr
 * @copyright       Copyright © 2021 Tassos Marinos All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
 */

namespace ACF\Previewer;

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class Field
{
	/**
	 * The field type.
	 * 
	 * @var  string
	 */
	protected $field = '';

	/**
	 * Field Editor Form Data.
	 * 
	 * @var  array
	 */
	protected $data = [];

	/**
	 * Field Params.
	 * 
	 * @var  object
	 */
	protected $fieldParams = [];

	/**
	 * The field payload used to render the field.
	 * 
	 * @var  array
	 */
	protected $payload;

	/**
	 * The Framework Widget.
	 * 
	 * @var  Widget
	 */
	protected $widget = null;

	public function __construct($data = [], $payload = [])
	{
		$this->data = new Registry($data);
		
		$fieldParams = isset($data['fieldparams']) ? $data['fieldparams'] : [];
		$this->fieldParams = new Registry($fieldParams);

		if ($payload)
		{
			$this->payload = $payload;
		}
	}

	/**
	 * Saves the field's JSON data for previewer to render it.
	 * 
	 * @return  void
	 */
	protected function saveJSON()
	{
		// Get path to file
		$file = implode(DIRECTORY_SEPARATOR, [\ACF\Helpers\Previewer::getJsonDirectory(), $this->data->get('type') . '.json']);

		// Save JSON file
		file_put_contents($file, $this->getHTML());
	}

	/**
	 * Setup the field.
	 * 
	 * @return  string
	 */
	public function setup()
	{
		if (method_exists($this, 'onSetup'))
		{
			$this->onSetup();
		}

		$this->saveJSON();
	}

	/**
	 * Render the field.
	 * 
	 * @return  string
	 */
	public function render()
	{
		return $this->widget->render();
	}

	/**
	 * Field HTML output.
	 * 
	 * @return  string
	 */
	private function getHTML()
	{
		return '<html><head>' . $this->getHead() . '</head><body>' . $this->render() . '</body></html>';
	}

	/**
	 * Returns the head of the preview HTML.
	 * 
	 * @return  string
	 */
	private function getHead()
	{
		if (!$assets = $this->getAssets())
		{
			return;
		}

		// Add Reset CSS
		$head = '<style>' . $this->getResetCSS() . '</style>';

		// Add Custom CSS
		if (isset($assets['custom_css']) && !empty($assets['custom_css']))
		{
			$head .= '<style>' . $assets['custom_css'] . '</style>';
		}

		$base_url = \JURI::root();

		// Add CSS
		if (isset($assets['css']) && is_array($assets['css']) && count($assets['css']))
		{
			foreach ($assets['css'] as $css)
			{
				$css = str_replace('plg_system_nrframework/', 'plg_system_nrframework/css/', $css);
				
				$link = $base_url . 'media/' . $css;

				$head .= '<link href="' . $link . '" rel="stylesheet" />';
			}
		}

		// Add Core JS
		$head .= '<script src="' . $base_url . 'media/system/js/core.js"></script>';
		
		// Add JS
		if (isset($assets['js']) && is_array($assets['js']) && count($assets['js']))
		{
			foreach ($assets['js'] as $js)
			{
				$js = str_replace('plg_system_nrframework/', 'plg_system_nrframework/js/', $js);
				
				$link = $base_url . 'media/' . $js;

				$head .= '<script src="' . $link . '"></script>';
			}
		}

		return $head;
	}

    /**
     * Returns the field reset CSS.
     * 
     * @return  string
     */
    private function getResetCSS()
    {
        return '
        body {
            border: 0 !important;
            background: #fff !important;
            padding: 0 !important;
			font-family: Arial;
			font-size: 16px;
        }
        ';
    }

	/**
	 * The CSS/JS assets that are required for the field to run.
	 * 
	 * @return  array
	 */
	public function getAssets()
	{
		return [
			'css' => [],
			'js' => [],
			'custom_css' => ''
		];
	}
}