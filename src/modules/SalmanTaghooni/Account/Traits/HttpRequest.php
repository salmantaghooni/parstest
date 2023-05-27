<?php

namespace SalmanTaghooni\Account\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

trait HttpRequest
{
    private array $parametrs = [];
    private $client;
    private $BASE_URL;
    private $header;

    public function setConfig($baseUrl, $header, $time)
    {

        $this->BASE_URL = $baseUrl;
        $this->client = new Client();
        $this->header = [
            'basicAuthentication' => "Basic " . base64_encode(Config::get('metabank.metaBankBasicAuth')),
            'apiKey' => Config::get('metabank.metaBankApiKey'),
            'Authorization' => $header['authorization'] ?? null,


        ];
        $this->parametrs = array_merge(['ip' => $this->getUserIp(), 'time' => $time], $this->parametrs);
    }


    public function httpGet($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : null;
        try {
            $response = $this->client->request('GET', $this->BASE_URL . $pathName, [
                'headers' => $this->header,
                "query" => $parametrs
            ]);
        } catch (RequestException $e) {
            return $e->getResponse();

        }
        return $response;
    }

    public function httpPut($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : [];

        try {
            $response = $this->client->put($this->BASE_URL . $pathName, [
                'headers' => $this->header,
                'form_params' => $parametrs,
            ]);
        } catch (RequestException $e) {
            return $e->getResponse();
        }

        return $response;
    }

    public function httpPost($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : [];
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

    public function httpUpload($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : null;
        $parametrs['frontImage'] = file_get_contents($parametrs['frontImage']);

        //$parametrs['backImage'] = file_get_contents($parametrs['backImage']);
        if (isset($parametrs['f']))
            $data1 = Storage::get($parametrs['f'] . '.jpg');
        if (isset($parametrs['b']))
            $data2 = Storage::get($parametrs['b'] . '.jpg');
        //$parametrs['f'] = $data1;
        //$parametrs['b'] = $data2;


        try {
            $response = $this->client->post(
            // $this->BASE_URL . $pathName,
                "https://webhook.site/333befe2-780f-4109-8ff9-7d5e672a2503",
                [
                    'headers' => $this->header,
                    "query" => $parametrs,

                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => fopen('data:image/png;base64,' . base64_encode(file_get_contents($parametrs['frontImage'])), 'r'),
                            'filename' => 'file.jpg'
                        ],
                        [
                            'name' => 'file1',
                            'contents' => array_key_exists("backImage", $parametrs) ? fopen('data:image/png;base64,' . base64_encode(file_get_contents($parametrs['backImage'])), 'r') : fopen('data:image/png;base64,' . base64_encode(file_get_contents($parametrs['frontImage'])), 'r'),
                            'filename' => 'file1.jpg'
                        ],
                    ],


                ]
            );
        } catch (RequestException $e) {
            return $e->getResponse();
        }
        return $response;
    }


    public function httpOneUpload($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : [];
        if ($parametrs['type_file']=="mp4")
//            $data1 = storage_path('') .'\\'. $parametrs['f'] . '.' . $parametrs['type_file'];
            $data1 = storage_path('') .'//'. $parametrs['f'] . '.' . $parametrs['type_file'];
        else
//            $data1 = storage_path(''). '\\app\\'.$parametrs['f'] . '.' . $parametrs['type_file'];
            $data1 = storage_path(''). '//app//'.$parametrs['f'] . '.' . $parametrs['type_file'];
        $data2="";

        if($parametrs['b']){
            if ($parametrs['type_file']=="mp4")
//                $data2 = storage_path('') .'\\'. $parametrs['b'] . '.' . $parametrs['type_file'];
                $data2 = storage_path('') .'//'. $parametrs['b'] . '.' . $parametrs['type_file'];
            else
//                $data2 =  storage_path('') .'\\app\\'. $parametrs['b'] . '.' . $parametrs['type_file'];
                $data2 =  storage_path('') .'//app//'. $parametrs['b'] . '.' . $parametrs['type_file'];

        }

        $data1 = base64_encode(file_get_contents($data1));
        if($parametrs['b'])
            $data2 = base64_encode(file_get_contents($data2));

        $p = $parametrs;
        $p['front_image'] = "";

        try {
            $response = $this->client->post(
                $this->BASE_URL . $pathName,
                //"https://webhook.site/333befe2-780f-4109-8ff9-7d5e672a2503",
                [
                    'headers' => $this->header,
                    "query" => $p,

                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => fopen('data:image/' . $parametrs['type_file'] . ';base64,' . $data1, 'r'),
                            'filename' => 'file.' . $parametrs['type_file']
                        ],
                        [
                            'name' => 'file1',
                            'contents' => array_key_exists("b", $parametrs) ? fopen('data:image/'.$parametrs['type_file'].';base64,' . $data2, 'r') : fopen('data:image/'.$parametrs['type_file'].'base64,' . $data1, 'r'),
                            'filename' => 'file1.' . $parametrs['type_file']
                        ],
                    ],


                ]
            );
        } catch (RequestException $e) {
            return $e->getResponse();
        }
        return $response;
    }


    public function httpUploadVideo($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : null;
        $parametrs['frontImage'] = file_get_contents($parametrs['frontImage']);

        //$parametrs['backImage'] = file_get_contents($parametrs['backImage']);
        if (isset($parametrs['f']))
            $data1 = Storage::get($parametrs['f'] . '.jpg');
        if (isset($parametrs['b']))
            $data2 = Storage::get($parametrs['b'] . '.jpg');
        //$parametrs['f'] = $data1;
        //$parametrs['b'] = $data2;
        $p = $parametrs;
        $p['frontImage'] = "";

        try {
            $response = $this->client->post(
                $this->BASE_URL . $pathName,
                //"https://webhook.site/333befe2-780f-4109-8ff9-7d5e672a2503",
                [
                    'headers' => $this->header,
                    "query" => $p,

                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => isset($data1) ? fopen('data:image/png;base64,' . base64_encode($data1), 'r') : fopen('data:video/mp4;base64,' . base64_encode($parametrs['frontImage']), 'r'),
                            'filename' => 'file.mp4'
                        ]
                    ],


                ]
            );
        } catch (RequestException $e) {
            return $e->getResponse();
        }
        return $response;
    }

    public function httpPutUpload($pathName, $query = null)
    {
        $parametrs = $query !== null ? array_merge($query, $this->parametrs) : [];

        $data2 = "";
        $data1 = Storage::get($parametrs['f'] . '.' . $parametrs['type_file']);
        if (isset($parametrs['b']))
            $data2 = Storage::get($parametrs['b'] . '.' . $parametrs['type_file']);

        $p = $parametrs;
        $p['frontImage'] = "";
        try {
            $response = $this->client->put(
                $this->BASE_URL . $pathName,
                [
                    'headers' => $this->header,
                    "query" => $p,

                    'multipart' => [
                        [
                            'name' => 'file',
                            'contents' => fopen('data:image/' . $parametrs['type_file'] . ';base64,' . base64_encode($data1), 'r'),
                            'filename' => 'file.' . $parametrs['type_file']
                        ],
                        [
                            'name' => 'file1',
                            'contents' => array_key_exists("backImage", $parametrs) ? fopen('data:image/' . $parametrs['type_file'] . ';base64,' . base64_encode($data2), 'r') : fopen('data:image/' . $parametrs['type_file'] . ';base64,' . base64_encode($data1), 'r'),
                            'filename' => 'file1.' . $parametrs['type_file']
                        ],
                    ],


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
        $client = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote = @$_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }
}
