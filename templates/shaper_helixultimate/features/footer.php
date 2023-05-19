<?php
/**
 * @package Helix_Ultimate_Framework
 * @author JoomShaper <support@joomshaper.com>
 * Copyright (c) 2010 - 2021 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined ('_JEXEC') or die();

/**
 * Helix ultimate footer features
 *
 * @since	1.0.0
 */
$app = JFactory::getApplication();
$menu = $app->getMenu();
$currentItem = $menu->getActive();
class HelixUltimateFeatureFooter
{
	/**
	 * Template params
	 *
	 * @var		Registry	Template params registry
	 * @since	1.0.0
	 */
	private $params;

	public function __construct($params)
	{
		$this->params = $params;
		$this->position = $this->params->get('copyright_position');
		$this->load_pos = $this->params->get('copyright_load_pos');
	}

	public function renderFeature()
	{
		if($this->params->get('enabled_copyright'))
		{
			$output = '';

			if($this->params->get('copyright'))
			{

              if ($currentItem) {
                  $pageId = $currentItem->id;
                  if ($pageId == 9) { // ID universal
                      // Código para el pie de página de la página 1
                      echo '<footer>Pie de página de la página 1</footer>';
                  } elseif ($pageId == 30) { // ID doctores
                      // Código para el pie de página de la página 2
                      echo '<footer>Pie de página de la página 2</footer>';
                  } elseif ($pageId == 36) { // ID pacientes
                      // Código para el pie de página por defecto
                      echo '<footer>Pie de página por defecto</footer>';
                  }
              }

			}
		}
	}
}
