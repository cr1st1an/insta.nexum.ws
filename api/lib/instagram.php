<?php

class Instagram {

    const API_URL = 'https://api.instagram.com/v1';
    const API_OAUTH_URL = 'https://api.instagram.com/oauth/authorize';
    const API_OAUTH_TOKEN_URL = 'https://api.instagram.com/oauth/access_token';
    const API_CLIENT_ID = INSTAGRAM_CLIENT_ID;
    const API_CLIENT_SECRET = INSTAGRAM_CLIENT_SECRET;
    const API_CALLBACK_URL = INSTAGRAM_CALLBACK_URL;

    protected $_token = null;
    protected $_access_token = null;
    protected $_curl_client = null;
    protected $_config = array(
        'client_id' => self::API_CLIENT_ID,
        'client_secret' => self::API_CLIENT_SECRET,
        'grant_type' => 'authorization_code',
        'redirect_uri' => self::API_CALLBACK_URL,
    );

    public function __construct($ACCESS_TOKEN = NULL) {
        $this->_curl_client = new CurlClient();

        if (!empty($ACCESS_TOKEN))
            $this->_access_token = $ACCESS_TOKEN;
    }

    public function auth($CODE) {
        $data = array(
            'client_id' => $this->_config['client_id'],
            'client_secret' => $this->_config['client_secret'],
            'grant_type' => $this->_config['grant_type'],
            'redirect_uri' => $this->_config['redirect_uri'],
            'code' => $CODE
        );

        return json_decode($this->_curl_client->post(self::API_OAUTH_TOKEN_URL, $data), true);
    }

    public function getUser($ID, $DATA) {
        return json_decode($this->_curl_client->get(self::API_URL . '/users/'.$ID.'', $DATA), true);
    }
    
}

class CurlClient {
    
    protected $curl = null;
    
    public function __construct() {
        $this->initializeCurl();
    }
    
    public function get($url, array $data = null) {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->curl, CURLOPT_URL, sprintf("%s?%s", $url, http_build_query($data)));
        return $this->fetch();
    }
    
    public function post($url, array $data = null) {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($data));
        return $this->fetch();
    }
    
    public function put($url, array $data = null) {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    }
    
    public function delete($url, array $data = null) {
        curl_setopt($this->curl, CURLOPT_URL, sprintf("%s?%s", $url, http_build_query($data)));
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->fetch();
    }
    
    protected function initializeCurl() {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
    }
    
    protected function fetch() {
        $raw_response = curl_exec($this->curl);
        $error = curl_error($this->curl);
        if ($error) {
            echo $error;
            exit();
        }
        return $raw_response;
    }
    
}