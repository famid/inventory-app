<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class StoreProductRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|integer',
            'subcategory_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'string',
            'price' => 'required|numeric|between:0,9999999999.99',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'category_id.required' => __('Category id field can not be empty.'),
            'category_id.integer' => __('Category id field must be integer.'),
            'subcategory_id.required' => __('Subcategory id field can not be empty.'),
            'subcategory_id.integer' => __('Subcategory id field must be integer.'),
            'title.required' => __('Title field can not be empty.'),
            'title.string' => __('Title field must be string.'),
            'description.string' => __('description field must be string.'),
            'price.required' => __('Price id field can not be empty.'),
            'price.numeric' => __('Price field must be numeric.'),
            'thumbnail.required' => __('Thumbnail id field can not be empty.'),
        ];
    }

    protected function failedValidation (Validator $validator) {
        $errors = '';
        if ($validator->fails()) {
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors = $errors . $error . "\n";
            }
        }
        $json = [
            'success' => false,
            'message' => $errors,
            'data' => []
        ];
        $response = new JsonResponse( $json, 200);

        throw (new ValidationException( $validator, $response))
            ->errorBag($this->errorBag)->redirectTo($this->getRedirectUrl());
    }
}
