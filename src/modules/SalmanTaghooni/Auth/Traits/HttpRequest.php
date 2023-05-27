<?php

namespace SalmanTaghooni\Auth\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;

trait HttpRequest
{
    private $parametrs = [];
    private $client;
    private $BASE_URL;
    private $header;
    public function setConfig($baseUrl, $header,$time)
    {
        $this->BASE_URL = $baseUrl;
        $this->client = new Client();
        $this->header = [
            'basicAuthentication' => "Basic " . base64_encode(Config::get('metabank.metaBankBasicAuth')),
            'apiKey' => Config::get('metabank.metaBankApiKey'),
            'Authorization' => isset($header['authorization']) ? $header['authorization'] : null
        ];
        $this->parametrs = array_merge(['ip' => $this->getUserIp(), 'time' => $time], $this->parametrs);
    }


    public function httpGet($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : null;
        try {
            $response =  $this->client->request('GET', $this->BASE_URL . $pathName, [
                'headers' => $this->header,
                "query" => $parametrs
            ]);
        } catch (RequestException $e) {
            return $e->getResponse();
        }
        return $response;
    }

    public function httpPost($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : null;
        try {
            $response = $this->client->post(
                $this->BASE_URL . $pathName,
                [
                    'headers' => $this->header,
                    "query" => $parametrs
                ]
            );
        } catch (RequestException $e) {
            return $e->getResponse();
        }
        return $response;
    }

    public function getUserIp()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
        return "127.0.0.1";
    }
}
