<?php

namespace App\Service;

class TinyUrl
{
    private function getBaseURL()
    {
        return 'https://api.tinyurl.com';
    }

    private function getURL($method)
    {
        switch ($method) {
            case 'create':
                return $this->getBaseURL() . '/create';
        }
    }

    private function getCustomRequest($method)
    {
        switch ($method) {
            case 'create':
                return 'POST';
        }
    }

    private function getToken($method)
    {
        $token = '9DRdDmv8GvTcsryyxTjxizZAxocKUd7OehjOr7RXp5tF1riHqqaaMjBaCPWC';
        switch ($method) {
            case 'create': // no token
                return $token;
            default:
                return '';
        }
    }

    private function getResponse($method, $data)
    {
        switch ($method) {
            default:
                return json_decode($data, true);
        }
    }

    private function getRequest($method, $data)
    {
        switch ($method) {
            case 'create':
                $data['alias'] = $this->getShortName();
                $data['domain'] = 'tinyurl.com';
                $data['api_token'] = $this->getToken($method);
                return json_encode($data);
            default:
                return json_encode($data);
        }
    }

    private function getShortName()
    {
        $str = 'abcdefghijklmnopqrstuvwxyz';
        $shortName = '';

        for ($i = 0; $i < 10; $i++) {

            $shortName .= substr($str, rand(0, 25), 1);
            if ($i == 2) {
                $shortName .= '-';
            }
        }

        return $shortName;
    }

    public function send($method, $data)
    {
        $type = $this->getCustomRequest($method);
        $url = $this->getURL($method);
        $request = $this->getRequest($method, $data);
        if (strcmp($type, 'GET') == 0) {
            $url = $url . $request;
        }
        $ch = curl_init($url);
        curl_setopt(
            $ch,
            CURLOPT_RETURNTRANSFER,
            true
        );
        curl_setopt(
            $ch,
            CURLOPT_CUSTOMREQUEST,
            $type
        );
        if (strcmp($type, 'GET') != 0) {
            curl_setopt(
                $ch,
                CURLOPT_POSTFIELDS,
                $request
            );
        }
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );
        $response = curl_exec($ch);
        curl_close($ch);
        if (!$response) {
            return false;
        } else {
            $newResponse = $this->getResponse($method, $response);
            return $newResponse;
        }
    }
}
