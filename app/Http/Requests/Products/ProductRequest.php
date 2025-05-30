<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|numeric|exists:categories,id',
            'brand_id' => 'required|numeric|exists:brands,id',
            'name' => 'required|string',
            'slug' => 'required|string|nullable|unique:products,slug',
            'quantity' => 'numeric|nullable',
            'price' => 'numeric|nullable',
            'discount' => 'numeric|nullable',
            'sku' => 'required|string',
            'description' => 'required|string|nullable',
            'is_active' => 'boolean|nullable',
            'title' => 'required|string',
            'meta_keywords' => 'required|string',
            'product_description' => 'required|string',
            'short_description' => 'required|string',
            'image' => 'string|nullable',
            'images' => 'json',
        ];
    }
}
