<?php

namespace App\Services;


class Api
{
    private $api_key = '';
    private $base_url = '';

    public function __construct()
    {
        $this->api_key = env('CREATEPH_API_KEY', null);
        $this->base_url = env('CREATEPH_BASE_URL', 'https://www.createphilippines.com/api_reg/v1/');
    }

    protected function build_request($params, $content_type = 'application/json')
    {
        if (!$this->api_key) {
            return false;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->base_url . $params['endpoint'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $params['method'],
            CURLOPT_POSTFIELDS => $params['data'],
            CURLOPT_HTTPHEADER => array(
                'Content-Type: ' . $content_type,
                'x-api-key: ' . $this->api_key,
            ),
        ));

        return $curl;
    }

}