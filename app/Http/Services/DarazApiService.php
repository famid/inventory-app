<?php

namespace App\Http\Services;

use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Spatie\ArrayToXml\ArrayToXml;

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

    public $accessToken = "50000900a30Mjt7jCqZMwZeal0CkvCutkZjDthLUUD15fbd5acofQoVEunfe19";
    public $refreshToken = "50001900e30jFqwoscCYmtiJvgRri9efx6sUxGGGuH1f69ab804fx0jD03KqfK";

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
                'refresh_token' => $this->refreshToken
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
                'access_token' => $this->accessToken
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
//                'access_token' => $this->$this->accessToken
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
                'primary_category_id' => '20000013'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }
    }

    public function GetBrandByPages() {
        try {
            $apiName = "/category/brands/query";
            $method = 'GET';
            $apiParams = [
                'startRow' => '0',
                'pageSize' => '5'
            ];

            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }

            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );
        } catch (Exception $e) {

            return response()->json($e->getMessage());
        }
    }

    private function buildProductPayload() {
        $productData = Product::first();

        $array = [
  "Product" =>  [
    "PrimaryCategory" => "20000013",
    "SPUId" => [],
    "AssociatedSku" => [],
    "Images" =>  [
      "Image" =>  [
        0 => "https://my-live-02.slatic.net/p/765888ef9ec9e81106f451134c94048f.jpg",
        1 => "https://my-live-02.slatic.net/p/9eca31edef9f05f7e42f0f19e4d412a3.jpg"
      ]
    ],
    "Attributes" =>  [
      "name" => "Test1 Girls",
      "short_description" => "This is a nice product",
        "brand_id"=>"23892",
      "brand" => "AKG",
//      "model" => "asdf",
//      "kid_years" => "Kids (6-10yrs)",
//      "delivery_option_sof" => "Yes",
//      "comment" => []
    ],
    "Skus" =>  [
      "Sku" =>  [
        "SellerSku" => "api-create-test-1",
        "color_family" => "Green",
        "size" => "40",
        "quantity" => "1",
        "price" => "388",
        "package_length" => "11",
        "package_height" => "22",
        "package_weight" => "33",
        "package_width" => "44",
        "package_content" => "this is what's in the box",
        "Images" =>  [
          "Image" =>  [
//            0 => "http://sg.s.alibaba.lzd.co/original/59046bec4d53e74f8ad38d19399205e6.jpg",
//            1 => "http://sg.s.alibaba.lzd.co/original/179715d3de39a1918b19eec3279dd482.jpg"
          ]
        ]
      ]
    ]
  ]
];

        return ArrayToXml::convert(
            $array,
            'Request',
            true,
            "UTF-8"
        );

//        return $productArray;


    }

    public function createProduct() {

        try {
            $apiName = "/product/create";
            $method = 'POST';
            $apiParams = [
                'access_token' => $this->accessToken
            ];
            $apiParams ['payload'] = $this->buildProductPayload();


            foreach ($apiParams as $key => $value) {
                $this->darazRequestBuilderService->addApiParam($key, $value);
            }


            return $this->darazService->execute($this->darazRequestBuilderService, $apiName, $method );

        } catch (Exception $e) {
            dd($e->getMessage(), "========");
            return response()->json($e->getMessage());
        }
    }
}
