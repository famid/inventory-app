<?php

namespace App\Http\Services\Boilerplate;
abstract class ResponseService {

    /**
     * @var array
     */
    public $response = [
        "success" => null,
        "message" => "",
        "data" => null
    ];

    /**
     * @var string
     */
    public $errorMessage = 'Something went wrong';

    /**
     * @param null $data
     * @return ResponseService
     */
    public function response($data = null) : ResponseService {
        $this->response["data"] = $data;
        return $this;
    }

    /**
     * @param $message
     * @return array
     */
    public function success($message="") : array {
        $this->response["success"] = true;
        $this->response["message"] = __($message);

        return $this->response;
    }

    /**
     * @param $message
     * @return array
     */
    public function error($message="") : array {
        $this->response["success"] = false;
        $this->response["message"] = empty($message) ?
            __($this->errorMessage) :
            __($message);

        return $this->response;
    }
}
