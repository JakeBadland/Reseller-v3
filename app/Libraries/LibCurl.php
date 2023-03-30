<?php


namespace App\Libraries;

class LibCurl
{

    private $cookieFile = 'cookies-prom-ua.txt';
    //private $url = 'https://prom.ua/ua/Tehnika-i-elektronika';
    //private $url = 'https://my.prom.ua/cms/order';
    //private $url = 'https://my.prom.ua/cms/order/context';
    private $url = 'https://my.prom.ua/cms/order/context?page=1&per_page=20';
    //private $url = 'https://my.prom.ua/cms/order/context?page=2&per_page=20';

    public function execute($url, $headers = null, $cookies = null) : \App\Models\CurlResponse
    {
        $curl = $this->getCurl($url);

        if ($headers){
            $this->setHeaders($curl, $headers);
        }

        if ($cookies){
            $this->setCookies($curl, $cookies);
        }

        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $headerStr = substr($response, 0, $headerSize);
        $bodyStr = substr($response, $headerSize );

        if ($httpCode != 200){
            //die("http code != 200");
        }

        $result = new \App\Models\CurlResponse($httpCode, $headerStr, $bodyStr);

        curl_close($curl);

        return $result;
    }

    private function getCurl($url = null)
    {
        if (!$url){
            $url = $this->url;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HEADER  => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //CURLOPT_POSTFIELDS => json_encode($data) , // отправка кода
        ));

        return $curl;
    }

    private function setHeaders($curl, $headers)
    {
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    private function setCookies($curl, $cookies)
    {
        $data = [];
        foreach ($cookies as $line){
            array_push($data, "{$line['name']}={$line['value']}");
        }

        $data = implode(';', $data);

        curl_setopt($curl, CURLOPT_COOKIE , $data);
    }

    private function readCookies()
    {
        if (!is_file($this->cookieFile)) {
            die("Cookie file \"{$this->cookieFile}\" not found!");
        }

        return file_get_contents($this->cookieFile);

    }

    private function parseCookies($cookies)
    {
        $cookies = explode("\n", $cookies);

        $result = [];

        foreach ($cookies as $key => $line) {
            if ($line == '') {
                unset($cookies[$key]);
                continue;
            }

            $line = preg_split("/\t+/", $line);

            $result[$key] = [
                'domain' => $line[0],
                'httpOnly' => $line[1],
                'secure' => $line[3],
                'ttl' => $line[4],
                'name' => $line[5],
                'value' => $line[6],
            ];
        }

        return $result;

    }

}