<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'invoice_no' => 'required|string',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'total_amount' => 'required|numeric',
            'note' => 'nullable|string',
            'purchase_items' => 'required|array',
            'purchase_items.*.product_id' => 'required|exists:products,id',
            'purchase_items.*.quantity' => 'required|integer|min:1',
            'purchase_items.*.price' => 'required|numeric|min:0',
            'purchase_items.*.total' => 'required|numeric|min:0',
        ];
    }
}
