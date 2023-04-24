<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	com_nobossajax
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('_JEXEC') or die;

// Utilizado para Joomla 3 a partir da versao 3.8.0
use Joomla\CMS\Document\Renderer\Html\HeadRenderer;

error_reporting(0);

$app = JFactory::getApplication();
$input = $app->input;
$doc = JFactory::getDocument();
$html = '';

// Permite requisicao de qualquer site
header('Access-Control-Allow-Origin: *');

/*
 * 	* Parametros opcionais para requisicoes ajax 
 *      * load-head: 0/1 (define se vai carregar o head do Joomla com todas chamadas JS e CSS)
 * 		* load-css: 0/1 (define se deve carregar arquivos CSS da extensao)
 * 		* load-js: 0/1 (define se deve carregar arquivos JS da extensao)
 *      * nd: 0/1 (forca que os arquivos js e css sejam inseridos via JS no head - necessario tb que a requisicao seja ajax)
 *      * lang (define o idioma da requisicao. se nao informado, carrega idioma default do site)
 *   * Importante: os parametros de load para JS e CSS soh funcionam se atender os dois criterios abaixo:
 *      1 - A requisicao nao utilizar 'format=raw' na url
 *      2 - Se for requisicao direta para uma funcao, a mesma nao pode ter um exit;
 */

// Requisicao de modulo
if(!empty($input->get('module-position')) || !empty($input->get('module-id'))){
    /*
     * Chamada de modulo por posicao
     *      Ex de chamada: URLSITE/index.php?option=com_nobossajax&module-position=footer
     */
    if(!empty($input->get('module-position'))){
        // Carrega modulos da posicao informada
        $modules = JModuleHelper::getModules($input->get('module-position'));
        
        // Existem modulos na posicao
        if(is_array($modules)){
            // Exibe todos os modulos da posicao
            foreach($modules as $content){
                // Guarda o html do modulo em variavel
		        $html .= JModuleHelper::renderModule($content);
            }		
        }
    }

    /*
     * Chamada de modulo por ID
     *      Ex de chamada: URLSITE/index.php?option=com_nobossajax&module-id=21
     *      - No metodo que fizemos abaixo sem loadmoduleid, nao tem restricao de versao do joomla para funcionar
     */
    else if ($input->get('module-id')){

        /* Obtem os dados do modulo conforme ID informado para renderizar na pagina
            NOTA: Inicialmente era utilizada a funcao loadmoduleid do proprio Joomla, mas descobrimos que os módulos que não estivessem marcados para serem exibidos em todas as páginas, não seriam exibidos. Isso inviabiliza o uso como embed Por esse motivo, foi replicada a logica da funcao do Joomla aqui, mas sem considerar para quais paginas esta atribuido. Baseado nas duas funcoes abaixo:
                - '_loadid($id)' do arquivo plugins\content\loadmodule\loadmodule.php
                - 'getModuleList()' do arquivo libraries\src\Helper\ModuleHelper.php
         */
        $Itemid = $app->input->getInt('Itemid', 0);
		$groups = implode(',', \JFactory::getUser()->getAuthorisedViewLevels());
		$lang = \JFactory::getLanguage()->getTag();
		$clientId = (int) $app->getClientId();
        $db = \JFactory::getDbo();
        $date = \JFactory::getDate();
        $now = $date->toSql();
        $nullDate = $db->getNullDate();
        
		$query = $db->getQuery(true)
			->select('m.id, m.title, m.module, m.position, m.content, m.showtitle, m.params, "" as menuid')
			->from('#__modules AS m')
			->where('m.published = 1')
			->join('LEFT', '#__extensions AS e ON e.element = m.module AND e.client_id = m.client_id')
            ->where('e.enabled = 1')
            ->where('(m.publish_up = ' . $db->quote($nullDate) . ' OR m.publish_up IS NULL OR m.publish_up <= ' . $db->quote($now) . ')')
			->where('(m.publish_down = ' . $db->quote($nullDate) . ' OR m.publish_down IS NULL OR m.publish_down >= ' . $db->quote($now) . ')')
			->where('m.access IN (' . $groups . ')')
            ->where('m.client_id = ' . $clientId)
            ->where('m.language IN (' . $db->quote($lang) . ',' . $db->quote('*') . ')')
            ->where('m.id = '.$db->quote($input->get('module-id')));
        $db->setQuery($query);

        //echo str_replace('#__', 'qdgee_', $query); exit;

        $module = $db->loadObject();

        // Nao ha modulo a exibir
        if(empty($module)){
            exit;
        }

        // Renderizar e exibe o modulo
        $renderer = $doc->loadRenderer('module');
        $params   = array('style' => 'none');

        ob_start();
        // Guarda o html do modulo em variavel
		$html = $renderer->render($module, $params);
        ob_get_clean();
    }
}

