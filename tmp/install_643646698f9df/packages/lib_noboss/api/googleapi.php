<?php
/**
 * @package			No Boss Extensions
 * @subpackage  	No Boss Library
 * @author			No Boss Technology <contact@nobosstechnology.com>
 * @copyright		Copyright (C) 2022 No Boss Technology. All rights reserved.
 * @license			GNU Lesser General Public License version 3 or later; see <https://www.gnu.org/licenses/lgpl-3.0.en.html>
 */

defined('JPATH_PLATFORM') or die;

jimport('noboss.util.curl');

// Classe para requisicoes para API do Google (extendida por outras classes do google)
class NoBossGoogleapi {

    /**
     * __construct
     *
     * @param   string  $redirectURI    url para redirecionar apos autorizar aplicacao (deve estar tb cadastrada no console da API)
     * @param   array   $config         matriz associativa, deve conter client_id e client_secret.
     * @return void
     */
    public function __construct($redirectURI = '', $config = array()) {
        $this->redirectURI = $redirectURI;
        $this->config = $config;
    }

    /**
     * Realiza autorizacao de usuario via interface e depois obtem um token de aplicacao
     * 
     * Quando utilizar: 
     *      - Somente quando precisa autorizacao de um usuario antes de obter o token.
     *      - Quando nao precisar, execute diretamente a funcao 'authenticate'
     * 
     * Como funciona:
     *      1 - Funcao eh executada redirecionando para tela de autenticacao onde sera informado um usuario e senha
     *      2 - Apos autenticado usuario, ocorre um redirecionamento de volta para aplicacao conforme definida a url em         'redirectURI' executando o mesmo codigo que chamou essa funcao
     *      3 - A aplicacao ira chamar novamente essa funcao, agora passando 'code' na requisicao
     *      4 - A funcao ira cair agora no else para obter o token da requisicao e token de renovacao
     *
     * @return  json com token ou null
     */
    public function authorize() {
        // Redireciona usuario para tela de autenticacao
        if (!isset($_GET['code']) || empty($_GET['code'])) {
            $authURL = "{$this->oauthURL}?" . \http_build_query([
                'scope' => $this->scope,
                'access_type' => 'offline', // necessario para que retorne refresh_token
                'prompt' => 'consent', // exige sempre autenticacao (refresh_token eh retornado somente qnd loga)
                'include_granted_scopes' => 'true',
                'response_type' => 'code',
                'redirect_uri' => $this->redirectURI,
                'client_id' => $this->config['client_id']
                ]);
            header('Location: ' . filter_var($authURL, FILTER_SANITIZE_URL));
        }
        // Segunda requisicao desta funcao (usuario ja autorizado): executa funcao que obtem o token
        else {
            $authCode = $_GET['code'];
            return json_encode($this->authenticate($authCode));
        }
    }

    /**
     * Autentica a aplicacao obtendo o token para proximas requisicoes
     *
     * @param   string  $code   returned by authorize()
     * 
     * @return  array access and refresh token
     */
    public function authenticate($code) {
        $queryParams = [
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->redirectURI
        ];
        
        $response = NoBossUtilCurl::request("POST", 'https://oauth2.googleapis.com/token', $queryParams);
        
        if (!$response->success) {
            $data = json_decode($response->data);
            if(!empty($data->error_description)){
                throw new \Exception($data->error_description.' | '.$data->error); 
            }
            else if(!empty($data->error->message)){
                throw new \Exception($data->error->message, $data->error->code);
            }
            else if(!empty($response->message)){
                throw new \Exception($response->message); 
            }
            else{
                throw new \Exception('Error.'); 
            }
        }
            
        return \json_decode($response->data, true);
    }

    /**
     * Obtem novo access token a partir do refresh token
     *
     * @param   String      $clientId       Id da api
     * @param   String      $clientSecret   Secret da api
     * @param   String      $refreshToken   Token de renovacao para geracao de novo token de acesso
     * 
     * @return  mixed       access token ou false em caso de erro
     */
    public static function getNewAccessToken($clientId, $clientSecret, $refreshToken){
        $queryParams = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        ];
        
        $response = NoBossUtilCurl::request("POST", 'https://oauth2.googleapis.com/token', $queryParams);
        
        // echo '<pre>';
        // var_dump($response);
        // exit;

        $data = json_decode($response->data);
        
        if (!$response->success) {
            if(!empty($data->error_description)){
                // Retornando erro de 'invalid_grant': acrescenta link para nossa documentacao que explica como resolver                
                if($data->error == 'invalid_grant'){
                    $data->error_description .= " | <a href='https://docs.nobosstechnology.com/api/google-error-invalid-grant' target='_blank'>Learn more</a>";
                }

                throw new \Exception($data->error.' | '.$data->error_description); 
            }
            else if(!empty($data->error->message)){
                throw new \Exception($data->error->message, $data->error->code);
            }
            else if(!empty($response->message)){
                throw new \Exception($response->message); 
            }
            else{
                throw new \Exception('Error.'); 
            }
        }

        if (property_exists($data, 'expires_in') && $data->expires_in > 0) {
            return $data->access_token;
        }
        return false;
    }

    /**
     * Verifica se access token informado eh valido
     *
     * @param   String      $accessToken    Token de acesso para requisicao na API
     * 
     * @return  boolean     true ou false
     */
    public static function checkAccessToken($accessToken){
        // Realiza requisicao para API p/ verificar        
        $isAccessTokenValidJSON = NoBossUtilCurl::request('GET', "https://oauth2.googleapis.com/tokeninfo?access_token={$accessToken}");

        $isAccessTokenValid = json_decode($isAccessTokenValidJSON->data);

        // Ainda eh valido
        if (property_exists($isAccessTokenValid, 'expires_in') && $isAccessTokenValid->expires_in > 0) {
            return true;
        }
        
        return false;
    }

    /**
     * Obtem access token valido (verifica se o enviado como parametro eh valido ou gera um novo a partir do refresh token)
     *
     * @param   String      $clientId       Id da api
     * @param   String      $clientSecret   Secret da api
     * @param   String      $refreshToken   Token de renovacao para geracao de novo token de acesso
     * @param   String      $accessToken    Token acesso atual
     * 
     * @return  mixed       acceess token ou false
     */
    public static function getValidAccessToken($clientId, $clientSecret, $refreshToken, $accessToken){
        $accessTokenIsValid = self::checkAccessToken($accessToken);

        // Access token ainda eh valido
        if ($accessTokenIsValid) {
            return $accessToken;
        } else {
            return self::getNewAccessToken($clientId, $clientSecret, $refreshToken);
        }
    }
}
