<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\lazop\LazopClient;
use App\Http\lazop\LazopRequest;


class DarazController extends Controller
{
    public $url = "https://api.daraz.com.bd/rest";
    public $appkey = "500812";
    public $appSecret = "oz7NCX1BYeIp3RwK7JehtLsj1pbChEzb";

    /**
     * @throws \Exception
     */
    public function getToken() {
        $c = new LazopClient($this->url,$this->appkey,$this->appSecret);
        $request = new LazopRequest('/auth/token/create');
        $request->addApiParam('code','4_500812_Z6TB1Vs2BU5uvUtiY1YvJT4m338');
        dd($c->execute($request));
    }


    function generateValidTimestamp(): int
    {
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

        if (abs($time_difference) <= 7200) {
            // The generated timestamp is within the 7200 seconds range
            return $valid_timestamp;
        } else {
            // The generated timestamp is outside the 7200 seconds range, generate a new one recursively
            return $this->generateValidTimestamp();
        }
    }

    public function signApiRequest(array $params, string $apiName,  $requestBody=null): ?string
    {
        $signMethod = 'HMAC-SHA256';
        $appSecret = "oz7NCX1BYeIp3RwK7JehtLsj1pbChEzb";

        ksort($params);
        $paramString = '';
        foreach ($params as $key => $value) {
            $paramString .= $key . $value;
        }

//        if ($requestBody !== null && !empty($requestBody)) {
//            $paramString .= $requestBody;
//        }

        $stringToSign = $apiName . $paramString;

        return hash_hmac('sha256', $stringToSign, $appSecret);
//        $signature = null;
//        if ($signMethod === 'HMAC-SHA256') {
//            $encodedString = utf8_encode($stringToSign);
//            $binarySignature = hash_hmac('sha256', $encodedString, $appSecret, true);
//            $hexString = bin2hex($binarySignature);
//            $signature = strtoupper($hexString);
//        }
//
////        dd($signature, "===");
//
//
//        return $signature;
    }


}
