<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Autoupdate
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2021 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

// no direct access
defined( '_JEXEC' ) or die;

class plgSystemNobossautoupdate extends JPlugin {

    protected $autoloadLanguage = true;

    /*
     * Funcao executada apos renderizar qualquer pagina do site da area admin
     * para realizar atualizacao de extensoes conforme regra
     */
    public function onBeforeRender(){
        $app = JFactory::getApplication();

        // Permite apenas em requisicoes admin
		if (!$app->isClient('administrator')){
			return;
		}
        
        // Atualizacao esta cofigurada para ser realizada via cron: cai fora
        if ($this->params->get('execution_method', 'admin') == 'cron') {
            return;
        }

        // Data atual em timestamp
        $now = time();
        // Data da ultima execucao em timestamp
        $last = (int) $this->params->get('lastrun', 0);
        // Intervalo entre as execucoes (em horas)
        $interval = (int) $this->params->get('interval_verify', 6);

        // Ainda nao esta na hora de executar
        if (abs($now - $last) < $interval*60*60){
            return;
        }

        // Atualiza dado da ultima execucao no parametro do banco
        $this->params->set('lastrun', $now);
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                    ->update($db->qn('#__extensions'))
                    ->set($db->qn('params') . ' = ' . $db->q($this->params->toString('JSON')))
                    ->where($db->qn('type') . ' = ' . $db->q('plugin'))
                    ->where($db->qn('folder') . ' = ' . $db->q('system'))
                    ->where($db->qn('element') . ' = ' . $db->q('nobossautoupdate'));

        try {
            // Tranca as tabelas para previnir multiplas execuções de plugins
            $db->lockTable('#__extensions');
        } catch (Exception $e) {
            // Se não deu para trancar, paramos a execução
            return;
        }

        try	{
            // Atualiza os parametros do plugin
            $result = $db->setQuery($query)->execute();
        } catch (Exception $exc) {
            // Se falhar destranca as tabelas e retorna false
            $db->unlockTables();
            $result = false;
        }

        try {
            // Destranca as tabelas
            $db->unlockTables();
        } catch (Exception $e) {
            // Caso não dê, retorna erro
            $result = false;
        }

        // Aborta em caso de falha
        if (!$result) {
            return;
        }

        // Executa script da library que realiza as atualizacoes
        $url = JUri::root().'index.php?option=com_nobossajax&library=noboss.util.nobossautoupdate&method=update&format=raw';
        JFactory::getDocument()->addScriptDeclaration("jQuery.ajax('{$url}')");
    }
}
