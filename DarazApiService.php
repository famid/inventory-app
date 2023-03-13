<?php

namespace App\Http\Services;

use Exception;
use Illuminate\Http\JsonResponse;

class DarazApiService
{
    /**
     * @var DarazService
     */
    private $darazService;
    /**
     * @var DarazRequestBuilderService
     */
    private $darazRequestBuilderService;

    /**
     * @param DarazService $darazService
     * @param DarazRequestBuilderService $darazRequestBuilderService
     */
    public function __construct(DarazService $darazService, DarazRequestBuilderService $darazRequestBuilderService) {
        $this->darazService = $darazService;
        $this->darazRequestBuilderService = $darazRequestBuilderService;
    }

//    /**
//     * @throws Exception
//     */
//    private function executeRequest($apiName, $method, $apiParams = [], $isRequiredAcessToken = false)
//    {
//        foreach ($apiParams as $key => $value) {
//            $this->darazRequestBuilderService->addApiParam($key, $value);
//        }
//        if ($isRequiredAcessToken) {
//            $this->darazRequestBuilderService->addApiParam($key, $value);
//        }
//
//        return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
//    }

    /**
     * @return bool|JsonResponse|string|null
     */
    public function generateAccessToken() {
        try {
            $apiName = "/auth/token/create";
            $method = 'POST';
            $apiParams = [
                'code' => '4_500812_y8LBpKImA7Qg06FNppNbM1I5385'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }
    }


    /**
     * @return bool|JsonResponse|string|null
     */
    public function refreshAccessToken() {
        try {
            $apiName = "/auth/token/refresh";
            $method = 'POST';
            $apiParams = [
                'refresh_token' => '50001901414be1gvfkT9yoi8hh19ae11a2P6qUwhngRJzHRVkD5AvwAusqLnrw'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }
    }

    /**
     * @return bool|JsonResponse|string|null
     */
    public function getSeller() {
        try {
            $apiName = "/seller/get";
            $method = 'GET';
            $apiParams = [
                'access_token' => '50000901d15tufXddshKytiHjQG1af76f26yjTvEkzGRsEuRWQuo23ePfB6hyj'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }
    }

    public function getCategoryTree() {
        try {
            $apiName = "/category/tree/get";
            $method = 'GET';
//            $apiParams = [
//                'access_token' => '50000901d15tufXddshKytiHjQG1af76f26yjTvEkzGRsEuRWQuo23ePfB6hyj'
//            ];
//
//            foreach ($apiParams as $key => $value) {
//                $this->darazRequestBuilderService->addApiParam($key, $value);
//            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }

    }

    public function getCategoryAttributes() {
        try {
            $apiName = "/category/attributes/get";
            $method = 'GET';
            $apiParams = [
                'primary_category_id' => '10001956'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }
    }

    public function createProduct() {
        try {
            $apiName = "/product/create";
            $method = 'POST';
            $apiParams = [
                'access_token' => '50000901d15tufXddshKytiHjQG1af76f26yjTvEkzGRsEuRWQuo23ePfB6hyj'
            ];
            $apiParams = [
                'primary_category_id' => '10001956'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );

        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }



}