// Requisicao para library
else if ($input->get('library')){
	$library       = $input->get('library');
	$method        = $input->get('method');
	$class		   = $input->get('class');
	$libPath	   = explode(".", $library);
	$fileName	   = end($libPath);
	$libName 	   = reset($libPath);
	
	// Verifica se está setado uma library
	if ($library){
		jimport($library);
		
		if (!isset($class) || empty($class)){
			$class = ucfirst($libName) . ucfirst($fileName);
		}
		
		$method = $input->get('method') ? $input->get('method') : 'get';

		if (method_exists($class, $method)){
			try{
				ob_start();
                $results = call_user_func($class . '::' . $method);
                $html .= ob_get_clean();
			}catch (Exception $e){
				$results = $e;
			}
		}
		// Method does not exist
		else{
			$results = new LogicException(JText::sprintf('COM_AJAX_METHOD_NOT_EXISTS', $method), 404);
		}
	}

}
else{
    /*
        TODO: em set/2020 adicionamos o codigo abaixo que era executado diretamente no 'com_ajax' do joomla:
                - MOTIVADOR: 
                    - Qnd faziamos requisicao ajax do administrator para um modulo do front, nao podíamos chamar o componente ajax que esta no diretorio /administrator pq ele ao incluir o componente do front, usava 'JPATH_BASE' para tentar localizar o diretorio do modulo e isso fazia com que tentasse localizar na area admin ao invez do front.
                    - A solucao que era usada era requisicar via ajax direto o componente do front a partir do administrator, mas isso gerava outros problemas: ex: cliente que usam redirecionamento de url no front do site
                - O QUE FOI ALTERADO:
                    - Copiamos o codigo abaixo do componente ajax do Joomla e apenas modificamos a parte a linha do $helperFIle mudando valor de JPATH_BASE para JPATH_ROOT
                    - Depois esvaziamos o valor de '$input->get('module')' para cair ainda no componente do joomla sem executar o mesmo codigo de novo, executando somente o restante do codigo
    */
    if ($input->get('module')){
        $module   = $input->get('module');
        $table    = JTable::getInstance('extension');
        $moduleId = $table->find(array('type' => 'module', 'element' => 'mod_' . $module));

        if ($moduleId && $table->load($moduleId) && $table->enabled)
        {
            $helperFile = JPATH_ROOT . '/modules/mod_' . $module . '/helper.php';

            if (strpos($module, '_'))
            {
                $parts = explode('_', $module);
            }
            elseif (strpos($module, '-'))
            {
                $parts = explode('-', $module);
            }

            if ($parts)
            {
                $class = 'Mod';

                foreach ($parts as $part)
                {
                    $class .= ucfirst($part);
                }

                $class .= 'Helper';
            }
            else
            {
                $class = 'Mod' . ucfirst($module) . 'Helper';
            }

            $method = $input->get('method') ?: 'get';

            if (is_file($helperFile))
            {
                JLoader::register($class, $helperFile);

                if (method_exists($class, $method . 'Ajax'))
                {
                    // Load language file for module
                    $basePath = JPATH_BASE;
                    $lang     = JFactory::getLanguage();
                    $lang->load('mod_' . $module, $basePath, null, false, true)
                    ||  $lang->load('mod_' . $module, $basePath . '/modules/mod_' . $module, null, false, true);

                    try
                    {
                        $results = call_user_func($class . '::' . $method . 'Ajax');
                    }
                    catch (Exception $e)
                    {
                        $results = $e;
                    }
                }
                // Method does not exist
                else
                {
                    $results = new LogicException(JText::sprintf('COM_AJAX_METHOD_NOT_EXISTS', $method . 'Ajax'), 404);
                }
            }
            // The helper file does not exist
            else
            {
                $results = new RuntimeException(JText::sprintf('COM_AJAX_FILE_NOT_EXISTS', 'mod_' . $module . '/helper.php'), 404);
            }
        }
        // Module is not published, you do not have access to it, or it is not assigned to the current menu item
        else
        {
            $results = new LogicException(JText::sprintf('COM_AJAX_MODULE_NOT_ACCESSIBLE', 'mod_' . $module), 404);
        }

        $input->get('module', '');
    }

    ob_start();

    // Caso não seja uma requisição para a library, só inclui o com_ajax do joomla
	require_once JPATH_SITE . '/components/com_ajax/ajax.php';

    $html .= ob_get_clean();
    
}

