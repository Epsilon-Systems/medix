<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  Content.loadmodule
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

/**
 * Plugin to enable loading modules into content (e.g. articles)
 * This uses the {loadmodule} syntax
 *
 * @since  1.5
 */
class PlgContentjoomtestimonials extends JPlugin
{


	public function  onContentPrepare($context, &$article, &$params, $page = 0) {


		if ($context == 'com_finder.indexer')
		{
			return true;
		}
		if ($context == 'com_joomtestimonials.testimonial' || !isset($article->text))
		{
			return true;
		}

		if (Factory::getApplication()->isClient('administrator')) {
			return true;
		}
		// Simple performance check to determine whether bot should process further

		if (strpos($article->text, '{joomtestimonials id=') === false) {
			return true;

		}


		$regex = "#{joomtestimonials id=([0-9]+)( layout=([a-zA-Z]+))*}#s";
		$article->text = preg_replace_callback($regex, array(&$this, '_processMatches'), $article->text);

	}

	public function _processMatches(&$matches) {

		$app = Factory::getApplication();
		$old_option = $app->input->getCmd('option');
		$old_view = $app->input->getCmd('view');
		$old_id = $app->input->getCmd('id');

        $app->input->set('option', 'com_joomtestimonials');
        $app->input->set('view', 'testimonial');
        $app->input->set('id', $matches[1]);

		// get content
		ob_start();
		JHtml::_('stylesheet', 'com_joomtestimonials/style.css', false, true, false, false, true);
		require_once  JPATH_ROOT . '/components/com_joomtestimonials/controllers/testimonial.php';
		require_once  JPATH_ROOT . '/components/com_joomtestimonials/models/testimonial.php';
		require_once  JPATH_ROOT . '/components/com_joomtestimonials/views/testimonial/view.html.php';
		require_once  JPATH_ROOT . '/components/com_joomtestimonials/helpers/joomtestimonials.php';
		require_once  JPATH_ROOT . '/components/com_joomtestimonials/helpers/route.php';

		JoomtestimonialsFrontendHelper::getLangjt();

		$controller = new JoomtestimonialsControllerTestimonial();
		$controller->_model = new JoomtestimonialsModelTestimonial();

         if(!isset($matches[3])){
	         $matches[3] = "default";
         }
		$options['name'] = 'testimonial';
		$options['layout'] = $matches[3];
		$options['tmpl'] = 'component';
		$options['base_path'] = JPATH_ROOT . '/components/com_joomtestimonials';

		$view = new JoomtestimonialsViewTestimonial($options);
		$view->setModel($controller->_model, true);
		$view->hide_header = 1;
		$view->display();
		$output = ob_get_contents();
		ob_end_clean();

        $app->input->set('option', $old_option);
        $app->input->set('view', $old_view);
        $app->input->set('id', $old_id);

		return $output;
	}

}
