<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'payment_method_id' => 'required|numeric|exists:payment_methods,id',
            'payment_address_id' => 'numeric|exists:payment_addresses,id|nullable',
            'payment_address_name' => 'string|nullable',
            'shipping_method_id' => 'required|numeric|exists:shipping_methods,id',
            'shipping_address_id' => 'numeric|exists:shipping_addresses,id|nullable',
            'shipping_address_name' => 'string|nullable',
            'notes' => 'string|nullable',
            'discount_code' => 'string|nullable',
        ];
    }
}
