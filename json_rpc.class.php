<?php

class rpc_exception extends Exception {}

class json_rpc {

    private $url = null;

    public function __construct($url) {
        $this->url = $url;
    }

    public function __call($method, $params) {
        if (!is_scalar($method)) {
            throw new rpc_exception('Method name has no scalar value');
        }

        if (!is_array($params)) {
            throw new rpc_exception('Params must be given as array');
        }

        $request = array(
            'method' => $method,
            'params' => array_values($params),
        );

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));

        $ret = json_decode(curl_exec($ch), true);
        if ($ret === null) {
            throw new rpc_exception(curl_error($ch));
        }

        return $ret;
    }
}
