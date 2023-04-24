<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2023 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;

jimport('noboss.util.curl');

// Classe para requisicoes para API do Paypal
class NoBossApiPaypal {
    private $config;
    private $host;

    /**
     * __construct
     *
     * @param   array       $config         matriz associativa, deve conter client_id, client_secret e pode conter tb 'sandbox'.
     * @param   boolean     $sandbox        Informe se deve executar requisicao no sandbox
     * 
     * @return void
     */
    public function __construct($config, $sandbox = false) {
        $this->config = $config;

        if($sandbox){
            $this->host = 'https://api.sandbox.paypal.com/';
        }
        else{
            $this->host = 'https://api.paypal.com/';
        }
    }

     /**
     * Autentica a aplicacao obtendo o token para proximas requisicoes
     * 
     * @return  array access and refresh token
     */
    public function authenticate() {
        $dataPost = array(
            'grant_type' => 'client_credentials');
            
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . base64_encode( $this->config['client_id'] . ':' . $this->config['client_secret'] )
            ];

        // Realiza a requisição
        $response = NobossUtilCurl::request("POST", $this->host.'v1/oauth2/token', $dataPost, $headers);

        if (!$response->success) {
            $data = json_decode($response->data);
          
            if(!empty($data->details)){
                $data->message .= "<br /><b>Details:</b> ".$data->details['0']->issue;
            }
            throw new \Exception($data->message, 1);
        }

        $response->data = json_decode($response->data);

        return $response->data->access_token;
    }

    /**
     * Obtem transacoes realizadas por periodo
     *
     * @param   string    $token    access_token
     * @param   array     $options  parametros para enviar na requisicao conforme documentacao do paypal (obrigatorio 'start_date' e 'end_date')
     * 
     * Documentacao: https://developer.paypal.com/docs/api/transaction-search/v1/#transactions_get
     * 
     * @return
     */
    public function geTransactions($token, $options) {
        $dest = $this->host.'v1/reporting/transactions';

        $headers = [
            'Authorization' => "Bearer {$token}",
            'Accept' => 'application/json'
        ];
        
        $response = NoBossUtilCurl::request("GET", "{$dest}?" . http_build_query($options), null, $headers);

        if (!$response->success) {
            $data = json_decode($response->data);

            // echo '<pre>';
            // var_dump($data);
            // exit;

            if(!empty($data->details)){
                $data->message .= "<br /><b>Details:</b> ".$data->details['0']->issue;
            }
            throw new \Exception($data->message, 1);
        }

        $data = \json_decode($response->data, true);

        return $data;
    }
}
