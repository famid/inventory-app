<?php

namespace App\Http\Services;

use Exception;

class DarazService
{
    private $appKey;

    private $secretKey;
    /**
     * @var string
     */
    private $gatewayUrl;

    protected $signMethod = "sha256";

    protected $sdkVersion = "lazop-sdk-php-20180422";

    public function __construct() {
        $this->appKey = "500812";
        $this->secretKey = "oz7NCX1BYeIp3RwK7JehtLsj1pbChEzb";
        $this->gatewayUrl = "https://api.daraz.com.bd/rest";
    }

    protected function generateSignature($apiName,$params): string {
        ksort($params);

        $stringToBeSigned = '';
        $stringToBeSigned .= $apiName;
        foreach ($params as $key => $value)
        {
            $stringToBeSigned .= "$key$value";
        }
        unset($key, $value);

        return strtoupper($this->hmac_sha256($stringToBeSigned,$this->secretKey));
    }


    function hmac_sha256($data, $key): string {
        return hash_hmac('sha256', $data, $key);
    }

    function generateValidTimestamp(): int {
        // Get current UTC timestamp
        $current_utc_timestamp = round(microtime(true) * 1000);

        // Generate a random timestamp within the 7200 seconds range
        $min_timestamp = $current_utc_timestamp - 7200 * 1000;
        $max_timestamp = $current_utc_timestamp + 7200 * 1000;
        $valid_timestamp = mt_rand($min_timestamp, $max_timestamp);

        // Check if the generated timestamp is within the 7200 seconds range
        $utc_time = gmdate('Y-m-d H:i:s', $valid_timestamp / 1000);
        $current_utc_time = gmdate('Y-m-d H:i:s');
        $time_difference = strtotime($current_utc_time) - strtotime($utc_time);

        return (abs($time_difference) <= 7200)  ? $valid_timestamp  : $this->generateValidTimestamp();
    }

    private function buildSystemParams($apiName, $apiParams): array
    {
        $sysParams = [
            "app_key" => $this->appKey,
            "sign_method" => $this->signMethod,
            'timestamp' => $this->generateValidTimestamp(),
//            "partner_id" => $this->sdkVersion,
        ];

//        if($this->logLevel == Constants::$log_level_debug)
//        {
//            $sysParams["debug"] = 'true';
//        }

        $sysParams["sign"] = $this->generateSignature($apiName,array_merge($apiParams, $sysParams));

        return $sysParams;

    }

    private function buildRequestUrl($request, $apiName, $sysParams) {
        $requestUrl = $this->gatewayUrl;

        if($this->endWith($requestUrl,"/"))
        {
            $requestUrl = substr($requestUrl, 0, -1);
        }

        $requestUrl .= $apiName;
        $requestUrl .= '?';

        foreach ($sysParams as $sysParamKey => $sysParamValue)
        {
            $requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
        }

        return substr($requestUrl, 0, -1);
    }

    function endWith($haystack, $needle): bool {
        $length = strlen($needle);
        return !($length == 0) && substr($haystack, -$length) === $needle;
    }


    public function execute(DarazRequestBuilderService $request, $apiName, $httpMethod="POST") {
        try {
            $apiParams = $request->udfParams;
//            $apiName = $request->apiName;

            $sysParams = $this->buildSystemParams($apiName, $apiParams);

            $requestUrl = $this->buildRequestUrl($request, $apiName, $sysParams);

            if($httpMethod == 'POST')
            {
                return $this->curl_post($requestUrl, $apiParams, $request->fileParams,$request->headerParams);
            }

            return $this->curl_get($requestUrl, $apiParams,$request->headerParams);

        } catch (Exception $e) {
            dd(1);
            dd($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function curl_get($url, $apiFields = null, $headerFields = null)
    {
        $ch = curl_init();

        foreach ($apiFields as $key => $value)
        {
            $url .= "&" ."$key=" . urlencode($value);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        if($headerFields)
        {
            $headers = array();
            foreach ($headerFields as $key => $value)
            {
                $headers[] = "$key: $value";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            unset($headers);
        }

        curl_setopt ( $ch, CURLOPT_USERAGENT, $this->sdkVersion );

        //https ignore ssl check ?
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" )
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $response = curl_exec($ch);

        $errno = curl_errno($ch);

        if ($errno)
        {
            curl_close($ch);
            throw new Exception($errno,0);
        }
        else
        {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            if (200 !== $httpStatusCode)
            {
                throw new Exception($response,$httpStatusCode);
            }
        }

        return $response;
    }

    /**
     * @throws Exception
     */
    public function curl_post($url, $postFields = null, $fileFields = null, $headerFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if($headerFields)
        {
            $headers = array();
            foreach ($headerFields as $key => $value)
            {
                $headers[] = "$key: $value";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            unset($headers);
        }

        curl_setopt ( $ch, CURLOPT_USERAGENT, $this->sdkVersion );

        //https ignore ssl check ?
        if(strlen($url) > 5 && strtolower(substr($url,0,5)) == "https" )
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        $delimiter = '-------------' . uniqid();
        $data = '';
        if($postFields != null)
        {
            foreach ($postFields as $name => $content)
            {
                $data .= "--" . $delimiter . "\r\n";
                $data .= 'Content-Disposition: form-data; name="' . $name . '"';
                $data .= "\r\n\r\n" . $content . "\r\n";
            }
            unset($name,$content);
        }

        if($fileFields != null)
        {
            foreach ($fileFields as $name => $file)
            {
                $data .= "--" . $delimiter . "\r\n";
                $data .= 'Content-Disposition: form-data; name="' . $name . '"; filename="' . $file['name'] . "\" \r\n";
                $data .= 'Content-Type: ' . $file['type'] . "\r\n\r\n";
                $data .= $file['content'] . "\r\n";
            }
            unset($name,$file);
        }
        $data .= "--" . $delimiter . "--";

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER ,
            array(
                'Content-Type: multipart/form-data; boundary=' . $delimiter,
                'Content-Length: ' . strlen($data)
            )
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        unset($data);

        $errno = curl_errno($ch);
        if ($errno)
        {
            curl_close($ch);
            throw new Exception($errno,0);
        }
        else
        {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if (200 !== $httpStatusCode)
            {
                throw new Exception($response,$httpStatusCode);
            }
        }

        return $response;
    }

}
