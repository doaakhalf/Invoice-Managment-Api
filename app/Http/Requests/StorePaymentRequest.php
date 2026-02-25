<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
        //$invoice_id, $amount,$payment_method, $reference_number//
        return [
            'amount'=>'required|numeric',
            'payment_method'=>'required|in:cash,bank_transfer,credit_card',
            'reference_number'=>'required|string',
        ];
    }
}