jimport('noboss.util.loadextensionassets');

// Setado para carregar head na requisicao com chamadas JS, CSS e metatags basicas
if ($input->get('load-head', '0')){
    // Remove alguns metatags que nao queremos exibir
    $doc->resetHeadData(array('title'));
    $doc->setMetaData("keywords", '');
    $doc->setMetaData("description", '');
    $doc->setMetaData("generator", '');

    // Para reconhecer acesso mobile
    $doc->setMetaData('viewport', 'width=device-width, initial-scale=1');

    // Joomla 4
    if(version_compare(JVERSION, '4', '>=')){
        // Exibe o head contendo as chamadas de JS e CSS
        $html = $doc->render().$html;
    }
    // Joomla 3 (antes de 3.8.0)
    else if(version_compare(JVERSION, '3.8.0', '<')){
        require_once JPATH_SITE."/libraries/joomla/document/renderer/html/head.php";
        // Exibe o head contendo as chamadas de JS e CSS
        $html = JDocumentRendererHtmlHead::fetchHead($doc).$html;
    }
    // Joomla 3 (a partir de 3.8.0)
    else{
        // Exibe o head contendo as chamadas de JS e CSS
        $HeadRenderer = new HeadRenderer($doc);
        $html = $HeadRenderer->fetchHead($doc).$html;
    }
}

// Nao carrega head, mas permite carregar CSS e/ou JS diretamente com o modulo
else if($input->get('load-css', '0') || $input->get('load-js', '0')){
    // Verifica de deve carregar CSS (default eh sim)
    if ($input->get('load-css', '0')){
        // Requisicao ajax e setado variavel 'nd' (nao exibir duplicados via jS): carrega os arquivos CSS via javascript, verificando os arquivos que ja existem na pagina para nao inserir novamente
        if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') && ($input->get('nd', '1'))){
            $addViaJs = true;
        }
        // Sera retornado html para exibir depois via php
        else{
            $addViaJs = false;
        }

        // Executa funcao para adicionar arquivos e inline (soh retorna html $addViaJs for false)
        $html .= NoBossUtilLoadExtensionAssets::addCss($addViaJs);
    }

    // Verifica de deve carregar JS (default eh sim)
    if ($input->get('load-js', '0')){
        // Requisicao ajax e setado variavel 'nd' (nao exibir duplicados via jS): carrega os arquivos JS via javascript, verificando os arquivos que ja existem na pagina para nao inserir novamente
        // TODO: alguns casos pode dar erros no console log para scripts inseridos inline apos os arquivos. Nestes casos, recomenda-se nao passar a variavel 'nd' na url para nao inserir desta forma e assim evitar o erro
        if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') && ($input->get('nd', '0'))){
            $addViaJs = true;
        }
        // Sera retornado html para exibir depois via php
        else{
            $addViaJs = false;
        }

        // Executa funcao para adicionar arquivos e inline (soh retorna html $addViaJs for false)
        $html .= NoBossUtilLoadExtensionAssets::addJs($addViaJs);
    }
}

if(!empty($html)){
    echo $html;
    exit;
}
